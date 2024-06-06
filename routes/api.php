<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EventController as AdminEventController;

Route::get('events/{event}/scan', [AdminEventController::class, 'scanAPI'])->name('api.events.scan');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
