<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseAPI;
use App\Models\ModelCategories;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class Categories extends BaseAPI
{
    public function read(Request $request, Response $response)
    {
        $categories = ModelCategories::all();

        return $this->sendSuccessResponse('get data berhasil', $categories);
    }

    public function create(Request $request, Response $response)
    {
        $data = $request->all();

        // Validasi data
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
        ]);

        // Kalau validasi gagal
        if ($validator->fails()) {
            return $this->sendErrorResponse('payload tidak valid', $validator->error(), 400);
        }

        // Kalau validasi berhasil
        // Mencoba meng-insert data
        try {
            ModelCategories::insert([
                'name' => $data['name']
            ]);

            return $this->sendSuccessResponse('insert kategori berhasil');
        } catch (QueryException $e) {

            return $this->sendErrorResponse(...['message' => 'kesalahan pada server. gagal insert data', 'statusCode' => 500]);
        }
    }

    public function update($id = null, Request $request, Response $response)
    {
        $data = $request->all();

        // Validasi data
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
        ]);

        // Kalau validasi gagal
        if ($validator->fails()) {
            return $this->sendErrorResponse('payload tidak valid', $validator->error(), 400);
        }

        // Kalau validasi berhasil
        // Check id
        $find = ModelCategories::find($id);

        if (!$find)
            return $this->sendErrorResponse(...['message' => 'id tidak ditemukan', 'statusCode' => 404]);

        // Update data
        try {
            $find->update([
                'name' => $data['name'],
            ]);

            return $this->sendSuccessResponse('update kategori berhasil');
        } catch (QueryException $e) {

            return $this->sendErrorResponse(...['message' => 'kesalahan pada server. gagal update data', 'statusCode' => 500]);
        }
    }

    public function delete($id = null, Request $request, Response $response)
    {
        // Check id
        $find = ModelCategories::find($id);

        if (!$find) {
            return $this->sendErrorResponse(...['message' => 'id tidak ditemukan', 'statusCode' => 404]);
        }

        // Delete data
        try {
            $find->delete();

            return $this->sendSuccessResponse('delete kategori berhasil');
        } catch (QueryException $e) {

            return $this->sendErrorResponse(...['message' => 'kesalahan pada server. gagal delete data', 'statusCode' => 500]);
        }
    }
}
