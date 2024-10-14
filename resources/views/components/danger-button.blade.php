<button {{ $attributes->merge(['class' => 'button inline-flex items-center justify-center rounded-md border border-transparent px-4 py-2 bg-danger-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-danger-500 focus:outline-none focus:border-danger-700 sm:text-sm sm:leading-5 focus:ring-2 focus:ring-offset-2 focus:ring-offset-body focus:ring-danger-500']) }}>
    {{ $slot }}
</button>
