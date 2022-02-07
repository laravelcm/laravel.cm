<button {{ $attributes->merge(['class' => 'inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-negative-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-negative-500 focus:outline-none focus:border-negative-700 sm:text-sm sm:leading-5 focus:ring-2 focus:ring-offset-2 focus:ring-offset-body focus:ring-negative-500']) }}>
    {{ $slot }}
</button>
