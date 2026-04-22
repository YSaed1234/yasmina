<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-rose-500 border border-transparent rounded-full font-bold text-sm text-white uppercase tracking-widest hover:bg-rose-600 focus:bg-rose-600 active:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg shadow-rose-200']) }}>
    {{ $slot }}
</button>
