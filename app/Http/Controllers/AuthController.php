<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|unique:users',
            'password' => 'required|min:6'
        ]);

        $email = $request->input("email");
        $password = $request->input("password");

        $hashPwd = Hash::make($password);

        $data = [
            "email" => $email,
            "password" => $hashPwd
        ];

        if (User::create($data)) {
            $response = [
                "message" => "register_success",
                "code"    => 201,
            ];
        }

        return response()->json($response, $response['code']);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required|min:6'
        ]);

        $email = $request->input("email");
        $password = $request->input("password");

        $user = User::where("email", $email)->first();

        if (!$user) {
            $response = [
                "message" => "login_vailed",
                "code"    => 401,
                "result"  => [
                    "token" => null,
                ]
            ];
            return response()->json($response, $response['code']);
        }

        if (Hash::check($password, $user->password)) {
            if (!$user->token) {
                $newtoken  = Str::random(80);

                $user->update([
                    'token' => $newtoken
                ]);
            }

            $user = User::where("email", $email)->first();

            $response = [
                "message" => "login_success",
                "code"    => 200,
                "result"  => [
                    "token" => $user->token,
                ]
            ];
        } else {
            $response = [
                "message" => "login_vailed",
                "code"    => 401,
                "result"  => [
                    "token" => null,
                ]
            ];
        }

        return response()->json($response, $response['code']);
    }

    public function cekToken(Request $request)
    {
        $token = $request->token;
        $check = User::where('token', $token)->exists();
        if ($check) {
            $response = [
                'code' => 200,
            ];
            return response()->json($response);
        } else {
            $response = [
                'code' => 401,
            ];
            return response()->json($response);
        }
    }
}
