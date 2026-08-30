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
     PIE CHART & TASK STATUS METRICS (Replaces Recent Tasks)
============================================================ --}}
<div class="rounded-3xl border shadow-sm transition-all duration-300 p-6 sm:p-8
            border-gray-100 dark:border-gray-700/60
            bg-white dark:bg-gray-800/90 backdrop-blur-md">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6 pb-4 border-b border-gray-100 dark:border-gray-700/60">
        <div>
            <h2 class="text-lg font-bold text-gray-800 dark:text-white flex items-center gap-2.5">
                <i class="fas fa-chart-pie text-indigo-500"></i> Task Status Distribution
            </h2>
            <p class="text-xs sm:text-sm text-gray-400 dark:text-gray-500 mt-0.5">
                Real-time visual breakdown of task progress and health.
            </p>
        </div>
        <a href="{{ route('tasks.list') }}"
           class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl text-xs font-semibold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition-colors self-start sm:self-auto">
            <span>Manage in Tasks</span>
            <i class="fas fa-arrow-right text-[10px]"></i>
        </a>
    </div>

    {{-- Grid Content: Chart on left, Detailed Metrics on right --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">

        {{-- Left: The Canvas Chart --}}
        <div class="lg:col-span-5 flex flex-col items-center justify-center relative">
            <div class="relative w-64 h-64 sm:w-72 sm:h-72">
                <canvas id="taskStatusPieChart"></canvas>
            </div>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-3 flex items-center gap-1.5">
                <i class="fas fa-info-circle text-indigo-400"></i> Hover or tap segments for details
            </p>
        </div>

        {{-- Right: Status Cards & Metrics Breakdown --}}
        <div class="lg:col-span-7 space-y-3.5">

            {{-- 1. Completed (Green) --}}
            <div class="p-4 rounded-2xl border transition-all duration-200 flex items-center justify-between
                        bg-emerald-50/60 dark:bg-emerald-950/20 border-emerald-200/80 dark:border-emerald-800/40 hover:shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center shadow-md shadow-emerald-500/20">
                        <i class="fas fa-check text-base"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h4 class="text-sm font-bold text-gray-800 dark:text-white">Completed</h4>
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Successfully finished tasks</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-xl font-extrabold text-emerald-600 dark:text-emerald-400">{{ $completedTasks }}</p>
                    <p class="text-xs font-medium text-gray-400 dark:text-gray-500">
                        {{ $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0 }}%
                    </p>
                </div>
            </div>

            {{-- 2. Pending (Blue) --}}
            <div class="p-4 rounded-2xl border transition-all duration-200 flex items-center justify-between
                        bg-blue-50/60 dark:bg-blue-950/20 border-blue-200/80 dark:border-blue-800/40 hover:shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-500 text-white flex items-center justify-center shadow-md shadow-blue-500/20">
                        <i class="fas fa-clock text-base"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h4 class="text-sm font-bold text-gray-800 dark:text-white">Pending</h4>
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Awaiting action or in backlog</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-xl font-extrabold text-blue-600 dark:text-blue-400">{{ $pendingTasks }}</p>
                    <p class="text-xs font-medium text-gray-400 dark:text-gray-500">
                        {{ $totalTasks > 0 ? round(($pendingTasks / $totalTasks) * 100) : 0 }}%
                    </p>
                </div>
            </div>

            {{-- 3. Overdue (Red) --}}
            <div class="p-4 rounded-2xl border transition-all duration-200 flex items-center justify-between
                        bg-rose-50/60 dark:bg-rose-950/20 border-rose-200/80 dark:border-rose-800/40 hover:shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-red-500 text-white flex items-center justify-center shadow-md shadow-red-500/20">
                        <i class="fas fa-exclamation-triangle text-base"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h4 class="text-sm font-bold text-gray-800 dark:text-white">Overdue</h4>
                            <span class="w-2.5 h-2.5 rounded-full bg-red-500 animate-pulse"></span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Tasks past their due date</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-xl font-extrabold text-red-600 dark:text-red-400">{{ $overdueTasks }}</p>
                    <p class="text-xs font-medium text-gray-400 dark:text-gray-500">
                        {{ $totalTasks > 0 ? round(($overdueTasks / $totalTasks) * 100) : 0 }}%
                    </p>
                </div>
            </div>

            {{-- 4. In Progress (Sky / Cyan Accent) --}}
            @if($inProgressTasks > 0)
            <div class="p-4 rounded-2xl border transition-all duration-200 flex items-center justify-between
                        bg-amber-50/60 dark:bg-amber-950/20 border-amber-200/80 dark:border-amber-800/40 hover:shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center shadow-md shadow-amber-500/20">
                        <i class="fas fa-spinner text-base"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h4 class="text-sm font-bold text-gray-800 dark:text-white">In Progress</h4>
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Currently being worked on</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-xl font-extrabold text-amber-600 dark:text-amber-400">{{ $inProgressTasks }}</p>
                    <p class="text-xs font-medium text-gray-400 dark:text-gray-500">
                        {{ $totalTasks > 0 ? round(($inProgressTasks / $totalTasks) * 100) : 0 }}%
                    </p>
                </div>
            </div>
            @endif

        </div>

    </div>

</div>

{{-- ============================================================
     PIE CHART SCRIPT
============================================================ --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    var ctx = document.getElementById('taskStatusPieChart');
    if (!ctx) return;

    var overdueCount    = {{ $overdueTasks }};
    var completedCount  = {{ $completedTasks }};
    var pendingCount    = {{ $pendingTasks }};
    var inProgressCount = {{ $inProgressTasks }};
    var total           = {{ $totalTasks }};

    // If no tasks exist, show a pleasant placeholder segment
    var chartLabels = [];
    var chartData   = [];
    var chartColors = [];
    var hoverColors = [];

    if (total === 0) {
        chartLabels = ['No Tasks Yet'];
        chartData   = [1];
        chartColors = ['#cbd5e1'];
        hoverColors = ['#94a3b8'];
    } else {
        // Red for Overdue
        if (overdueCount > 0) {
            chartLabels.push('Overdue');
            chartData.push(overdueCount);
            chartColors.push('#ef4444');
            hoverColors.push('#dc2626');
        }

        // Green for Completed
        if (completedCount > 0) {
            chartLabels.push('Completed');
            chartData.push(completedCount);
            chartColors.push('#22c55e');
            hoverColors.push('#16a34a');
        }

        // Blue for Pending
        if (pendingCount > 0) {
            chartLabels.push('Pending');
            chartData.push(pendingCount);
            chartColors.push('#3b82f6');
            hoverColors.push('#2563eb');
        }

        // In Progress (if any)
        if (inProgressCount > 0) {
            chartLabels.push('In Progress');
            chartData.push(inProgressCount);
            chartColors.push('#f59e0b');
            hoverColors.push('#d97706');
        }
    }

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: chartLabels,
            datasets: [{
                data: chartData,
                backgroundColor: chartColors,
                hoverBackgroundColor: hoverColors,
                borderWidth: 3,
                borderColor: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
                hoverOffset: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '68%',
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        boxHeight: 12,
                        borderRadius: 6,
                        useBorderRadius: true,
                        padding: 16,
                        font: {
                            family: 'Inter, sans-serif',
                            size: 12,
                            weight: '600'
                        },
                        color: document.documentElement.classList.contains('dark') ? '#9ca3af' : '#4b5563'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    titleFont: { family: 'Inter, sans-serif', size: 13, weight: 'bold' },
                    bodyFont: { family: 'Inter, sans-serif', size: 12 },
                    padding: 12,
                    cornerRadius: 10,
                    callbacks: {
                        label: function (context) {
                            if (total === 0) return 'No tasks created yet';
                            var val = context.raw || 0;
                            var pct = total > 0 ? Math.round((val / total) * 100) : 0;
                            return ' ' + context.label + ': ' + val + ' (' + pct + '%)';
                        }
                    }
                }
            },
            animation: {
                animateScale: true,
                animateRotate: true,
                duration: 1000,
                easing: 'easeOutQuart'
            }
        }
    });
});
</script>

@endsection
