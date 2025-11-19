@extends('admin.layout.app')

@section('title', 'Edit Website')
@section('page-title', 'Edit Website')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Website</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Update website information</p>
        </div>

        <form action="{{ route('website.update', $website->id) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Website Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Website Name <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       name="name"
                       id="name"
                       value="{{ old('name', $website->name) }}"
                       required
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white @error('name') border-red-500 @enderror"
                       placeholder="e.g., My Company Website">
                @error('name')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Website URL -->
            <div>
                <label for="url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Website URL <span class="text-red-500">*</span>
                </label>
                <input type="url"
                       name="url"
                       id="url"
                       value="{{ old('url', $website->url) }}"
                       required
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white @error('url') border-red-500 @enderror"
                       placeholder="https://example.com">
                @error('url')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tracking Method -->
            <div>
                <label for="tracking_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Tracking Method <span class="text-red-500">*</span>
                </label>
                <select name="tracking_method"
                        id="tracking_method"
                        required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white @error('tracking_method') border-red-500 @enderror">
                    <option value="javascript" {{ old('tracking_method', $website->tracking_method) === 'javascript' ? 'selected' : '' }}>JavaScript</option>
                    <option value="wordpress" {{ old('tracking_method', $website->tracking_method) === 'wordpress' ? 'selected' : '' }}>WordPress</option>
                </select>
                @error('tracking_method')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Total Visit -->
            <div>
                <label for="total_visit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Total Visits
                </label>
                <input type="number"
                       name="total_visit"
                       id="total_visit"
                       value="{{ old('total_visit', $website->total_visit) }}"
                       min="0"
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white @error('total_visit') border-red-500 @enderror">
                @error('total_visit')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('website.index') }}"
                   class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-sm transition-colors">
                    Update Website
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

