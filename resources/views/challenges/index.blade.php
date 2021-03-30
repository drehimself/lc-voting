<x-app-layout :categories='$categories' class="md:w-screen" smallClass="w-70">
    <x-slot name='ideasTotal'>
        {{ $challengesCount }}
    </x-slot>
    <form action="{{ request()->url() }}" method="GET" id="filterForm">
    <div class="filters flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-6">
        <div class="w-full md:w-2/3">
            <select name="category" id="category" class="w-full rounded-xl border-none px-4 py-2">
                <option value="">Select Category</option>
                @forelse ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ isSelected('category',$category->id) }}>{{ $category->name }}</option>
                @empty
                    
                @endforelse
            </select>
        </div>
        <div class="w-full md:w-2/3">
            <select name="source" id="source" class="w-full rounded-xl border-none px-4 py-2">
                <option value="">Select Source</option>
                <option value="user" {{ isSelected('source','user') }}>User</option>
                <option value="admin" {{ isSelected('source','admin') }}>Admin</option>
                <option value="brand" {{ isSelected('source','brand') }}>Brands</option>
            </select>
        </div>
        
        <div class="w-full md:w-5/6 relative">
            <input type="search" placeholder="Find a Challenge" name="search" class="w-full rounded-xl bg-white border-none 
            placeholder-gray-900 px-4 py-2 pl-8" value="{{ request()->search }}">
            <div class="absolute top-0 flex itmes-center h-full ml-2">
                <svg class="w-4 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
        <div class="w-full md:w-2/3">
            <select name="other_filters" id="other_filters" class="w-full rounded-xl border-none px-4 py-2">
                <option value="">Select Sort</option>
                <option value="popular"
                {{ isSelected('other_filters','popular') }}>Popular</option>
            </select>
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
        <x-alerts></x-alerts>
        @forelse ($challenges as $challenge)
            <livewire:challenges.challenge-index
                :challenge="$challenge"
                :votesCount="$challenge->votes_count"
                :commentsCount="$challenge->comments_count"
            />
        @empty
        <h3 class="text-center text-xl font-semibold">
            No Challenge's found.
        </h3>
        @endforelse
    </div> <!-- end ideas-container -->

    <div class="my-8">
        {{ $challenges->appends(request()->all())->links() }}
    </div>
</x-app-layout>
