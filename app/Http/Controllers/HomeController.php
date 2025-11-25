<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        if (Auth::check()){
            if (Auth::user()->role == 'admin'){
                return view('dashboard.admin.home');
            }
            if (Auth::user()->role == 'manager'){
                return view('dashboard.manager.home');
            }
                return view('dashboard.user.home');
        }else{
            return redirect('login');
        }
    }
}
