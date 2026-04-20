@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white rounded-xl shadow">
    <h2 class="text-xl font-bold mb-4">Edit Task</h2>
    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
            <input type="text" name="title" id="title" value="{{ $task->title }}" class="w-full border rounded px-3 py-2 bg-white text-gray-900 dark:bg-slate-800 dark:text-white" required>
        </div>
        <div class="mb-3">
            <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
            <select name="priority" id="priority" class="w-full border rounded px-3 py-2 bg-white text-gray-900 dark:bg-slate-800 dark:text-white">
                <option value="urgent" {{ $task->priority == 'urgent' ? 'selected' : '' }}>Urgent</option>
                <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>High</option>
                <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>Low</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
            <input type="date" name="due_date" id="due_date" value="{{ $task->due_date ? $task->due_date->format('Y-m-d') : '' }}" class="w-full border rounded px-3 py-2 bg-white text-gray-900 dark:bg-slate-800 dark:text-white">
        </div>
        <div class="mb-3">
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status" class="w-full border rounded px-3 py-2 bg-white text-gray-900 dark:bg-slate-800 dark:text-white">
                <option value="todo" {{ $task->status == 'todo' ? 'selected' : '' }}>To Do</option>
                <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="for_review" {{ $task->status == 'for_review' ? 'selected' : '' }}>For Review</option>
                <option value="done" {{ $task->status == 'done' ? 'selected' : '' }}>Done</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save Changes</button>
        <a href="{{ route('tasks.list') }}" class="ml-3 text-blue-600">Cancel</a>
    </form>
</div>
@endsection
