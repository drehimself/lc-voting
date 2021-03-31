@if (session()->has('success'))    
    <div {{ $attributes->merge(['class' => 'px-6 py-6 leading-normal text-white bg-green rounded-lg']) }} role="alert"
        {{-- x-data="{showAlert : true}"
        x-show.transition.duration.1000ms="showAlert"
        x-init="setTimeout(() => {
            showAlert = false;
        },5000)" --}}
        >
        <p>{{ session()->get('success') }}</p>
    </div>
@endif

@if (session()->has('error'))    
    <div {{ $attributes->merge(['class' => 'px-6 py-6 leading-normal text-white bg-red rounded-lg']) }} role="alert"
        {{-- x-data="{showAlert2 : true}"
        x-show.transition.duration.1000ms="showAlert2"
        x-init="setTimeout(() => {
            showAlert2 = false;
        },3000)" --}}
        >
        <p>{{ session()->get('error') }}</p>
    </div>
@endif