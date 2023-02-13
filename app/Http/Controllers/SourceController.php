<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\Cast;
use App\Models\Content;
use App\Models\Language;
use App\Models\Source;
use App\Models\Subtitle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class SourceController extends Controller
{

    public function sourceList(Request $request)
    {

        $totalData =  Source::where('movie_id', $request->movie_id)->count();
        $rows = Source::where('movie_id', $request->movie_id)->orderBy('id', 'DESC')->get();

        $result = $rows;

        $columns = array(
            0 => 'id',
            1 => 'image',
            1 => 'name'
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $result = Source::where('movie_id', $request->movie_id)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $result =  Source::where('movie_id', $request->movie_id)->Where('name', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Source::where('movie_id', $request->movie_id)->Where('name', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = array();
        foreach ($result as $item) {
            
            if ($item->source_type == 7) {
                $source_url = '<a href="#" id="video_id" rel="' .$item->source_url. '" data-bs-toggle="modal" data-bs-target="#viewVideoModal" class="btn btn-success green video_show_link"><i class="bi bi-play-fill fs-2"></i></a>';
            } else {
                $source_url = $item->source_url;
            }

            $edit = '<a href="#" data-title="'. $item->title .'" data-quality="'. $item->quality .'" data-size="'. $item->size .'" data-download="'. $item->download_type .'" data-sourcetype="'. $item->source_type .'" data-sourceurl="'. $item->source_url .'" data-accesstype="'. $item->access_type .'" class="me-3 btn btn-primary px-4 text-white edit" rel=' . $item->id . ' >' . __("Edit") . '</a>';

            $delete = '<a href="" class="mr-2 btn btn-danger px-4 text-white delete" rel=' . $item->id . ' >' . __("Delete") . '</a>';

            $action =  '<div class="action" style="text-align: right;"> ' . $edit . $delete .' </div>'; 

            $data[] = array(
                $item->source_type,
                $item->title,
                $source_url,
                $action,
            );
        }
        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => $totalFiltered,
            "data"            => $data
        );
        echo json_encode($json_data);
        exit();
    }
    
    public function contentListEdit($id)
    {
        $content = Content::find($id)->all()->first();
        $data = Content::where('id', $id)->first();
        $actors = Actor::get();
        $languages = Language::get();
        if ($content) {
            return view(
                'movieDetail',
                [
                    'contentId' => $id,
                    'data' => $data,
                    'actors' => $actors,
                    'languages' => $languages,
                ]
            );
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Content Not Found',
            ]);
        }

        
    }

    public function storeNewSource(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'movie_id' => 'required',
            'title' => 'required',
            'quality' => 'required',
            'size' => 'required',
            'source_type' => 'required',
            'access_type' => 'required',
            'download_type' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }

        $source = new Source;
        $source->movie_id = $request->movie_id;
        $source->title = $request->title;
        $source->quality = $request->quality;
        $source->size = $request->size;
        $source->download_type = $request->download_type;
        $source->source_type = $request->source_type;
        $source->access_type = $request->access_type;

        if ($request->hasFile('source_file')) {
            $file = $request->file('source_file');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extenstion;
            $file->move('upload/', $filename);
            $source->source_url = $filename;
        } else {
            $source->source_url = $request->source_url;
        }

        $source->save();

        return response()->json([
            'status' => 200,
            'message' => 'Source Added Successfully',
        ]);
    }

    public function updateSource(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'movie_id' => 'required',
            'title' => 'required',
            'quality' => 'required',
            'size' => 'required',
            'source_type' => 'required',
            'access_type' => 'required',
            'download_type' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }

        $source = Source::find($id);
        if ($source) {
            
            $source->title = $request->title;
            $source->quality = $request->quality;
            $source->size = $request->size;
            $source->source_type = $request->source_type;
            $source->access_type = $request->access_type;
            $source->download_type = $request->download_type;

            if ($request->hasFile('source_file')) {
                $path = 'upload/' . $source->source_url;
                if (File::exists($path)) {
                    File::delete($path);
                }
                $file = $request->file('source_file');
                $extenstion = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extenstion;
                $file->move('upload/', $filename);
                $source->source_url = $filename;
            } else {
                $source->source_url = $request->source_url;
            }

            
            $source->save();
            return response()->json([
                'status' => 200,
                'message' => 'Source Updated Successfully',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Source Not Found',
            ]);
        }
    }

    public function deleteSource($id)
    {
        {
            $source = Source::find($id);
            $path = 'upload/' . $source->source_url;
            if (File::exists($path)) {
                File::delete($path);
            }
            if ($source) {
                $source->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'Source Delete Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Source Not Found',
                ]);
            }
        }
    }

    // Cast Table Fetch
    public function castList(Request $request)
    {

        $totalData =  Cast::where('movie_id', $request->movie_id)->count();
        $rows = Cast::where('movie_id', $request->movie_id)->orderBy('id', 'DESC')->get();

        $result = $rows;

        $columns = array(
            0 => 'id',
            1 => 'image',
            1 => 'name'
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $result = Cast::where('movie_id', $request->movie_id)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $result =  Cast::where('movie_id', $request->movie_id)->Where('name', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Cast::where('movie_id', $request->movie_id)->Where('name', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = array();
        foreach ($result as $item) {
            
            $image = '<img src="../upload/'.$item->actors->image.'" width="50px" height="50px" style="object-fit: cover;">';

            $edit = '<a data-title="' . $item->actors->id . '" data-role="' . $item->role . '" href="" class="me-3 btn btn-primary px-4 text-white edit" rel=' . $item->id . ' >' . __("Edit") . '</a>';

            $delete = '<a href="" class="mr-2 btn btn-danger px-4 text-white delete" rel=' . $item->id . ' >' . __("Delete") . '</a>';

            $action =  '<div class="action" style="text-align: right;"> ' . $edit . $delete .' </div>'; 

            $data[] = array(
                $image,
                $item->actors->name,
                $item->role,
                $action,
            );
        }
        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => $totalFiltered,
            "data"            => $data
        );
        echo json_encode($json_data);
        exit();
    }

    public function storeNewCast(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }

        $cast = new Cast;
        $cast->movie_id = $request->movie_id;
        $cast->title = $request->title;
        $cast->role = $request->role;
        $cast->save();

        return response()->json([
            'status' => 200,
            'message' => 'Cast Added Successfully',
        ]);
    }

    public function updateCast(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }

        $cast = Cast::find($id);
        if ($cast) {
            
            $cast->title = $request->title;
            $cast->role = $request->role;
            $cast->save();

            return response()->json([
                'status' => 200,
                'message' => 'Cast Updated Successfully',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Cast Not Found',
            ]);
        }
    }

    public function deleteCast($id)
    {
        {
            $cast = Cast::find($id);
          
            if ($cast) {
                $cast->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'Cast Delete Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Cource Not Found',
                ]);
            }
        }
    }

     // Subtitle Table Fetch
    public function SubtitleList(Request $request)
    {

        $totalData =  Subtitle::where('movie_id', $request->movie_id)->count();
        $rows = Subtitle::where('movie_id', $request->movie_id)->orderBy('id', 'DESC')->get();

        $result = $rows;

        $columns = array(
            0 => 'id',
            1 => 'image',
            1 => 'name'
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $result = Subtitle::where('movie_id', $request->movie_id)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $result =  Subtitle::where('movie_id', $request->movie_id)->Where('name', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Subtitle::where('movie_id', $request->movie_id)->Where('name', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = array();
        foreach ($result as $item) {
          

            $download = '<a href="../upload/'. $item->subtitle .'" download data-title="'. $item->title .'" class="me-3 btn btn-primary px-3 text-white edit" rel=' . $item->id . ' >' . __('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>') . '</a>';

            $delete = '<a href="#" class="mr-2 btn btn-danger px-4 text-white delete" rel=' . $item->id . ' >' . __("Delete") . '</a>';

            $action =  '<div class="action" style="text-align: right;"> ' . $download . $delete .' </div>'; 


            $data[] = array(
                $item->languages->languageName,
                $action,
            );
        }
        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => $totalFiltered,
            "data"            => $data
        );
        echo json_encode($json_data);
        exit();
    }

    public function storeSubtitle(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'subtitle' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }

        $subtitle = new Subtitle;
        $subtitle->movie_id = $request->movie_id;
        $subtitle->title = $request->title;

        if ($request->hasFile('subtitle')) {
            $file = $request->file('subtitle');
            $filename = time() . '.srt';
            $file->move('upload/', $filename);
            $subtitle->subtitle = $filename;
        }
        $subtitle->save();

        return response()->json([
            'status' => 200,
            'message' => 'Subtitle Added Successfully',
        ]);
    }

    public function deleteSubtitle($id)
    {
        {
            $subtitle = Subtitle::find($id);
          
            if ($subtitle) {
                $path = 'upload/' . $subtitle->subtitle;
                if (File::exists($path)) {
                    File::delete($path);
                }
                $subtitle->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'Subtitle Delete Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Subtitle Not Found',
                ]);
            }
        }
    }




    // APIs
    // viewCount 
    public function viewCount(Request $request)
    {
        $viewcount = Content::where('id', $request->id)->get()->first();

        $viewcount->view_count += 1;
        $viewcount->save();
        return response()->json([
            'status' => true,
            'message' => 'Movie Count',
            'data' =>  $viewcount,
        ]);
    }

    // Share View
    public function shareCount(Request $request)
    {
        $sharecount = Content::where('id', $request->id)->get()->first();

        $sharecount->share_count += 1;
        $sharecount->save();
        return response()->json([
            'status' => true,
            'message' => 'Share Count',
            'data' =>  $sharecount,
        ]);
    }

    // Share View
    public function downloadCount(Request $request)
    {
        $downloadcount = Content::where('id', $request->id)->get()->first();

        $downloadcount->download_count += 1;
        $downloadcount->save();
        return response()->json([
            'status' => true,
            'message' => 'download Count',
            'data' =>  $downloadcount,
        ]);
    }
}
