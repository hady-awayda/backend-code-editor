<?php

use App\Helpers\AdminHelper;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SourceCodeController;
use App\Http\Controllers\AuthController;

Route::group([
    "prefix" => "auth",
    "controller" => AuthController::class
], function () {
    Route::post("/register", "register");
    Route::post("/login", "login");
});

Route::group([
    'middleware' => 'jwt.verify',
    "prefix" => "users",
    "controller" => UserController::class
], function () {
    Route::get("/", "getAllUsers");
    Route::get("/{id}", "getUserById");
    Route::put("/{id}", "updateUser");
    Route::delete("/{id}", "deleteUser");
});

Route::group([
    'middleware' => 'jwt.verify',
    "prefix" => "source_codes",
    "controller" => SourceCodeController::class
], function () {
    Route::get('/{user_id}', 'getSourceCodesByUserId');
    Route::post('/', 'createSourceCode');
    Route::put('/{id}', 'updateSourceCode');
    Route::delete('/{id}', 'deleteSourceCode');
});

Route::group([
    'middleware' => 'jwt.verify',
    "prefix" => "messages",
    "controller" => MessageController::class
], function () {
    Route::get("/{user_id_1}/{user_id_2}", "getMessagesBetweenUsers");
    Route::post("/", "addMessageToConversation");
});