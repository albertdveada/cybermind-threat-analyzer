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
                🎯 Completed Security Incidents (AI-Analyzed)
            </h2>
            <span class="text-sm text-gray-400">All resolved incidents verified by AI</span>
        </div>

        {{-- FILTER FORM --}}
        <form method="GET" action="{{ route('resolved.incidents') }}" class="mb-6 flex flex-wrap gap-4 items-end">
            <div>
                <label for="date" class="block text-sm text-gray-300 mb-1">Date</label>
                <input type="date" name="date" id="date" value="{{ request('date') }}"
                    class="bg-gray-800 text-white px-4 py-2 rounded-md border border-gray-600">
            </div>
            <div>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm shadow transition">
                    🎯 Apply Filter
                </button>
            </div>
            @if(request()->has('status') || request()->has('date'))
            <div>
                <a href="{{ route('resolved.incidents') }}"
                   class="text-sm text-red-400 hover:text-red-300 transition underline">
                    ♻️ Clear Filters
                </a>
            </div>
            @endif
        </form>

        {{-- LOG TABLE --}}
        <div class="overflow-x-auto rounded border border-gray-700">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-800 text-gray-300 text-sm">
                    <tr>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Type</th>
                        <th class="px-4 py-2 text-left">Source IP</th>
                        <th class="px-4 py-2 text-left">Country</th>
                        <th class="px-4 py-2 text-left">City</th>
                        <th class="px-4 py-2 text-left">Level</th>
                        <th class="px-4 py-2 text-left">AI Message</th>
                        <th class="px-4 py-2 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700 text-white text-sm">
                    @forelse($logs as $log)
                    <tr class="hover:bg-gray-800/70 transition duration-150">
                        <td class="px-4 py-2 font-medium text-green-400">
                            {{ ucfirst($log->status) }}
                        </td>
                        <td class="px-4 py-2">{{ $log->type }}</td>
                        <td class="px-4 py-2">{{ $log->source_ip }}</td>
                        <td class="px-4 py-2">{{ $log->country }}</td>
                        <td class="px-4 py-2">{{ $log->city }}</td>
                        <td class="px-4 py-2 capitalize">{{ $log->security_level }}</td>
                        <td class="px-4 py-2 truncate max-w-xs text-gray-300" title="{{ $log->log_message }}">
                            {{ Str::limit($log->log_message, 80) }}
                        </td>
                        <td class="px-4 py-2 text-right">
                            <button @click="$dispatch('open-modal', 'log-detail-{{ $log->id }}')"
                                class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-indigo-600 hover:to-blue-600 text-white text-xs font-medium px-3 py-1 rounded shadow">
                                Detail
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-4 text-center text-gray-400">✅ All security threats are resolved and no incidents remain.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modals --}}
    @foreach ($logs as $log)
    <x-modal name="log-detail-{{ $log->id }}" focusable>
        <div class="p-6">
            <h2 class="text-lg font-semibold text-blue-300 mb-4">🔍 AI Log Analysis</h2>
            <div class="space-y-2 text-sm text-gray-300">
                <p><span class="font-semibold text-white">Status:</span> {{ ucfirst($log->status) }}</p>
                <p><span class="font-semibold text-white">Type:</span> {{ $log->type }}</p>
                <p><span class="font-semibold text-white">Source IP:</span> {{ $log->source_ip }}</p>
                <p><span class="font-semibold text-white">Country:</span> {{ $log->country }}</p>
                <p><span class="font-semibold text-white">City:</span> {{ $log->city }}</p>
                <p><span class="font-semibold text-white">Security Level:</span> {{ ucfirst($log->security_level) }}</p>
                <p class="font-semibold text-white">AI Message Insight:</p>
                <div class="p-3 border border-blue-600 bg-blue-900 text-blue-100 rounded">
                    {{ $log->log_message }}
                </div>
                <p><span class="font-semibold text-white">Timestamp:</span> {{ $log->created_at->format('Y-m-d H:i:s') }}</p>
            </div>

            <div class="mt-6 text-green-400">✅ This incident has been successfully resolved.</div>
            <div class="flex justify-end mt-4">
                <x-secondary-button x-on:click="$dispatch('close')">Close</x-secondary-button>
            </div>
        </div>
    </x-modal>
    @endforeach

    <div class="mt-6 text-sm text-gray-400">
        {{ $logs->withQueryString()->links() }}
    </div>
</main>
@endsection
