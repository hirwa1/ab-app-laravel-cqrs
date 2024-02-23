<?php

use Illuminate\Support\Facades\Route;


// add fallback route

Route::fallback(function () {
    return response()->json(['message' => 'Hello!'], 200);
})->name('fallback');
