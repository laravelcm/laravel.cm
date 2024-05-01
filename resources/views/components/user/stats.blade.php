@props([
    'user',
])

<dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
    <div class="overflow-hidden rounded-xl bg-skin-card-gray px-4 py-5 ring-1 ring-inset ring-gray-900/10 sm:p-6">
        <dt class="truncate text-sm font-medium text-skin-base">Total Articles/Discussions</dt>
        <dd class="mt-1 text-3xl font-semibold text-skin-inverted">
            {{ number_format($user->articles_count + $user->discussions_count) }}
        </dd>
    </div>

    <div class="overflow-hidden rounded-xl bg-skin-card-gray px-4 py-5 ring-1 ring-inset ring-gray-900/10 sm:p-6">
        <dt class="truncate text-sm font-medium text-skin-base">Total Réponses</dt>
        <dd class="mt-1 text-3xl font-semibold text-skin-inverted">
            {{ number_format($user->replies_count) }}
        </dd>
    </div>

    <div class="overflow-hidden rounded-xl bg-skin-card-gray px-4 py-5 ring-1 ring-inset ring-gray-900/10 sm:p-6">
        <dt class="truncate text-sm font-medium text-skin-base">Sujets Résolus</dt>
        <dd class="mt-1 text-3xl font-semibold text-skin-inverted">
            {{ number_format($user->solutions_count) }}
        </dd>
    </div>

    <div class="overflow-hidden rounded-xl bg-skin-card-gray px-4 py-5 ring-1 ring-inset ring-gray-900/10 sm:p-6">
        <dt class="truncate text-sm font-medium text-skin-base">Total Experience</dt>
        <dd class="mt-1 text-3xl font-semibold text-skin-inverted">0</dd>
    </div>
</dl>
