<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Idea Sharing</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <livewire:styles />

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" 
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" 
            crossorigin="anonymous"></script>
        {{ $style ?? ''}}
    </head>
 
    <body class="font-sans bg-gray-background text-gray-900 text-sm">
        <header class="flex flex-col md:flex-row items-center justify-between px-8 py-4">
            <a href="#" style="font-size:30px;">
                {{-- <img src="{{ asset('img/logo.svg') }}" alt="logo"> --}}
                Logo
            </a>
            <div class="flex items-center mt-2 md:mt-0">
                @if (Route::has('login'))
                    <div class="px-6 py-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-sm text-gray-700 underline">Dashboard</a>
                            <a href="{{ route('logout') }}" class="ml-4 text-sm text-gray-700 underline"
                                    onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Log out') }}
                            </a>
                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
                <a href="#">
                    <img src="https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp" alt="avatar" class="w-10 h-10 rounded-full">
                </a>
            </div>
        </header>

        <main class="container mx-auto max-w-custom flex flex-col md:flex-row">
            <div class="{{ $small }} mx-auto md:mx-0 md:mr-5">
                <div
                    class="bg-white md:sticky md:top-8 border-2 border-blue rounded-xl mt-16"
                    style="
                          border-image-source: linear-gradient(to bottom, rgba(50, 138, 241, 0.22), rgba(99, 123, 255, 0));
                            border-image-slice: 1;
                            background-image: linear-gradient(to bottom, #ffffff, #ffffff), linear-gradient(to bottom, rgba(50, 138, 241, 0.22), rgba(99, 123, 255, 0));
                            background-origin: border-box;
                            background-clip: content-box, border-box;
                    "
                >
                    <div class="text-center px-6 py-2 pt-6">
                        <h3 class="font-semibold text-base">Add an idea</h3>
                        <p class="text-xs mt-4">
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
            <div class="w-full px-2 md:px-0 {{ $class }}">
                <nav class="hidden md:flex items-center justify-between text-xs">
                    <ul class="flex uppercase font-semibold border-b-4 pb-3 space-x-10">
                        <li><a href="#" class="border-b-4 pb-3 border-blue">All Ideas ({{ $ideasTotal }})</a></li>
                        <li><a href="#" class="text-gray-400 transition duration-150 ease-in border-b-4 pb-3 hover:border-blue">All Challenges (6)</a></li>
                        <li><a href="#" class="text-gray-400 transition duration-150 ease-in border-b-4 pb-3 hover:border-blue">Favourites</a></li>
                    </ul>
                </nav>

                <div class="mt-8">
                    {{ $slot }}
                </div>
            </div>
        </main>
        <livewire:scripts />

        @stack('js')
    </body>
</html>
