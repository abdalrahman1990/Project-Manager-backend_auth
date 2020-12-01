<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request) {
        $getRequest = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);

        if (Auth::attempt(['email' => $getRequest['email'], 'password' => $getRequest['password']])) {

            $user = Auth::user();
            $userRole = $user->role()->first();



            if($userRole) {
                $this->scope = $userRole->role;
            }

            $this->scope = 'basic';
            $token = $user->createToken($user->email.'_'.now(), [$this->scope]);

            return response()->json([
                'data' => $user = Auth::user(),
                'message' => trans("auth.login.success"),
                'status_code' => 200,
                'status_text' => "OK",

               // 'token' => $token->accessToken

            ],200);

        } else {
            return response()->json([
                'message' => 'Error '
            ]);
        }
    }

    public function register(Request $request){

        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email',
        //     'password' => 'required',
        //     'c_password' => 'required|same:password'
        //   ]);
        // if ($validator->fails()) {
        //   return response()->json(['error'=>$validator->errors()], 401);
        // }

        $getRequest = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'password' => 'required',
            'password_confirmation' => 'required|same:password'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
          ]);

        if($user instanceOf User)
            $getToken = $user->createToken('personal token');
        $token = $getToken->token;

        if($request['remember_token']){
           // $change= User::find($user->id);
           // $change->remember_token = $getToken->accessToken;
           // $change->save();
            $token->expires_at = Carbon::now()->addDays(15);
        }else{
            $token->expires_at = Carbon::now()->addDays();
        }
        $token->save();

        return response()->json([
            'access' => $getToken->accessToken,
            'token' => 'Bearer',
            'expires' => Carbon::parse(
                $token->expires_at
            )->toDateTimeString()
        ],200);
    }

    public function logout(){
        $user = Auth::user();
        if($user instanceOf User)
            $logout = $user->token()->revoke();
        return response()->json([
            'data' => 'you are logout'
        ], 201);
    }

    public function details(){
        $user = auth()->user ();
        return response()->json($user, 200);
    }



}
