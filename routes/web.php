<?php

use App\Http\Controllers\VerifyController;
use Illuminate\Support\Facades\Route;

Route::get('/verify/{token}', [VerifyController::class, 'verify'])->name('verify');
