<div {{$attributes->merge(['id' => 'accordion-flush-body-1', 'class' => 'hidden', 'aria-labelledby' => 'accordion-flush-heading-1'])}}>
    <div class="py-2 border-b border-gray-200 dark:border-gray-700">
        {{$slot}}
    </div>
  </div>
