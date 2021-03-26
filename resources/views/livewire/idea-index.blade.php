<div
    x-data
    @click="
        const clicked = $event.target
        const target = clicked.tagName.toLowerCase()

        const ignores = ['button', 'svg', 'path', 'a','span','i']

        if (! ignores.includes(target)) {
            clicked.closest('.idea-container').querySelector('.idea-link').click()
        }
    "
    class="idea-container hover:shadow-card transition duration-150 ease-in bg-white rounded-xl flex cursor-pointer"
    >
    
    <div class="hidden md:block border-r border-gray-100 px-5 py-8">
        <div class="text-center">
            <div class="font-semibold text-2xl @if ($hasVoted) text-blue @endif">{{ $votesCount }}</div>
            <div class="text-gray-500">Likes</div>
        </div>

        <div class="mt-8">
            @if ($hasVoted)
                <button wire:click.prevent="vote" class="w-20 bg-blue text-white border border-blue hover:bg-blue-hover font-bold text-xxs uppercase rounded-xl transition duration-150 ease-in px-4 py-3">Liked</button>
            @else
                <button wire:click.prevent="vote" class="w-20 bg-gray-200 border border-gray-200 hover:border-gray-400 font-bold text-xxs uppercase rounded-xl transition duration-150 ease-in px-4 py-3">Like</button>
            @endif
        </div>
    </div>
    <div class="flex flex-col md:flex-row flex-1 px-2 py-6">
        <div class="flex-none mx-2 md:mx-0">
            <a href="#">
                <img src="{{ optional($idea->user)->getAvatar() }}" alt="avatar" class="w-14 h-14 rounded-xl">
            </a>
        </div>
        <div class="w-full flex flex-col justify-between mx-2 md:mx-4">
            <h4 class="text-xl font-semibold mt-2 md:mt-0">
                <a href="{{ route('idea.show', ['idea' => $idea,'page' => request()->page]) }}" class="idea-link hover:underline">{{ $idea->title }}</a>
            </h4>
            <div class="text-gray-600 mt-3 line-clamp-3">
                {{ $idea->description }}
            </div>
            <div class="flex flex-col md:flex-row md:items-center justify-between mt-6">
                <div class="flex items-center text-xs text-gray-400 font-semibold space-x-2">
                    <div>{{ $idea->created_at->diffForHumans() }}</div>
                    <div>&bull;</div>
                    <div>{{ $idea->category->name }}</div>
                    @auth
                        <div>&bull;</div>
                        <div x-data="{isFav : '{{ $hasFav }}'}">
                            <span wire:click.prevent="fav('{{ $idea->id }}')">
                                <i class="fa fa-heart" style="font-size:18px;" :class="{'text-red' : isFav == true}"></i>
                            </span>
                        </div>
                    @endauth
                    <div>&bull;</div>
                    <div class="text-gray-900">{{ $commentsCount }} Comments</div>
                    @if ($idea->created_at != $idea->updated_at)
                        <div>&bull;</div>
                        <div class="text-gray-900">Edited: {{ $idea->updated_at->diffForHumans() }}</div>
                    @endif
                </div>
                {{-- @if ($idea->isIdeaOwner())

                <div
                    x-data="{ isOpen: false }"
                    class="flex items-center space-x-2 mt-4 md:mt-0">
                    
                    <button
                        @click="isOpen = !isOpen"
                        class="relative bg-gray-100 hover:bg-gray-200 border rounded-full 
                        h-7 transition duration-150 ease-in py-2 px-3">
                        <svg fill="currentColor" width="24" height="6"><path d="M2.97.061A2.969 2.969 0 000 3.031 2.968 2.968 0 002.97 6a2.97 2.97 0 100-5.94zm9.184 0a2.97 2.97 0 100 5.939 2.97 2.97 0 100-5.939zm8.877 0a2.97 2.97 0 10-.003 5.94A2.97 2.97 0 0021.03.06z" style="color: rgba(163, 163, 163, .5)"></svg>
                        <ul
                            x-cloak
                            x-show.transition.origin.top.left="isOpen"
                            @click.away="isOpen = false"
                            @keydown.escape.window="isOpen = false"
                            class="absolute w-44 text-left font-semibold bg-white 
                            shadow-dialog rounded-xl py-3 md:ml-8 top-8 md:top-6 right-0 md:left-0">
                            <li><a href="#" class="hover:bg-gray-100 block transition duration-150 ease-in px-5 py-3">Mark as Spam</a></li>
                            <li><a href="javascript:;" wire:click.prevent="deleteIdea('{{ $idea->id }}')" class="hover:bg-gray-100 block transition duration-150 ease-in px-5 py-3">Delete Post</a></li>
                        </ul>
                    </button>
                </div>
                @endif --}}

                <div class="flex items-center md:hidden mt-4 md:mt-0">
                    <div class="bg-gray-100 text-center rounded-xl h-10 px-4 py-2 pr-8">
                        <div class="text-sm font-bold leading-none @if ($hasVoted) text-blue @endif">{{ $votesCount }}</div>
                        <div class="text-xxs font-semibold leading-none text-gray-400">Votes</div>
                    </div>
                    @if ($hasVoted)
                        <button
                            wire:click.prevent="vote"
                            class="w-20 bg-blue text-white border border-blue font-bold text-xxs uppercase rounded-xl hover:bg-blue-hover transition duration-150 ease-in px-4 py-3 -mx-5"
                        >
                            Voted
                        </button>
                    @else
                        <button
                            wire:click.prevent="vote"
                            class="w-20 bg-gray-200 border border-gray-200 font-bold 
                            text-xxs uppercase rounded-xl hover:border-gray-400 transition 
                            duration-150 ease-in px-4 py-3 -mx-5">
                            Vote
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>