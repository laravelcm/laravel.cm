@props([
    'user',
])

<dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
    <div class="overflow-hidden rounded-xl bg-skin-card-gray px-4 py-5 ring-1 ring-inset ring-gray-900/10 sm:p-6">
        <dt class="truncate text-sm font-medium text-gray-500 dark:text-gray-400">Total Articles/Discussions</dt>
        <dd class="mt-1 text-3xl font-semibold text-gray-900">
            {{ number_format($user->articles_count + $user->discussions_count) }}
        </dd>
    </div>

    <div class="overflow-hidden rounded-xl bg-skin-card-gray px-4 py-5 ring-1 ring-inset ring-gray-900/10 sm:p-6">
        <dt class="truncate text-sm font-medium text-gray-500 dark:text-gray-400">Total Réponses</dt>
        <dd class="mt-1 text-3xl font-semibold text-gray-900">
            {{ number_format($user->replies_count) }}
        </dd>
    </div>

    <div class="overflow-hidden rounded-xl bg-skin-card-gray px-4 py-5 ring-1 ring-inset ring-gray-900/10 sm:p-6">
        <dt class="truncate text-sm font-medium text-gray-500 dark:text-gray-400">Sujets Résolus</dt>
        <dd class="mt-1 text-3xl font-semibold text-gray-900">
            {{ number_format($user->solutions_count) }}
        </dd>
    </div>

    <div class="overflow-hidden rounded-xl bg-skin-card-gray px-4 py-5 ring-1 ring-inset ring-gray-900/10 sm:p-6">
        <dt class="truncate text-sm font-medium text-gray-500 dark:text-gray-400">Total Experience</dt>
        <dd class="mt-1 text-3xl font-semibold text-gray-900">0</dd>
    </div>
</dl>
