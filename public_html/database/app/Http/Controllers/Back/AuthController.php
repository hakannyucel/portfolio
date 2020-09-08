<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// Model
use App\Models\Admin;

class AuthController extends Controller
{
    // Admin Login Route
    public function adminLogin(){
        return view('Back.Login');
    }

    // Admin Login
    public function adminPost(Request $request){
        // Declare form value
        $email = $request->post('email');
        $password = $request->post('password');

        // Verify Admin Auth
        if(Auth::attempt(['email' => $email, 'password' => $password])){
            toastr()->success('Hoşgeldin '.Auth::user()->name);
            return redirect()->route('admin.dashboard');
            die;
        }else{
            return redirect()->route('admin.login')->withErrors('Eposta veya şifre hatalı.');
        }
    }

    // Admin Logout
    public function adminLogout(){
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
