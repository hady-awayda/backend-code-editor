<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\ImportService;

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
        // $validator = Validator::make($request->all(), [
        //     'file' => 'required|file|mimes:csv,txt|max:10240',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'message' => 'Validation failed',
        //         'errors' => $validator->errors()
        //     ], 422);
        // }

        $file = $request->file('file');

        try {
            $csv = Reader::createFromPath($file->getRealPath(), 'r');
            $csv->setHeaderOffset(0);

            $stmt = Statement::create()
                ->offset(0)
                ->limit(1000);

            $records = $stmt->process($csv);

            $importedCount = 0;
            foreach ($records as $record) {
                // $recordValidator = Validator::make($record, [
                //     'id' => 'required',
                //     'name' => 'required|string|max:255',
                //     'email' => 'required|email|max:255',
                //     'created_at' => 'required',
                //     'updated_at' => 'required',
                // ]);

                if ($recordValidator->fails()) {
                    continue;
                }

                ImportService::insertUser($record);
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
