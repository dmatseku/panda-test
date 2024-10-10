<?php

namespace App\Http\Controllers;

use App\Services\SubscribeService;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{

    public function subscribe(Request $request, SubscribeService $subscribeService)
    {
        $data = $request->validate([
            'email' => ['required', 'email:rfc,dns'],
            'url' => ['required', 'url', 'regex:/^https:\/\/www\.olx\.ua/'],
        ]);

        $subscriber = $subscribeService->subscribe($data['email'], $data['url']);

        return response()->json([
            'message' => $subscriber->confirmed ? 'Successfully subscribed' : 'Successfully subscribed but email needs to be verified']
        );
    }

    public function unsubscribe(Request $request, SubscribeService $subscribeService)
    {
        $data = $request->validate([
            'email' => ['required', 'email:rfc,dns'],
            'url' => ['nullable', 'url', 'regex:/^https:\/\/www\.olx\.ua/'],
        ]);

        $subscribeService->unsubscribe($data['email'], $data['url'] ?? null);

        return response()->json([
            'message' => 'Successfully unsubscribed'
        ]);
    }
}
