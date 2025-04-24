@if(session('info'))
<div class="alert alert-info">
    {{ session('info') }}
</div>
@endif

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('errors'))
@foreach (session('errors') as $error)
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ $error }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endforeach
@endif


@if (session()->has('failures'))
    <div class="alert alert-danger" role="alert">
        <strong>{{__('Some Rows didn\'t importe due to Validation Errors:')}}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <ul>
            @foreach (session()->get('failures') as $failure)
                <li>{{__('Row')}} {{ $failure->row() }}: {{ implode(', ', $failure->errors()) }}</li>
            @endforeach
        </ul>
    </div>
@endif
