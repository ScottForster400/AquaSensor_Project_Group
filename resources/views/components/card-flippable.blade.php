{{-- //used https://www.youtube.com/watch?v=CC78NrgZkY8&t=505s for animated card --}}
<div {{$attributes->merge(['class' => 'h-full w-full basis-1/2 bg-transparent perspective group'])}}>
    <div class="relative bg-white preserve-3d rounded-md  w-full h-full shadow-md duration-300" id="flippable-card" onclick="flipCard(this)">
        {{$slot}}
    </div>
</div>
