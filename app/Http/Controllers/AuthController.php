<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Auth;

class AuthController extends Controller
{

    public function login()
    {
        if (Session::get('username')) {
            return redirect('/index');
        }
        return  view('login');
    }
    public function doLogin(Request $req){

        $data = Auth::where('username', $req->username)->first();

        if ($data && $req->username == $data['username'] && $req->password == $data['password']) {
            $req->session()->put('username', $data['username']);
            return  redirect('index');
        } else {
            Session::flash('message', 'Wrong credentials!');
            return redirect()->route('login');
        }
    }

    function logout()
    {

        session()->pull('username');
        return  redirect(url('/login'));
    }
    
 
}
