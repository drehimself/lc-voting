@props([
    'fun' => 'loadMore'
])
<div class="flex flex-col md:flex-row items-center md:space-x-3 mt-3">
    <a wire:loading.remove
        href="javascript:;"
        wire:click="{{ $fun }}()"
        class="flex items-center justify-center h-11 w-full md:w-1/2 text-sm bg-green 
        text-white font-semibold rounded-xl border border-blue hover:bg-blue-hover 
        transition duration-150 ease-in px-6 py-3">
        Load More
    </a>
</div>