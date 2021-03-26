<div class="idea-and-buttons container">
    <x-alerts class="mt-3"></x-alerts>
    <div class="idea-container bg-white rounded-xl flex mt-4">
        <div class="flex flex-col md:flex-row flex-1 px-4 py-6">
            <div class="flex-none mx-2 md:mx-4">
                <a href="#">
                    <img src="{{ $idea->user->getAvatar() }}" alt="avatar" class="w-14 h-14 rounded-xl">
                </a>
            </div>
            <div class="w-full mx-2 md:mx-4">
                <h4 class="text-xl font-semibold">
                    <a href="#" class="hover:underline">{{ $idea->title }}</a>
                </h4>
                <div class="text-gray-600 mt-3">
                    {{ $idea->description }}
                </div>
                @if ($idea->files != '')
                    <img src="{{ asset('storage/'.$idea->files) }}" alt="" x-data="{}" class="md:object-scale-down h-10 mt-5 inset-0.5"
                    @click="$dispatch('show-image-modal',{image : $event.target.getAttribute('src') })">
                @endif
                <div class="flex flex-col md:flex-row md:items-center justify-between mt-6">
                    <div class="flex items-center text-xs text-gray-400 font-semibold space-x-2">
                        <div class="hidden md:block font-bold text-gray-900">{{ $idea->user->name }}</div>
                        <div class="hidden md:block">&bull;</div>
                        <div>{{ $idea->created_at->diffForHumans() }}</div>
                        <div>&bull;</div>
                        <div>{{ $idea->category->name }}</div>
                        @auth
                            <div>&bull;</div>
                            <div x-data="{isFav : '{{ $hasFav }}'}">
                                <span wire:click.prevent="fav('{{ $idea->id }}')">
                                    <i class="fa fa-heart" style="font-size:18px;cursor: pointer;   " :class="{'text-red' : isFav == true}"></i>
                                </span>
                            </div>
                            <div>&bull;</div>
                            <div x-data="{isSpammed : '{{ $hasMarkedSpam }}'}">
                                <span wire:click.prevent="markAsSpam('{{ $idea->id }}')">
                                    <i class="fa fa-flag" style="font-size:18px;cursor: pointer;   " :class="{'text-red' : isSpammed == true}"></i>
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

                    @auth    
                    <div class="flex items-center space-x-2 mt-4 md:mt-0"
                    x-data="{ isOpen: false }">
                    
                    <button
                    class="relative bg-gray-100 hover:bg-gray-200 border rounded-full h-7 transition duration-150 ease-in py-2 px-3"
                    @click="isOpen = !isOpen">
                    <svg fill="currentColor" width="24" height="6"><path d="M2.97.061A2.969 2.969 0 000 3.031 2.968 2.968 0 002.97 6a2.97 2.97 0 100-5.94zm9.184 0a2.97 2.97 0 100 5.939 2.97 2.97 0 100-5.939zm8.877 0a2.97 2.97 0 10-.003 5.94A2.97 2.97 0 0021.03.06z" style="color: rgba(163, 163, 163, .5)"></svg>
                        <ul
                        class="absolute w-44 text-left font-semibold bg-white shadow-dialog rounded-xl z-10 py-3 md:ml-8 top-8 md:top-6 right-0 md:left-0"
                        x-cloak
                        x-show.transition.origin.top.left="isOpen"
                        @click.away="isOpen = false"
                        @keydown.escape.window="isOpen = false">
                        @if ($idea->isIdeaOwner())
                            <li><a href="javascript:;" wire:click.prevent="deleteIdea('{{ $idea->id }}')" class="hover:bg-gray-100 block transition duration-150 ease-in px-5 py-3">Delete Post</a></li>
                        @endif
                    </ul>
                    </button>
                </div>
                @endauth
                        
                    <div class="flex items-center md:hidden mt-4 md:mt-0">
                        <div class="bg-gray-100 text-center rounded-xl h-10 px-4 py-2 pr-8">
                            <div class="text-sm font-bold leading-none @if($hasVoted) text-blue @endif">{{ $votesCount }}</div>
                            <div class="text-xxs font-semibold leading-none text-gray-400">Likes</div>
                        </div>
                        @if ($hasVoted)
                            <button
                                wire:click.prevent="vote"
                                class="w-20 bg-blue text-white border border-blue font-bold text-xxs uppercase rounded-xl hover:bg-blue-hover transition duration-150 ease-in px-4 py-3 -mx-5"
                            >
                                Liked
                            </button>
                        @else
                            <button
                                wire:click.prevent="vote"
                                class="w-20 bg-gray-200 border border-gray-200 font-bold text-xxs uppercase rounded-xl hover:border-gray-400 transition duration-150 ease-in px-4 py-3 -mx-5"
                            >
                                Like
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end idea-container -->

    <div class="buttons-container flex items-center justify-between mt-6">
        <div class="flex flex-col md:flex-row items-center space-x-4 md:ml-6"
            x-data="{ isOpen: false,showMessage : false,timeout : null}"
            x-init="@this.on('comment-saved',() => {
                isOpen = false;
                clearTimeout(timeout); showMessage = true; setTimeout(() => {
                    showMessage = false;
                },2000) 
            })">
            <div class="relative">
                <button
                    type="button"
                    @click="isOpen = !isOpen"
                    class="flex items-center justify-center h-11 w-32 text-sm bg-blue text-white font-semibold rounded-xl border border-blue hover:bg-blue-hover transition duration-150 ease-in px-6 py-3"
                >
                    Reply
                </button>
                <div
                    class="absolute z-10 w-64 md:w-104 text-left font-semibold text-sm bg-white shadow-dialog rounded-xl mt-2"
                    x-cloak
                    x-show.transition.origin.top.left="isOpen"
                    @click.away="isOpen = false"
                    @keydown.escape.window="isOpen = false"
                    style="z-index:999999999"
                >
                    <form action="#" class="space-y-4 px-4 py-6">
                        <div>
                            <textarea name="post_comment" id="post_comment" wire:model.defer="commentBody" cols="30" rows="4" class="w-full text-sm bg-gray-100 rounded-xl placeholder-gray-900 border-none px-4 py-2" placeholder="Suggest ways to improve on this idea"></textarea>
                            @error('commentBody')
                                <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex flex-col md:flex-row items-center md:space-x-3">
                            <button
                                type="button"
                                wire:click.prevent="postComment()"
                                class="flex items-center justify-center h-11 w-full md:w-1/2 text-sm bg-blue text-white font-semibold rounded-xl border border-blue hover:bg-blue-hover transition duration-150 ease-in px-6 py-3"
                            >
                                Post Comment
                            </button>
                        </div>

                    </form>
                </div>
            </div>
            
            <div>
                <span class="text-green" x-show="showMessage" x-cloak>
                    Comment Saved Successfully
                </span>
            </div>
        </div>

        <div class="hidden md:flex items-center space-x-3">
            <div class="bg-white font-semibold text-center rounded-xl px-3 py-2">
                <div class="text-xl leading-snug @if($hasVoted) text-blue @endif">{{ $votesCount }}</div>
                <div class="text-gray-400 text-xs leading-none">Likes</div>
            </div>
            @if ($hasVoted)
                <button
                    type="button"
                    wire:click.prevent="vote"
                    class="w-32 h-11 text-xs bg-blue text-white font-semibold uppercase rounded-xl 
                        border border-blue hover:bg-blue-hover transition duration-150 
                        ease-in px-6 py-3">
                    <span>Liked</span>
                </button>
            @else
                <button
                    type="button"
                    wire:click.prevent="vote"
                    class="w-32 h-11 text-xs bg-gray-200 font-semibold uppercase 
                    rounded-xl border border-gray-200 hover:border-gray-400 
                    transition duration-150 ease-in px-6 py-3">
                    <span>Like</span>
                </button>
            @endif
        </div>
    </div> <!-- end buttons-container -->
</div>
<x-image-show-modal></x-image-show-modal>
