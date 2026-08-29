@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
            <h2 class="text-xl font-semibold text-gray-800">Task Details</h2>
            <div class="flex space-x-2">
                <a href="{{ route('tasks.edit', $task) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                    <i class="fas fa-edit mr-1"></i> Edit
                </a>
                <a href="{{ route('tasks.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
                    <i class="fas fa-arrow-left mr-1"></i> Back
                </a>
            </div>
        </div>
        
        <div class="p-6">
            <div class="mb-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $task->title }}</h3>
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                        {{ $task->status === 'Completed' ? 'bg-green-100 text-green-800' : ($task->status === 'In Progress' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                        <i class="fas fa-tasks mr-2 mt-1"></i> {{ $task->status }}
                    </span>
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                        {{ $task->priority === 'High' ? 'bg-red-100 text-red-800' : ($task->priority === 'Medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                        <i class="fas fa-flag mr-2 mt-1"></i> {{ $task->priority }} Priority
                    </span>
                    
                    @if($task->due_date && $task->due_date->isPast() && $task->status !== 'Completed')
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-600 text-white">
                            <i class="fas fa-exclamation-triangle mr-2 mt-1"></i> OVERDUE
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-1">Assigned To</h4>
                    <p class="text-lg text-gray-900 font-medium flex items-center">
                        <i class="fas fa-user-circle text-gray-400 mr-2 text-xl"></i> {{ $task->assigned_to }}
                    </p>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-1">Due Date</h4>
                    <p class="text-lg text-gray-900 font-medium flex items-center">
                        <i class="fas fa-calendar-alt text-gray-400 mr-2 text-xl"></i> 
                        {{ $task->due_date ? $task->due_date->format('F j, Y') : 'No due date set' }}
                    </p>
                </div>
            </div>
            
            <div class="mb-6">
                <h4 class="text-lg font-medium text-gray-900 mb-2 border-b pb-2">Description</h4>
                <div class="prose max-w-none text-gray-700 bg-white p-4 rounded-lg border border-gray-100 shadow-sm min-h-[100px]">
                    @if($task->description)
                        {!! nl2br(e($task->description)) !!}
                    @else
                        <p class="text-gray-400 italic">No description provided for this task.</p>
                    @endif
                </div>
            </div>
            
            <div class="text-sm text-gray-500 flex justify-between border-t pt-4">
                <span>Created: {{ $task->created_at->format('M d, Y h:i A') }}</span>
                <span>Last Updated: {{ $task->updated_at->format('M d, Y h:i A') }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
