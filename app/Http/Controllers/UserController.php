<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function user()
    {
        $userCount = User::count();
        return view('user',
        [
            'user' => $userCount
        ]
        );
    }

    public function userDetail(Request $request, $id)
    {
        $data = User::where('id', $id)->get()->first();
        return view('userDetail', [
            'data' => $data,
        ]);
    }
    public function fetchUserList(Request $request)
    {
        $totalData =  User::count();
        $rows = User::orderBy('id', 'DESC')->get();

        $result = $rows;

        $columns = array(
            0 => 'id',
            1 => 'title',
            2 => 'email',
            3 => 'total_purchase',
            4 => 'status',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $result = User::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $result =  User::Where('title', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = User::Where('title', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = array();
        foreach ($result as $item) {
            
            if ($item->image == null) {
                $item->image = "assets/img/profile.svg";
            }
            else {
                $item->image = 'upload/user/'.$item->image;
            }

            $image = '<img class="img-fluid" src="'.$item->image.'" style="width: 70px; height: 70px; object-fit: cover;">';



            $data[] = array(
                $image,
                $item->title,
                $item->email,
                $item->totle_purchase,
                $item->status,
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


    public function addUser(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->messages()->first(),
            ]);
        }
        
        $user = User::where('email',$request->email)->first();
        if ($user != null) {
            return response()->json([
                'status' => true,
                'message' => 'User is Already Exist',
                'data' => $user,
            ]);
        }
        
        $user = new User;
        $user->title = $request->title;
        $user->email = $request->email;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extenstion;
            $file->move('upload/user/', $filename);
            $user->image = $filename;
        }
        $user->totle_purchase = $request->totle_purchase;
        $user->save();
    
        return response()->json([
            'status' => true,
            'message' => 'User Added Successfully',
            'asga' => $user,
        ]);
    }
}
