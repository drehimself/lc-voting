<div>
    <x-alerts></x-alerts>
@forelse ($comments as $comment)
    @if (!($challenge->user_id == $comment->user_id))
    <div class="comment-container relative bg-white rounded-xl flex mt-4">
        <div class="flex flex-col md:flex-row flex-1 px-4 py-6">
            <div class="flex-none">
                <a href="#">
                    <img src="{{ $comment->user->getAvatar() }}" alt="avatar" class="w-14 h-14 rounded-xl">
                </a>
            </div>
            <div class="w-full md:mx-4">
                <div class="text-gray-600 mt-3 line-clamp-3">
                    {{ $comment->body }}
                </div>

                <div class="flex items-center justify-between mt-6">
                    <div class="flex items-center text-xs text-gray-400 font-semibold space-x-2">
                        <div class="font-bold text-gray-900">{{ $comment->user->name }}</div>
                        <div>&bull;</div>
                        <div>{{ $comment->created_at->diffForHumans() }}</div>
                    </div>
                    @if ($comment->isCommentOwner())
                    <div
                        class="flex items-center space-x-2"
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
                            <li><a href="javascript:;" class="hover:bg-gray-100 block transition duration-150 ease-in px-5 py-3"
                                        data-id="{{ $comment->id }}"
                                        data-body="{{ $comment->body }}"
                                        @click="$dispatch('show-modal',{id : $event.target.getAttribute('data-id'),body : $event.target.getAttribute('data-body')})">Edit Comment</a></li>
                                    <li><a href="javascript:;" 
                                            wire:click="deleteComment('{{ $comment->id }}')" class="hover:bg-gray-100 block transition duration-150 ease-in px-5 py-3">Delete Comment</a></li>
                                </ul>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div> <!-- end comment-container -->
    @else
    <div class="is-admin comment-container relative bg-white rounded-xl flex mt-4">
        <div class="flex flex-1 px-4 py-6">
            <div class="flex-none">
                <a href="#">
                    <img src="{{ $comment->user->getAvatar() }}" alt="avatar" class="w-14 h-14 rounded-xl">
                </a>
                <div class="text-center uppercase text-blue text-xxs font-bold mt-1">Author</div>
            </div>
            <div class="w-full mx-4">
                <div class="text-gray-600 mt-3 line-clamp-3 text-xl font-semibold">
                    {{ $comment->body }}
                </div>

                <div class="flex items-center justify-between mt-6">
                    <div class="flex items-center text-xs text-gray-400 font-semibold space-x-2">
                        <div class="font-bold text-blue">{{ $comment->user->name }}</div>
                        <div>&bull;</div>
                        <div>{{ $comment->created_at->diffForHumans() }}</div>
                        @if ($comment->created_at != $comment->updated_at)    
                            <div>&bull;</div>
                            <div>Edited {{ $comment->updated_at->diffForHumans() }}</div>
                        @endif
                    </div>
                    @if ($comment->isCommentOwner())

                    <div class="flex items-center space-x-2"
                    x-data="{ isOpen2: false }">
                        <button class="relative bg-gray-100 hover:bg-gray-200 border rounded-full h-7 transition duration-150 ease-in py-2 px-3"
                            @click="isOpen2 = !isOpen2">
                            <svg fill="currentColor" width="24" height="6"><path d="M2.97.061A2.969 2.969 0 000 3.031 2.968 2.968 0 002.97 6a2.97 2.97 0 100-5.94zm9.184 0a2.97 2.97 0 100 5.939 2.97 2.97 0 100-5.939zm8.877 0a2.97 2.97 0 10-.003 5.94A2.97 2.97 0 0021.03.06z" style="color: rgba(163, 163, 163, .5)"></svg>
                            <ul class="absolute w-44 text-left font-semibold bg-white shadow-dialog rounded-xl py-3 ml-8"
                            class="absolute w-44 text-left font-semibold bg-white shadow-dialog rounded-xl z-10 py-3 md:ml-8 top-8 md:top-6 right-0 md:left-0"
                            style="z-index: 9999999;"
                                x-cloak
                                x-show.transition.origin.top.left="isOpen2"
                                @click.away="isOpen2 = false"
                                @keydown.escape.window="isOpen2 = false">
                                    <li><a href="javascript:;" class="hover:bg-gray-100 block transition duration-150 ease-in px-5 py-3"
                                        data-id="{{ $comment->id }}"
                                        data-body="{{ $comment->body }}"
                                        @click="$dispatch('show-modal',{id : $event.target.getAttribute('data-id'),body : $event.target.getAttribute('data-body')})">Edit Comment</a></li>
                                        <li><a href="javascript:;" 
                                            wire:click="deleteComment('{{ $comment->id }}')" class="hover:bg-gray-100 block transition duration-150 ease-in px-5 py-3">Delete Comment</a></li>
                            </ul>
                        </button>
                    </div>
                    @endif

                </div>
            </div>
        </div>

    </div> <!-- end comment-container -->
    @endif
    @empty
    
    @endforelse

    <x-comment-edit-modal></x-comment-edit-modal>
    @if ($comments->hasMorePages() && $comments->count() > 0)
        <x-load-more></x-load-more>
    @endif
    <div wire:loading.flex class="normal-case">
        Loading More Comments...
    </div>
</div>