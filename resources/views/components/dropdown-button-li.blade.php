<li>
    <div {{ $attributes->merge([ 'class' => 'flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600'])}}>
        {{$slot}}
    </div>
  </li>
