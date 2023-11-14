<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Traits\Authentication;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

    public function register(){        
        return Inertia::render('Authentication/Register');
    }

    public function create(Request $request){
        
        // Will refactor in the future

        $data = $request->validate([
            'password' => 'required|string|confirmed',
            'username' => 'required|string|unique:users',
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'remember' => 'nullable'
        ]);

        User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'name' => $data['name'],
            'password' => Hash::make($data['password']),
        ]);

        $message = "Success registration!";
        return Inertia::render('Authentication/Login', compact('message'));

    }
}
