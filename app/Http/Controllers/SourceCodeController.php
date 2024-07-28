<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SourceCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class SourceCodeController extends Controller
{
    public function getSourceCodesByUserId($userId) {
        $sourceCodes = SourceCode::where('user_id', $userId)->get();
        return response()->json([
            "data" => $sourceCodes
        ], 200);
    }


    public function createSourceCode(Request $req)
    {
        $validated_data = $req->validate([
            "user_id" => "required|exists:users,id|numeric",
            "title" => "required|string|max:255",
            "code" => "required|string|min:0"
        ]);
        $code = new SourceCode;
        $code->fill($validated_data);
        $code->save();
        return response()->json([
            "code" => $code,
            "message" => 'created successfully'
        ], 201);
    }

    public function readSourceCode($id)
    {
        $code = SourceCode::find($id);
        return response()->json([
            "code" => $code
        ], 200);
    }

    public function getAllSourceCode()
    {
        $code = SourceCode::all();
        return response()->json([
            "code" => $code
        ], 200);
    }

    public function updateSourceCode(Request $req, $id)
    {
        try {
            $code = SourceCode::find($id);
            if (!$code) {
                return response()->json(['message' => 'Code not found'], 404);
            }

            $validated_data = $req->validate([
                "title" => "required|string|max:255",
                "code" => "required|string",
                "user_id" => "required|exists:users,id|numeric",
            ]);

            $code->update($validated_data);

            return response()->json(['message' => 'updated successfully'], 204);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Error:', $e->errors());

            return response()->json(['message' => 'Validation Error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error($e);

            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }

    public function deleteSourceCode($id)
    {
        $code = SourceCode::find($id);
        $code->delete();
        if ($code) {
            $code->delete();
            return response()->json(null, 204);
        } else {
            return response()->json(['error' => 'Code not found'], 404);
        }
    }
}