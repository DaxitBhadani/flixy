<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GenreController extends Controller
{
    public function genre()
    {
        $genreCount = Genre::count();

        return view(
            'genre',
            [
                'genreCount' => $genreCount,

            ]
        );
    }

    public function fetchGenreList(Request $request)
    {

        $totalData =  Genre::count();
        $rows = Genre::orderBy('id', 'DESC')->get();

        $result = $rows;

        $columns = array(
            0 => 'id',
            1 => 'title'
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $result = Genre::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $result =  Genre::Where('title', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Genre::Where('title', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = array();
        foreach ($result as $item) {

            $edit = '<a data-title="' . $item->title . '" href="" class="me-3 btn btn-primary px-4 text-white edit" rel=' . $item->id . ' >' . __("Edit") . '</a>';

            $delete = '<a href="" class="mr-2 btn btn-danger px-4 text-white delete" rel=' . $item->id . ' >' . __("Delete") . '</a>';

            $action = $edit . $delete;

            $data[] = array(
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

    public function storeGenre(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'genre' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $genre = new Genre;
            $genre->title = $request->genre;
            $genre->save();
            return response()->json([
                'status' => 200,
                'message' => 'Genre Added Successfully',
            ]);
        }
    }

    public function updateGenre(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'genre' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }

        $genre = Genre::find($id);
        if ($genre) {
            $genre->title = $request->genre;
            $genre->save();
            return response()->json([
                'status' => 200,
                'message' => 'Genre Updated Successfully',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Genre Not Found',
            ]);
        }
    }

    public function deleteGenre($id)
    {
        $genre = Genre::find($id);
        if ($genre) {
            $genre->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Genre Delete Successfully',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Genre Not Found',
            ]);
        }
    }


   
}
