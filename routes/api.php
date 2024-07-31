<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SourceCodeController;
use App\Http\Controllers\ConversationController;

Route::group([
    // "middleware" => "api",
    "prefix" => "auth",
    "controller" => AuthController::class
], function () {
    Route::post("/register", "register");
    Route::post("/login", "login");
    Route::post("/logout", "logout");
    Route::post("/refresh", "refresh");
});

Route::group([
    // 'middleware' => 'jwt.auth',
    "prefix" => "users",
    "controller" => UserController::class
], function () {
    Route::get("/{id}", "getUserById");
    Route::put("/{id}", "updateUser");
    Route::delete("/{id}", "deleteUser");
});

Route::group([
    'middleware' => 'jwt.auth',
    "prefix" => "source_codes",
    "controller" => SourceCodeController::class
], function () {
    Route::get('/{user_id}', 'getSourceCodesByUserId');
    Route::post('/', 'createSourceCode');
    Route::put('/{id}', 'updateSourceCode');
    Route::delete('/{id}', 'deleteSourceCode');
});

Route::group([
    // 'middleware' => 'jwt.auth',
    "prefix" => "messages",
    "controller" => MessageController::class
], function () {
    Route::get("/{user_id_1}/{user_id_2}", "getMessagesBetweenUsers");
    Route::post("/", "addMessageToConversation");
});

Route::group([
    // 'middleware' => 'jwt.auth',
    "prefix" => "conversations",
    "controller" => ConversationController::class
], function () {
    Route::get("/{user_id}", "getUserConversations");
});

Route::group([
    // 'middleware' => 'jwt.auth',
    "prefix" => "search",
    "controller" => SearchController::class
], function () {
    Route::get("/{username}", "search");
});

Route::group([
    // 'middleware' => 'jwt.auth',
    "middleware" => "admin",
    "prefix" => "admin",
    "controller" => AdminController::class
], function () {
    Route::get("/", "getAllUsers");
    Route::post("/import", "importUsers");
});
