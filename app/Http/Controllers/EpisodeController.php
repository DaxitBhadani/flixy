<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\EpisodeSource;
use App\Models\EpisodeSubtitle;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class EpisodeController extends Controller
{

    public function episodeList($id)
    {
        $episode = EpisodeSource::where('episode_id', $id)->get()->first();
        $data = Episode::where('season_id', $id)->get()->first();
        $languages = Language::get();
        return view('episodeDetail',[
            'episodes' => $episode,
            'languages' => $languages,
            'data' => $data,
        ]);        
    }

    public function fetchEpisodeList(Request $request)
    {
        $id = $request->id;
        $totalData =  Episode::where('season_id', $id)->count();
        $rows = Episode::where('season_id', $id)->orderBy('id', 'DESC')->get();

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
            $result = Episode::where('season_id', $id)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $result =  Episode::where('season_id', $id)->Where('name', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Episode::where('season_id', $id)->Where('name', 'LIKE', "%{$search}%")
                ->count();
        }
        
        $data = array();
        foreach ($result as $item) {

            $image = '<img src="../../upload/'. $item->image .'" width="100px" height="60px">';

            $episodeDetail = '<a href="source/'. $item->season_id .'" class="btn btn-secondary me-3" style="white-space: nowrap;">Episode Detail</a>';

            $edit = '<a href="javascript:;" data-title="' . $item->title . '"  data-duration="' . $item->duration . '" data-accesstype="' . $item->access_type . '" data-desc="' . $item->desc . '" data-image="' . $item->image . '"  class="me-3 btn btn-primary px-4 text-white edit" rel=' . $item->id . ' >' . __("Edit") . '</a>';

            $delete = '<a href="javascript:;" class="mr-2 btn btn-danger px-4 text-white delete" rel=' . $item->id . ' >' . __("Delete") . '</a>';

            $action =  '<div class="action" style="text-align: right;"> ' . $episodeDetail . $edit . $delete . ' </div>';

            $data[] = array(
                $image,
                $item->title,
                $item->desc,
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

    public function addEpisode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'season_id' => 'required',
            'title' => 'required',
            'duration' => 'required',
            'access_type' => 'required',
            'desc' => 'required',
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }

        $episode = new Episode;
        $episode->season_id = $request->season_id;
        $episode->title = $request->title;
        $episode->duration = $request->duration;
        $episode->access_type = $request->access_type;
        $episode->access_type = $request->access_type;
        $episode->desc = $request->desc;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extenstion;
            $file->move('upload/', $filename);
            $episode->image = $filename;
        }

        $episode->save();

        return response()->json([
            'status' => 200,
            'message' => 'Episode Added Successfully',
        ]);
    }

    public function updateEpisode(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'duration' => 'required',
            'access_type' => 'required',
            'desc' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }

        $episode = Episode::find($id);
        $episode->title = $request->title;
        $episode->duration = $request->duration;
        $episode->access_type = $request->access_type;
        $episode->access_type = $request->access_type;
        $episode->desc = $request->desc;
      
        if ($request->hasFile('image')) {
            $path = 'upload/' . $episode->image;
            if (File::exists($path)) {
                File::delete($path);
            }
            $file = $request->file('image');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extenstion;
            $file->move('upload/', $filename);
            $episode->image = $filename;
        }

        $episode->save();

        return response()->json([
            'status' => 200,
            'message' => 'Episode Updated Successfully',
        ]);
    }

    public function deleteEpisode($id)
    {
        {
            $episode = Episode::find($id);
            if ($episode) {
                $path = 'upload/' . $episode->image;
                if (File::exists($path)) {
                    File::delete($path);
                }
                $episode->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'Episode Delete Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Episode Not Found',
                ]);
            }
        }
    } 

    
    public function fetchEpisodeSourceList(Request $request, $id)
    {
        
        $totalData =  EpisodeSource::where('episode_id', $id)->count();
        $rows = EpisodeSource::where('episode_id', $id)->orderBy('id', 'DESC')->get();

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
            $result = EpisodeSource::where('episode_id', $id)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $result =  EpisodeSource::where('episode_id', $id)->Where('name', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = EpisodeSource::where('episode_id', $id)->Where('name', 'LIKE', "%{$search}%")
                ->count();
        }
        
        $data = array();
        foreach ($result as $item) {



            if ($item->source_type == 7) {
                $source_url = '<a href="#" id="video_id" rel="' .$item->source_url. '" data-bs-toggle="modal" data-bs-target="#viewVideoModal" class="btn btn-success green video_show_link"><i class="bi bi-play-fill fs-2"></i></a>';
            } else {
                $source_url = $item->source_url;
            }

           


            $edit = '<a href="javascript:;" data-title="' . $item->title . '" data-quality="' . $item->quality . '" data-size="' . $item->size . '" data-downloadtype="' . $item->download_type . '"  data-sourcetype="' . $item->source_type . '" data-sourceurl="' . $item->source_url . '" data-accesstype="' . $item->access_type . '" class="me-3 btn btn-primary px-4 text-white edit" rel=' . $item->id . ' >' . __("Edit") . '</a>';

            $delete = '<a href="javascript:;" class="mr-2 btn btn-danger px-4 text-white delete" rel=' . $item->id . ' >' . __("Delete") . '</a>';

            $action =  '<div class="action" style="text-align: right;"> ' .  $edit . $delete . ' </div>';

            switch ($item->source_type) {
                case 1: $item->source_type = "Youtube Id"; break;
                case 2: $item->source_type = "M3u8 Url"; break;
                case 3: $item->source_type = "Mov Url"; break;
                case 4: $item->source_type = "Mp4 Url"; break;
                case 5: $item->source_type = "Mkv Url"; break;
                case 6: $item->source_type = "Webm Url"; break;
                default: $item->source_type = "File "; break;
            }
            
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

    public function addEpisodeSource(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'series_id' => 'required',
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

        $source = new EpisodeSource;
        $source->series_id = $request->series_id;
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
            'message' => 'Episode Source Added Successfully',
        ]);
    }

    public function updateEpisodeSource(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
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

        $source = EpisodeSource::find($id);
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
                'message' => 'Episode Source Updated Successfully',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Episode Source Not Found',
            ]);
        }
    }

    public function deleteEpisodeSource($id)
    {
        {
            $source = EpisodeSource::find($id);
            if ($source) {
                $path = 'upload/' . $source->source_url;
                if (File::exists($path)) {
                    File::delete($path);
                }
                $source->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'Episode Source Delete Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Episode Source Not Found',
                ]);
            }
        }
    }


        
    public function fetchEpisodeSubtitle(Request $request, $id)
    {
       
        $totalData =  EpisodeSubtitle::where('episode_id', $id)->count();
        $rows = EpisodeSubtitle::where('episode_id', $id)->orderBy('id', 'DESC')->get();

        $result = $rows;

        $columns = array(
            0 => 'id',
            1 => 'image',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $result = EpisodeSubtitle::where('episode_id', $id)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $result =  EpisodeSubtitle::where('episode_id', $id)->Where('name', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = EpisodeSubtitle::where('episode_id', $id)->Where('name', 'LIKE', "%{$search}%")
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

    public function addEpisodeSubtitle(Request $request)
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

        $subtitle = new EpisodeSubtitle;
        $subtitle->episode_id = $request->episode_id;
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
            'message' => 'Episode Subtitle Added Successfully',
        ]);
    }

    public function deleteEpisodeSubtitle($id)
    {
        {
            $subtitle = EpisodeSubtitle::find($id);
          
            if ($subtitle) {
                $path = 'upload/' . $subtitle->subtitle;
                if (File::exists($path)) {
                    File::delete($path);
                }
                $subtitle->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'Episode Subtitle Delete Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Episode Subtitle Not Found',
                ]);
            }
        }
    }

    // APIs
    // Episode View Count

    public function episodeViewCount(Request $request){
        $episodeViewCount = Episode::where('id', $request->id)->get()->first();

        $episodeViewCount->view_count += 1;
        $episodeViewCount->save();
        return response()->json([
            'status' => true,
            'message' => 'View Count',
            'data' => $episodeViewCount,

        ]);

    }

    // Episode Download Count
    public function episodeDownloadCount(Request $request){

            $episodeDownloadCount = Episode::where('id', $request->id)->get()->first();

            $episodeDownloadCount->download_count += 1;
            $episodeDownloadCount->save();
            return response()->json([
                'status' => true,
                'message' => 'Download Count',
                'data' => $episodeDownloadCount,
            ]);
    }


}
