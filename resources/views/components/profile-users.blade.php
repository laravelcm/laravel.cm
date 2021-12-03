<div class="flex justify-center -space-x-2 py-1 overflow-hidden">
    @foreach($users as $user)
        <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="{{ $user->profile_photo_url }}" alt="{{ $user->username }} avatar">
    @endforeach
</div>
