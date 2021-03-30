<x-app-layout :categories='$categories' class="md:w-screen" smallClass="w-70">
    <x-slot name='ideasTotal'>
        {{ $ideasCount }}
    </x-slot>
    

    <div class="ideas-container space-y-6 my-8">
        <x-alerts></x-alerts>
        {{-- <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
            <div class="inline-block w-full shadow rounded-lg overflow-hidden">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr style="background-color:#10B981;color:#ffff">
                            <th
                                class="px-5 py-3 border-b-2 border-gray-300 bg-gray text-left text-xs font-semibold text-gray uppercase tracking-wider">
                                Idea
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray bg-gray text-left text-xs font-semibold text-gray uppercase tracking-wider">
                                Fav At
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray bg-gray text-left text-xs font-semibold text-gray uppercase tracking-wider">
                                Remove
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($favs as $fav)
                            <tr>
                                <td class="px-5 py-5 border-b border-gray bg-white text-sm">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-full h-10 font-semibold">
                                            <a href="{{ route('idea.show',['idea' => $fav->slug]) }}">
                                                <h3>{{ $fav->title }}</h3>
                                            </a>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-5 py-5 border-b border-gray bg-white text-sm">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-full h-10">
                                            <h3>{{ $fav->pivot->created_at->diffForHumans() }}</h3>
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="px-5 py-5 border-b border-gray bg-white text-sm">
                                    <a href="{{ route('favourites.remove',['idea' => $fav->id]) }}">
                                        <span
                                            class="relative inline-block px-3 py-1 font-semibold text-white leading-tight">
                                            <span aria-hidden
                                                class="absolute inset-0 bg-red opacity-1 rounded-full"></span>
                                            <span class="relative">Remove</span>
                                        </span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-5 py-5 border-b border-gray bg-white text-sm" colspan="3">
                                    <div class="flex items-center text-center">
                                        <div class="flex-shrink-0 w-full h-10 font-semibold">
                                            <h3>No Fav's huh?</h3>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $favs->appends(request()->all())->links() }}
        </div> --}}
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
    </div> <!-- end ideas-container -->
</x-app-layout>
