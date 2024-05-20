<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseAPI;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Session;

class Login extends BaseAPI
{
    public function login(Request $request, Response $response)
    {
        $data = $request->all();

        // Validasi data
        $validator = Validator::make($data, [
            'email' => 'required',
            'password' => 'required',
        ]);

        // Kalau validasi gagal
        if ($validator->fails()) {
            return $this->sendErrorResponse('payload tidak valid', $validator->error(), 400);
        }

        // Kalau validasi berhasil
        // Mencoba login
        try {

            // Kalau login gagal
            if (!$token = JWTAuth::attempt($data)) {
                return $this->sendErrorResponse(...['message' => 'email atau password salah', 'statusCode' => 401]);
            }
        } catch (JWTException $e) {

            // Kalau gagal buat JWT
            return $this->sendErrorResponse(...['message' => 'email atau password salah', 'statusCode' => 401]);
        }

        // Kalau login berhasil
        return $this->sendSuccessResponse(
            'login sukses',
            [
                'token' => $token
            ]
        );
    }

    public function redirectGoogle(Request $request, Response $response)
    {
        Session::forget('state');
        Session::forget('code');
        Session::forget('oauth_state');

        return Socialite::driver('google')->redirect();
    }

    public function handleCallback(Request $request, Response $response)
    {
        $userGoogle = Socialite::driver('google')->user();

        try {

            $user = User::firstOrCreate([
                'name' => $userGoogle->getName(),
                'email' => $userGoogle->getEmail(),
                'password' => 'none'
            ]);

            $token = JWTAuth::fromUser($user);

            // Beri respon token
            return $this->sendSuccessResponse('login sukses', [
                'token' => $token
            ]);
        } catch (Exception $e) {

            return $this->sendErrorResponse(...['message' => 'tidak bisa membuat token', 'statusCode' => 500]);
        }
    }
}
