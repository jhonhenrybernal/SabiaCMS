<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicMessageController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->string('lang')->toString();

        $query = Message::query()->select(['id', 'content', 'author', 'language', 'created_at']);

        if ($lang) {
            $query->where('language', $lang);
        }

        // UX: paginación razonable
        $messages = $query->latest()->paginate(60)->withQueryString();

        return Inertia::render('messages/Index', [
            'messages' => $messages,
            'filters' => [
                'lang' => $lang,
            ],
        ]);
    }
}
