@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center px-4 py-2.5 text-sm font-medium text-blue-600 bg-blue-100 rounded-md group'
            : 'flex items-center px-4 py-2.5 text-sm font-medium text-gray-500 rounded-md hover:bg-gray-50 group';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
