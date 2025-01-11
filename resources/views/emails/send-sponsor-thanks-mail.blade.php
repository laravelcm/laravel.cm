<x-mail::message>

    <x-mail::panel>

        {!! __('emails/sponsor.greeting', ['name' => $name]) !!}

        {!! __('emails/sponsor.thanks') !!}

        {!! __('emails/sponsor.impact') !!}

    </x-mail::panel>
    <p>
        {!! __('emails/sponsor.closing') !!} <br>
        {!! __('emails/sponsor.team') !!}
    </p>
</x-mail::message>
