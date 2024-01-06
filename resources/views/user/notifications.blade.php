<x-app-layout title="Notifications" :canonical="route('notifications')">

    <x-container class="py-12">
        <div>
            <x-user.breadcrumb section="Notifications" />

            <h2 class="inline-flex items-center gap-x-2 text-xl font-bold leading-7 text-skin-inverted sm:text-2xl sm:truncate font-heading">
                Notifications <livewire:notification-count />
            </h2>
        </div>

        <section class="mt-8 relative">
            <livewire:notifications-page />
        </section>
    </x-container>

</x-app-layout>
