<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    "prefix" => "users",
    "controller" => UserController::class
], function () {
    Route::get("/", "getAllUsers");
    Route::get("/{id}", "getUserById");
    Route::post("/", "createUser");
    Route::put("/{id}", "updateUser");
    Route::delete("/{id}", "deleteUser");
});

Route::group([
    // "middleware" => "authenticate",
    "prefix" => "source_code",
    "controller" => CodeController::class
], function () {
    Route::get('/{user_id}', 'getSourceCodesByUserId');
    Route::post('/', 'createSourceCode');
    Route::get('/{id}', 'readSourceCode');
    Route::get('/', 'getAllSourceCode');
    Route::put('/{id}', 'updateSourceCode');
});