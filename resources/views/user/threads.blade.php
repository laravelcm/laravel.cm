<x-app-layout :title="'Sujets ~ ' . $user->username . ' (' . $user->name . ')'" :canonical="route('threads.me')">
    <x-container class="py-12">
        <div>
            <x-status-message class="mb-5" />

            <x-user.breadcrumb section="{{ __('pages/forum.subject') }}" />

            <h2 class="font-heading text-xl font-bold leading-7 text-gray-900 sm:truncate sm:text-2xl">{{ __('pages/forum.subject') }}</h2>
        </div>

        <section class="relative mt-8 lg:grid lg:grid-cols-12 lg:gap-12">
            <div class="hidden lg:col-span-3 lg:block">
                <x-user.sidebar :user="$user" />
            </div>
            <main class="lg:col-span-9">
                <x-user.page-heading title="{{ __('pages/forum.your_thread') }}" url="#"
                                     :button="{{ __('pages/forum.new_thread') }}" />

                <div class="flex items-center space-x-3">
                    @forelse ($threads as $thread)
                        <x-forum.thread :thread="$thread" />
                    @empty
                        <p class="text-base text-gray-500 dark:text-gray-400">{{ __('pages/forum.not_thread_created') }}</p>
                    @endforelse

                    <div class="pt-5">
                        {{ $threads->links() }}
                    </div>
                </div>
            </main>
        </section>
    </x-container>
</x-app-layout>
