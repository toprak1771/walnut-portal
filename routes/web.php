<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Test;
use App\Http\Controllers\AdminUserController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

Route::get('/', function () {
    return view('welcome');
});

Route::get('test', [Test::class, 'test_method']);

Route::prefix(('adminUser'))->withoutMiddleware(VerifyCsrfToken::class)
->group(function () {
    Route::post('create', [AdminUserController::class, 'create_admin_user']);
    Route::post('login', [AdminUserController::class, 'login']);
    Route::post('logout', [AdminUserController::class, 'logout']);
    Route::prefix('get')->group(function () {
        Route::get('user', [AdminUserController::class, 'get_user']);
        Route::get('all', [AdminUserController::class, 'get_all_admin_user']);
        Route::get('', [AdminUserController::class, 'get_admin_user_from_id']);
    });
    Route::delete(('delete'), [AdminUserController::class, 'delete_admin_user']);
    Route::put('update', [AdminUserController::class, 'update_admin_user']);
});
