<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthCreateRequest;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Traits\Authentication;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use Authentication;
    
    public function index(){        
        return Inertia::render('Authentication/Login');
    }

    public function login(AuthLoginRequest $request){

        $data = $request->validated();

        return $this->authenticate($data);
    }

    public function register(){        
        return Inertia::render('Authentication/Register');
    }

    public function create(AuthCreateRequest $request){
        
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return Inertia::render('Authentication/Login', [ 'message' => "Success registration!"]);

    }
}
