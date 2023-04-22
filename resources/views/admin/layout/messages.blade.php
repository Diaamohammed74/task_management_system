@if (session()->has('success'))
<div class="alert alert-success text-center col-12" role="alert">
    {{ session('success') }}
</div>

@elseif (session()->has('deleted'))
<div class="alert alert-warning text-center col-12" role="alert">
    {{ session('deleted') }}
</div>
@elseif (session()->has('permission'))
<div class="alert alert-danger text-center col-12" role="alert">
    {{ session('permission') }}
</div>
@endif

@if ($errors->has('email') || $errors->has('password'))
    <div class="alert alert-danger">
        These credentials do not match our records.
    </div>
@endif

