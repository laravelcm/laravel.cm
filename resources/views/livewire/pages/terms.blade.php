
<div class="prose relative mx-auto max-w-4xl px-4 py-10">
        <h1>{{ __('pages/terms.title') }}</h1>
        <p>
            <span class="text-xs font-medium uppercase text-skin-muted">{{ __('pages/terms.last_maj', ['date' => \Carbon\Carbon::create(2019,6,19)->toFormattedDateString()]) }}</span>
        </p>
        <p>
            {{ __('pages/terms.first_description') }}
        </p>
        <p>
            {{ __('pages/terms.second_description') }}
        </p>

        <h2>{{ __('pages/terms.intellectual_property_rights.title') }}</h2>
        <p>
            {{ __('pages/terms.intellectual_property_rights.first_paragraph') }}
        </p>
        <p>{{ __('pages/terms.intellectual_property_rights.second_paragraph') }}</p>

        <h2>{{ __('pages/terms.content.title') }}</h2>
        <p>
            {{ __('pages/terms.content.first_paragraph') }}
        </p>
        <p>
            {{ __('pages/terms.content.second_paragraph') }}
        </p>

        <h2>{{ __('pages/terms.limitations.title') }}</h2>
        <p>
            {{ __('pages/terms.limitations.first_paragraph') }}
        </p>
        <p>
            {{ __('pages/terms.limitations.second_paragraph') }}
        </p>

        <h2>{{ __('pages/terms.indemnities.title') }}</h2>
        <p>
            {{ __('pages/terms.indemnities.description') }}
        </p>

        <h2>{{ __('pages/terms.update_terms.title') }}</h2>
        <p>
            {{ __('pages/terms.update_terms.description') }}
        </p>

        <h2>{{ __('pages/terms.affectation.title') }}</h2>
        <p>
            {{ __('pages/terms.affectation.description') }}
        </p>

        <h2>{{ __('pages/terms.juridictions.title') }}</h2>
        <p>
            {{ __('pages/terms.juridictions.description') }}
        </p>

        <h2>{{ __('pages/terms.contact_us.title') }}</h2>
        <p>{{ __('pages/terms.contact_us.description') }}</p>
</div>

