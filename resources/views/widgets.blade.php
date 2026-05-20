<div class="container mx-auto py-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
            <h3 class="text-lg font-semibold mb-2">Quick Actions</h3>
            <a href="{{ route('tasks.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-2">Create Task</a>
            @can('create-project')
                <a href="{{ route('projects.create') ?? '#' }}" class="bg-green-500 text-white px-4 py-2 rounded mb-2">Create Project</a>
            @endcan
            <a href="{{ route('reports.index') ?? '#' }}" class="bg-yellow-500 text-white px-4 py-2 rounded">View Reports</a>
        </div>
        <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
            <h3 class="text-lg font-semibold mb-2">Upcoming Deadlines</h3>
            <ul class="w-full">
                @php($upcomingList = collect($upcomingTasks ?? []))
                @foreach($upcomingList as $task)
                    <li class="mb-2 flex justify-between items-center">
                        <span>{{ $task->title }}</span>
                        <span class="text-xs {{ $task->due_date && $task->due_date->isPast() ? 'text-red-600 font-semibold' : 'text-gray-500' }}">
                            {{ $task->due_date ? $task->due_date->format('m-d-Y') : '-' }}
                            @if(isset($task->status) && $task->status === 'for_review')
                                <span class="ml-2 px-2 py-0.5 rounded-full bg-orange-100 text-orange-700 text-[10px] font-semibold">For Review</span>
                            @endif
                        </span>
                    </li>
                @endforeach
                {{-- Example For Review task if list is empty --}}
                @if($upcomingList->isEmpty())
                    <li class="mb-2 flex justify-between items-center">
                        <span>Sample Task for Review</span>
                        <span class="text-xs text-orange-700">
                            {{ now()->addDays(2)->format('m-d-Y') }}
                            <span class="ml-2 px-2 py-0.5 rounded-full bg-orange-100 text-orange-700 text-[10px] font-semibold">For Review</span>
                        </span>
                    </li>
                @endif
            </ul>
        </div>
        <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
            <h3 class="text-lg font-semibold mb-2">Recent Activity</h3>
            <ul class="w-full">
                @php($recentList = collect($recentActivity ?? []))
                @foreach($recentList as $log)
                    <li class="mb-2 text-sm">{{ $log->getDescription() }}</li>
                @endforeach
                @if($recentList->isEmpty())
                    <li class="text-gray-400">No recent activity</li>
                @endif
            </ul>
        </div>
    </div>
</div>
