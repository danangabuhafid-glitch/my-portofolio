<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PortfolioService;

class HomeController extends Controller
{
    protected $portfolioService;

    public function __construct(PortfolioService $portfolioService)
    {
        $this->portfolioService = $portfolioService;
    }

    public function index()
    {
        $data = $this->portfolioService->getHomeData();
        return view('welcome', $data);
    }

    public function chat(Request $request)
    {
        $prompt = $request->input('prompt', '');
        
        if (empty(trim($prompt))) {
            return response()->json(['response' => 'Command empty.']);
        }

        try {
            $apiKey = config('services.gemini.key') ?? env('GEMINI_API_KEY');
            
            $models = [
                'gemini-2.0-flash',
                'gemini-1.5-flash',
                'gemini-1.5-flash-8b',
            ];

            $response = null;
            $json = null;

            foreach ($models as $model) {
                $response = \Illuminate\Support\Facades\Http::withHeaders([
                    'Content-Type' => 'application/json'
                ])->post('https://generativelanguage.googleapis.com/v1beta/models/' . $model . ':generateContent?key=' . $apiKey, [
                    'contents' => [
                        ['parts' => [['text' => $prompt]]]
                    ],
                    'systemInstruction' => [
                        'parts' => [['text' => 'You are Danang Abu Hafid\'s professional AI assistant inside his portfolio website terminal. Your SOLE purpose is to answer questions about Danang, his portfolio, his projects, his skills, and his professional experience. If the user asks about ANYTHING ELSE (such as coding tutorials, general knowledge, news, Laravel facts, etc.), you MUST politely decline and state that you are only programmed to discuss Danang\'s professional portfolio. Answer professionally, concisely, in a helpful manner. Strictly DO NOT use any emojis. Answer in the language the user speaks.']]
                    ]
                ]);

                if ($response->successful()) {
                    $json = $response->json();
                    break; // Success! Exit the loop.
                }

                if ($response->status() !== 429) {
                    $json = $response->json();
                    break; // If it's a real error (not just rate limit), break and return it.
                }
                
                // If 429 (Rate Limit), the loop continues to the next model.
            }
            
            if ($response && $response->successful() && isset($json['candidates'][0]['content']['parts'][0]['text'])) {
                $aiResponse = $json['candidates'][0]['content']['parts'][0]['text'];
            } else {
                $errorMessage = isset($json['error']['message']) ? $json['error']['message'] : 'All fallback models failed or rate limited.';
                $aiResponse = "API Error: " . $errorMessage . " | Status: " . ($response ? $response->status() : 'Unknown');
            }

            return response()->json(['response' => $aiResponse]);
            
        } catch (\Exception $e) {
            return response()->json(['response' => 'System Error: ' . $e->getMessage()]);
        }
    }
}
