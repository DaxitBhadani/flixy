<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ActorController extends Controller
{
    public function actors()
    {
        $actorCount = Actor::count();
        return view('actors',
        [
        'actorCount' => $actorCount
        ]
    );
    }

    public function fetchActorList(Request $request)
    {

        $totalData =  Actor::count();
        $rows = Actor::orderBy('id', 'DESC')->get();

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
            $result = Actor::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $result =  Actor::Where('name', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Actor::Where('name', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = array();
        foreach ($result as $item) {

            $image = '<img src="./upload/'. $item->image .'" alt="actor image" width="50px" height="50px" style="object-fit: cover;">';

            $edit = '<a data-title="' . $item->name . '" data-image="' . $item->image . '" href="" class="me-3 btn btn-primary px-4 text-white edit" rel=' . $item->id . ' >' . __("Edit") . '</a>';

            $delete = '<a href="" class="mr-2 btn btn-danger px-4 text-white delete" rel=' . $item->id . ' >' . __("Delete") . '</a>';

            $action = $edit . $delete;

            $data[] = array(
                $image,
                $item->name,
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

    public function storeActor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required',
            'actor' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $actor = new Actor;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extenstion = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extenstion;
                $file->move('upload/', $filename);
                $actor->image = $filename;
            }
            $actor->name = $request->actor;
            $actor->save();
            return response()->json([
                'status' => 200,
                'message' => 'Actor Added Successfully',
            ]);
        }
    }

    public function updateActor(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'actor' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }

        $actor = Actor::find($id);
        if ($actor) {
            if ($request->hasFile('image')) {
                $path = 'upload/' . $actor->image;
                if (File::exists($path)) {
                    File::delete($path);
                }
                $file = $request->file('image');
                $extenstion = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extenstion;
                $file->move('upload/', $filename);
                $actor->image = $filename;
            }
            $actor->name = $request->actor;
            $actor->save();
            return response()->json([
                'status' => 200,
                'message' => 'Actor Updated Successfully',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Actor Not Found',
            ]);
        }
    }

    public function deleteActor($id)
    {
        {
            $actor = Actor::find($id);
            $path = 'upload/' . $actor->image;
            if (File::exists($path)) {
                File::delete($path);
            }
            if ($actor) {
                $actor->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'Actor Delete Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Actor Not Found',
                ]);
            }
        }
    }

}
