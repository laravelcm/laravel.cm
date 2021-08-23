<button {{ $attributes->merge(['class' => 'inline-flex justify-center py-2 px-4 border border-skin-light rounded-md shadow-sm bg-skin-button text-sm text-skin-base hover:bg-skin-button-hover']) }}>
    {{ $slot }}
</button>
