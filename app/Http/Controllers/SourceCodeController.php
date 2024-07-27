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
}
