<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
    public function wishlistAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'content_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->messages()->first(),
            ]);
        }

        $wishlist = Wishlist::where('user_id', $request->user_id)->where('content_id', $request->content_id)->get()->first();
        if ($wishlist != null) {
            return response()->json([
                'status' => true,
                'message' => 'wishlist is Already Exist',
                'data' => $wishlist,
            ]);
        }

        $wishlist = new Wishlist;
        $wishlist->user_id = (int)$request->user_id;
        $wishlist->content_id = (int)$request->content_id;
        $wishlist->save();

        return response()->json([
            'status' => true,
            'message' => 'wishlist Added Successfully',
            'data' => $wishlist,
        ]);
    }


    public function wishlistRemove(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'content_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->messages()->first(),
            ]);
        }

        $wishlist = Wishlist::where('user_id', $request->user_id)->where('content_id', $request->content_id)->get()->first();

        if ($wishlist == true) {
            $wishlist->delete();
            return response()->json([
                'status' => true,
                'message' => 'wishlist Remove Successfully',
                'data' => $wishlist,
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'wishlist Data Not Found',
            ]);
        }
    }

    public function fetchWishlist(Request $request)
    {
        $data = Wishlist::where('user_id', $request->user_id)->with('content')->get();
        if ($data == null) {
            return response()->json([
                'status' => false,
                'message' => 'Wishlist not found',
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Fetch Wishlist',
            'data' => $data,
        ]);

       
    }
}
