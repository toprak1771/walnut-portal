<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use App\Models\IncomingLog;
use App\Models\IncomingLogData;
use Illuminate\Http\Request;

class Test extends Controller
{
    public function test_method(){
        // AdminUser::create([
        //     'name'=>'Test',
        //     'email'=>'toprak@hotmail.com',
        //     'password'=>'toprak'
        // ]);
        $incoming_log_data_model = IncomingLogData::create([
            'payload'=>'{"source":"test","title":"test","word_count":1}',
            'inserted'=>'{"source":"test","title":"test","word_count":1}',
        ]);

        IncomingLog::create([
            'source'=>'test',
            'title'=>'test',
            'word_count'=>1,
            'incoming_log_data_id'=>$incoming_log_data_model->id
        ]);

        // $incoming_log = IncomingLog::with('IncomingLogData')->get();
        // logger()->info(json_decode($incoming_log));
        // dd($incoming_log);

        $incoming_log = IncomingLog::find(2);
        dd($incoming_log);
    }
}
