<?php

namespace App\Services;

use JWTAuth;
use Socialite;
use Exception;
use Auth;
use App\Models\Role;
use App\Models\User;
use App\Interfaces\AuthInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class AuthService implements AuthInterface {

  private function authenticate($credentials){
    $token = JWTAuth::attempt($credentials);
    if (!$token) {
        return response()->json([
            'status' => 'error',
            'message' => 'Unauthorized',
        ], 401);
    }
    return response()->json([
        'status' => 'success',
        'authorization' => [
            'token' => $token,
            'type' => 'bearer',
        ]
    ]);
  }
  /* 
  @return json with token
  */
  public function login(LoginRequest $request) {
    try{
      $credentials = $request->only('email', 'password');
      return $this->authenticate($credentials);
    }catch(\Exception $e){
      return $e->getMessage();
    }
  }
    /* 
    @return json with default role to User
    */
  public function register(RegisterRequest $request) {
    try{
      DB::beginTransaction();
      $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password)
      ]);
      $res = $this->authenticate($request->only('email', 'password'));
      $return = json_decode($res->getContent());
      $return->user = $user;
      $res->setContent(json_encode($return));
      DB::commit();
      return $return;
    }catch(\Exception $e){ 
      DB::rollBack();
      return $e->getMessage();
    }
  }
  public function googleLogin(){
    
    return Socialite::driver('google')->redirect();
  }
  public function handleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $findUser = User::where('google_id', $user->id)->first();

            if (!is_null($findUser)){ 
              return response()->json([
                'status' => 'success',
                'driver-token' => $user->token
              ]);            
            }else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id
                ]);
                return response()->json([
                  'status' => 'success',
                  'driver-token' => $user->token,
                  'user' => $newUser
              ]);     
            }
        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}