<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Traits\Authentication;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuthController extends Controller
{
    use Authentication;
    
    public function index(){        
        return Inertia::render('Authentication/Login');
    }

    public function login(Request $request){

        $data = $request->validate([
            'password' => 'required|string',
            'username' => 'required|string',
            'remember' => 'nullable'
        ]);

        return $this->authenticate($data);
    }
}
