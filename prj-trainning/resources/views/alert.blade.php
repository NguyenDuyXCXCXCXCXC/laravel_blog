@if (\Illuminate\Support\Facades\Session::has('myError'))
    <div class="alert alert-danger">
        {{ \Illuminate\Support\Facades\Session::get('myError') }}
    </div>
@endif

@if (\Illuminate\Support\Facades\Session::has('mySuccess'))
    <div class="alert alert-success">
        {{ \Illuminate\Support\Facades\Session::get('mySuccess') }}
    </div>
@endif
