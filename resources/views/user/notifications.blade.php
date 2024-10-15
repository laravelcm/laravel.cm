<x-app-layout title="Notifications" :canonical="route('notifications')">
    <x-container class="py-12">
        <div>
            <x-user.breadcrumb section="Notifications" />

            <h2
                class="inline-flex items-center gap-x-2 font-heading text-xl font-bold leading-7 text-skin-inverted sm:truncate sm:text-2xl"
            >
                Notifications
                <livewire:notification-count />
            </h2>
        </div>

        <section class="relative mt-8">
            <livewire:notifications-page />
        </section>
    </x-container>
</x-app-layout>
