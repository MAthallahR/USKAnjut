<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function welcome()
    {
        $user = Auth::user();
        
        return view('welcome', [
            'userName' => $user->nama // atau $user->name tergantung field di database
        ]);
    }
}

