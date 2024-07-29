<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SourceCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class SourceCodeController extends Controller
{
    public function getSourceCodesByUserId($userId) {
        $this->authorize('view', SourceCode::class);

        $sourceCodes = SourceCode::where('user_id', $userId)->get();
        
        return response()->json([
            "data" => $sourceCodes
        ], 200);
    }

    public function createSourceCode(Request $req)
    {
        $validator = Validator::make($req->all(), [
            "user_id" => "required|exists:users,id|numeric",
            "title" => "required|string|max:255",
            "code" => "required|string|min:0"
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        $code = new SourceCode();
        
        $validated_data = $validator->validated();

        $code->fill($validated_data);
        $code->save();
        
        return response()->json([
                'message' => 'Source code created successfully'
            ], 201);
    }

    public function updateSourceCode(Request $req, $id)
    {
        $code = SourceCode::find($id);
        
        if (!$code) {
            return response()->json(['message' => 'Code not found'], 404);
        }
        
        $validator = Validator::make($req->all(), [
            "user_id" => "required|exists:users,id|numeric",
            "title" => "required|string|max:255",
            "code" => "required|string|min:0",
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($req['user_id'] != $code->user_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        $validated_data = $validator->validated();
        $code->update($validated_data);
    
        return response()->json(['message' => 'Updated successfully'], 200);
    }

    public function deleteSourceCode($id)
    {
        $code = SourceCode::find($id);
        
        if (!$code) {
            return response()->json(['error' => 'Code not found'], 404);
        }
        
        $code->delete();
        
        return response()->json(['message' => 'Deleted successfully'], 200);
    }
}