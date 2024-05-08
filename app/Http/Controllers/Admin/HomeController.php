<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class HomeController extends Controller
{
    //

    function loginForm(){
        return view('admin.auth.login');
    }

    function login(Request $request){
        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required'
        ], );

        $login = auth('admin')->attempt($request->except('_token'));

        if($login){
            return to_route('admin.dashboard');
        }else{
            return back()->withErrors('Invalid Email, Password');
        }
    }

    function dashboard(){
        $data['users'] = User::all();
        return view('admin.dashboard',compact('data'));
    }
    function storeUser(Request $request){


        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'account_type' => 'required|in:Individual,Business',
            'password' => 'required|string|min:8',
        ]);

        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->account_type = $request->account_type;
            $user->balance = 0;
            $user->password = Hash::make($request->password);
            $user->save();

            Toastr::success('New User Created');
            return back();
        } catch (\Throwable $th) {
            dd($th);
            Toastr::error('Failed to create User');
            return back()->withInput();
        }

        

    }
}
