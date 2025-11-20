@extends('admin.layout.app')

@section('title', 'Documentation')
@section('page-title', 'Tracking Documentation')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Tracking Documentation</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $website->name }}</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('website.show', $website->id) }}"
               class="inline-flex items-center px-4 py-2 font-medium text-white bg-gray-600 rounded-lg shadow-sm transition-colors hover:bg-gray-700">
                <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Website
            </a>
        </div>
    </div>

    <!-- Website Info Card -->
    <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-800">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $website->name }}</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $website->url }}</p>
            </div>
            <div class="flex items-center space-x-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $website->tracking_method === 'javascript' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400' : 'bg-purple-100 text-purple-800 dark:bg-purple-900/20 dark:text-purple-400' }}">
                    {{ ucfirst($website->tracking_method) }}
                </span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $token->active ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-300' }}">
                    {{ $token->active ? 'Active' : 'Inactive' }}
                </span>
            </div>
        </div>
    </div>

    @if($website->tracking_method === 'javascript')
        <!-- JavaScript Documentation -->
        <div class="overflow-hidden bg-white rounded-lg shadow dark:bg-gray-800">
            <div class="px-6 py-4 bg-indigo-50 border-b border-gray-200 dark:border-gray-700 dark:bg-indigo-900/20">
                <div class="flex items-center">
                    <svg class="mr-2 w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">JavaScript Integration</h3>
                </div>
            </div>
            <div class="p-6 space-y-6">
                <!-- Step 1: Installation -->
                <div>
                    <div class="flex items-center mb-3">
                        <span class="flex justify-center items-center mr-3 w-8 h-8 font-semibold text-indigo-600 bg-indigo-100 rounded-full dark:bg-indigo-900/20 dark:text-indigo-400">1</span>
                        <h4 class="text-base font-semibold text-gray-900 dark:text-white">Installation</h4>
                    </div>
                    <p class="mb-3 ml-11 text-sm text-gray-600 dark:text-gray-400">
                        Tempelkan kode berikut di akhir <code class="px-1.5 py-0.5 bg-gray-100 rounded dark:bg-gray-700">&lt;/head&gt;</code> atau sebelum <code class="px-1.5 py-0.5 bg-gray-100 rounded dark:bg-gray-700">&lt;/body&gt;</code> pada setiap halaman yang ingin di-track.
                    </p>
                    <div class="relative ml-11">
                        <div class="absolute top-3 right-3">
                            <button type="button"
                                    onclick="copyCode('js-code')"
                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-gray-700 bg-white rounded border border-gray-300 transition-colors dark:text-gray-300 dark:bg-gray-700 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <svg class="mr-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                Copy
                            </button>
                        </div>
                        <pre id="js-code" class="overflow-x-auto p-4 text-sm text-gray-100 bg-gray-900 rounded-lg dark:bg-gray-950"><code>&lt;script&gt;
fetch('{{ $apiUrl }}', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({
        website_id: '{{ $website->id }}',
        token: '{{ $token->token }}',
        referrer: document.referrer,
        user_agent: navigator.userAgent,
        current_url: window.location.href

    })
});
&lt;/script&gt;</code></pre>
                    </div>
                </div>

                <!-- Step 2: How it works -->
                <div>
                    <div class="flex items-center mb-3">
                        <span class="flex justify-center items-center mr-3 w-8 h-8 font-semibold text-indigo-600 bg-indigo-100 rounded-full dark:bg-indigo-900/20 dark:text-indigo-400">2</span>
                        <h4 class="text-base font-semibold text-gray-900 dark:text-white">Cara Kerja</h4>
                    </div>
                    <div class="ml-11 space-y-2">
                        <div class="flex items-start">
                            <svg class="flex-shrink-0 mt-0.5 mr-2 w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Script ini akan otomatis mencatat kunjungan setiap kali halaman dibuka</p>
                        </div>
                        <div class="flex items-start">
                            <svg class="flex-shrink-0 mt-0.5 mr-2 w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Tidak perlu plugin WordPress</p>
                        </div>
                        <div class="flex items-start">
                            <svg class="flex-shrink-0 mt-0.5 mr-2 w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Bisa dipasang di HTML, Laravel Blade, Blogger, atau platform lainnya</p>
                        </div>
                    </div>
                </div>

                <!-- Step 3: API Details -->
                <div>
                    <div class="flex items-center mb-3">
                        <span class="flex justify-center items-center mr-3 w-8 h-8 font-semibold text-indigo-600 bg-indigo-100 rounded-full dark:bg-indigo-900/20 dark:text-indigo-400">3</span>
                        <h4 class="text-base font-semibold text-gray-900 dark:text-white">API Details</h4>
                    </div>
                    <div class="ml-11 space-y-3">
                        <div>
                            <p class="mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">API Endpoint:</p>
                            <code class="block px-3 py-2 text-sm text-gray-900 bg-gray-100 rounded dark:bg-gray-700 dark:text-white">{{ $apiUrl }}</code>
                        </div>
                        <div>
                            <p class="mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Website ID:</p>
                            <code class="block px-3 py-2 text-sm text-gray-900 bg-gray-100 rounded dark:bg-gray-700 dark:text-white">{{ $website->id }}</code>
                        </div>
                        <div>
                            <p class="mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Token:</p>
                            <div class="flex items-center space-x-2">
                                <code class="flex-1 px-3 py-2 font-mono text-sm text-gray-900 break-all bg-gray-100 rounded dark:bg-gray-700 dark:text-white">{{ $token->token }}</code>
                                <button type="button"
                                        onclick="copyToClipboard('{{ $token->token }}')"
                                        class="px-3 py-2 text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">
                                    Copy
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- WordPress Documentation -->
        <div class="overflow-hidden bg-white rounded-lg shadow dark:bg-gray-800">
            <div class="px-6 py-4 bg-purple-50 border-b border-gray-200 dark:border-gray-700 dark:bg-purple-900/20">
                <div class="flex items-center">
                    <svg class="mr-2 w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">WordPress Plugin Integration</h3>
                </div>
            </div>
            <div class="p-6 space-y-6">
                <!-- Step 1: Installation -->
                <div>
                    <div class="flex items-center mb-3">
                        <span class="flex justify-center items-center mr-3 w-8 h-8 font-semibold text-purple-600 bg-purple-100 rounded-full dark:bg-purple-900/20 dark:text-purple-400">1</span>
                        <h4 class="text-base font-semibold text-gray-900 dark:text-white">Cara Instal Plugin WordPress</h4>
                    </div>
                    <div class="ml-11 space-y-3">
                        <div class="flex items-start">
                            <span class="flex justify-center items-center mt-0.5 mr-3 w-6 h-6 text-xs font-semibold text-purple-600 bg-purple-100 rounded-full dark:bg-purple-900/20 dark:text-purple-400">1</span>
<p class="flex-1 text-sm text-gray-600 dark:text-gray-400">
    Download plugin:
    <a href="{{ route('plugin.govtraffic.download') }}"
       class="inline-flex items-center px-3 py-1.5 ml-2 text-xs font-medium text-white bg-indigo-600 rounded transition hover:bg-indigo-700">
        Download GovTraffic Plugin
    </a>
</p>
                        </div>
                        <div class="flex items-start">
                            <span class="flex justify-center items-center mt-0.5 mr-3 w-6 h-6 text-xs font-semibold text-purple-600 bg-purple-100 rounded-full dark:bg-purple-900/20 dark:text-purple-400">2</span>
                            <p class="flex-1 text-sm text-gray-600 dark:text-gray-400">Upload di WordPress → <strong>Plugins</strong> → <strong>Add New</strong> → <strong>Upload Plugin</strong></p>
                        </div>
                        <div class="flex items-start">
                            <span class="flex justify-center items-center mt-0.5 mr-3 w-6 h-6 text-xs font-semibold text-purple-600 bg-purple-100 rounded-full dark:bg-purple-900/20 dark:text-purple-400">3</span>
                            <p class="flex-1 text-sm text-gray-600 dark:text-gray-400">Aktifkan plugin</p>
                        </div>
                        <div class="flex items-start">
                            <span class="flex justify-center items-center mt-0.5 mr-3 w-6 h-6 text-xs font-semibold text-purple-600 bg-purple-100 rounded-full dark:bg-purple-900/20 dark:text-purple-400">4</span>
                            <p class="flex-1 text-sm text-gray-600 dark:text-gray-400">Masuk ke menu <strong>Settings</strong> → <strong>GovTraffic</strong></p>
                        </div>
                        <div class="flex items-start">
                            <span class="flex justify-center items-center mt-0.5 mr-3 w-6 h-6 text-xs font-semibold text-purple-600 bg-purple-100 rounded-full dark:bg-purple-900/20 dark:text-purple-400">5</span>
                            <p class="flex-1 text-sm text-gray-600 dark:text-gray-400">Masukkan data berikut:</p>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Configuration -->
                <div>
                    <div class="flex items-center mb-3">
                        <span class="flex justify-center items-center mr-3 w-8 h-8 font-semibold text-purple-600 bg-purple-100 rounded-full dark:bg-purple-900/20 dark:text-purple-400">2</span>
                        <h4 class="text-base font-semibold text-gray-900 dark:text-white">Configuration</h4>
                    </div>
                    <div class="ml-11">
                        <div class="p-4 space-y-3 bg-gray-50 rounded-lg dark:bg-gray-700">
                            <div>
                                <p class="mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Website ID:</p>
                                <div class="flex items-center space-x-2">
                                    <code class="flex-1 px-3 py-2 font-mono text-sm text-gray-900 bg-white rounded dark:bg-gray-800 dark:text-white">{{ $website->id }}</code>
                                    <button type="button"
                                            onclick="copyToClipboard('{{ $website->id }}')"
                                            class="px-3 py-2 text-sm font-medium text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300">
                                        Copy
                                    </button>
                                </div>
                            </div>
                            <div>
                                <p class="mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">API Key:</p>
                                <div class="flex items-center space-x-2">
                                    <code class="flex-1 px-3 py-2 font-mono text-sm text-gray-900 break-all bg-white rounded dark:bg-gray-800 dark:text-white">{{ $token->token }}</code>
                                    <button type="button"
                                            onclick="copyToClipboard('{{ $token->token }}')"
                                            class="px-3 py-2 text-sm font-medium text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300">
                                        Copy
                                    </button>
                                </div>
                            </div>
                            <div>
                                <p class="mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">API Endpoint:</p>
                                <div class="flex items-center space-x-2">
                                    <code class="flex-1 px-3 py-2 text-sm text-gray-900 bg-white rounded dark:bg-gray-800 dark:text-white">{{ $apiUrl }}</code>
                                    <button type="button"
                                            onclick="copyToClipboard('{{ $apiUrl }}')"
                                            class="px-3 py-2 text-sm font-medium text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300">
                                        Copy
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3: API Request Format -->
                <div>
                    <div class="flex items-center mb-3">
                        <span class="flex justify-center items-center mr-3 w-8 h-8 font-semibold text-purple-600 bg-purple-100 rounded-full dark:bg-purple-900/20 dark:text-purple-400">3</span>
                        <h4 class="text-base font-semibold text-gray-900 dark:text-white">API Request Format</h4>
                    </div>
                    <div class="ml-11">
                        <p class="mb-3 text-sm text-gray-600 dark:text-gray-400">Plugin akan otomatis mengirim data kunjungan dengan format berikut:</p>
                        <div class="relative">
                            <div class="absolute top-3 right-3">
                                <button type="button"
                                        onclick="copyCode('api-code')"
                                        class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-gray-700 bg-white rounded border border-gray-300 transition-colors dark:text-gray-300 dark:bg-gray-700 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <svg class="mr-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                    Copy
                                </button>
                            </div>
                            <pre id="api-code" class="overflow-x-auto p-4 text-sm text-gray-100 bg-gray-900 rounded-lg dark:bg-gray-950"><code>POST {{ $apiUrl }}

{
    "website_id": "{{ $website->id }}",
    "token": "{{ $token->token }}",
    "user_agent": "Mozilla/Chrome",
    "referrer": "https://example.com",
    "current_url": "https://your-site.com/artikel-berita"
}</code></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    function copyCode(elementId) {
        const element = document.getElementById(elementId);
        const text = element.textContent || element.innerText;
        navigator.clipboard.writeText(text).then(function() {
            // Show success feedback
            const button = element.parentElement.querySelector('button');
            const originalText = button.innerHTML;
            button.innerHTML = '<svg class="mr-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>Copied!';
            button.classList.add('bg-green-100', 'text-green-800', 'border-green-300');
            setTimeout(() => {
                button.innerHTML = originalText;
                button.classList.remove('bg-green-100', 'text-green-800', 'border-green-300');
            }, 2000);
        }, function(err) {
            console.error('Failed to copy: ', err);
            alert('Failed to copy code');
        });
    }

    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            // You can add a toast notification here if you have SweetAlert or similar
            alert('Copied to clipboard!');
        }, function(err) {
            console.error('Failed to copy: ', err);
            alert('Failed to copy');
        });
    }
</script>
@endpush
@endsection

