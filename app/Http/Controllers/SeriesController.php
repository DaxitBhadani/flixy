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
    {
        {
            $season = Season::where('id', $id);

            if ($season) {
                Episode::where('season_id', $id)->delete();
                $season->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'Season and Episode Delete Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Season Not Found',
                ]);
            }
        }
    } 
}
