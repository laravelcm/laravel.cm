@props(['user'])

<dl class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-5 lg:grid-cols-4">
    <div class="px-4 py-5 bg-skin-card-gray shadow rounded-lg overflow-hidden sm:p-6">
        <dt class="text-sm font-medium text-skin-base truncate font-sans">
            Total Articles/Discussions
        </dt>
        <dd class="mt-1 text-3xl font-semibold text-skin-inverted">
            {{ number_format($user->countArticles() + $user->countDiscussions()) }}
        </dd>
    </div>

    <div class="px-4 py-5 bg-skin-card-gray shadow rounded-lg overflow-hidden sm:p-6">
        <dt class="text-sm font-medium text-skin-base truncate font-sans">
            Total Réponses
        </dt>
        <dd class="mt-1 text-3xl font-semibold text-skin-inverted">
            {{ number_format($user->countReplies()) }}
        </dd>
    </div>

    <div class="px-4 py-5 bg-skin-card-gray shadow rounded-lg overflow-hidden sm:p-6">
        <dt class="text-sm font-medium text-skin-base truncate font-sans">
            Sujets Résolus
        </dt>
        <dd class="mt-1 text-3xl font-semibold text-skin-inverted">
            {{ number_format($user->countSolutions()) }}
        </dd>
    </div>

    <div class="px-4 py-5 bg-skin-card-gray shadow rounded-lg overflow-hidden sm:p-6">
        <dt class="text-sm font-medium text-skin-base truncate font-sans">
            Total Experience
        </dt>
        <dd class="mt-1 text-3xl font-semibold text-skin-inverted">
            0
        </dd>
    </div>
</dl>
