@extends('admin.layout.app')

@section('title', 'Visitor Logs')
@section('page-title', 'Visitor Logs')

@section('content')
<div class="bg-white dark:bg-gray-800 shadow rounded-lg">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Visitor Logs</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Monitor and filter visitor activity across your websites.</p>
        </div>
        <form method="GET" class="flex flex-col gap-2 w-full lg:flex-row lg:items-center lg:w-auto">
            <div class="flex items-center gap-2 w-full lg:w-56">
                <label for="website_id" class="sr-only">Website</label>
                <select name="website_id" id="website_id" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All Websites</option>
                    @foreach($websites as $website)
                        <option value="{{ $website->id }}" @selected(request('website_id') == $website->id)>{{ $website->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-center gap-2 w-full lg:w-64">
                <label for="search" class="sr-only">Search</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Search IP, URL, agent" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500" />
            </div>
            <div class="flex gap-2">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Filter</button>
                <a href="{{ route('visitor.log.index') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-700 text-sm font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">Reset</a>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-900/50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Visited At</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">IP Address</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Website</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Referrer</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Current URL</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">User Agent</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($visitorLog as $log)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::parse($log->visited_at)->format('Y-m-d H:i:s') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">{{ $log->ip_address }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">{{ $log->website->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-indigo-600 dark:text-indigo-400 max-w-xs truncate">
                            @if($log->referrer)
                                <a href="{{ $log->referrer }}" target="_blank" rel="noreferrer">{{ $log->referrer }}</a>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-indigo-600 dark:text-indigo-400 max-w-xs truncate">
                            @if($log->current_url)
                                <a href="{{ $log->current_url }}" target="_blank" rel="noreferrer">{{ $log->current_url }}</a>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300 max-w-md truncate" title="{{ $log->user_agent }}">
                            {{ \Illuminate\Support\Str::limit($log->user_agent, 100) ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400">No visitor logs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
        {{ $visitorLog->links() }}
    </div>
</div>
@endsection
