@extends('layouts.app')
@section('content')
<div x-data="{ showOldPassword: false, showNewPassword: false, showConfirmPassword: false, showEmailInput: false }" class="max-w-4xl mx-auto bg-gray-800 rounded-xl shadow-xl p-8 space-y-6 text-white">

    <h2 class="text-2xl font-semibold border-b border-gray-600 pb-2">YOUR PROFILE DETAILS</h2>
    {{-- Profile Update Section --}}
    <div class="space-y-4">
        <h3 class="text-lg font-semibold border-b border-gray-600 pb-1">Update Account</h3>
        {{-- Notification Successfully! --}}
        @if (session('success') === 'avatars-updated')
            <div x-data="{ show: true }" x-show="show" x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-init="setTimeout(() => show = false, 4000)" class="relative bg-green-500 text-white px-4 py-2 rounded text-sm flex items-center justify-between mt-4">
                <span>Your profile has been Successfully Updated! 🎉</span>
                <button type="button" @click="show = false" class="ml-4 text-white hover:text-gray-100 focus:outline-none">
                    <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                    </svg>
                </button>
            </div>
        @endif
        <div class="flex flex-col md:flex-row items-center gap-6">
            @include('profile.content.edit')
            <div class="flex-grow space-y-4 w-full">
                <div>
                    <label for="current-email" class="block text-sm font-medium mb-1">Current Email Address</label>
                    <div class="flex flex-col md:flex-row items-stretch md:items-center gap-2">
                        <input type="email" id="current-email" class="bg-gray-700 text-gray-400 px-4 py-2 rounded w-full outline-none cursor-not-allowed" value="{{ Auth::user()->email }}" readonly disabled>
                        <button class="bg-blue-600 hover:bg-blue-500 px-3 py-2 text-sm rounded w-full md:w-auto md:min-w-[120px]">Verify Email</button>
                    </div>
                    <p class="text-xs text-yellow-400 mt-1">Your email is not verified.</p>
                </div>

                {{-- New Email Input (shown when changing email) --}}
                <div x-show="showEmailInput" class="space-y-2">
                    <label for="new-email" class="block text-sm font-medium mb-1">New Email Address</label>
                    <input name="email" type="email" id="new-email" class="bg-gray-700 text-white px-4 py-2 rounded w-full outline-none" placeholder="Enter new email address">
                </div>
                <button @click="showEmailInput = !showEmailInput" class="bg-gray-600 hover:bg-gray-500 px-4 py-2 rounded text-white text-sm">
                    <span x-text="showEmailInput ? 'Cancel Change Email' : 'Change Email Address'"></span>
                </button>
                <button class="bg-pink-600 hover:bg-pink-500 px-4 py-2 rounded text-white">Save Profile Changes</button>
            </div>
        </div>
    </div>
    @include('profile.content.password')
    {{-- Danger Zone: Disable Account Permanently --}}
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">DELET ACCOUNT</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Note: Deleting an account will erase all data associated with the current account and cannot be recovered!</p>
        </header>
        <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">Delete Account Now</x-danger-button>
        
        <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
            <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                @csrf
                @method('DELETE')
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Are you sure you want to delete your account?</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.</p>
                <div class="mt-6">
                    <x-input-label for="password" value="Current Password" class="sr-only" />
                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4" placeholder="Current Password"/>
                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>
                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                    <x-danger-button class="ms-3">Delete Account</x-danger-button>
                </div>
            </form>
        </x-modal>
    </section>
</div>
@endsection
