{{-- Change Password Section --}}
<form method="POST" action="{{ route('password.update') }}" class="space-y-4" x-data="{ showOldPassword: false, showNewPassword: false, showConfirmPassword: false }">
    @csrf
    @method('PUT')
    <h3 class="text-lg font-semibold border-b border-gray-600 pb-1">Change Password</h3>
    {{-- Notification Successfully! --}}
    @if (session('status') === 'password-updated')
        <div x-data="{ show: true }" x-show="show" x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-init="setTimeout(() => show = false, 5000)" class="relative bg-green-500 text-white px-4 py-2 rounded text-sm flex items-center justify-between">
            <span>Your password has been Successfully Updated!🎉</span>
            <button type="button" @click="show = false" class="ml-4 text-white hover:text-gray-100 focus:outline-none">
                <svg class="h-4 w-4 fill-current" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </button>
        </div>
    @endif

    <div>
        <label for="old-password" class="block text-sm font-medium mb-1">Current Password</label>
        <div class="flex items-center gap-2">
            <input name="current_password" :type="showOldPassword ? 'text' : 'password'" id="old-password" class="bg-gray-700 text-white px-4 py-2 rounded w-full outline-none @error('current_password', 'updatePassword') border border-red-500 @enderror">
            <button type="button" @click="showOldPassword = !showOldPassword" class="bg-gray-600 hover:bg-gray-500 px-3 py-2 text-sm rounded">
                <span x-text="showOldPassword ? 'Hide' : 'Show'"></span>
            </button>
        </div>
        {{-- Validation Error Notification for Current Password --}}
        @error('current_password', 'updatePassword')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label for="new-password" class="block text-sm font-medium mb-1">New Password</label>
        <div class="flex items-center gap-2">
            <input name="password" :type="showNewPassword ? 'text' : 'password'" id="new-password" class="bg-gray-700 text-white px-4 py-2 rounded w-full outline-none @error('password', 'updatePassword') border border-red-500 @enderror">
            <button type="button" @click="showNewPassword = !showNewPassword" class="bg-gray-600 hover:bg-gray-500 px-3 py-2 text-sm rounded">
                <span x-text="showNewPassword ? 'Hide' : 'Show'"></span>
            </button>
        </div>
        {{-- Validation Error Notification for New Password --}}
        @error('password', 'updatePassword')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label for="confirm-password" class="block text-sm font-medium mb-1">Confirm Password</label>
        <div class="flex items-center gap-2">
            <input name="password_confirmation" :type="showConfirmPassword ? 'text' : 'password'" id="confirm-password" class="bg-gray-700 text-white px-4 py-2 rounded w-full outline-none @error('password_confirmation', 'updatePassword') border border-red-500 @enderror">
            <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="bg-gray-600 hover:bg-gray-500 px-3 py-2 text-sm rounded">
                <span x-text="showConfirmPassword ? 'Hide' : 'Show'"></span>
            </button>
        </div>
        {{-- Validation Error Notification Confirm Password --}}
        @error('password_confirmation', 'updatePassword')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
    <button type="submit" class="bg-pink-600 hover:bg-pink-500 px-4 py-2 rounded text-white">Change Password</button>
</form>