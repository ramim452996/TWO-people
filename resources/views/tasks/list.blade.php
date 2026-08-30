@extends('layouts.app')

@section('content')

{{-- ============================================================
     PAGE HEADER
============================================================ --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-7">
    <div>
        <div class="flex items-center gap-2 text-xs text-gray-400 dark:text-gray-500 mb-1">
            <a href="{{ route('tasks.index') }}" class="hover:text-indigo-500 transition-colors">Dashboard</a>
            <i class="fas fa-chevron-right text-[10px]"></i>
            <span class="text-gray-600 dark:text-gray-300 font-medium">Tasks</span>
        </div>
        <h1 class="text-2xl font-extrabold text-gray-800 dark:text-white flex items-center gap-2">
            <i class="fas fa-list-check text-indigo-500"></i>
            All Tasks
            <span class="ml-2 text-sm font-semibold px-2.5 py-0.5 rounded-full
                         bg-indigo-100 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400">
                {{ $totalCount }}
            </span>
        </h1>
        <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">
            Full list of all tasks — sortable, filterable, and searchable.
        </p>
    </div>
    <a href="{{ route('tasks.create') }}"
       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white
              bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500
              shadow-md shadow-indigo-500/25 hover:shadow-indigo-500/40 transition-all duration-200">
        <i class="fas fa-plus"></i> Add New Task
    </a>
</div>

{{-- ============================================================
     SEARCH & FILTER TOOLBAR
============================================================ --}}
<div class="rounded-2xl border shadow-sm mb-6 p-4 transition-colors duration-200
            bg-white dark:bg-gray-800/80 border-gray-100 dark:border-gray-700/60">
    <form action="{{ route('tasks.list') }}" method="GET"
          class="flex flex-col sm:flex-row flex-wrap gap-3 items-stretch sm:items-center">

        {{-- Search --}}
        <div class="relative flex-grow min-w-[180px]">
            <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 text-xs"></i>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search title or assignee…"
                   class="w-full pl-9 pr-4 py-2 rounded-xl border text-sm transition-colors duration-200
                          border-gray-200 dark:border-gray-600
                          bg-gray-50 dark:bg-gray-700/60
                          text-gray-900 dark:text-white
                          placeholder-gray-400 dark:placeholder-gray-500
                          focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
        </div>

        {{-- Status --}}
        <select name="status"
                class="px-3 py-2 rounded-xl border text-sm transition-colors duration-200
                       border-gray-200 dark:border-gray-600
                       bg-gray-50 dark:bg-gray-700/60
                       text-gray-900 dark:text-white
                       focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="All"        {{ request('status','All') === 'All'         ? 'selected' : '' }}>All Status</option>
            <option value="Pending"    {{ request('status') === 'Pending'           ? 'selected' : '' }}>Pending</option>
            <option value="In Progress"{{ request('status') === 'In Progress'       ? 'selected' : '' }}>In Progress</option>
            <option value="Completed"  {{ request('status') === 'Completed'         ? 'selected' : '' }}>Completed</option>
        </select>

        {{-- Priority --}}
        <select name="priority"
                class="px-3 py-2 rounded-xl border text-sm transition-colors duration-200
                       border-gray-200 dark:border-gray-600
                       bg-gray-50 dark:bg-gray-700/60
                       text-gray-900 dark:text-white
                       focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="All"   {{ request('priority','All') === 'All'   ? 'selected' : '' }}>All Priority</option>
            <option value="Low"   {{ request('priority') === 'Low'         ? 'selected' : '' }}>Low</option>
            <option value="Medium"{{ request('priority') === 'Medium'      ? 'selected' : '' }}>Medium</option>
            <option value="High"  {{ request('priority') === 'High'        ? 'selected' : '' }}>High</option>
        </select>

        {{-- Sort Field --}}
        <select name="sort"
                class="px-3 py-2 rounded-xl border text-sm transition-colors duration-200
                       border-gray-200 dark:border-gray-600
                       bg-gray-50 dark:bg-gray-700/60
                       text-gray-900 dark:text-white
                       focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="created_at" {{ request('sort','created_at') === 'created_at' ? 'selected' : '' }}>Sort: Newest</option>
            <option value="title"      {{ request('sort') === 'title'                   ? 'selected' : '' }}>Sort: Title</option>
            <option value="due_date"   {{ request('sort') === 'due_date'                ? 'selected' : '' }}>Sort: Due Date</option>
            <option value="priority"   {{ request('sort') === 'priority'                ? 'selected' : '' }}>Sort: Priority</option>
            <option value="status"     {{ request('sort') === 'status'                  ? 'selected' : '' }}>Sort: Status</option>
            <option value="assigned_to"{{ request('sort') === 'assigned_to'             ? 'selected' : '' }}>Sort: Assignee</option>
        </select>

        {{-- Sort Direction --}}
        <select name="dir"
                class="px-3 py-2 rounded-xl border text-sm transition-colors duration-200
                       border-gray-200 dark:border-gray-600
                       bg-gray-50 dark:bg-gray-700/60
                       text-gray-900 dark:text-white
                       focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="desc" {{ request('dir','desc') === 'desc' ? 'selected' : '' }}>↓ Descending</option>
            <option value="asc"  {{ request('dir') === 'asc'         ? 'selected' : '' }}>↑ Ascending</option>
        </select>

        <button type="submit"
                class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium
                       transition-colors duration-200 flex items-center gap-2 whitespace-nowrap">
            <i class="fas fa-filter text-xs"></i> Apply
        </button>
        <a href="{{ route('tasks.list') }}"
           class="px-5 py-2 rounded-xl text-sm font-medium flex items-center gap-2 whitespace-nowrap transition-colors duration-200
                  bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300
                  hover:bg-gray-200 dark:hover:bg-gray-600">
            <i class="fas fa-times text-xs"></i> Clear
        </a>
    </form>
</div>

{{-- Result summary --}}
<div class="flex items-center justify-between mb-3">
    <p class="text-xs text-gray-400 dark:text-gray-500">
        Showing <span class="font-semibold text-gray-600 dark:text-gray-300">{{ $tasks->count() }}</span>
        of <span class="font-semibold text-gray-600 dark:text-gray-300">{{ $totalCount }}</span> tasks
        @if(request('search')) for "<span class="italic text-indigo-500">{{ request('search') }}</span>"@endif
    </p>
    @if(config('office.enable_task_export'))
        <a href="{{ route('tasks.export') }}"
           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors duration-200
                  border border-gray-200 dark:border-gray-600 text-gray-500 dark:text-gray-400
                  hover:bg-gray-100 dark:hover:bg-gray-700">
            <i class="fas fa-file-export"></i> Export CSV
        </a>
    @endif
</div>

{{-- ============================================================
     TASK TABLE
============================================================ --}}
<div class="rounded-2xl overflow-hidden border shadow-sm transition-colors duration-200
            border-gray-100 dark:border-gray-700/60
            bg-white dark:bg-gray-800/80">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-700/60
                           bg-gradient-to-r from-gray-50 to-white dark:from-gray-700/50 dark:to-gray-800">
                    <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500 w-8">#</th>
                    <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500">Task Title</th>
                    <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500">Assigned To</th>
                    <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500">Priority</th>
                    <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500">Status</th>
                    <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500">Due Date</th>
                    <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500">Created</th>
                    <th class="px-5 py-4 text-right text-xs font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 dark:divide-gray-700/40">
                @forelse($tasks as $index => $task)
                    @php
                        $isOverdue = $task->due_date && $task->due_date->isPast() && $task->status !== 'Completed';
                    @endphp
                    <tr class="group transition-colors duration-150
                               {{ $isOverdue
                                    ? 'bg-red-50/50 dark:bg-red-900/10 hover:bg-red-100/60 dark:hover:bg-red-900/20'
                                    : 'hover:bg-indigo-50/30 dark:hover:bg-indigo-900/10' }}">

                        {{-- Row Number --}}
                        <td class="px-5 py-3.5">
                            <span class="text-xs font-mono text-gray-300 dark:text-gray-600">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>

                        {{-- Title --}}
                        <td class="px-5 py-3.5 max-w-[220px]">
                            <div class="flex flex-col gap-0.5">
                                <a href="{{ route('tasks.show', $task) }}"
                                   class="text-sm font-semibold text-gray-800 dark:text-white truncate
                                          hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                    {{ $task->title }}
                                </a>
                                @if($task->description)
                                    <span class="text-xs text-gray-400 dark:text-gray-500 truncate">
                                        {{ Str::limit($task->description, 50) }}
                                    </span>
                                @endif
                                @if($isOverdue)
                                    <span class="inline-flex w-fit items-center px-1.5 py-0.5 rounded-md text-[10px] font-bold tracking-wide
                                                 bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-400 border border-red-200 dark:border-red-800/60">
                                        OVERDUE
                                    </span>
                                @endif
                            </div>
                        </td>

                        {{-- Assigned To --}}
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full flex-shrink-0 flex items-center justify-center text-xs font-bold
                                            bg-gradient-to-br from-purple-500 to-indigo-600 text-white shadow-sm">
                                    {{ strtoupper(substr($task->assigned_to, 0, 1)) }}
                                </div>
                                <span class="text-sm text-gray-600 dark:text-gray-300 truncate max-w-[100px]">
                                    {{ $task->assigned_to }}
                                </span>
                            </div>
                        </td>

                        {{-- Priority --}}
                        <td class="px-5 py-3.5">
                            @if($task->priority === 'High')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold border
                                             bg-rose-100 dark:bg-rose-900/30 text-rose-700 dark:text-rose-400 border-rose-200 dark:border-rose-800/50">
                                    <i class="fas fa-arrow-up text-[9px]"></i> High
                                </span>
                            @elseif($task->priority === 'Medium')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold border
                                             bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 border-amber-200 dark:border-amber-800/50">
                                    <i class="fas fa-minus text-[9px]"></i> Medium
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold border
                                             bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-800/50">
                                    <i class="fas fa-arrow-down text-[9px]"></i> Low
                                </span>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td class="px-5 py-3.5">
                            @if($task->status === 'Completed')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold border
                                             bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-800/50">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Completed
                                </span>
                            @elseif($task->status === 'In Progress')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold border
                                             bg-sky-100 dark:bg-sky-900/30 text-sky-700 dark:text-sky-400 border-sky-200 dark:border-sky-800/50">
                                    <span class="w-1.5 h-1.5 rounded-full bg-sky-500 animate-pulse"></span> In Progress
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold border
                                             bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 border-gray-200 dark:border-gray-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Pending
                                </span>
                            @endif
                        </td>

                        {{-- Due Date --}}
                        <td class="px-5 py-3.5">
                            @if($task->due_date)
                                <span class="text-xs {{ $isOverdue ? 'text-red-600 dark:text-red-400 font-bold' : 'text-gray-500 dark:text-gray-400' }}">
                                    <i class="fas fa-calendar-alt mr-1 opacity-60"></i>
                                    {{ $task->due_date->format('M d, Y') }}
                                </span>
                            @else
                                <span class="text-xs text-gray-300 dark:text-gray-600">—</span>
                            @endif
                        </td>

                        {{-- Created At --}}
                        <td class="px-5 py-3.5">
                            <span class="text-xs text-gray-400 dark:text-gray-500" title="{{ $task->created_at->format('Y-m-d H:i') }}">
                                {{ $task->created_at->format('M d, Y') }}
                            </span>
                        </td>

                        {{-- Actions --}}
                        <td class="px-5 py-3.5 text-right">
                            <div class="flex items-center justify-end gap-1 opacity-40 group-hover:opacity-100 transition-opacity duration-200">
                                <a href="{{ route('tasks.show', $task) }}"
                                   title="View"
                                   class="w-8 h-8 flex items-center justify-center rounded-lg
                                          text-indigo-500 hover:text-white hover:bg-indigo-500 transition-colors duration-200">
                                    <i class="fas fa-eye text-sm"></i>
                                </a>
                                <a href="{{ route('tasks.edit', $task) }}"
                                   title="Edit"
                                   class="w-8 h-8 flex items-center justify-center rounded-lg
                                          text-sky-500 hover:text-white hover:bg-sky-500 transition-colors duration-200">
                                    <i class="fas fa-pen text-sm"></i>
                                </a>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Are you sure you want to delete this task?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Delete"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg
                                                   text-rose-500 hover:text-white hover:bg-rose-500 transition-colors duration-200">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-5 py-20 text-center">
                            <div class="flex flex-col items-center gap-3 text-gray-400 dark:text-gray-500">
                                <div class="w-16 h-16 rounded-2xl bg-gray-100 dark:bg-gray-700/50 flex items-center justify-center">
                                    <i class="fas fa-clipboard-list text-3xl text-gray-300 dark:text-gray-600"></i>
                                </div>
                                <p class="text-sm font-medium">No tasks found matching your criteria.</p>
                                <a href="{{ route('tasks.list') }}" class="text-xs text-indigo-500 hover:underline">
                                    Clear filters
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>

            {{-- Table Footer Summary --}}
            @if($tasks->count() > 0)
            <tfoot>
                <tr class="border-t border-gray-100 dark:border-gray-700/60
                           bg-gray-50/60 dark:bg-gray-700/20">
                    <td colspan="8" class="px-5 py-3">
                        <div class="flex flex-wrap items-center justify-between gap-3 text-xs text-gray-400 dark:text-gray-500">
                            <div class="flex items-center gap-4">
                                <span>Total: <strong class="text-gray-600 dark:text-gray-300">{{ $tasks->count() }}</strong></span>
                                <span class="text-emerald-600 dark:text-emerald-400 font-medium">
                                    ✓ Completed: {{ $tasks->where('status', 'Completed')->count() }}
                                </span>
                                <span class="text-sky-600 dark:text-sky-400 font-medium">
                                    ⟳ In Progress: {{ $tasks->where('status', 'In Progress')->count() }}
                                </span>
                                <span class="text-amber-600 dark:text-amber-400 font-medium">
                                    ⏳ Pending: {{ $tasks->where('status', 'Pending')->count() }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('tasks.index') }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg font-semibold transition-colors
                                          bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400
                                          hover:bg-indigo-100 dark:hover:bg-indigo-900/50 border border-indigo-100 dark:border-indigo-800/50">
                                    <i class="fas fa-tachometer-alt text-[10px]"></i> Go to Dashboard
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>

@endsection
