<label class="inline-flex justify-between items-center me-2 cursor-pointer w-full">
    <span class=" text-xs font-medium text-gray-900 dark:text-gray-300">{{$slot}}</span>
    <input type="checkbox" value=""  name="" {{$attributes->merge(['name'=>'', 'class' => 'sr-only peer','id' => ''])}}>
    <div class="relative w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 dark:peer-focus:ring-purple-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-purple-600 peer-checked:bg-purple-600 dark:peer-checked:bg-purple-600"></div>
</label>
