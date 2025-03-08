<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Test;


Route::get('/', function () {
    return view('welcome');
});
Route::get('test',[Test::class,'test_method']);
