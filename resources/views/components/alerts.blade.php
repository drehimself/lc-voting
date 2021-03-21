@if (session()->has('success'))    
    <div class="px-6 py-6 leading-normal text-white bg-green rounded-lg" role="alert">
        <p>{{ session()->get('success') }}</p>
    </div>
@endif

@if (session()->has('error'))    
    <div class="px-6 py-6 leading-normal text-white bg-red rounded-lg" role="alert">
        <p>{{ session()->get('error') }}</p>
    </div>
@endif