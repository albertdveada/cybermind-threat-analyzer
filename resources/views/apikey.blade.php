@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto bg-gray-800 rounded-xl shadow-xl p-8 space-y-6">
    <h2 class="text-2xl font-semibold border-b border-gray-600 pb-2">Account / Apikey</h2>
    @if (session('success') === 'api-updated')
        <div x-data="{ show: true }" x-show="show" x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-init="setTimeout(() => show = false, 4000)" class="relative bg-green-500 text-white px-4 py-2 rounded text-sm flex items-center justify-between mt-4">
            <span>Your API Key has been successfully updated! 🎉</span>
            <button type="button" @click="show = false" class="ml-4 text-white hover:text-gray-100 focus:outline-none">
                <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <title>Close</title>
                    <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                </svg>
            </button>
        </div>
    @endif
    <div class="bg-red-500 text-white p-4 rounded-md">
        <strong>⚠️ Caution!</strong> Please ensure that your API key remains confidential and is not shared or made public.
    </div>
    <div class="space-y-2">
        <label class="text-sm font-medium">Your API Key</label>
        <div class="flex items-center gap-2">
            <input :type="showKey ? 'text' : 'password'" class="bg-gray-700 text-white px-4 py-2 rounded w-full outline-none" readonly value="{{ Auth::user()->public_key }}">
            <button @click="showKey = !showKey" class="bg-gray-600 hover:bg-gray-500 px-3 py-2 text-sm rounded">
                <span x-text="showKey ? 'Hide' : 'Show'"></span>
            </button>
        </div>
        <form action="{{ route('regenerate.key') }}" method="POST">
            @csrf
            <button type="submit" class="bg-pink-600 hover:bg-pink-500 px-4 py-2 rounded text-white">🔁 Change API Key</button>
        </form>
    </div>
    <div class="space-y-4">
        <h3 class="text-lg font-semibold border-b border-gray-600 pb-1">URL API</h3>
        <div class="flex gap-2">
            <span class="px-3 py-1 bg-blue-600 rounded text-sm">API Endpoint</span>
        </div>
        <div class="space-y-3">
            <div class="bg-gray-700 rounded-md p-3">
                <div class="flex justify-between items-center text-sm">
                    <span class="font-semibold">Analyst Login 🔗</span>
                    <span class="text-green-400">Status: {{ (Auth::user()->status) }}</span>
                </div>
                <p class="text-xs break-all mt-1">
                    {{ url('/analyze-logins?public_key=' . Auth::user()->public_key) }}
                </p>
            </div>
            <div class="bg-gray-700 rounded-md p-3">
                <div class="flex justify-between items-center text-sm">
                    <span class="font-semibold">Security Analyst 🔗</span>
                    <span class="text-green-400">Status: {{ (Auth::user()->status) }}</span>
                </div>
                <p class="text-xs break-all mt-1">
                    {{ url('/log-analysis?public_key=' . Auth::user()->public_key) }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
