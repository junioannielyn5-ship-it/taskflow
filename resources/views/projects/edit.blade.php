@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-3xl space-y-4">
    <div class="mb-4">
        <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Edit Project</h1>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Update the details of your project space.</p>
    </div>

    @php
        $currentOwnerCode = match($project->project_owner) {
            'Lawrence Solee' => 'LS',
            'Norman Reyes' => 'NR',
            'Philip Borromeo' => 'PB',
            'Vera Andino' => 'VA',
            'Edcel Ching' => 'EC',
            default => $project->project_owner
        };
    @endphp

    <form method="POST" action="{{ route('projects.update', $project) }}" class="rounded-xl border border-slate-200/40 bg-white/90 dark:border-slate-800 dark:bg-slate-900/90 p-4 shadow-sm space-y-3.5">
        @csrf
        @method('PUT')
        
        <div>
            <label class="mb-1 block text-[11px] font-semibold text-slate-700 dark:text-slate-300" for="company_name">Company Name</label>
            <input type="text" name="company_name" id="company_name" class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/50 px-2.5 py-1.5 text-xs text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-1 focus:ring-blue-500 outline-none transition-all" value="{{ old('company_name', $project->company_name) }}" placeholder="e.g. Movaflex Designs Unlimited Inc.">
            @error('company_name')
                <span class="text-red-500 text-[10px] mt-1 block font-bold">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="mb-1 block text-[11px] font-semibold text-slate-700 dark:text-slate-300" for="name">Project Name</label>
            <input type="text" name="name" id="name" class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/50 px-2.5 py-1.5 text-xs text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-1 focus:ring-blue-500 outline-none transition-all" value="{{ old('name', $project->name) }}" required autocomplete="off">
            @error('name')
                <span class="text-red-500 text-[10px] mt-1 block font-bold">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="mb-1 block text-[11px] font-semibold text-slate-700 dark:text-slate-300" for="project_owner">Project Owner</label>
            <select name="project_owner" id="project_owner" class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/50 px-2.5 py-1.5 text-xs text-slate-900 dark:text-white focus:ring-1 focus:ring-blue-500 outline-none transition-all cursor-pointer" required>
                <option value="LS" {{ old('project_owner', $currentOwnerCode) === 'LS' ? 'selected' : '' }}>LS - Lawrence Solee</option>
                <option value="NR" {{ old('project_owner', $currentOwnerCode) === 'NR' ? 'selected' : '' }}>NR - Norman Reyes</option>
                <option value="PB" {{ old('project_owner', $currentOwnerCode) === 'PB' ? 'selected' : '' }}>PB - Philip Borromeo</option>
                <option value="VA" {{ old('project_owner', $currentOwnerCode) === 'VA' ? 'selected' : '' }}>VA - Vera Andino</option>
                <option value="EC" {{ old('project_owner', $currentOwnerCode) === 'EC' ? 'selected' : '' }}>EC - Edcel Ching</option>
            </select>
            <p class="mt-1 text-[10px] text-slate-500 dark:text-slate-450 font-medium">Sales owner mapping: LS = Lawrence Solee, NR = Norman Reyes.</p>
            @error('project_owner')
                <span class="text-red-500 text-[10px] mt-1 block font-bold">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="mb-1 block text-[11px] font-semibold text-slate-700 dark:text-slate-300" for="status">Project Status</label>
            <select name="status" id="status" class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/50 px-2.5 py-1.5 text-xs text-slate-900 dark:text-white focus:ring-1 focus:ring-blue-500 outline-none transition-all cursor-pointer" required>
                <option value="pending_request" {{ old('status', $project->status) === 'pending_request' ? 'selected' : '' }}>Pending Request (Sales)</option>
                <option value="ongoing" {{ old('status', $project->status) === 'ongoing' ? 'selected' : '' }}>Implementation (Technical)</option>
            </select>
            <p class="mt-1 text-[10px] text-slate-500 dark:text-slate-450 font-medium">Pending Request = Sales team, Ongoing = Technical team.</p>
            @error('status')
                <span class="text-red-500 text-[10px] mt-1 block font-bold">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="mb-1 block text-[11px] font-semibold text-slate-700 dark:text-slate-300" for="description">Description</label>
            <textarea name="description" id="description" class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/50 px-2.5 py-1.5 text-xs text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-1 focus:ring-blue-500 outline-none transition-all" rows="3">{{ old('description', $project->description) }}</textarea>
            @error('description')
                <span class="text-red-500 text-[10px] mt-1 block font-bold">{{ $message }}</span>
            @enderror
        </div>

        <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex justify-end gap-2">
            <a href="{{ route('projects.index') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-300 dark:border-slate-750 bg-white dark:bg-slate-900 px-3 py-1.5 text-[11px] font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all duration-200">Cancel</a>
            <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-3 py-1.5 text-[11px] font-semibold text-white shadow-sm hover:bg-blue-700 transition-all duration-200 hover:-translate-y-0.5">Update</button>
        </div>
    </form>
</div>
@endsection

