@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Add New Task</h2>
            <a href="{{ route('tasks.index') }}" class="text-gray-600 hover:text-gray-900 transition">
                <i class="fas fa-arrow-left mr-1"></i> Back
            </a>
        </div>
        
        <div class="p-6">
            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" 
                           class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('title') border-red-500 @else border-gray-300 @enderror">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="assigned_to" class="block text-sm font-medium text-gray-700 mb-1">Assigned To <span class="text-red-500">*</span></label>
                    <input type="text" name="assigned_to" id="assigned_to" value="{{ old('assigned_to') }}" 
                           class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('assigned_to') border-red-500 @else border-gray-300 @enderror">
                    @error('assigned_to')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="description" rows="4" 
                              class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">Priority <span class="text-red-500">*</span></label>
                        <select name="priority" id="priority" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="Low" {{ old('priority') == 'Low' ? 'selected' : '' }}>Low</option>
                            <option value="Medium" {{ old('priority', 'Medium') == 'Medium' ? 'selected' : '' }}>Medium</option>
                            <option value="High" {{ old('priority') == 'High' ? 'selected' : '' }}>High</option>
                        </select>
                        @error('priority')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                        <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="Pending" {{ old('status', 'Pending') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="In Progress" {{ old('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-6">
                    <label for="due_date" class="block text-sm font-medium text-gray-700 mb-1">Due Date</label>
                    <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('due_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex justify-end pt-4 border-t border-gray-200">
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                        Save Task
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
