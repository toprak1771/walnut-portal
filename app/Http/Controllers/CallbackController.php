<?php

namespace App\Http\Controllers;

use App\Models\CallBackLog;
use App\Models\IncomingLog;
use App\Models\IncomingLogData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class CallbackController extends Controller
{
    public function callback(Request $request)
    {

        ini_set('max_execution_time', 300);

        try {
            $existingDataArray = [];
            $client = new Client([
                'timeout' => 300,
            ]);
            $response = $client->request('GET', "http://localhost:3000/puppeteer?url=https://www.bbc.com/news");
            $data = json_decode($response->getBody(), true);

            $createdIncomingLogDatas = IncomingLogData::create([
                'payload' => json_encode($data['data']),
            ]);

            foreach ($data['data'] as $item) {
                $existingData = IncomingLog::whereRaw('LOWER(title) = ? AND word_count = ?', [
                    strtolower($item['title']),
                    $item['word_count']
                ])->first();
                if (!$existingData) {
                    $createdIncomingLog = IncomingLog::create([
                        'title' => $item['title'],
                        'word_count' => $item['word_count'],
                        'source' => 'https://www.bbc.com/news',
                        'incoming_log_data_id' => $createdIncomingLogDatas->id
                    ]);

                    //Bug var çözülecek
                    // $apiResponse = $client->request('POST', 'http://127.0.0.1:8000/api/test-reciever', [
                    //     'json' => [
                    //         'id' => $createdIncomingLog->id,  // id'yi ekleyin
                    //         'title' => $item['title'],
                    //         'word_count' => $item['word_count']
                    //     ]
                    // ]);


                    // $apiResponseBody = json_decode($apiResponse->getBody(), true);
                    // Log::info('API Response:', $apiResponseBody);
                } else {
                    $existingDataArray[] = [
                        'title' => $item['title'],
                        'word_count' => $item['word_count'],
                        'source' => 'https://www.bbc.com/news',
                        "incoming_log_data_id" => $createdIncomingLogDatas->id
                    ];
                }
            }

            if (count($existingDataArray) > 0) {
                IncomingLogData::where('id', $createdIncomingLogDatas->id)
                    ->update([
                        'inserted' => json_encode($existingDataArray)
                    ]);
            }
            return response()->json(['message' => 'Veriler başarıyla kaydedildi']);
        } catch (\Exception $e) {
            Log::error('General Exception', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return response()->json(['error' => 'An unexpected error occurred', 'message' => $e->getMessage()], 500);
        }
    }

    public function test_receiver(Request $request)
    {
        ini_set('max_execution_time', 300); 
        try {
            $data = $request->all();

            $resultData = [
                'title' => $data['title'] ?? 'No Title',
                'word_count' => $data['word_count'] ?? 0
            ];

            $createdCallBackLog = CallBackLog::create([
                'status' => 'confirmed',
                'incoming_log_id' => $data['id'],
                'result' => json_encode($resultData),
            ]);

            $title = $resultData['title'];

            return response()->json([
                'ok' => true,
                'title' => $title,
            ]);
        } catch (\Exception $e) {
            Log::error('Callback API Error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'error' => 'Bir hata oluştu',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
