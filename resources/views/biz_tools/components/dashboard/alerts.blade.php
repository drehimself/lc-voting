@if (session()->has('success'))
    <div class="alert alert-success">
        <strong>{{ session()->get('success') }}</strong>
    </div>
@endif

@if (session()->has('error'))
    <div class="alert alert-danger">
        <strong>{{ session()->get('error') }}</strong>
    </div>
@endif