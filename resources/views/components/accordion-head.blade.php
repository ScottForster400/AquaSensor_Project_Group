{{-- @props(['title']) --}}


    <h2 id="accordion-flush-heading-1">
      <button {{ $attributes->merge([ 'type'=>'button', 'class' => 'flex items-center justify-between w-full py-2 font-medium rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 gap-3', 'data-accordion-target' => '#accordion-flush-body-1', 'aria-expanded' => 'false', 'aria-controls' => 'accordion-flush-body-1'])}}>
        <span class="text-sm text-grey-">{{$title}}</span>
        <svg data-accordion-icon class=" rotate-180 shrink-0 mr-3" style="width: .7rem; height: .7rem;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
        </svg>
      </button>
    </h2>
    {{$slot}}

