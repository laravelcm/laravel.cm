<button {{ $attributes->merge(['class' => 'flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-body focus:ring-green-500']) }}>
    {{ $slot }}
</button>
