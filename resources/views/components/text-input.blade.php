@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-[var(--yasmina-bg-soft)] focus:border-[var(--yasmina-primary)] focus:ring-[var(--yasmina-primary)] rounded-2xl shadow-sm bg-[var(--yasmina-bg-soft)]/50']) }}>
