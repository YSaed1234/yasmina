<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-8 py-4 bg-[var(--yasmina-primary)] border border-transparent rounded-2xl font-bold text-sm text-white uppercase tracking-widest hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-[var(--yasmina-primary)] focus:ring-offset-2 transition ease-in-out duration-150 shadow-xl shadow-[var(--yasmina-secondary)]/20']) }}>
    {{ $slot }}
</button>
