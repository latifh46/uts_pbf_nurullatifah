<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\ModelUsers;
use Illuminate\Database\QueryException;

class Register
{
    public function create(Request $request, Response $response)
    {
        $data = $request->all();

        // Validasi data
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);

        // Kalau validasi gagal
        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => 'payload tidak valid',
                    'error' => $validator->errors(),
                ],
                400
            );
        }

        // Kalau validasi berhasil
        try {

            ModelUsers::insert([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);

            return response()->json([
                'message' => 'registrasi akun berhasil'
            ]);
        } catch (QueryException $e) {

            if ($e->errorInfo[1] == '1062') {

                return response()->json([
                    'message' => 'email sudah terdaftar'
                ], 409);
            } else {

                return response()->json([
                    'message' => 'kesalahan pada server. gagal insert data'
                ], 500);
            }
        }
    }
}
