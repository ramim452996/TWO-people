@extends('layouts.app')

@section('content')

{{-- ============================================================
     1. EXECUTIVE WELCOME & COMMAND HEADER
============================================================ --}}
<div class="relative mb-8 rounded-3xl p-6 sm:p-8 bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white shadow-2xl border border-indigo-500/20 overflow-hidden">
    <!-- Ambient Background Glow -->
    <div class="absolute -top-16 -right-16 w-64 h-64 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-16 -left-16 w-64 h-64 bg-purple-500/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-2.5 mb-2">
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-indigo-500/30 text-indigo-300 border border-indigo-400/30 backdrop-blur-md flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Live Operations</span>
                </span>
                <span class="text-xs text-slate-400 font-medium">
                    <i class="far fa-calendar-alt mr-1"></i> {{ date('l, F d, Y') }}
                </span>
            </div>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight text-white flex items-center gap-3">
                <span>Executive Dashboard</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-300 max-w-xl mt-1 font-normal leading-relaxed">
                Real-time task velocity, sprint metrics, and team deliverables across the {{ config('office.company_name', 'ASTGD') }} enterprise workspace.
            </p>
        </div>

        <!-- Quick Action Buttons -->
        <div class="flex flex-wrap items-center gap-3 shrink-0">
            <a href="{{ route('tasks.export') }}"
               class="px-4 py-2.5 rounded-2xl text-xs sm:text-sm font-bold text-slate-200 bg-white/10 hover:bg-white/20 border border-white/15 backdrop-blur-md shadow-sm transition-all duration-200 flex items-center gap-2">
                <i class="fas fa-file-arrow-down text-indigo-300"></i>
                <span>Export CSV</span>
            </a>
            <a href="{{ route('tasks.list') }}"
               class="px-4 py-2.5 rounded-2xl text-xs sm:text-sm font-bold text-slate-200 bg-white/10 hover:bg-white/20 border border-white/15 backdrop-blur-md shadow-sm transition-all duration-200 flex items-center gap-2">
                <i class="fas fa-table-list text-purple-300"></i>
                <span>All Tasks</span>
            </a>
            <a href="{{ route('tasks.create') }}"
               class="px-5 py-2.5 rounded-2xl text-xs sm:text-sm font-bold text-white bg-gradient-to-r from-indigo-500 via-indigo-600 to-purple-600 hover:from-indigo-400 hover:to-purple-500 shadow-lg shadow-indigo-500/30 transition-all duration-200 transform hover:-translate-y-0.5 flex items-center gap-2">
                <i class="fas fa-plus"></i>
                <span>New Task</span>
            </a>
        </div>
    </div>
</div>

{{-- ============================================================
     2. SLEEK 5-METRIC STAT CARDS
============================================================ --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5 mb-8">

    {{-- 1. Total Tasks --}}
    <div class="relative overflow-hidden rounded-3xl p-5 bg-gradient-to-br from-indigo-600 to-indigo-800 text-white shadow-xl shadow-indigo-600/20 hover:-translate-y-1 transition-all duration-300 group border border-indigo-400/20">
        <div class="absolute -top-6 -right-6 w-24 h-24 bg-white/10 rounded-full group-hover:scale-125 transition-transform duration-500"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-4">
                <div class="w-11 h-11 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-lg shadow-inner">
                    <i class="fas fa-layer-group"></i>
                </div>
                <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-white/20 text-indigo-100 uppercase tracking-wider">Total</span>
            </div>
            <p class="text-3xl sm:text-4xl font-black tracking-tight mb-1">{{ $totalTasks }}</p>
            <p class="text-xs font-medium text-indigo-200 flex items-center gap-1">
                <i class="fas fa-briefcase text-[10px]"></i> Total Registered Tasks
            </p>
        </div>
    </div>

    {{-- 2. Pending Backlog --}}
    <div class="relative overflow-hidden rounded-3xl p-5 bg-gradient-to-br from-amber-500 to-amber-700 text-white shadow-xl shadow-amber-500/20 hover:-translate-y-1 transition-all duration-300 group border border-amber-300/20">
        <div class="absolute -top-6 -right-6 w-24 h-24 bg-white/10 rounded-full group-hover:scale-125 transition-transform duration-500"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-4">
                <div class="w-11 h-11 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-lg shadow-inner">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-white/20 text-amber-100 uppercase tracking-wider">Queued</span>
            </div>
            <p class="text-3xl sm:text-4xl font-black tracking-tight mb-1">{{ $pendingTasks }}</p>
            <p class="text-xs font-medium text-amber-100 flex items-center gap-1">
                <i class="fas fa-clock text-[10px]"></i> Awaiting Initiation
            </p>
        </div>
    </div>

    {{-- 3. In Progress --}}
    <div class="relative overflow-hidden rounded-3xl p-5 bg-gradient-to-br from-sky-500 to-blue-700 text-white shadow-xl shadow-sky-500/20 hover:-translate-y-1 transition-all duration-300 group border border-sky-300/20">
        <div class="absolute -top-6 -right-6 w-24 h-24 bg-white/10 rounded-full group-hover:scale-125 transition-transform duration-500"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-4">
                <div class="w-11 h-11 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-lg shadow-inner">
                    <i class="fas fa-spinner animate-spin text-base" style="animation-duration: 4s;"></i>
                </div>
                <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-white/20 text-sky-100 uppercase tracking-wider">Active</span>
            </div>
            <p class="text-3xl sm:text-4xl font-black tracking-tight mb-1">{{ $inProgressTasks }}</p>
            <p class="text-xs font-medium text-sky-100 flex items-center gap-1">
                <i class="fas fa-arrows-rotate text-[10px]"></i> Under Active Sprint
            </p>
        </div>
    </div>

    {{-- 4. Completed --}}
    <div class="relative overflow-hidden rounded-3xl p-5 bg-gradient-to-br from-emerald-500 to-teal-700 text-white shadow-xl shadow-emerald-500/20 hover:-translate-y-1 transition-all duration-300 group border border-emerald-300/20">
        <div class="absolute -top-6 -right-6 w-24 h-24 bg-white/10 rounded-full group-hover:scale-125 transition-transform duration-500"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-4">
                <div class="w-11 h-11 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-lg shadow-inner">
                    <i class="fas fa-circle-check"></i>
                </div>
                <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-white/20 text-emerald-100 uppercase tracking-wider">{{ $completionRate }}%</span>
            </div>
            <p class="text-3xl sm:text-4xl font-black tracking-tight mb-1">{{ $completedTasks }}</p>
            <p class="text-xs font-medium text-emerald-100 flex items-center gap-1">
                <i class="fas fa-shield-check text-[10px]"></i> Successfully Delivered
            </p>
        </div>
    </div>

    {{-- 5. High Priority --}}
    <div class="relative overflow-hidden rounded-3xl p-5 bg-gradient-to-br from-rose-500 to-red-700 text-white shadow-xl shadow-rose-500/20 hover:-translate-y-1 transition-all duration-300 group border border-rose-300/20">
        <div class="absolute -top-6 -right-6 w-24 h-24 bg-white/10 rounded-full group-hover:scale-125 transition-transform duration-500"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-4">
                <div class="w-11 h-11 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-lg shadow-inner">
                    <i class="fas fa-fire-flame-curved"></i>
                </div>
                <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-white/20 text-rose-100 uppercase tracking-wider">Urgent</span>
            </div>
            <p class="text-3xl sm:text-4xl font-black tracking-tight mb-1">{{ $highPriorityTasks }}</p>
            <p class="text-xs font-medium text-rose-100 flex items-center gap-1">
                <i class="fas fa-triangle-exclamation text-[10px]"></i> Critical Priority
            </p>
        </div>
    </div>

</div>

{{-- ============================================================
     3. OVERALL SPRINT PROGRESS VELOCITY BAR
============================================================ --}}
<div class="rounded-3xl border shadow-sm mb-8 p-6 bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-800 transition-colors">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-3">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-sm font-bold">
                <i class="fas fa-gauge-high"></i>
            </div>
            <div>
                <h3 class="text-sm sm:text-base font-bold text-slate-800 dark:text-white">
                    Overall Project Velocity & Completion
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400">Total deliverables completed across active cycle</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-2xl font-black text-indigo-600 dark:text-indigo-400">{{ $completionRate }}%</span>
            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-indigo-50 dark:bg-indigo-950 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800">
                {{ $completedTasks }}/{{ $totalTasks }} Tasks
            </span>
        </div>
    </div>

    <!-- Progress Track -->
    <div class="w-full h-3.5 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden p-0.5 border border-slate-200/60 dark:border-slate-700/60">
        <div class="h-full rounded-full bg-gradient-to-r from-indigo-500 via-purple-500 to-emerald-400 transition-all duration-1000 shadow-sm"
             style="width: {{ $completionRate }}%"></div>
    </div>

    <div class="flex justify-between items-center text-xs text-slate-400 dark:text-slate-500 mt-2.5 font-medium">
        <span>0% (Project Start)</span>
        <span class="hidden sm:inline">Remaining: {{ max(0, $totalTasks - $completedTasks) }} tasks</span>
        <span>100% (Target Goal)</span>
    </div>
</div>

{{-- ============================================================
     4. DUE SOON / CRITICAL ALERT SECTION
============================================================ --}}
@if($dueSoonTasks->count() > 0)
<div class="mb-8 rounded-3xl p-5 sm:p-6 bg-gradient-to-r from-amber-500/10 via-orange-500/10 to-amber-500/5 border border-amber-300/80 dark:border-amber-500/40 shadow-sm relative overflow-hidden">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
        <div class="flex items-center gap-2.5">
            <div class="w-9 h-9 rounded-2xl bg-amber-500 text-white flex items-center justify-center shadow-md shadow-amber-500/20">
                <i class="fas fa-bell animate-bounce text-sm"></i>
            </div>
            <div>
                <h3 class="text-sm sm:text-base font-extrabold text-amber-900 dark:text-amber-300">
                    Deliverables Due Soon (Next 3 Days)
                </h3>
                <p class="text-xs text-amber-700 dark:text-amber-400">
                    {{ $dueSoonTasks->count() }} {{ Str::plural('task', $dueSoonTasks->count()) }} require immediate attention before deadline.
                </p>
            </div>
        </div>
        <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-500 text-white shadow-xs self-start sm:self-auto">
            {{ $dueSoonTasks->count() }} Urgent
        </span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
        @foreach($dueSoonTasks as $dt)
            <a href="{{ route('tasks.edit', $dt->id) }}"
               class="p-3.5 rounded-2xl bg-white/90 dark:bg-slate-900/90 border border-amber-200 dark:border-amber-700/50 hover:border-amber-400 dark:hover:border-amber-400 transition-all duration-200 shadow-xs flex items-center justify-between group">
                <div class="flex items-center gap-3 overflow-hidden">
                    <div class="w-2.5 h-2.5 rounded-full bg-amber-500 shrink-0"></div>
                    <div class="truncate">
                        <p class="text-xs font-bold text-slate-800 dark:text-white truncate group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                            {{ $dt->title }}
                        </p>
                        <p class="text-[11px] text-slate-400">
                            Assigned to: <span class="font-semibold text-slate-600 dark:text-slate-300">{{ $dt->assigned_to }}</span>
                        </p>
                    </div>
                </div>
                <span class="text-xs font-bold px-2.5 py-1 rounded-xl bg-amber-100 dark:bg-amber-950 text-amber-700 dark:text-amber-300 shrink-0 ml-2">
                    {{ $dt->due_date ? $dt->due_date->format('M d') : 'No date' }}
                </span>
            </a>
        @endforeach
    </div>
</div>
@endif

{{-- ============================================================
     5. VISUAL ANALYTICS & TASK DISTRIBUTION CHART
============================================================ --}}
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-8">

    {{-- Left: Status Distribution Chart (5 Cols) --}}
    <div class="lg:col-span-5 rounded-3xl p-6 sm:p-7 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100 dark:border-slate-800">
                <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <i class="fas fa-chart-pie text-indigo-500"></i>
                    <span>Status Distribution</span>
                </h3>
                <span class="text-xs font-semibold text-slate-400">Real-time</span>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-6">
                Visual proportion of tasks categorized by operational workflow state.
            </p>
        </div>

        <div class="flex flex-col items-center justify-center my-2">
            <div class="relative w-56 h-56 sm:w-64 sm:h-64">
                <canvas id="taskStatusPieChart"></canvas>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-around text-xs text-slate-500 dark:text-slate-400 font-medium">
            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Completed</span>
            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-sky-500"></span> In Progress</span>
            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> Pending</span>
            @if($overdueTasks > 0)
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span> Overdue</span>
            @endif
        </div>
    </div>

    {{-- Right: Status Metrics Cards & Insights (7 Cols) --}}
    <div class="lg:col-span-7 rounded-3xl p-6 sm:p-7 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col justify-between">
        <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100 dark:border-slate-800">
            <div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <i class="fas fa-list-check text-purple-500"></i>
                    <span>Category Breakdown</span>
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Detailed task health summary</p>
            </div>
            <a href="{{ route('tasks.list') }}" class="text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:underline flex items-center gap-1">
                <span>View Table</span>
                <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="space-y-3.5">
            <!-- 1. Completed -->
            <div class="p-3.5 rounded-2xl bg-emerald-50/50 dark:bg-emerald-950/20 border border-emerald-200/70 dark:border-emerald-800/40 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-emerald-500 text-white flex items-center justify-center text-sm shadow-sm">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <h4 class="text-xs sm:text-sm font-bold text-slate-800 dark:text-white">Completed Tasks</h4>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400">Shipped and confirmed</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-lg font-black text-emerald-600 dark:text-emerald-400">{{ $completedTasks }}</p>
                    <p class="text-[11px] font-bold text-slate-400">{{ $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0 }}%</p>
                </div>
            </div>

            <!-- 2. In Progress -->
            <div class="p-3.5 rounded-2xl bg-sky-50/50 dark:bg-sky-950/20 border border-sky-200/70 dark:border-sky-800/40 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-sky-500 text-white flex items-center justify-center text-sm shadow-sm">
                        <i class="fas fa-spinner"></i>
                    </div>
                    <div>
                        <h4 class="text-xs sm:text-sm font-bold text-slate-800 dark:text-white">In Progress</h4>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400">Currently active in sprint</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-lg font-black text-sky-600 dark:text-sky-400">{{ $inProgressTasks }}</p>
                    <p class="text-[11px] font-bold text-slate-400">{{ $totalTasks > 0 ? round(($inProgressTasks / $totalTasks) * 100) : 0 }}%</p>
                </div>
            </div>

            <!-- 3. Pending -->
            <div class="p-3.5 rounded-2xl bg-amber-50/50 dark:bg-amber-950/20 border border-amber-200/70 dark:border-amber-800/40 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center text-sm shadow-sm">
                        <i class="fas fa-hourglass-start"></i>
                    </div>
                    <div>
                        <h4 class="text-xs sm:text-sm font-bold text-slate-800 dark:text-white">Pending Backlog</h4>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400">Queued for next assignment</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-lg font-black text-amber-600 dark:text-amber-400">{{ $pendingTasks }}</p>
                    <p class="text-[11px] font-bold text-slate-400">{{ $totalTasks > 0 ? round(($pendingTasks / $totalTasks) * 100) : 0 }}%</p>
                </div>
            </div>

            <!-- 4. Overdue -->
            <div class="p-3.5 rounded-2xl bg-rose-50/50 dark:bg-rose-950/20 border border-rose-200/70 dark:border-rose-800/40 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-rose-500 text-white flex items-center justify-center text-sm shadow-sm">
                        <i class="fas fa-triangle-exclamation"></i>
                    </div>
                    <div>
                        <h4 class="text-xs sm:text-sm font-bold text-slate-800 dark:text-white">Overdue Tasks</h4>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400">Exceeded due deadline</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-lg font-black text-rose-600 dark:text-rose-400">{{ $overdueTasks }}</p>
                    <p class="text-[11px] font-bold text-slate-400">{{ $totalTasks > 0 ? round(($overdueTasks / $totalTasks) * 100) : 0 }}%</p>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ============================================================
     6. RECENT TASKS QUICK TABLE
============================================================ --}}
<div class="rounded-3xl border shadow-sm p-6 sm:p-7 bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-800 transition-colors">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 mb-5 border-b border-slate-100 dark:border-slate-800">
        <div>
            <h3 class="text-lg font-extrabold text-slate-900 dark:text-white flex items-center gap-2.5">
                <i class="fas fa-clipboard-list text-indigo-500"></i>
                <span>Recent Active Tasks</span>
            </h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Quick glance of latest entries</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('tasks.list') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/60 border border-indigo-200 dark:border-indigo-800 hover:bg-indigo-100 transition-colors">
                View Full Table
            </a>
        </div>
    </div>

    @if($tasks->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead>
                    <tr class="border-b border-slate-100 dark:border-slate-800 text-slate-400 uppercase text-[10px] font-bold tracking-wider">
                        <th class="pb-3">Task Title</th>
                        <th class="pb-3">Assigned To</th>
                        <th class="pb-3">Priority</th>
                        <th class="pb-3">Status</th>
                        <th class="pb-3">Due Date</th>
                        <th class="pb-3 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60">
                    @foreach($tasks->take(6) as $task)
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="py-3.5 pr-3">
                                <a href="{{ route('tasks.show', $task->id) }}" class="font-bold text-slate-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors block">
                                    {{ $task->title }}
                                </a>
                                @if($task->description)
                                    <p class="text-[11px] text-slate-400 truncate max-w-xs mt-0.5">{{ Str::limit($task->description, 50) }}</p>
                                @endif
                            </td>
                            <td class="py-3.5 pr-3">
                                <span class="inline-flex items-center gap-1.5 font-medium text-slate-700 dark:text-slate-300">
                                    <div class="w-6 h-6 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-600 text-white flex items-center justify-center text-[10px] font-bold">
                                        {{ strtoupper(substr($task->assigned_to, 0, 1)) }}
                                    </div>
                                    <span>{{ $task->assigned_to }}</span>
                                </span>
                            </td>
                            <td class="py-3.5 pr-3">
                                @if($task->priority === 'High')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-100 text-rose-700 dark:bg-rose-950 dark:text-rose-300 border border-rose-200 dark:border-rose-800">High</span>
                                @elseif($task->priority === 'Medium')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-300 border border-amber-200 dark:border-amber-800">Medium</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300 border border-slate-200 dark:border-slate-700">Low</span>
                                @endif
                            </td>
                            <td class="py-3.5 pr-3">
                                @if($task->status === 'Completed')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 flex items-center gap-1 w-max">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Completed
                                    </span>
                                @elseif($task->status === 'In Progress')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-sky-100 text-sky-700 dark:bg-sky-950 dark:text-sky-300 border border-sky-200 dark:border-sky-800 flex items-center gap-1 w-max">
                                        <span class="w-1.5 h-1.5 rounded-full bg-sky-500 animate-pulse"></span> In Progress
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-300 border border-amber-200 dark:border-amber-800 flex items-center gap-1 w-max">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 pr-3 text-slate-500 dark:text-slate-400">
                                @if($task->due_date)
                                    <span class="{{ $task->due_date->isPast() && $task->status !== 'Completed' ? 'text-rose-600 dark:text-rose-400 font-bold' : '' }}">
                                        {{ $task->due_date->format('M d, Y') }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic">No deadline</span>
                                @endif
                            </td>
                            <td class="py-3.5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('tasks.edit', $task->id) }}" class="p-1.5 rounded-lg text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" title="Edit">
                                        <i class="fas fa-edit text-xs"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-10 text-slate-400">
            <i class="fas fa-tasks text-3xl mb-2 text-slate-300 dark:text-slate-700"></i>
            <p class="text-xs">No tasks found. Click "+ New Task" to create your first task.</p>
        </div>
    @endif
</div>

{{-- ============================================================
     7. CHART.JS SCRIPT INITIALIZATION
============================================================ --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('taskStatusPieChart');
    if (!ctx) return;

    var completed  = {{ $completedTasks }};
    var pending    = {{ $pendingTasks }};
    var inProgress = {{ $inProgressTasks }};
    var overdue    = {{ $overdueTasks }};

    var total = completed + pending + inProgress + overdue;
    var dataValues = total > 0 ? [completed, inProgress, pending, overdue] : [1, 0, 0, 0];
    var bgColors = [
        '#10b981', // Emerald 500
        '#0ea5e9', // Sky 500
        '#f59e0b', // Amber 500
        '#f43f5e'  // Rose 500
    ];

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Completed', 'In Progress', 'Pending', 'Overdue'],
            datasets: [{
                data: dataValues,
                backgroundColor: bgColors,
                borderWidth: 0,
                hoverOffset: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '72%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    padding: 12,
                    cornerRadius: 12,
                    titleFont: { family: 'Inter', size: 12, weight: 'bold' },
                    bodyFont: { family: 'Inter', size: 12 }
                }
            }
        }
    });
});
</script>

@endsection