<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminMessageController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->string('q')->toString();
        $language = $request->string('language')->toString();

        $messages = Message::query()
            ->when($q, function ($qb) use ($q) {
                $qb->where(function ($w) use ($q) {
                    $w->where('content', 'like', "%{$q}%")
                      ->orWhere('author', 'like', "%{$q}%")
                      ->orWhere('source', 'like', "%{$q}%");
                });
            })
            ->when($language, fn ($qb) => $qb->where('language', $language))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('admin/Messages/Index', [
            'messages' => $messages,
            'filters' => [
                'q' => $q,
                'language' => $language,
            ],
        ]);
    }

    public function create()
    {
        return Inertia::render('admin/Messages/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'content' => ['required', 'string'],
            'author' => ['nullable', 'string', 'max:255'],
            'language' => ['required', 'in:es,en,fr,it'],
            'source' => ['nullable', 'string', 'max:255'],
        ]);

        Message::create($data);

        return redirect()->route('admin.messages.index')
            ->with('success', 'Mensaje creado.');
    }

    public function edit(Message $message)
    {
        return Inertia::render('admin/Messages/Edit', [
            'message' => $message,
        ]);
    }

    public function update(Request $request, Message $message)
    {
        $data = $request->validate([
            'content' => ['required', 'string'],
            'author' => ['nullable', 'string', 'max:255'],
            'language' => ['required', 'in:es,en,fr,it'],
            'source' => ['nullable', 'string', 'max:255'],
        ]);

        $message->update($data);

        return redirect()->route('admin.messages.index')
            ->with('success', 'Mensaje actualizado.');
    }

    public function destroy(Message $message)
    {
        $message->delete();

        return redirect()->route('admin.messages.index')
            ->with('success', 'Mensaje eliminado.');
    }
}
