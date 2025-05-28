<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AIChatController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'history' => 'array'
        ]);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.openrouter.api_key'),
                'Content-Type' => 'application/json'
            ])->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => 'deepseek/deepseek-chat:free',
                'messages' => $request->history
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['choices'][0]['message']['content'])) {
                    return response()->json([
                        'response' => $data['choices'][0]['message']['content']
                    ]);
                }
            }

            return response()->json([
                'error' => 'Failed to get response from AI service'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while processing your request'
            ], 500);
        }
    }
} 