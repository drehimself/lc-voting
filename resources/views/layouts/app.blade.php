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

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" 
            integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" 
            crossorigin="anonymous" />
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" 
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" 
            crossorigin="anonymous"></script>
        {{ $style ?? ''}}
        <style>
            .float{
                position:fixed;
                width:60px;
                height:60px;
                bottom:5%;
                left:3%;
                color:#FFF;
                border-radius:50px;
                text-align:center;
                box-shadow: 2px 2px 3px #999;
            }

            .my-float{
                margin-top:24px;
                align-items: center;
            }
        </style>
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
            
            <div class="w-full px-2 md:px-0 {{ $class }}">
                <nav class="hidden md:flex items-center justify-between text-xs">
                    <ul class="flex uppercase font-semibold border-b-4 pb-3 space-x-10">
                        <li><a href="{{ route('idea.index') }}" class="pb-3 border-blue {{ request()->routeIs('idea.index') ? 'border-b-4' : '' }}"">All Ideas ({{ $ideasTotal }})</a></li>
                        <li><a href="#" class="text-gray-400 transition duration-150 ease-in border-b-4 pb-3 hover:border-blue">All Challenges (6)</a></li>
                        @auth
                            <li><a href="{{ route('favourites.list') }}" class="text-gray-400 transition duration-150 ease-in pb-3 hover:border-blue {{ request()->routeIs('favourites.list') ? 'border-blue border-b-4' : '' }}">Favourites</a></li>
                        @endauth
                    </ul>
                </nav>

                <div class="mt-8">
                    {{ $slot }}
                </div>
            </div>
        </main>
        <livewire:scripts />

        @if (!request()->routeIs('idea.show'))    
            <x-add-idea-modal :categories="$categories"></x-add-idea-modal>
            <x-floating-icon></x-floating-icon>
        @endif
        @stack('js')
    </body>
</html>
