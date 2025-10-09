<?php

declare(strict_types=1);

namespace App\Services\API;

use Illuminate\Support\Facades\Http;

class AIService 
{
    public static function apiAI(array $prompt): ?array
    {
        $apiKey = config('app.openrouter_key');
        
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $apiKey,
        ])->post('https://openrouter.ai/api/v1/chat/completions', [
            'model' => 'meta-llama/llama-3.3-70b-instruct:free',
            'messages' => $prompt,
        ]);

        if($response->failed() || !$response->successful()) {
            return null;
        }

        $data = $response->json();

        if(!isset($data['choices'][0]['message']['content'])) {
            return null;
        }

        $body = $data['choices'][0]['message']['content'];
        $decodedBody = json_decode($body, true);

        if(json_last_error() !== JSON_ERROR_NONE || !is_array($decodedBody)){
            return null;
        }

        return $decodedBody;
    }
}