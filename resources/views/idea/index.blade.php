<x-app-layout>
    <x-slot name='ideasTotal'>
        {{ $ideasCount }}
    </x-slot>
    <form action="{{ request()->url() }}" method="GET" id="filterForm">
    <div class="filters flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-6">
        <div class="w-full md:w-2/3">
            <select name="category" id="category" class="w-full rounded-xl border-none px-4 py-2">
                <option value="">Select</option>
                @forelse ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ isset(request()->category) && request()->category == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @empty
                    
                @endforelse
            </select>
        </div>
        <div class="w-full md:w-2/3">
            <select name="other_filters" id="other_filters" class="w-full rounded-xl border-none px-4 py-2">
                <option value="">Select</option>
                <option value="popular"
                {{ isset(request()->other_filters) && request()->other_filters == 'popular' ? 'selected' : '' }}>Popular</option>
            </select>
        </div>
        <div class="w-full md:w-2/3 relative">
            <input type="search" placeholder="Find an idea" name="search" class="w-full rounded-xl bg-white border-none 
            placeholder-gray-900 px-4 py-2 pl-8" value="{{ request()->search }}">
            <div class="absolute top-0 flex itmes-center h-full ml-2">
                <svg class="w-4 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
        <div class="w-full md:w-1/2 relative">
            <button class="flex items-center justify-center w-1/2 h-8 text-xs 
            bg-purple text-white font-semibold rounded-xl border border-purple 
            hover:bg-blue-hover transition duration-150 ease-in px-6 py-3 my-1"
            type="submit">Filter</button>
        </div>
    </div> <!-- end filters -->
    </form>

    <div class="ideas-container space-y-6 my-8">
        
        @foreach ($ideas as $idea)
            <livewire:idea-index
                :idea="$idea"
                :votesCount="$idea->votes_count"
                :commentsCount="$idea->comments_count"
            />
        @endforeach
    </div> <!-- end ideas-container -->

    <div class="my-8">
        {{ $ideas->appends(request()->all())->links() }}
    </div>
</x-app-layout>
