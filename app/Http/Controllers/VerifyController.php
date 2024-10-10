<?php

namespace App\Http\Controllers;

use App\Services\VerificationService;
use Illuminate\Http\Request;

class VerifyController extends Controller
{
    public function verify($token, VerificationService $verificationService)
    {
        $email = $verificationService->verify($token);

        return view('verified', ['email' => $email]);
    }
}
