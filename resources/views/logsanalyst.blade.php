@extends('layouts.app')

@push('styles')
<style>
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    ::-webkit-scrollbar-thumb {
        background-color: #4a5568;
        border-radius: 4px;
    }
    ::-webkit-scrollbar-track {
        background-color: #2d3748;
    }
</style>
@endpush

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto px-6 py-6">
    <div class="bg-gray-900 rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-blue-400 flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                </svg>
                AI Login Records
            </h2>
            <span class="text-sm text-gray-400">Smart insights powered by Artificial Intelligence</span>
        </div>

        {{-- FILTER FORM --}}
        <form method="GET" action="{{ route('logs.analyst') }}" class="mb-6 flex flex-wrap gap-4 items-end">
            <div>
                <label for="date" class="block text-sm text-gray-300 mb-1">Date</label>
                <input type="date" name="date" id="date" value="{{ request('date') }}"
                    class="bg-gray-800 text-white px-4 py-2 rounded-md border border-gray-600">
            </div>
            <div>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm shadow transition">
                    🔍 Filter
                </button>
            </div>
            @if(request()->has('status') || request()->has('date'))
            <div>
                <a href="{{ route('logs.analyst') }}"
                class="text-sm text-red-400 hover:text-red-300 transition underline">
                    ❌ Reset
                </a>
            </div>
            @endif
        </form>

        {{-- SUCCESS MESSAGE --}}
        @if (session('success') === 'status-updated')
            <div x-data="{ show: true }" x-show="show"
                class="relative bg-green-800 text-white px-4 py-2 rounded text-sm flex items-center justify-between mt-4 mb-4">
                <span>🛡️ Resolved! This incident is no longer active.</span>
                <button type="button" @click="show = false" class="ml-4 text-white hover:text-gray-100 focus:outline-none">
                    <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                    </svg>
                </button>
            </div>
        @endif

        {{-- LOG TABLE --}}
        <div class="overflow-x-auto rounded border border-gray-700">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-800 text-gray-300 text-sm">
                    <tr>
                        <th class="px-4 py-2 text-left">STATUS</th>
                        <th class="px-4 py-2 text-left">IP ADDRESS</th>
                        <th class="px-4 py-2 text-left">COUNTRY</th>
                        <th class="px-4 py-2 text-left">CITY</th>
                        <th class="px-4 py-2 text-left">USERNAME</th>
                        <th class="px-4 py-2 text-right">ACTION</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700 text-white text-sm">
                    @forelse($logs as $log)
                    <tr class="hover:bg-gray-800/70 transition duration-150">
                        <td class="px-4 py-2 font-medium">
                            @if($log->status === 'success')
                                <span class="text-green-400">✅ Success</span>
                            @elseif($log->status === 'failed')
                                <span class="text-red-400">❌ Failed</span>
                            @else
                                <span class="text-yellow-400">{{ ucfirst($log->status) }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $log->ip_address }}</td>
                        <td class="px-4 py-2">{{ $log->country }}</td>
                        <td class="px-4 py-2">{{ $log->city }}</td>
                        <td class="px-4 py-2">{{ $log->username }}</td>
                        <td class="px-4 py-2 text-right">
                            <button @click="$dispatch('open-modal', 'log-detail-{{ $log->id }}')"
                                class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-indigo-600 hover:to-blue-600 text-white text-xs font-medium px-3 py-1 rounded shadow">
                                Detail
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-4 text-center text-gray-400">No logs available.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODALS --}}
    @foreach ($logs as $log)
    <x-modal name="log-detail-{{ $log->id }}" focusable>
        <div class="p-6">
            <h2 class="text-lg font-semibold text-blue-300 mb-4">🔍 Login Details</h2>
            <div class="space-y-2 text-sm text-gray-300">
                <p>
                    <span class="font-semibold text-white">STATUS:</span>
                    @if($log->status === 'success')
                        <span class="text-green-400">✅ Success</span>
                    @elseif($log->status === 'failed')
                        <span class="text-red-400">❌ Failed</span>
                    @else
                        <span class="text-yellow-400">{{ ucfirst($log->status) }}</span>
                    @endif
                </p>
                <p><span class="font-semibold text-white">IP ADDRESS:</span> {{ $log->ip_address }}</p>
                <p><span class="font-semibold text-white">COUNTRY:</span> {{ $log->country }}</p>
                <p><span class="font-semibold text-white">CITY:</span> {{ $log->city }}</p>
                <p><span class="font-semibold text-white">USERNAME:</span> {{ $log->username }}</p>

                @if (!empty($log->user_agent))
                    <p><span class="font-semibold text-white">USER AGENT:</span> {{ $log->user_agent }}</p>
                @endif

                @if (!empty($log->device))
                    <p><span class="font-semibold text-white">DEVICE:</span> {{ $log->device }}</p>
                @endif

                @if (!empty($log->platform))
                    <p><span class="font-semibold text-white">PLATFORM:</span> {{ $log->platform }}</p>
                @endif

                @if (!empty($log->browser))
                    <p><span class="font-semibold text-white">BROWSER:</span> {{ $log->browser }}</p>
                @endif

                @if (!empty($log->session_id))
                    <p><span class="font-semibold text-white">SESSION ID:</span> {{ $log->session_id }}</p>
                @endif

                <p><span class="font-semibold text-white">TIMESTAMP:</span> {{ $log->created_at->format('Y-m-d H:i:s') }}</p>
            </div>
        </div>
    </x-modal>
    @endforeach

    <div class="mt-6 text-sm text-gray-400">
        {{ $logs->withQueryString()->links() }}
    </div>
</main>
@endsection
