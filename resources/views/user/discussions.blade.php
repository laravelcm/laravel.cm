<x-app-layout
    :title="'Discussions ~ ' . $user->username . ' ('. $user->name .')'"
    :canonical="route('discussions.me')"
>
    <x-container class="py-12">
        <div>
            <x-status-message class="mb-5" />

            <x-user.breadcrumb section="Discussions" />

            <h2 class="font-heading text-xl font-bold leading-7 text-gray-900 sm:truncate sm:text-2xl">
                Discussions
            </h2>
        </div>

        <section class="relative mt-8 lg:grid lg:grid-cols-12 lg:gap-12">
            <div class="hidden lg:col-span-3 lg:block">
                <x-user.sidebar :user="$user" />
            </div>
            <main class="lg:col-span-9">
                <x-user.page-heading
                    title="Vos discussions"
                    :url="route('discussions.new')"
                    button="Nouvelle discussion"
                />

                <div class="mt-5">
                    @forelse ($discussions as $discussion)
                        <x-discussions.summary :discussion="$discussion" />
                    @empty
                        <p class="text-base text-gray-500 dark:text-gray-400">Vous n'avez pas encore créé de discussions.</p>
                    @endforelse

                    <div class="pt-5">
                        {{ $discussions->links() }}
                    </div>
                </div>
            </main>
        </section>
    </x-container>
</x-app-layout>
