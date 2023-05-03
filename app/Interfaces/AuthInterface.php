<?php
namespace App\Interfaces;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

interface AuthInterface {
  /* 
  @return string 
  */
  public function login(LoginRequest $request);

  public function register(RegisterRequest $request);

  public function googleLogin();

  public function handleCallback();
}