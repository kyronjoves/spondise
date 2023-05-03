<?php

namespace App\Http\Controllers;

use JWTAuth;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use App\Interfaces\AuthInterface;

class AuthController extends Controller
{
    protected $interface;

    public function __construct(AuthInterface $interface)
    {
        $this->interface = $interface;
    }
    public function login(LoginRequest $request){
        return $this->interface->login($request);
    }

    public function register(RegisterRequest $request){

        return $this->interface->register($request);
        
    }

    public function redirectToGoogle(){
        return $this->interface->googleLogin();
    }
    
    public function handleCallback(){
        return $this->interface->handleCallback();
    }
}
