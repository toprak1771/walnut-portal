<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use Illuminate\Http\Request;

class Test extends Controller
{
    public function test_method(){
        AdminUser::create([
            'name'=>'Test',
            'email'=>'toprak@hotmail.com',
            'password'=>'toprak'
        ]);
    }
}
