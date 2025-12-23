<x-app-layout :title="__('pages/rules.title')">
    <x-layouts.policy-card>
        <div class="prose prose-emerald text-gray-500 prose-headings:font-heading mx-auto dark:prose-invert dark:text-gray-400">
            <h1>{{ __('pages/rules.title') }}</h1>
            <p>{{ __('pages/rules.description') }}</p>

            <h2>{{ __('pages/rules.our_commitment.title') }}</h2>
            <p>{{ __('pages/rules.our_commitment.paragraph') }}</p>

            <h2>{{ __('pages/rules.standards.title') }}</h2>
            <p>{{ __('pages/rules.standards.paragraph_one') }}</p>

            <ul>
                <li>{{ __('pages/rules.standards.item_one') }}</li>
                <li>{{ __('pages/rules.standards.item_two') }} </li>
                <li>{{ __('pages/rules.standards.item_three') }}</li>
                <li>{{ __('pages/rules.standards.item_four') }} </li>
                <li>{{ __('pages/rules.standards.item_five') }}</li>
            </ul>

            <p>{{ __('pages/rules.standards.paragraph_two') }}</p>

            <ul>
                <li>{{ __('pages/rules.standards.item_six') }}</li>
                <li>{{ __('pages/rules.standards.item_seven') }}</li>
                <li>{{ __('pages/rules.standards.item_seven') }}</li>
                <li>{{ __('pages/rules.standards.item_eight') }}</li>
                <li>{{ __('pages/rules.standards.item_nine') }}</li>
            </ul>

            <h2>{{ __('pages/rules.responsibilities.title') }}</h2>
            <p>{{ __('pages/rules.responsibilities.first_paragraph') }}</p>
            <p>{{ __('pages/rules.responsibilities.second_paragraph') }}</p>

            <h2>{{ __('pages/rules.implementation.title') }}</h2>
            <p>
                {{ __('pages/rules.implementation.first_paragraph_one') }}
                <a href="mailto:arthur@laravel.cm">{{ __('pages/rules.implementation.mail') }}</a>
                . {{ __('pages/rules.implementation.first_paragraph_two') }}
            </p>
            <p>{{ __('pages/rules.implementation.second_paragraph') }}</p>

            <h2>{{ __('pages/rules.attribution.title') }}</h2>
            <p>
                {{ __('pages/rules.attribution.description') }}
                <a href="https://www.contributor-covenant.org/version/1/4/code-of-conduct">
                     {{ __('pages/rules.attribution.link') }}
                </a>
                {{ __('pages/rules.attribution.version') }}
            </p>
        </div>
    </x-layouts.policy-card>
</x-app-layout>
