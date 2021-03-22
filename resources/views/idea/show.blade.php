<x-app-layout :categories='$categories' class="md:w-screen" smallClass="w-6/12">
    <x-slot name="style">
        <style>
            .is-admin::before {
                z-index: 99999;
            }
        </style>
    </x-slot>

    <x-slot name='ideasTotal'>
        {{ $ideasCount }}
    </x-slot>
    
    <div>
        <a href="/?page={{ request()->page }}" class="flex items-center font-semibold hover:underline">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span class="ml-2">Back</span>
        </a>
    </div>

    <livewire:idea-show
        :idea="$idea"
        :votesCount="$votesCount"
        :commentsCount="$commentsCount"
    />

    <div class="comments-container relative space-y-6 md:ml-22 pt-4 my-8 mt-1">
        <livewire:idea-comment 
            :idea="$idea"
            :key="$comment->id"
        />
    </div>

</x-app-layout>
