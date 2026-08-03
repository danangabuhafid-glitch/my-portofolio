<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::post('/language', function (Request $request) {
    $locale = $request->input('locale');
    if (in_array($locale, ['en', 'id'])) {
        session(['locale' => $locale]);
        cookie()->queue(cookie()->forever('locale', $locale));
    }
    return response()->json(['success' => true]);
})->name('language.switch');

Route::post('/ai-chat', [HomeController::class, 'chat'])->name('ai.chat');
