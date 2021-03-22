@if (session()->has('success'))    
    <div {{ $attributes->merge(['class' => 'px-6 py-6 leading-normal text-white bg-green rounded-lg']) }} role="alert"
        x-data="{showAlert : '{{ session()->has('success') }}'}"
        x-showAlert.transition.duration.1000ms="showAlert"
        x-cloak
        x-init="setTimeout(() => {
            showAlert = false;
        },3000)">
        <p>{{ session()->get('success') }}</p>
    </div>
@endif

@if (session()->has('error'))    
    <div {{ $attributes->merge(['class' => 'px-6 py-6 leading-normal text-white bg-red rounded-lg']) }} role="alert"
        x-data="{showAlert2 : '{{ session()->has('error') }}'}"
        x-showAlert2.transition.duration.1000ms="showAlert2"
        x-cloak
        x-init="console.log('foobar');setTimeout(() => {
            showAlert2 = false;
        },3000)">
        <p>{{ session()->get('error') }}</p>
    </div>
@endif