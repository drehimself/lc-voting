<!-- edit modal --->
<div class="modal h-screen w-full fixed left-0 top-0 flex justify-center items-center bg-black bg-opacity-50"
    style="z-index: 9999999"
    x-cloak
    :class="{hidden : addIdeaModal === false}"
    x-data="{addIdeaModal : false}"
    x-on:show-add-idea-modal.window="addIdeaModal = true">
    <!-- modal -->
    <div class="bg-white rounded shadow-lg w-10/12 md:w-1/3  border-2 border-blue"
      @click.away="addIdeaModal = false"
      x-show.transition.duration.700ms="addIdeaModal">
      <!-- modal header -->
        <div class="border-b px-4 py-2 flex justify-between items-center">
            <h3 class="font-semibold text-base">Add an idea</h3>
            <button class="text-black close-modal"
            @click="addIdeaModal = false">&cross;</button>
        </div>
      <!-- modal body -->
        <div class="">
            <div
                class="bg-white md:sticky md:top-8"
                style="">
                <div class="text-center px-6 py-2 pt-6">
                    {{-- <h3 class="font-semibold text-base">Add an idea</h3> --}}
                    <p class="text-sm mt-4">
                        @auth
                            Let us know what you would like and we'll take a look over!
                        @else
                            Please login to create an idea.
                        @endauth
                    </p>
                </div>
                @auth
                    <livewire:create-idea 
                    :categories="$categories"/>
                @else
                    <div class="my-6 text-center">
                        <a
                            href="{{ route('login') }}"
                            class="inline-block justify-center w-1/2 h-11 text-xs 
                            bg-blue text-white font-semibold rounded-xl border border-blue 
                            hover:bg-blue-hover transition duration-150 ease-in px-6 py-3">
                            Login
                        </a>
                        <a
                            href="{{ route('register') }}"
                            class="inline-block justify-center w-1/2 h-11 text-xs 
                            bg-gray-200 font-semibold rounded-xl border border-gray-200 
                            hover:border-gray-400 transition duration-150 ease-in px-6 py-3 mt-4">
                            Sign Up
                        </a>
                    </div>
                @endauth

            </div>
        </div>
    </div>
</div>