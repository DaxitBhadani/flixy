<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\Content;
use App\Models\Episode;
use App\Models\Language;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SeriesController extends Controller
{

    public function fetchEpisodeList(Request $request)
    {

        // $totalData =  Episode::where('season_id', $request->season_id)->count();
        // $rows = Episode::where('season_id', $request->season_id)->orderBy('id', 'DESC')->get();
        $totalData =  Episode::count();
        $rows = Episode::orderBy('id', 'DESC')->get();

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
            $result = Episode::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $result =  Episode::Where('name', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Episode::Where('name', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = array();
        foreach ($result as $item) {

            $image = '<img src="../../upload/'. $item->image .'" width="100px" height="60px">';
            $edit = '<a href="#" data-title="' . $item->title . '" data-quality="' . $item->quality . '" data-size="' . $item->size . '" data-download="' . $item->download_type . '" data-sourcetype="' . $item->source_type . '" data-sourceurl="' . $item->source_url . '" data-accesstype="' . $item->access_type . '" class="me-3 btn btn-primary px-4 text-white edit" rel=' . $item->id . ' >' . __("Edit") . '</a>';

            $delete = '<a href="" class="mr-2 btn btn-danger px-4 text-white delete" rel=' . $item->id . ' >' . __("Delete") . '</a>';

            $action =  '<div class="action" style="text-align: right;"> ' . $edit . $delete . ' </div>';

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
    public function seriesList($id)
    {
        $content = Content::find($id)->all()->first();
        $data = Content::where('id', $id)->first();
        $actors = Actor::get();
        $languages = Language::get();
        $seasons = Season::where('series_id', $id)->get();

        if ($content) {
            return view(
                'seriesDetail',
                [
                    'contentId' => $id,
                    'data' => $data,
                    'actors' => $actors,
                    'languages' => $languages,
                    'seasons' => $seasons,
                ]
            );
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Content Not Found',
            ]);
        }
    }

    public function addSeason(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'series_id' => 'required',
            'title' => 'required',
            'trailer_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }

        $season = new Season;
        $season->series_id = $request->series_id;
        $season->title = $request->title;
        $season->trailer_id = $request->trailer_id;
        $season->save();

        return response()->json([
            'status' => 200,
            'message' => 'Season Added Successfully',
        ]);
    }

    public function updateSeason(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'trailer_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }

        $season = Season::find($id);
        if ($season) {
            $season->title = $request->title;
            $season->trailer_id = $request->trailer_id;
            $season->save();

            return response()->json([
                'status' => 200,
                'message' => 'Season Updated Successfully',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Season Not Found',
            ]);
        }
    }

    public function deleteSeason($id)
    { {
            $season = Season::find($id);
            if ($season) {
                $season->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'Season Delete Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Season Not Found',
                ]);
            }
        }
    }

    public function addEpisode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'season_id' => 'required',
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
}
