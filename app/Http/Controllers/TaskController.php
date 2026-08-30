<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TaskController extends Controller
{
    public function index(Request $request): View
    {
        $query = Task::query();

        // Search Functionality
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('assigned_to', 'like', "%{$search}%");
            });
        }

        // Filtering System
        if ($request->filled('status') && $request->input('status') !== 'All') {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('priority') && $request->input('priority') !== 'All') {
            $query->where('priority', $request->input('priority'));
        }

        // Dashboard Counts
        $totalTasks = Task::count();
        $pendingTasks = Task::where('status', 'Pending')->count();
        $inProgressTasks = Task::where('status', 'In Progress')->count();
        $completedTasks = Task::where('status', 'Completed')->count();
        $highPriorityTasks = Task::where('priority', 'High')->count();

        // Overdue tasks count (not completed and past due date)
        $overdueTasks = Task::where('status', '!=', 'Completed')
            ->whereNotNull('due_date')
            ->where('due_date', '<', now()->startOfDay())
            ->count();

        $tasks = $query->latest()->paginate(config('office.tasks_per_page', 10))->withQueryString();

        // Bonus Features Logic (Section 17)
        $completionRate = $totalTasks > 0 ? (int) round(($completedTasks / $totalTasks) * 100) : 0;

        $dueSoonTasks = Task::where('status', '!=', 'Completed')
            ->whereNotNull('due_date')
            ->whereBetween('due_date', [now()->startOfDay(), now()->addDays(3)->endOfDay()])
            ->orderBy('due_date', 'asc')
            ->get();

        return view('tasks.index', compact(
            'tasks',
            'totalTasks',
            'pendingTasks',
            'inProgressTasks',
            'completedTasks',
            'highPriorityTasks',
            'overdueTasks',
            'completionRate',
            'dueSoonTasks'
        ));
    }

    public function create(): View
    {
        return view('tasks.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'assigned_to' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:Low,Medium,High',
            'status' => 'required|in:Pending,In Progress,Completed',
            'due_date' => 'nullable|date',
        ], [
            'title.required' => 'Task title is required.',
            'assigned_to.required' => 'Please select or enter the person responsible for this task.',
        ]);

        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function show(Task $task): View
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task): View
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'assigned_to' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:Low,Medium,High',
            'status' => 'required|in:Pending,In Progress,Completed',
            'due_date' => 'nullable|date',
        ], [
            'title.required' => 'Task title is required.',
            'assigned_to.required' => 'Please select or enter the person responsible for this task.',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    public function export(): StreamedResponse
    {
        if (! config('office.enable_task_export')) {
            abort(403, 'Task export is disabled.');
        }

        $tasks = Task::latest()->get();

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=tasks.csv',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $columns = ['ID', 'Title', 'Description', 'Assigned To', 'Priority', 'Status', 'Due Date', 'Created At'];

        $callback = function () use ($tasks, $columns) {
            $file = fopen('php://output', 'w');
            if ($file !== false) {
                fputcsv($file, $columns);

                foreach ($tasks as $task) {
                    fputcsv($file, [
                        $task->id,
                        $task->title,
                        $task->description,
                        $task->assigned_to,
                        $task->priority,
                        $task->status,
                        $task->due_date ? $task->due_date->format('Y-m-d') : '',
                        $task->created_at ? $task->created_at->format('Y-m-d H:i:s') : '',
                    ]);
                }

                fclose($file);
            }
        };

        return response()->stream($callback, 200, $headers);
    }

    public function list(Request $request): View
    {
        $query = Task::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('assigned_to', 'like', "%{$search}%");
            });
        }

        // Filters
        if ($request->filled('status') && $request->input('status') !== 'All') {
            $query->where('status', $request->input('status'));
        }
        if ($request->filled('priority') && $request->input('priority') !== 'All') {
            $query->where('priority', $request->input('priority'));
        }

        // Sort
        $sortField = in_array($request->input('sort'), ['title', 'assigned_to', 'priority', 'status', 'due_date', 'created_at'])
            ? $request->input('sort') : 'created_at';
        $sortDir = $request->input('dir') === 'asc' ? 'asc' : 'desc';

        $tasks = $query->orderBy($sortField, $sortDir)->get();
        $totalCount = Task::count();

        return view('tasks.list', compact('tasks', 'totalCount'));
    }
}
