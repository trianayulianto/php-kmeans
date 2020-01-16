<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // $atribut = \App\Atribut::count();
        // $nilai = \App\NilaiAtribut::count();
        // $dataset = \App\Dataset::count();
        // $users = \App\User::count();
        return view('MyHome');
    }

    public function loginCheck()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        return redirect()->route('home.index');
    }
}
