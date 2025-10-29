<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class BerandaController extends Controller
{
    public function index()
    {
        // Jika admin tidak boleh buka beranda user
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.beranda');
        }

        return view('beranda');
    }

    public function admin()
    {
        // Jika user biasa tidak boleh buka beranda admin
        if (Auth::user()->role === 'user') {
            return redirect()->route('beranda');
        }

        return view('admin.beranda');
    }
}
