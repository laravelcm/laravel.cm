<div class="flex justify-center -space-x-2 overflow-hidden py-1">
    @foreach ($users as $user)
        <img
            class="inline-block size-8 rounded-full ring-2 ring-white"
            src="{{ $user->profile_photo_url }}"
            alt="{{ $user->username }} avatar"
        />
    @endforeach
</div>
