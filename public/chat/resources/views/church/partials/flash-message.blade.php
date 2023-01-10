@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        <strong style="color: unset;">{{ $message }}</strong>
</div>
@endif


@if ($message = Session::get('error'))
<div class="alert alert-danger alert-block">
    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
        <strong style="color: unset;">{{ $message }}</strong>
</div>
@endif


@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-block">
    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
    <strong style="color: unset;">{{ $message }}</strong>
</div>
@endif


@if ($message = Session::get('info'))
<div class="alert alert-info alert-block">
    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
    <strong style="color: unset;">{{ $message }}</strong>
</div>
@endif


@if ($errors->any())
<div class="alert alert-danger">
    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"></a>
    Please check the form below for errors
</div>
@endif

<div class="alert alert-success" style="display: none;">
    {{ Session::get('success') }}
</div>