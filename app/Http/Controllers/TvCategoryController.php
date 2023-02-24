<?php

namespace App\Http\Controllers;

use App\Models\TvCategory;
use App\Models\TvCategoryIds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class TvCategoryController extends Controller
{
    public function tvCategory()
    {
        $tvCategoryCount =  TvCategory::count();

       return view('tvCategory',
            [
            'tvCategoryCount' => $tvCategoryCount,
            ]
        );
    }

    public function fetchTvCategoryList(Request $request)
    {

        $totalData =  TvCategory::count();
        $rows = TvCategory::orderBy('id', 'DESC')->get();

        $result = $rows;

        $columns = array(
            0 => 'id',
            1 => 'image',
            1 => 'title'
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $result = TvCategory::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $result =  TvCategory::Where('title', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = TvCategory::Where('title', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = array();
        foreach ($result as $item) {

            $image = '<img src="./upload/'. $item->image .'" alt="actor image" width="70px" height="70px" style="background: white; padding: 10px 10px;">';

            $edit = '<a data-title="' . $item->title . '" data-image="' . $item->image . '" href="" class="me-3 btn btn-primary px-4 text-white edit" rel=' . $item->id . ' >' . __("Edit") . '</a>';

            $delete = '<a href="" class="mr-2 btn btn-danger px-4 text-white delete" rel=' . $item->id . ' >' . __("Delete") . '</a>';

            $action = $edit . $delete;

            $data[] = array(
                $image,
                $item->title,
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

    public function storeTvCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required',
            'tvCategory' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $tvCategory = new TvCategory;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extenstion = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extenstion;
                $file->move('upload/', $filename);
                $tvCategory->image = $filename;
            }
            $tvCategory->title = $request->tvCategory;
            $tvCategory->save();
            return response()->json([
                'status' => 200,
                'message' => 'Tv Category Added Successfully',
            ]);
        }
    }

    public function updateTvCategory(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tvCategory' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }

        $tvCategory = TvCategory::find($id);
        if ($tvCategory) {
            if ($request->hasFile('image')) {
                $path = 'upload/' . $tvCategory->image;
                if (File::exists($path)) {
                    File::delete($path);
                }
                $file = $request->file('image');
                $extenstion = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extenstion;
                $file->move('upload/', $filename);
                $tvCategory->image = $filename;
            }
            $tvCategory->title = $request->tvCategory;
            $tvCategory->save();
            return response()->json([
                'status' => 200,
                'message' => 'TV Category Updated Successfully',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'TV Category Not Found',
            ]);
        }
    }

    public function deleteTvCategory($id)
    {
        {
            $tvCategory = TvCategory::find($id);
            $path = 'upload/' . $tvCategory->image;
            if (File::exists($path)) {
                File::delete($path);
            }
            if ($tvCategory) {
                $tvCategory->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'Tv Category Delete Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Tv Category Not Found',
                ]);
            }
        }
    }

    public function channelByCategory(Request $request)
    {
        $data = TvCategoryIds::where('tv_category_ids', $request->tvCategoryIds)->with('tvChannels')->get();
        return response()->json([
            'status' => true,
            'message' => 'Fetch Channel By Category',
            'data' => $data,
        ]);
    }

}
