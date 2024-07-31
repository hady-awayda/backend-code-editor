<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use League\Csv\Reader;
use League\Csv\Statement;
use Illuminate\Support\Facades\Validator;
use App\Http\Services\ImportService;

class AdminController extends Controller
{
    public function getAllUsers() {
        $users = User::all();

        if (!$users) {
            return response()->json([
                'message' => 'No users found'
            ], 404);
        }

        return response()->json([
            'data' => $users
        ], 200);
    }

    public function importUsers(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json([
                'message' => 'No file was uploaded'
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:csv,txt|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
    
        $file = $request->file('file');
    
        if (!$file->isValid()) {
            return response()->json([
                'message' => 'Uploaded file is not valid'
            ], 400);
        }
    
        try {
            $csv = Reader::createFromPath($file->getRealPath(), 'r');
            $csv->setHeaderOffset(0);

            $stmt = Statement::create()
                ->offset(0)
                ->limit(1000);

            $records = $stmt->process($csv);

            $importedCount = 0;
            foreach ($records as $record) {
                $error = ImportService::insertUser($record);

                if ($error) {
                    return response()->json([
                        'error' => $error
                    ], 500);
                }

                $importedCount++;
            }

            return response()->json([
                'message' => 'Users imported successfully',
                'imported_count' => $importedCount
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while importing users',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
