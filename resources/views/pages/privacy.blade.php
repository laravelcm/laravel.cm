<x-app-layout :title="__('pages/privacy.title')">
    <x-layouts.policy-card>
        <div class="prose prose-primary text-gray-500 prose-headings:font-heading mx-auto dark:prose-invert dark:text-gray-400">
            <h1>{{ __('pages/privacy.title') }}</h1>
            <p>{{ __('pages/privacy.first_description') }}</p>
            <p>{{ __('pages/privacy.second_description') }}</p>

            <h2>{{ __('pages/privacy.use_share_information.title') }}</h2>
            <p>{{ __('pages/privacy.use_share_information.first_paragraph') }}</p>

            <h2>{{ __('pages/privacy.cookies.title') }}</h2>
            <p>{{ __('pages/privacy.cookies.first_paragraph') }}</p>
            <p>{{ __('pages/privacy.cookies.second_paragraph') }}</p>

            <h2>{{ __('pages/privacy.security.title') }}</h2>
            <p>{{ __('pages/privacy.security.first_paragraph') }}</p>

            <h2>{{ __('pages/privacy.create_account.title') }}</h2>
            <p>{{ __('pages/privacy.create_account.description') }}</p>

            <h2>{{ __('pages/privacy.content_to_others_website.title') }}</h2>
            <p>{{ __('pages/privacy.content_to_others_website.description') }}</p>

            <h2>{{ __('pages/privacy.updated.title') }}</h2>
            <p>{{ __('pages/privacy.updated.description') }}</p>

            <h2>{{ __('pages/privacy.contact.title') }}</h2>
            <p>{{ __('pages/privacy.contact.description') }}</p>
        </div>
    </x-layouts.policy-card>
</x-app-layout>
