<?php

namespace App\Http\Controllers;

use App\Models\TvCategory;
use App\Models\TvChannel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class TvChannelController extends Controller
{
    public function tvChannel()
    {
        $tvChannelCount =  TvChannel::count();
        $tvCategories = TvCategory::get();
        return view(
            'tvChannel',
            [
                'tvChannelCount' => $tvChannelCount,
                'tvCategories' => $tvCategories,
            ]
        );
    }

    public function fetchTvChannelList(Request $request)
    {

        $totalData =  TvChannel::count();
        $rows = TvChannel::orderBy('id', 'DESC')->get();

        $result = $rows;

        $columns = array(
            0 => 'id',
            1 => 'image',
            2 => 'title'
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $result = TvChannel::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $result =  TvChannel::Where('title', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = TvChannel::Where('title', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = array();
        foreach ($result as $item) {

            $image = '<img src="./upload/' . $item->image . '" alt="Tv Channel image" width="70px" height="70px" style="background: #343434; padding: 4px 4px;">';

           

            $edit = '<a data-title="' . $item->title . '" data-categoryids="' . $item->category_ids . '"  data-accesstype="' . $item->access_type . '" data-sourcetype="' . $item->source_type . '" data-image="' . $item->image . '" data-sourceurl="' . $item->source_url . '" href="" class="me-3 btn btn-primary px-4 text-white edit" rel=' . $item->id . ' >' . __("Edit") . '</a>';

            $delete = '<a href="" class="mr-2 btn btn-danger px-4 text-white delete" rel=' . $item->id . ' >' . __("Delete") . '</a>';

            $action = $edit . $delete;

            $explode_id = explode(',', $item->category_ids);
            $categories = TvCategory::whereIn('id', $explode_id)->pluck('title');

            $data[] = array(
                $image,
                $item->title,
                $categories,
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

    public function storeTvChannel(Request $request)
    {

        // return response()->json([
        //     'status' => 200,
        //     'message' => $request->category,
        // ]);

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'access_type' => 'required',
            'category_ids' => 'required',
            'source_type' => 'required',
            'source_url' => 'required',
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }

        $tvChannel = new TvChannel;
        $tvChannel->title = $request->title;
        $tvChannel->access_type = $request->access_type;

        $tvChannel->category_ids =  implode(',', $request->category_ids);

        $tvChannel->source_type = $request->source_type;
        $tvChannel->source_url = $request->source_url;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extenstion;
            $file->move('upload/', $filename);
            $tvChannel->image = $filename;
        }
        $tvChannel->save();

        return response()->json([
            'status' => 200,
            'message' => 'Tv Channel Added Successfully',
        ]);
    }

    public function updateTvChannel(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'access_type' => 'required',
            'category_ids' => 'required',
            'source_type' => 'required',
            'source_url' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }

        $tvChannel = TvChannel::find($id);
        if ($tvChannel) {
            
            $tvChannel->title = $request->title;
            $tvChannel->access_type = $request->access_type;
            $tvChannel->category_ids = implode(',', $request->category_ids);
            $tvChannel->source_type = $request->source_type;
            $tvChannel->source_url = $request->source_url;

            if ($request->hasFile('image')) {
                $path = 'upload/' . $tvChannel->image;
                if (File::exists($path)) {
                    File::delete($path);
                }
                $file = $request->file('image');
                $extenstion = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extenstion;
                $file->move('upload/', $filename);
                $tvChannel->image = $filename;
            }
            $tvChannel->save();
            return response()->json([
                'status' => 200,
                'message' => 'TV Channel Updated Successfully',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'TV Channel Not Found',
            ]);
        }
    }


    public function deleteTvChannel($id)
    {
        {
            $tvChannel = TvChannel::find($id);
            $path = 'upload/' . $tvChannel->image;
            if (File::exists($path)) {
                File::delete($path);
            }
            if ($tvChannel) {
                $tvChannel->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'Tv Channel Delete Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Tv Channel Not Found',
                ]);
            }
        }
    }

    function test()
    {
        $musics = TvChannel::with('tvCategories')->pluck('category');
        return response()->json([
            'status' => 200,
            'message' => $musics,
        ]);

        // $array = ["1", "2", "3"];
        // $data = implode(",", $array);
        // return response()->json([
        //     'status' => 200,
        //     'message' => 'Tv Channel Added Successfully',
        //     'data' =>  $data
        // ]);
    }

    public function liveTV(Request $request)
    {

        $query = TvChannel::query();

        if ($request->has('category_ids')) {
            $query->Where('category_ids', $request->category_ids);
        }

        $tvChannels = $query->with('tvCategories')->get();
        $data = [];
        foreach ($tvChannels as $tvChannel) {
            $ids = explode(',', $tvChannel->category_ids);
            $tvChannel->category_ids = TvCategory::whereIn('category_ids', $ids)->get();
            array_push($data, $tvChannels);
        }

        return response()->json([
            'status' => true,
            'message' => 'Search Content',
            'data' =>  $data,
        ]);



        // $tvChannel = TvChannel::where('category_ids', $request->category_ids)->with('tvCategories')->get();
        // $tvCategory = TvCategory::with('tvChannels')->get();
        // $array = $tvChannel->category_ids;
        // $data = implode(",", $array);
        // return response()->json(['status' => 200,'data' =>  $array]);
        // return response()->json([
        //     'status' => 200,
        //     'message' => $tvCategory,
        //     'message' => $array,
        // ]);

       
      
    }
}
