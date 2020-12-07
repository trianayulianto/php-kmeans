<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $kriteria = \App\Kriteria::count();
        $alternatif = \App\Alternatif::count();
        $users = \App\User::count();
        return view('MyHome', compact('kriteria','alternatif','users'));
    }

    public function loginCheck()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        return redirect()->route('home.index');
    }
}
