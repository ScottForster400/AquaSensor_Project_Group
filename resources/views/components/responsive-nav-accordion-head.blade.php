@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex flex-row items-center w-full h-full ps-3 pe-4 py-5 border-l-4 border-indigo-400 dark:border-indigo-600 text-start text-base font-medium text-indigo-700 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/50 focus:outline-none focus:text-indigo-800 dark:focus:text-indigo-200 focus:bg-indigo-100 dark:focus:bg-indigo-900 focus:border-indigo-700 dark:focus:border-indigo-300 transition duration-150 ease-in-out'
            : 'flex flex-row items-center w-full h-full ps-3 pe-4 py-5 border-l-4 border-transparent text-start text-base font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 focus:outline-none focus:text-gray-800 dark:focus:text-gray-200 focus:bg-gray-50 dark:focus:bg-gray-700 focus:border-gray-300 dark:focus:border-gray-600 transition duration-150 ease-in-out';
@endphp

{{-- <a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a> --}}
<div id="accordion-collapse" data-accordion="collapse">
    <h2 id="accordion-collapse-heading-2">
        <button {{ $attributes->merge(['class' => $classes, 'type' => 'button', 'data-accordion-target' => '#accordion-collapse-body-2', 'aria-expanded' => 'false', 'aria-controls' => 'accordion-collapse-body-2']) }}>
        <span>{{$slot}}</span>
        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0 ml-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
        </svg>
        </button>
    </h2>
