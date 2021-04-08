@extends('biz_tools.layouts.dashboard')

@section('content')
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <div class="jumbotron mt-3 text-center">
                <h1 class="text-center">Hi {{ auth()->user()->name }} 👋</h1>
              </div>
        </div>
    </main>
</div>
@endsection