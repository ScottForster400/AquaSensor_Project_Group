<!-- Main modal -->
<div {{$attributes->merge(['id' => 'default-modal', 'tabindex' => '5', 'aria-hidden' => 'true', 'class' => 'hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full'])}}>
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            {{ $slot }}
        </div>
    </div>
</div>
