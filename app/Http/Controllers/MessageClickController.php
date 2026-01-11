<?php

namespace App\Http\Controllers;
use App\Models\MessageClick;
use Illuminate\Http\Request;

class MessageClickController extends Controller
{
    public function store(Request $request)
    {
        MessageClick::create([
            'message_id' => $request->message_id,
            'user_id' => auth()->id(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'browser' => $request->header('sec-ch-ua'),
            'clicked_at' => now(),
        ]);

        return response()->json(['ok' => true]);
    }
}
