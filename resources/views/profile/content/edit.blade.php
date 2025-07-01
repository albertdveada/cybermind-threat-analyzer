<form action="{{ route('avatar.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="flex-shrink-0">
        <img src="{{ Auth::user()->avatars ? asset('storage/' . Auth::user()->avatars) : asset('storage/default.png') }}" alt="User Avatar" class="mx-auto w-24 h-24 rounded-full border-4 border-gray-700 shadow-md object-cover">
        <input type="file" name="avatars" id="avatars" class="hidden" onchange="this.form.submit()">
        <label for="avatars" class="mt-2 w-full bg-gray-600 hover:bg-gray-500 px-3 py-2 text-sm rounded text-white text-center cursor-pointer block">Update Avatars</label>
    </div>
</form>
