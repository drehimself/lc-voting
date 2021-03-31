<x-app-layout :categories='$categories' class="md:w-screen" smallClass="w-70">
    <x-slot name='ideasTotal'>
        {{ $ideasCount }}
    </x-slot>
    

    <div class="ideas-container space-y-6 my-8">
        <x-alerts></x-alerts>
        <form action="{{ request()->url() }}" method="GET" id="filterForm">
            <div class="filters flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-6">
                <div class="w-full md:w-1/3">
                    <select name="filter" id="filter" class="w-full rounded-xl border-none px-4 py-2"
                    onchange="document.getElementById('filterForm').submit()">
                        <option value="idea" {{ isSelected('filter','idea') }}>Idea</option>
                        <option value="challenge" {{ isSelected('filter','challenge') }}>challenge</option>
                    </select>
                </div>
            </div>
        </form>
        @if (!request()->has('filter')  || (request()->filter == '') || (request()->filter == 'idea'))
            @forelse ($favs as $idea)
                <livewire:idea-index
                    :idea="$idea"
                    :votesCount="$idea->votes_count"
                    :commentsCount="$idea->comments_count"
                />
            @empty
            <h3 class="text-center text-xl font-semibold">
                No Idea's found.
            </h3>
            @endforelse
        @else 
            @forelse ($favs as $challenge)
                <livewire:challenges.challenge-index
                    :challenge="$challenge"
                    :votesCount="$challenge->votes_count"
                    :commentsCount="$challenge->comments_count"
                />
            @empty
            <h3 class="text-center text-xl font-semibold">
                No Challenges's found.
            </h3>
            @endforelse
        @endif
    </div> <!-- end ideas-container -->
</x-app-layout>
