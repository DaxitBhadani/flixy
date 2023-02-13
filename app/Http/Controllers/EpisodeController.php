<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class EpisodeController extends Controller
{

    public function episodeSource($id)
    {
        $episode = Episode::find($id)->all()->first();
        $data = Episode::where('id', $id)->first();
        return view('episodeDetail',[
            'episodes' => $episode,
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

            $episodeDetail = '<a href="source/'.$item->id .'" class="btn btn-secondary me-3" style="white-space: nowrap;">Episode Detail</a>';

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

}
