<?php

namespace App\Http\Controllers; 

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Arahkan ke rute masing-masing berdasarkan peran
        if ($user->peran === 'admin') {
            return redirect('admin/dashboard');
        } elseif ($user->peran === 'petugas') {
            return redirect('petugas/dashboard');
        } elseif ($user->peran === 'nasabah') {
            return redirect('nasabah/dashboard');
        }

        return redirect('/');
    }
}