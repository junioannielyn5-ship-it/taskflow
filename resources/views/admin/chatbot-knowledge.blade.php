@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <section class="rounded-2xl border border-violet-200 bg-gradient-to-r from-violet-50 to-indigo-50 p-5 shadow-sm">
        <h1 class="text-2xl font-bold text-slate-900">Chatbot Knowledge Manager</h1>
        <p class="mt-2 text-sm text-slate-600">Manage chatbot answers directly from the database. Supports English and Filipino.</p>
    </section>

    @if (session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
            {{ $errors->first() }}
        </div>
    @endif

    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <h2 class="text-lg font-semibold text-slate-900">Add Knowledge</h2>
        <p class="mt-1 text-xs text-slate-500">Links format per line: <code>Label|/path</code></p>

        <form method="POST" action="{{ route('admin.chatbot.store') }}" class="mt-4 grid grid-cols-1 gap-3 md:grid-cols-2">
            @csrf

            <div>
                <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600">Language</label>
                <select name="language" class="w-full rounded border border-slate-300 px-3 py-2 text-sm">
                    <option value="en">English</option>
                    <option value="fil">Filipino</option>
                </select>
            </div>

            <div>
                <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600">Intent</label>
                <input name="intent" required class="w-full rounded border border-slate-300 px-3 py-2 text-sm" placeholder="create_task">
            </div>

            <div class="md:col-span-2">
                <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600">Title</label>
                <input name="title" required class="w-full rounded border border-slate-300 px-3 py-2 text-sm" placeholder="Create Task (Step by Step)">
            </div>

            <div class="md:col-span-2">
                <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600">Summary</label>
                <textarea name="summary" rows="2" required class="w-full rounded border border-slate-300 px-3 py-2 text-sm" placeholder="Short answer summary"></textarea>
            </div>

            <div>
                <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600">Steps (one per line)</label>
                <textarea name="steps" rows="5" class="w-full rounded border border-slate-300 px-3 py-2 text-sm" placeholder="Step 1&#10;Step 2"></textarea>
            </div>

            <div>
                <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600">Keywords (comma-separated)</label>
                <textarea name="keywords" rows="5" class="w-full rounded border border-slate-300 px-3 py-2 text-sm" placeholder="create task, new task, task step"></textarea>
            </div>

            <div>
                <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600">Links (one per line)</label>
                <textarea name="links" rows="4" class="w-full rounded border border-slate-300 px-3 py-2 text-sm" placeholder="Dashboard|/dashboard&#10;Tasks|/tasks"></textarea>
            </div>

            <div>
                <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600">Sort Order</label>
                <input name="sort_order" type="number" value="100" class="w-full rounded border border-slate-300 px-3 py-2 text-sm">
                <label class="mt-2 inline-flex items-center gap-2 text-sm text-slate-700">
                    <input type="checkbox" name="is_active" value="1" checked>
                    Active
                </label>
            </div>

            <div class="md:col-span-2">
                <button type="submit" class="rounded-lg bg-violet-600 px-4 py-2 text-sm font-semibold text-white hover:bg-violet-700">Add Knowledge</button>
            </div>
        </form>
    </section>

    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <h2 class="text-lg font-semibold text-slate-900">Existing Knowledge</h2>

        <div class="mt-4 space-y-4">
            @forelse($records as $record)
                <div class="rounded-xl border border-slate-200 p-4">
                    <form method="POST" action="{{ route('admin.chatbot.update', $record) }}" class="grid grid-cols-1 gap-3 md:grid-cols-2">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600">Language</label>
                            <select name="language" class="w-full rounded border border-slate-300 px-3 py-2 text-sm">
                                <option value="en" @selected($record->language === 'en')>English</option>
                                <option value="fil" @selected($record->language === 'fil')>Filipino</option>
                            </select>
                        </div>

                        <div>
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600">Intent</label>
                            <input name="intent" required value="{{ $record->intent }}" class="w-full rounded border border-slate-300 px-3 py-2 text-sm">
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600">Title</label>
                            <input name="title" required value="{{ $record->title }}" class="w-full rounded border border-slate-300 px-3 py-2 text-sm">
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600">Summary</label>
                            <textarea name="summary" rows="2" required class="w-full rounded border border-slate-300 px-3 py-2 text-sm">{{ $record->summary }}</textarea>
                        </div>

                        <div>
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600">Steps (one per line)</label>
                            <textarea name="steps" rows="5" class="w-full rounded border border-slate-300 px-3 py-2 text-sm">{{ collect($record->steps ?? [])->implode("\n") }}</textarea>
                        </div>

                        <div>
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600">Keywords (comma-separated)</label>
                            <textarea name="keywords" rows="5" class="w-full rounded border border-slate-300 px-3 py-2 text-sm">{{ collect($record->keywords ?? [])->implode(', ') }}</textarea>
                        </div>

                        <div>
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600">Links (one per line)</label>
                            <textarea name="links" rows="4" class="w-full rounded border border-slate-300 px-3 py-2 text-sm">{{ collect($record->links ?? [])->map(fn($link) => (($link['label'] ?? '') . '|' . ($link['path'] ?? '')))->implode("\n") }}</textarea>
                        </div>

                        <div>
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600">Sort Order</label>
                            <input name="sort_order" type="number" value="{{ $record->sort_order }}" class="w-full rounded border border-slate-300 px-3 py-2 text-sm">
                            <label class="mt-2 inline-flex items-center gap-2 text-sm text-slate-700">
                                <input type="checkbox" name="is_active" value="1" @checked($record->is_active)>
                                Active
                            </label>
                        </div>

                        <div class="md:col-span-2 flex flex-wrap gap-2">
                            <button type="submit" class="rounded-lg bg-violet-600 px-4 py-2 text-sm font-semibold text-white hover:bg-violet-700">Save</button>
                    </form>
                            <form method="POST" action="{{ route('admin.chatbot.destroy', $record) }}" onsubmit="return confirm('Delete this knowledge item?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-lg border border-rose-300 bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-700 hover:bg-rose-100">Delete</button>
                            </form>
                        </div>
                </div>
            @empty
                <p class="text-sm text-slate-500">No chatbot knowledge records found.</p>
            @endforelse
        </div>
    </section>
</div>
@endsection
