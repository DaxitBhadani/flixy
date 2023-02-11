<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LanguageController extends Controller
{
    //
    public function language()
    {
        $languageCount = Language::count();
        return view('language',
        [
            'languageCount' => $languageCount,
        ]
    );
    }

    public function fetchLanguageList(Request $request)
    {

        $totalData =  Language::count();
        $rows = Language::orderBy('id', 'DESC')->get();

        $result = $rows;

        $columns = array(
            0 => 'id',
            1 => 'LanguageName'
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $result = Language::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $result =  Language::Where('languageName', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Language::Where('languageName', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = array();
        foreach ($result as $item) {

            $edit = '<a data-title="' . $item->languageName . '" href="" class="me-3 btn btn-primary px-4 text-white edit" rel=' . $item->id . ' >' . __("Edit") . '</a>';

            $delete = '<a href="" class="mr-2 btn btn-danger px-4 text-white delete" rel=' . $item->id . ' >' . __("Delete") . '</a>';

            $action = $edit . $delete;

            $data[] = array(
                $item->languageName,
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

    public function storeLanguage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'languageName' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $language = new Language;
            $language->languageName = $request->languageName;
            $language->save();
            return response()->json([
                'status' => 200,
                'message' => 'Language Added Successfully',
            ]);
        }
    }

    public function updateLanguage(Request $request,  $id)
    {

        $validator = Validator::make($request->all(), [
            'languageName' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }

        $language = Language::find($id);
        if ($language) {
            $language->languageName = $request->languageName;
            $language->save();
            return response()->json([
                'status' => 200,
                'message' => 'language Updated Successfully',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'language Not Found',
            ]);
        }
    }

    public function deleteLanguage($id)
    {
        $language = Language::find($id);
        if ($language) {
            $language->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Language Delete Successfully',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Language Not Found',
            ]);
        }
    }
}
