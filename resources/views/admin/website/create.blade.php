@extends('admin.layout.app')

@section('title', 'Create Website')
@section('page-title', 'Create Website')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add New Website</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Fill in the details to start tracking a new website</p>
        </div>

        <form action="{{ route('website.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <!-- Website Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Website Name <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       name="name"
                       id="name"
                       value="{{ old('name') }}"
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
                       value="{{ old('url') }}"
                       required
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white @error('url') border-red-500 @enderror"
                       placeholder="https://example.com">
                @error('url')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Enter the full URL including https://</p>
            </div>

            <!-- Tracking Method -->
            <div>
                <label for="method" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Tracking Method <span class="text-red-500">*</span>
                </label>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <input type="radio"
                               name="method"
                               id="method_javascript"
                               value="javascript"
                               {{ old('method', 'javascript') === 'javascript' ? 'checked' : '' }}
                               required
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600">
                        <label for="method_javascript" class="ml-3 flex items-center">
                            <div>
                                <div class="text-sm font-medium text-gray-700 dark:text-gray-300">JavaScript</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Add tracking code to your website's HTML</div>
                            </div>
                        </label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio"
                               name="method"
                               id="method_wordpress"
                               value="wordpress"
                               {{ old('method') === 'wordpress' ? 'checked' : '' }}
                               required
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600">
                        <label for="method_wordpress" class="ml-3 flex items-center">
                            <div>
                                <div class="text-sm font-medium text-gray-700 dark:text-gray-300">WordPress</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Install as a WordPress plugin</div>
                            </div>
                        </label>
                    </div>
                </div>
                @error('method')
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
                    Create Website
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

