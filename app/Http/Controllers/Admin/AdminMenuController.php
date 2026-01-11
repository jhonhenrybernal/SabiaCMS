<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

// Descomenta cuando exista el modelo
// use App\Models\Message;

class AdminMessageController extends Controller
{
    public function index()
    {
        // Cuando exista Message, cambia a:
        // $messages = Message::query()->latest()->paginate(20);

        return Inertia::render('admin/Messages/Index', [
            // 'messages' => $messages,
            'messages' => [],
        ]);
    }

    public function create()
    {
        return Inertia::render('admin/Messages/Create');
    }

    public function store(Request $request)
    {
        // Validación mínima (ajusta según tu esquema real)
        $data = $request->validate([
            'content' => ['required', 'string'],
            'author' => ['nullable', 'string'],
            'language' => ['required', 'string', 'max:5'],
        ]);

        // Message::create($data);

        return redirect()->route('admin.messages.index')
            ->with('success', 'Mensaje creado (stub).');
    }

    public function edit(string $id)
    {
        // $message = Message::findOrFail($id);

        return Inertia::render('admin/Messages/Edit', [
            // 'message' => $message,
            'message' => [
                'id' => $id,
                'content' => '',
                'author' => '',
                'language' => 'es',
            ],
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'content' => ['required', 'string'],
            'author' => ['nullable', 'string'],
            'language' => ['required', 'string', 'max:5'],
        ]);

        // $message = Message::findOrFail($id);
        // $message->update($data);

        return redirect()->route('admin.messages.index')
            ->with('success', 'Mensaje actualizado (stub).');
    }

    public function destroy(string $id)
    {
        // Message::findOrFail($id)->delete();

        return redirect()->route('admin.messages.index')
            ->with('success', 'Mensaje eliminado (stub).');
    }
}
