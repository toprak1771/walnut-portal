<?php


use App\Http\Controllers\CallbackController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('callback', [CallbackController::class, 'callback']);
Route::post('test-reciever',[CallbackController::class, 'test_receiver']);
