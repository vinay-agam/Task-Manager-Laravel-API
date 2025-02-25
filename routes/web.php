<?php

use Illuminate\Support\Facades\Route;


Route::get('/images/{filename}',fn($filename)=> response()->download(storage_path('app/public/image/$finename')));
Route::get('/file/{$filename}', fn($filename) => response() ->download(storage_path('app/public/file/$finename')));
