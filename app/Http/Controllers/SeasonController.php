<?php

namespace App\Http\Controllers;

use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SeasonController extends Controller
{
    // storeNewSeason
    // public function storeNewSeason(Request $request)
    // {
      
    //     $validator = Validator::make($request->all(), [
    //         'series_id' => 'required',
    //         'title' => 'required',
    //         'trailer_id' => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => 400,
    //             'errors' => $validator->messages(),
    //         ]);
    //     }

    //     $season = new Season;
    //     $season->series_id = $request->series_id;
    //     $season->title = $request->title;
    //     $season->trailer_id = $request->trailer_id;
    //     $season->save();

    //     return response()->json([
    //         'status' => 200,
    //         'message' => 'Season Added Successfully',
    //     ]);
    // }

}
