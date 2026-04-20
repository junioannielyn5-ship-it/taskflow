<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Modules\Admin\Models\ChatbotKnowledge;
use App\Modules\Identity\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatbotKnowledgeController
{
    public function index()
    {
        $this->authorizeManager();

        return view('admin.chatbot-knowledge', [
            'records' => ChatbotKnowledge::query()
                ->orderBy('language')
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeManager();

        $validated = $request->validate([
            'language' => ['required', 'in:en,fil'],
            'intent' => ['required', 'string', 'max:100'],
            'title' => ['required', 'string', 'max:255'],
            'summary' => ['required', 'string', 'max:4000'],
            'steps' => ['nullable', 'string', 'max:12000'],
            'keywords' => ['nullable', 'string', 'max:4000'],
            'links' => ['nullable', 'string', 'max:12000'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        ChatbotKnowledge::query()->create([
            'language' => $validated['language'],
            'intent' => trim($validated['intent']),
            'title' => trim($validated['title']),
            'summary' => trim($validated['summary']),
            'steps' => $this->parseLinesToArray((string) ($validated['steps'] ?? '')),
            'keywords' => $this->parseKeywords((string) ($validated['keywords'] ?? '')),
            'links' => $this->parseLinks((string) ($validated['links'] ?? '')),
            'sort_order' => (int) ($validated['sort_order'] ?? 100),
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        return back()->with('success', 'Chatbot knowledge created successfully.');
    }

    public function update(Request $request, ChatbotKnowledge $knowledge): RedirectResponse
    {
        $this->authorizeManager();

        $validated = $request->validate([
            'language' => ['required', 'in:en,fil'],
            'intent' => ['required', 'string', 'max:100'],
            'title' => ['required', 'string', 'max:255'],
            'summary' => ['required', 'string', 'max:4000'],
            'steps' => ['nullable', 'string', 'max:12000'],
            'keywords' => ['nullable', 'string', 'max:4000'],
            'links' => ['nullable', 'string', 'max:12000'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $knowledge->update([
            'language' => $validated['language'],
            'intent' => trim($validated['intent']),
            'title' => trim($validated['title']),
            'summary' => trim($validated['summary']),
            'steps' => $this->parseLinesToArray((string) ($validated['steps'] ?? '')),
            'keywords' => $this->parseKeywords((string) ($validated['keywords'] ?? '')),
            'links' => $this->parseLinks((string) ($validated['links'] ?? '')),
            'sort_order' => (int) ($validated['sort_order'] ?? 100),
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        return back()->with('success', 'Chatbot knowledge updated successfully.');
    }

    public function destroy(ChatbotKnowledge $knowledge): RedirectResponse
    {
        $this->authorizeManager();

        $knowledge->delete();

        return back()->with('success', 'Chatbot knowledge deleted successfully.');
    }

    private function parseLinesToArray(string $raw): array
    {
        return collect(preg_split('/\r\n|\r|\n/', $raw) ?: [])
            ->map(fn ($line) => trim((string) $line))
            ->filter(fn ($line) => $line !== '')
            ->values()
            ->all();
    }

    private function parseKeywords(string $raw): array
    {
        $normalized = str_replace(["\r\n", "\r", "\n"], ',', $raw);

        return collect(explode(',', $normalized))
            ->map(fn ($item) => trim((string) $item))
            ->filter(fn ($item) => $item !== '')
            ->values()
            ->all();
    }

    private function parseLinks(string $raw): array
    {
        $rows = $this->parseLinesToArray($raw);

        return collect($rows)
            ->map(function (string $row): ?array {
                $parts = explode('|', $row, 2);
                if (count($parts) !== 2) {
                    return null;
                }

                $label = trim((string) $parts[0]);
                $path = trim((string) $parts[1]);

                if ($label === '' || $path === '') {
                    return null;
                }

                if (!str_starts_with($path, '/')) {
                    $path = '/'.$path;
                }

                return [
                    'label' => $label,
                    'path' => $path,
                ];
            })
            ->filter(fn ($value) => is_array($value))
            ->values()
            ->all();
    }

    private function authorizeManager(): void
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (!$user || !($user instanceof User)) {
            abort(403, 'Forbidden');
        }

        $allowed = $user->hasAnyRole(['manager', 'project_manager', 'pm', 'admin'])
            || in_array((string) data_get($user, 'role', ''), ['manager', 'project_manager', 'pm', 'admin'], true);

        if (!$allowed) {
            abort(403, 'Forbidden');
        }
    }
}
