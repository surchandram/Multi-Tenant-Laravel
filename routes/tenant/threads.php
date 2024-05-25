<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('threads.messages', \SAAS\Http\Threads\Controllers\MessageController::class);
