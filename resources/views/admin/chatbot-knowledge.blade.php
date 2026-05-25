@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <section class="rounded-2xl border border-violet-200 dark:border-violet-800 bg-gradient-to-r from-violet-50 to-indigo-50 dark:from-violet-900/30 dark:to-indigo-900/30 p-5 shadow-sm">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Chatbot Knowledge Manager</h1>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Manage chatbot answers directly from the database. Supports English and Filipino.</p>
    </section>

    @if (session('success'))
        <div class="rounded-xl border border-emerald-200 dark:border-emerald-800 bg-emerald-50 dark:bg-emerald-900/30 px-4 py-3 text-sm text-emerald-700 dark:text-emerald-300">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="rounded-xl border border-rose-200 dark:border-rose-800 bg-rose-50 dark:bg-rose-900/30 px-4 py-3 text-sm text-rose-700 dark:text-rose-300">
            {{ $errors->first() }}
        </div>
    @endif

    <section class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm">
        <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Add Knowledge</h2>
        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Links format per line: <code class="dark:text-slate-300">Label|/path</code></p>

        <form method="POST" action="{{ route('admin.chatbot.store') }}" class="mt-4 grid grid-cols-1 gap-3 md:grid-cols-2">
            @csrf

            <div>
                <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Language</label>
                <select name="language" class="w-full rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-slate-100">
                    <option value="en">English</option>
                    <option value="fil">Filipino</option>
                </select>
            </div>

            <div>
                <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Intent</label>
                <input name="intent" required class="w-full rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500" placeholder="create_task">
            </div>

            <div class="md:col-span-2">
                <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Title</label>
                <input name="title" required class="w-full rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500" placeholder="Create Task (Step by Step)">
            </div>

            <div class="md:col-span-2">
                <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Summary</label>
                <textarea name="summary" rows="2" required class="w-full rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500" placeholder="Short answer summary"></textarea>
            </div>

            <div>
                <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Steps (one per line)</label>
                <textarea name="steps" rows="5" class="w-full rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500" placeholder="Step 1&#10;Step 2"></textarea>
            </div>

            <div>
                <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Keywords (comma-separated)</label>
                <textarea name="keywords" rows="5" class="w-full rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500" placeholder="create task, new task, task step"></textarea>
            </div>

            <div>
                <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Links (one per line)</label>
                <textarea name="links" rows="4" class="w-full rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500" placeholder="Dashboard|/dashboard&#10;Tasks|/tasks"></textarea>
            </div>

            <div>
                <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Sort Order</label>
                <input name="sort_order" type="number" value="100" class="w-full rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-slate-100">
                <label class="mt-2 inline-flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300">
                    <input type="checkbox" name="is_active" value="1" checked class="dark:bg-slate-700 dark:border-slate-600">
                    Active
                </label>
            </div>

            <div class="md:col-span-2">
                <button type="submit" class="rounded-lg bg-violet-600 px-4 py-2 text-sm font-semibold text-white hover:bg-violet-700 dark:bg-violet-500 dark:hover:bg-violet-600">Add Knowledge</button>
            </div>
        </form>
    </section>

    <section class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm">
        <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Existing Knowledge</h2>

        <div class="mt-4 space-y-4">
            @forelse($records as $record)
                <div class="rounded-xl border border-slate-200 dark:border-slate-700 p-4">
                    <form method="POST" action="{{ route('admin.chatbot.update', $record) }}" class="grid grid-cols-1 gap-3 md:grid-cols-2">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Language</label>
                            <select name="language" class="w-full rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-slate-100">
                                <option value="en" @selected($record->language === 'en')>English</option>
                                <option value="fil" @selected($record->language === 'fil')>Filipino</option>
                            </select>
                        </div>

                        <div>
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Intent</label>
                            <input name="intent" required value="{{ $record->intent }}" class="w-full rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-slate-100">
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Title</label>
                            <input name="title" required value="{{ $record->title }}" class="w-full rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-slate-100">
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Summary</label>
                            <textarea name="summary" rows="2" required class="w-full rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-slate-100">{{ $record->summary }}</textarea>
                        </div>

                        <div>
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Steps (one per line)</label>
                            <textarea name="steps" rows="5" class="w-full rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-slate-100">{{ collect($record->steps ?? [])->implode("\n") }}</textarea>
                        </div>

                        <div>
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Keywords (comma-separated)</label>
                            <textarea name="keywords" rows="5" class="w-full rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-slate-100">{{ collect($record->keywords ?? [])->implode(', ') }}</textarea>
                        </div>

                        <div>
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Links (one per line)</label>
                            <textarea name="links" rows="4" class="w-full rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-slate-100">{{ collect($record->links ?? [])->map(fn($link) => (($link['label'] ?? '') . '|' . ($link['path'] ?? '')))->implode("\n") }}</textarea>
                        </div>

                        <div>
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Sort Order</label>
                            <input name="sort_order" type="number" value="{{ $record->sort_order }}" class="w-full rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-slate-100">
                            <label class="mt-2 inline-flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300">
                                <input type="checkbox" name="is_active" value="1" @checked($record->is_active) class="dark:bg-slate-700 dark:border-slate-600">
                                Active
                            </label>
                        </div>

                        <div class="md:col-span-2 flex flex-wrap gap-2">
                            <button type="submit" class="rounded-lg bg-violet-600 px-4 py-2 text-sm font-semibold text-white hover:bg-violet-700 dark:bg-violet-500 dark:hover:bg-violet-600">Save</button>
                    </form>
                            <form method="POST" action="{{ route('admin.chatbot.destroy', $record) }}" onsubmit="return confirm('Delete this knowledge item?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-lg border border-rose-300 dark:border-rose-700 bg-rose-50 dark:bg-rose-900/30 px-4 py-2 text-sm font-semibold text-rose-700 dark:text-rose-400 hover:bg-rose-100 dark:hover:bg-rose-900/50">Delete</button>
                            </form>
                        </div>
                </div>
            @empty
                <p class="text-sm text-slate-500 dark:text-slate-400">No chatbot knowledge records found.</p>
            @endforelse
        </div>
    </section>
</div>
@endsection
