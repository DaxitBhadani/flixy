<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Genre;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ContentController extends Controller
{
    public function contentList()
    {
        $genres = Genre::get();
        $languages = Language::get();
        $data = Content::get();
        $movieCount = Content::where('content_type', 1)->count();
        $seriesCount = Content::where('content_type', 2)->count();
        return view(
            'contentList',
            [
                'genres' => $genres,
                'languages' => $languages,
                'data' => $data,
                'movie' => $movieCount,
                'series' => $seriesCount,
            ]
        );
    }

    public function fetchContentList(Request $request)
    {
        $totalData =  Content::where('content_type', 1)->count();
        $rows = Content::orderBy('id', 'DESC')->get();

        $result = $rows;

        $columns = array(
            0 => 'id',
            1 => 'vertical_poster',
            2 => 'horizontal_poster',
            3 => 'title',
            4 => 'rating',
            5 => 'year',
            6 => 'language',
            7 => 'isFeatured',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $content_type = 1;

        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $result = Content::offset($start)
                ->where('content_type', $content_type)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $result =  Content::whereHas('language', function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orwhere('languageName',  'LIKE', "%{$search}%")
                    ->orwhere('year',  'LIKE', "%{$search}%");
            })
                ->where('content_type', $content_type)
                ->offset($start)->limit($limit)->orderBy($order, $dir)->get();

            $totalFiltered = Content::whereHas('language', function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orwhere('languageName',  'LIKE', "%{$search}%")
                    ->orwhere('year',  'LIKE', "%{$search}%");
            })
                ->where('content_type', $content_type)
                ->count();
        }

        $data = array();
        foreach ($result as $item) {

            $verticlePoster = '<img src="./upload/' . $item->verticle_poster . '" alt="vertical image" width="60px" height="80px" class="object-cover">';
            $image = '<img src="./upload/' . $item->horizontal_poster . '" alt="horizontal image" width="100px" height="70px" class="object-cover">';

            $edit = '<a data-title="' . $item->title . '"  data-vimage="' . $item->verticle_poster . '" data-himage="' . $item->horizontal_poster . '" data-rating="' . $item->rating . '" data-year="' . $item->year . '"  data-language="' . $item->language . '"  data-desc="' . $item->desc . '" data-duration="' . $item->duration . '" data-year="' . $item->year . '" data-rating="' . $item->rating . '" data-genres="' . $item->genres . '" data-trailer_id="' . $item->trailer_id . '"  data-content_type="' . $item->content_type . '" class="me-2 btn btn-primary px-3 text-white edit" rel=' . $item->id . ' >' . __('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>') . '</a>';

            $delete = '<a href="" class="btn btn-danger px-3 text-white delete" rel=' . $item->id . ' >' . __('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>') . '</a>';

            $language = Language::where('id', $item->language)->pluck('languageName');

            if ($item->featured == 1) {
                $featured = '<label class="switch"><input type="checkbox" name="featured" rel="' . $item->id . '" value="' . $item->featured . '" id="featured" class="featured" checked><span class="slider"></span> </label>';
            } else {
                $featured = '<label class="switch"><input type="checkbox" name="featured" rel="' . $item->id . '" value="' . $item->featured . '" id="featured" class="featured"><span class="slider"></span> </label>';
            }

            $movieDetail = '<a href="contentList/' . $item->id . '" class="btn btn-secondary me-2 " style="white-space: nowrap;">Movie Detail</a>';

            $action = '<div class="action"> ' .  $movieDetail . $edit . $delete . ' </div>';

            $data[] = array(
                $verticlePoster,
                $image,
                $item->title,
                $item->rating,
                $item->year,
                $language,
                $featured,
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

    public function storeNewContent(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content_type' => 'required',
            'desc' => 'required',
            'duration' => 'required',
            'year' => 'required',
            'rating' => 'required',
            'language' => 'required',
            'genres' => 'required',
            'trailer_id' => 'required',
            'verticle_poster' => 'required',
            'horizontal_poster' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }

        $content = new Content;
        $content->title = $request->title;
        $content->content_type = $request->content_type;
        $content->desc = $request->desc;
        $content->duration = $request->duration;
        $content->year = $request->year;
        $content->rating = $request->rating;
        $content->language = $request->language;
        $content->genres =  implode(',', $request->genres);
        $content->trailer_id = $request->trailer_id;

        if ($request->hasFile('verticle_poster')) {
            $file = $request->file('verticle_poster');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extenstion;
            $file->move('upload/', $filename);
            $content->verticle_poster = $filename;
        }
        if ($request->hasFile('horizontal_poster')) {
            $file = $request->file('horizontal_poster');
            $extenstion = $file->getClientOriginalExtension();
            $filename = 'h_' . time() . '.' . $extenstion;
            $file->move('upload/', $filename);
            $content->horizontal_poster = $filename;
        }

        $content->save();

        return response()->json([
            'status' => 200,
            'message' => 'Content Added Successfully',
        ]);
    }

    public function updateContent(Request $request, $id)
    {
        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }

        $content = Content::where('id', $id)->get()->first();
        if ($content) {

            if ($request->has('title')) {
                $content->title = $request->title;
            }
            if ($request->has('content_type')) {
                $content->content_type = $request->content_type;
            }
            if ($request->has('desc')) {
                $content->desc = $request->desc;
            }
            if ($request->has('duration')) {
                $content->duration = $request->duration;
            }
            if ($request->has('year')) {
                $content->year = $request->year;
            }
            if ($request->has('rating')) {
                $content->rating = $request->rating;
            }
            if ($request->has('language')) {
                $content->language = $request->language;
            }
            if ($request->has('genres')) {
                $content->genres = implode(',', $request->genres);
            }
            if ($request->has('trailer_id')) {
                $content->trailer_id = $request->trailer_id;
            }
            if ($request->hasFile('verticle_poster')) {
                $path = 'upload/' . $content->verticle_poster;
                if (File::exists($path)) {
                    File::delete($path);
                }
                $file = $request->file('verticle_poster');
                $extenstion = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extenstion;
                $file->move('upload/', $filename);
                $content->verticle_poster = $filename;
            }
            if ($request->hasFile('horizontal_poster')) {
                $path = 'upload/' . $content->horizontal_poster;
                if (File::exists($path)) {
                    File::delete($path);
                }
                $file = $request->file('horizontal_poster');
                $extenstion = $file->getClientOriginalExtension();
                $filename = 'h_' . time() . '.' . $extenstion;
                $file->move('upload/', $filename);
                $content->horizontal_poster = $filename;
            }
            if ($request->has('featured')) {
                $content->featured = $request->featured;
            }
            $content->save();
            return response()->json([
                'status' => 200,
                'message' => 'Content Updated Successfully',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Content Not Found',
            ]);
        }
    }

    public function deleteContent($id)
    {
        $content = Content::find($id);
        $path = 'upload/' . $content->verticle_poster;
        $path1 = 'upload/' . $content->horizontal_poster;
        if (File::exists($path) || File::exists($path1)) {
            File::delete($path);
            File::delete($path1);
        }
        if ($content) {
            $content->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Content Deleted Successfully',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Content Not Found',
            ]);
        }
    }

    public function fetchContentSeries(Request $request)
    {

        $totalData =  Content::where('content_type', 1)->count();
        $rows = Content::orderBy('id', 'DESC')->get();

        $result = $rows;

        $columns = array(
            0 => 'id',
            1 => 'vertical_poster',
            2 => 'horizontal_poster',
            3 => 'title',
            4 => 'rating',
            5 => 'year',
            6 => 'language',
            7 => 'isFeatured',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $content_type = 2;

        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $result = Content::offset($start)
                ->where('content_type', $content_type)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $result =  Content::whereHas('language', function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orwhere('languageName',  'LIKE', "%{$search}%");
            })
                ->where('content_type', $content_type)
                ->offset($start)->limit($limit)->orderBy($order, $dir)->get();

            $totalFiltered = Content::whereHas('language', function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orwhere('languageName',  'LIKE', "%{$search}%");
            })
                ->where('content_type', $content_type)
                ->count();
        }




        $data = array();
        foreach ($result as $item) {

            $verticlePoster = '<img src="./upload/' . $item->verticle_poster . '" alt="vertical image" width="60px" height="80px" class="object-cover">';
            $image = '<img src="./upload/' . $item->horizontal_poster . '" alt="horizontal image" width="100px" height="70px" class="object-cover">';

            $edit = '<a data-title="' . $item->title . '"  data-vimage="' . $item->verticle_poster . '" data-himage="' . $item->horizontal_poster . '" data-rating="' . $item->rating . '" data-year="' . $item->year . '"  data-language="' . $item->language . '"  data-desc="' . $item->desc . '" data-duration="' . $item->duration . '" data-year="' . $item->year . '" data-rating="' . $item->rating . '" data-genres="' . $item->genres . '" data-trailer_id="' . $item->trailer_id . '"  data-content_type="' . $item->content_type . '" class="me-2 btn btn-primary px-3 text-white edit" rel=' . $item->id . ' >' . __('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>') . '</a>';

            $delete = '<a href="" class=" btn btn-danger px-3 text-white delete" rel=' . $item->id . ' >' . __('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>') . '</a>';

            $language = Language::where('id', $item->language)->pluck('languageName');

            if ($item->featured == 1) {
                $featured = '<label class="switch"><input type="checkbox" name="featured" rel="' . $item->id . '" value="' . $item->featured . '" id="featured" class="featured" checked><span class="slider"></span> </label>';
            } else {
                $featured = '<label class="switch"><input type="checkbox" name="featured" rel="' . $item->id . '" value="' . $item->featured . '" id="featured" class="featured"><span class="slider"></span> </label>';
            }

            $movieDetail = '<a href="contentList/series/' . $item->id . '" class="btn btn-secondary me-2 seriesDetail" style="white-space: nowrap;">Series Detail</a>';

            $action = '<div class="action"> ' . $movieDetail . $edit . $delete . ' </div>';

            $data[] = array(
                $verticlePoster,
                $image,
                $item->title,
                $item->rating,
                $item->year,
                $language,
                $featured,
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

    public function searchContent(Request $request)
    {
       $query = Content::query();
        if ($request->has('language_id')) {
            $query->Where('language', $request->language_id);
        }

        if ($request->has('content_type')) {
            $query->Where('content_type', $request->content_type);
        }

        

        $contents = $query->Where('title', 'LIKE', "%{$request->title}%")->with('language')->limit(2)->get();
        $data = [];
        foreach ($contents as $content) {
           $ids = explode(',' , $content->genres);
           $content->genres_ids = Genre::whereIn('id', $ids)->get();
           array_push($data, $content);
        }

        return response()->json([
            'status' => true,
            'message' => 'Search Content',
            'data' =>  $data,
        ]);

    }

    public function fetchContent(Request $request)
    {
        if ($request->id == 1 || $request->id == 2) {
            $contents = Content::where('content_type', $request->id)->get();
        }
        else if ($request->id == 0) {
            $contents = Content::all();
        } else {
            return response()->json([
                'message' => 'Record Not Found',
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'fetchContent',
            'data' =>  $contents,
        ]);
    }



}
