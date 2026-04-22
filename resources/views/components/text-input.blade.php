@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-rose-100 focus:border-rose-500 focus:ring-rose-500 rounded-2xl shadow-sm bg-rose-50/30']) }}>
