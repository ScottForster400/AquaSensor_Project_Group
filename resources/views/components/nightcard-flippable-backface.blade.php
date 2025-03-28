<x-card class=" bg-white absolute my-rotate-y-180 shadow-md w-full h-full backface-hidden !m-0 !my-0 !px-2 !py-1 hidden night-card">
    <div {{$attributes->merge(['class' => 'w-full h-full flex flex-col items-center justify-center text-center'])}}>
        {{$slot}}
    </div>
</x-card>
