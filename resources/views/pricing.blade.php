@extends('layouts.app')
@section('content')
<div class="bg-gray-900 text-gray-200 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-extrabold text-white">What’s Our Pricing Subscription</h2>
            <p class="mt-4 text-lg text-gray-400">Choose the plan that best suits your needs with us.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-gray-800 rounded-2xl shadow-lg p-8 flex flex-col ring-2 ring-blue-400 transform hover:scale-105 transition-transform duration-300">
                <div class="flex-grow">
                    <h3 class="text-2xl font-semibold text-center text-white">Bronze Plan</h3>
                    <div class="text-center my-6">
                        <span class="text-gray-400">USD</span>
                        <span class="text-5xl font-bold text-blue-400">$12</span>
                        <span class="text-lg text-gray-400">.99</span>
                        <p class="text-sm text-gray-500 mt-2">for 7 days</p>
                    </div>
                    <div class="text-center mb-8">
                        <p class="text-gray-400"><span class="font-semibold text-green-400">●</span> 30.000 API requests</p>
                    </div>
                    <ul class="space-y-4">
                        <li class="flex items-center">
                            <span class="text-green-400 mr-3">✔</span>
                            <span class="text-gray-300">Analyst Login</span>
                        </li>
                        <li class="flex items-center">
                            <span class="text-green-400 mr-3">✔</span>
                            <span class="text-gray-300">Security Analyst </span>
                        </li>
                    </ul>
                </div>
                <div class="mt-8">
                    <button class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                        Purchase Plan
                    </button>
                </div>
            </div>
            <div class="bg-gray-800 rounded-2xl shadow-lg p-8 flex flex-col ring-2 ring-yellow-400 transform hover:scale-105 transition-transform duration-300">
                <div class="flex-grow">
                    <h3 class="text-2xl font-semibold text-center text-white">Silver Plan</h3>
                    <div class="text-center my-6">
                        <span class="text-gray-400">USD</span>
                        <span class="text-5xl font-bold text-yellow-400">$18</span>
                        <span class="text-lg text-gray-400">.99</span>
                        <p class="text-sm text-gray-500 mt-2">for 15 days</p>
                    </div>
                    <div class="text-center mb-8">
                        <p class="text-gray-400"><span class="font-semibold text-green-400">●</span> 65.000 API requests</p>
                    </div>
                    <ul class="space-y-4">
                        <li class="flex items-center">
                            <span class="text-green-400 mr-3">✔</span>
                            <span class="text-gray-300">Analyst Login</span>
                        </li>
                        <li class="flex items-center">
                            <span class="text-green-400 mr-3">✔</span>
                            <span class="text-gray-300">Security Analyst </span>
                        </li>
                    </ul>
                </div>
                <div class="mt-8">
                    <button class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                        Purchase Plan
                    </button>
                </div>
            </div>
            <div class="bg-gray-800 rounded-2xl shadow-lg p-8 flex flex-col ring-2 ring-green-400 transform hover:scale-105 transition-transform duration-300">
                <div class="flex-grow">
                    <h3 class="text-2xl font-semibold text-center text-white">Gold Plan</h3>
                    <div class="text-center my-6">
                        <span class="text-gray-400">USD</span>
                        <span class="text-5xl font-bold text-green-400">$24</span>
                        <span class="text-lg text-gray-400">.99</span>
                        <p class="text-sm text-gray-500 mt-2">for 30 days</p>
                    </div>
                    <div class="text-center mb-8">
                        <p class="text-gray-400"><span class="font-semibold text-green-400">●</span> 130.000 API requests</p>
                    </div>
                    <ul class="space-y-4">
                        <li class="flex items-center">
                            <span class="text-green-400 mr-3">✔</span>
                            <span class="text-gray-300">Analyst Login</span>
                        </li>
                        <li class="flex items-center">
                            <span class="text-green-400 mr-3">✔</span>
                            <span class="text-gray-300">Security Analyst </span>
                        </li>
                        <li class="flex items-center">
                            <span class="text-green-400 mr-3">✔</span>
                            <span class="text-gray-300">24/7 Contact Support</span>
                        </li>
                    </ul>
                </div>
                <div class="mt-8">
                    <button class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                        Purchase Plan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
