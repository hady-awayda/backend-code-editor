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
}