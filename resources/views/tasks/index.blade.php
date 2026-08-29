@extends('layouts.app')

@section('content')

{{-- ============================================================
     PAGE HEADER
============================================================ --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-7">
    <div>
        <h1 class="text-2xl font-extrabold text-gray-800 dark:text-white flex items-center gap-2">
            <i class="fas fa-tachometer-alt text-indigo-500"></i> Dashboard
        </h1>
        <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">
            Welcome back! Here's an overview of all tasks.
        </p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('tasks.list') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200
                  border border-indigo-200 dark:border-indigo-700 text-indigo-600 dark:text-indigo-400
                  bg-indigo-50 dark:bg-indigo-900/30 hover:bg-indigo-100 dark:hover:bg-indigo-900/50">
            <i class="fas fa-list text-xs"></i> View All Tasks
        </a>
        <a href="{{ route('tasks.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white
                  bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500
                  shadow-md shadow-indigo-500/25 hover:shadow-indigo-500/40 transition-all duration-200">
            <i class="fas fa-plus"></i> Add Task
        </a>
    </div>
</div>

{{-- ============================================================
     STAT CARDS
============================================================ --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-5 mb-8">

    {{-- Total --}}
    <div class="relative overflow-hidden rounded-2xl p-5
                bg-gradient-to-br from-indigo-500 to-indigo-700
                shadow-lg shadow-indigo-500/30 text-white hover:-translate-y-1 transition-transform duration-300">
        <div class="absolute -top-4 -right-4 w-20 h-20 bg-white/10 rounded-full"></div>
        <div class="absolute -bottom-6 -right-2 w-28 h-28 bg-white/5 rounded-full"></div>
        <div class="relative z-10">
            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center mb-3">
                <i class="fas fa-layer-group text-white"></i>
            </div>
            <p class="text-xs font-semibold uppercase tracking-widest text-indigo-100 mb-1">Total Tasks</p>
            <p class="text-4xl font-extrabold">{{ $totalTasks }}</p>
        </div>
    </div>

    {{-- Pending --}}
    <div class="relative overflow-hidden rounded-2xl p-5
                bg-gradient-to-br from-amber-400 to-orange-500
                shadow-lg shadow-amber-400/30 text-white hover:-translate-y-1 transition-transform duration-300">
        <div class="absolute -top-4 -right-4 w-20 h-20 bg-white/10 rounded-full"></div>
        <div class="absolute -bottom-6 -right-2 w-28 h-28 bg-white/5 rounded-full"></div>
        <div class="relative z-10">
            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center mb-3">
                <i class="fas fa-hourglass-half text-white"></i>
            </div>
            <p class="text-xs font-semibold uppercase tracking-widest text-amber-100 mb-1">Pending</p>
            <p class="text-4xl font-extrabold">{{ $pendingTasks }}</p>
        </div>
    </div>

    {{-- In Progress --}}
    <div class="relative overflow-hidden rounded-2xl p-5
                bg-gradient-to-br from-sky-500 to-blue-600
                shadow-lg shadow-sky-500/30 text-white hover:-translate-y-1 transition-transform duration-300">
        <div class="absolute -top-4 -right-4 w-20 h-20 bg-white/10 rounded-full"></div>
        <div class="absolute -bottom-6 -right-2 w-28 h-28 bg-white/5 rounded-full"></div>
        <div class="relative z-10">
            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center mb-3">
                <i class="fas fa-spinner text-white"></i>
            </div>
            <p class="text-xs font-semibold uppercase tracking-widest text-sky-100 mb-1">In Progress</p>
            <p class="text-4xl font-extrabold">{{ $inProgressTasks }}</p>
        </div>
    </div>

    {{-- Completed --}}
    <div class="relative overflow-hidden rounded-2xl p-5
                bg-gradient-to-br from-emerald-500 to-green-600
                shadow-lg shadow-emerald-500/30 text-white hover:-translate-y-1 transition-transform duration-300">
        <div class="absolute -top-4 -right-4 w-20 h-20 bg-white/10 rounded-full"></div>
        <div class="absolute -bottom-6 -right-2 w-28 h-28 bg-white/5 rounded-full"></div>
        <div class="relative z-10">
            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center mb-3">
                <i class="fas fa-check-circle text-white"></i>
            </div>
            <p class="text-xs font-semibold uppercase tracking-widest text-emerald-100 mb-1">Completed</p>
            <p class="text-4xl font-extrabold">
                {{ $completedTasks }}
                <span class="text-base font-semibold text-emerald-200 ml-1">({{ $completionRate }}%)</span>
            </p>
        </div>
    </div>

    {{-- High Priority --}}
    <div class="relative overflow-hidden rounded-2xl p-5
                bg-gradient-to-br from-rose-500 to-red-600
                shadow-lg shadow-rose-500/30 text-white hover:-translate-y-1 transition-transform duration-300">
        <div class="absolute -top-4 -right-4 w-20 h-20 bg-white/10 rounded-full"></div>
        <div class="absolute -bottom-6 -right-2 w-28 h-28 bg-white/5 rounded-full"></div>
        <div class="relative z-10">
            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center mb-3">
                <i class="fas fa-fire text-white"></i>
            </div>
            <p class="text-xs font-semibold uppercase tracking-widest text-rose-100 mb-1">High Priority</p>
            <p class="text-4xl font-extrabold">{{ $highPriorityTasks }}</p>
        </div>
    </div>

</div>

{{-- ============================================================
     COMPLETION PROGRESS BAR
============================================================ --}}
<div class="rounded-2xl border shadow-sm mb-7 p-5 transition-colors duration-200
            bg-white dark:bg-gray-800/80 border-gray-100 dark:border-gray-700/60">
    <div class="flex items-center justify-between mb-3">
        <h3 class="text-sm font-bold text-gray-700 dark:text-gray-200 flex items-center gap-2">
            <i class="fas fa-chart-line text-indigo-500"></i> Overall Completion
        </h3>
        <span class="text-sm font-extrabold text-indigo-600 dark:text-indigo-400">{{ $completionRate }}%</span>
    </div>
    <div class="w-full h-3 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
        <div class="h-full rounded-full bg-gradient-to-r from-indigo-500 to-emerald-500 transition-all duration-700"
             style="width: {{ $completionRate }}%"></div>
    </div>
    <div class="flex justify-between text-xs text-gray-400 dark:text-gray-500 mt-2">
        <span>0%</span>
        <span>{{ $completedTasks }} of {{ $totalTasks }} tasks completed</span>
        <span>100%</span>
    </div>
</div>

{{-- ============================================================
     DUE SOON ALERT BANNER
============================================================ --}}
@if($dueSoonTasks->count() > 0)
<div class="relative mb-7 rounded-2xl overflow-hidden
            bg-gradient-to-r from-amber-500/10 to-orange-500/10
            border border-amber-300 dark:border-amber-500/40
            shadow-sm shadow-amber-200/40 dark:shadow-amber-900/20">
    <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-amber-400 to-orange-500 rounded-l-2xl"></div>
    <div class="pl-6 pr-5 py-4">
        <div class="flex items-center gap-2 mb-3">
            <div class="w-7 h-7 rounded-lg bg-amber-500/20 dark:bg-amber-500/30 flex items-center justify-center">
                <i class="fas fa-clock text-amber-600 dark:text-amber-400 text-xs"></i>
            </div>
            <h3 class="text-sm font-bold text-amber-800 dark:text-amber-300 uppercase tracking-wide">
                Due Soon — Next 3 Days
            </h3>
            <span class="ml-auto bg-amber-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                {{ $dueSoonTasks->count() }}
            </span>
        </div>
        <div class="flex flex-wrap gap-2">
            @foreach($dueSoonTasks as $dt)
                <a href="{{ route('tasks.show', $dt) }}"
                   class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-medium
                          bg-white dark:bg-gray-800 border border-amber-200 dark:border-amber-700/50
                          text-gray-700 dark:text-gray-200 hover:border-amber-400 transition-colors duration-200 shadow-sm">
                    <i class="fas fa-exclamation-circle text-amber-500 dark:text-amber-400"></i>
                    {{ $dt->title }}
                    <span class="text-gray-400 dark:text-gray-500">·</span>
                    <span class="text-amber-600 dark:text-amber-400">{{ $dt->due_date->format('M d') }}</span>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- ============================================================
     RECENT TASKS (full width)
============================================================ --}}
<div class="rounded-2xl overflow-hidden border shadow-sm transition-colors duration-200
            border-gray-100 dark:border-gray-700/60
            bg-white dark:bg-gray-800/80">

    {{-- Header --}}
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-700/60">
        <h2 class="text-base font-bold text-gray-800 dark:text-white flex items-center gap-2">
            <i class="fas fa-history text-purple-500"></i> Recent Tasks
            <span class="text-xs font-semibold px-2 py-0.5 rounded-full
                         bg-purple-100 dark:bg-purple-900/40 text-purple-600 dark:text-purple-400">
                Latest 5
            </span>
        </h2>
        <a href="{{ route('tasks.list') }}"
           class="text-xs font-semibold text-indigo-500 dark:text-indigo-400 hover:underline flex items-center gap-1">
            View all <i class="fas fa-arrow-right text-[10px]"></i>
        </a>
    </div>

    {{-- Task Rows --}}
    <ul class="divide-y divide-gray-50 dark:divide-gray-700/50">
        @forelse($recentTasks as $task)
            @php $isOverdue = $task->due_date && $task->due_date->isPast() && $task->status !== 'Completed'; @endphp
            <li class="group transition-colors duration-150
                       {{ $isOverdue ? 'bg-red-50/40 dark:bg-red-900/10' : 'hover:bg-indigo-50/30 dark:hover:bg-indigo-900/10' }}">
                <a href="{{ route('tasks.show', $task) }}"
                   class="flex flex-col sm:flex-row sm:items-center gap-3 px-6 py-4">

                    {{-- Avatar --}}
                    <div class="w-9 h-9 rounded-xl flex-shrink-0 flex items-center justify-center text-sm font-bold
                                bg-gradient-to-br from-purple-500 to-indigo-600 text-white shadow-sm shadow-purple-500/20">
                        {{ strtoupper(substr($task->assigned_to, 0, 1)) }}
                    </div>

                    {{-- Title & Description --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800 dark:text-white truncate
                                  group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                            {{ $task->title }}
                            @if($isOverdue)
                                <span class="ml-2 inline-flex items-center px-1.5 py-0.5 rounded-md text-[10px] font-bold
                                             bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-400 border border-red-200 dark:border-red-800/60">
                                    OVERDUE
                                </span>
                            @endif
                        </p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5 truncate">
                            <i class="fas fa-user mr-1 opacity-60"></i>{{ $task->assigned_to }}
                            <span class="mx-1.5 opacity-40">·</span>
                            {{ $task->created_at->diffForHumans() }}
                        </p>
                    </div>

                    {{-- Priority --}}
                    <div class="flex-shrink-0">
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
                    </div>

                    {{-- Status --}}
                    <div class="flex-shrink-0">
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
                    </div>

                    {{-- Due Date --}}
                    <div class="flex-shrink-0 text-xs {{ $isOverdue ? 'text-red-500 dark:text-red-400 font-semibold' : 'text-gray-400 dark:text-gray-500' }}">
                        @if($task->due_date)
                            <i class="fas fa-calendar-alt mr-1 opacity-60"></i>{{ $task->due_date->format('M d, Y') }}
                        @else
                            <span class="text-gray-300 dark:text-gray-600">No due date</span>
                        @endif
                    </div>

                    {{-- Arrow --}}
                    <i class="fas fa-chevron-right text-gray-300 dark:text-gray-600 text-xs flex-shrink-0
                              group-hover:text-indigo-400 transition-colors hidden sm:block"></i>
                </a>
            </li>
        @empty
            <li class="px-6 py-14 text-center">
                <div class="flex flex-col items-center gap-3 text-gray-400 dark:text-gray-500">
                    <div class="w-16 h-16 rounded-2xl bg-gray-100 dark:bg-gray-700/50 flex items-center justify-center">
                        <i class="fas fa-clipboard-list text-3xl text-gray-300 dark:text-gray-600"></i>
                    </div>
                    <p class="text-sm font-medium">No tasks yet.</p>
                    <a href="{{ route('tasks.create') }}"
                       class="text-xs text-indigo-500 dark:text-indigo-400 hover:underline">
                        + Create your first task
                    </a>
                </div>
            </li>
        @endforelse
    </ul>

    {{-- Footer --}}
    @if($recentTasks->count() > 0)
    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700/60 bg-gray-50/50 dark:bg-gray-700/20">
        <a href="{{ route('tasks.list') }}"
           class="flex items-center justify-center gap-2 text-sm font-semibold text-indigo-600 dark:text-indigo-400
                  hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors">
            View all {{ $totalTasks }} tasks
            <i class="fas fa-arrow-right text-xs"></i>
        </a>
    </div>
    @endif
</div>

@endsection
