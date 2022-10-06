@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex font-bold items-center px-1 pt-1 border-b-8 border-indigo-400 text-lg font-medium leading-5 text-emerald-500 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'inline-flex font-bold items-center px-1 pt-1 border-b-8 border-transparent text-lg font-medium leading-5 text-emerald-700 hover:text-emerald-900 hover:font-bold hover:border-green-600 ocus:outline-none focus:text-green-600 focus:border-green-600 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
