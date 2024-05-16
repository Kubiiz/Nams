<button {{ $attributes->merge(['type' => 'button', 'class' => ' inline-flex items-center justify-center rounded-md border text-sm bg-gray-200 border-gray-300 text-gray-500 shadow-sm hover:opacity-90 px-3 h-8 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
