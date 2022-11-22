<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller {
    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $email = $request->input("email");
        $password = $request->input("password");

        $hashPwd = Hash::make($password);

        $data = [
            "email" => $email,
            "password" => $hashPwd
        ];

        if (User::where('email', $email)->exists()) {
            $response = [
                "message" => "username is exist",
                "code"    => 422,
            ];
            return response()->json($response);
        }


        if (User::create($data)) {
            $response = [
                "message" => "register_success",
                "code"    => 201,
            ];
        } else {
            $response = [
                "message" => "vailed_regiser",
                "code"   => 404,
            ];
        }

        return response()->json($response, $response['code']);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $email = $request->input("email");
        $password = $request->input("password");

        $user = User::where("email", $email)->first();

        if (!$user) {
            $out = [
                "message" => "login_vailed",
                "code"    => 401,
                "result"  => [
                    "token" => null,
                ]
            ];
            return response()->json($out, $out['code']);
        }

        if (Hash::check($password, $user->password)) {
            $newtoken  = Str::random(80);

            $user->update([
                'token' => $newtoken
            ]);

            $response = [
                "message" => "login_success",
                "code"    => 200,
                "result"  => [
                    "token" => $newtoken,
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
}
