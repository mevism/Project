<script>

    @if(count($errors) > 0)
    @foreach($errors->all() as $error)
    toastr.error("{{ $error }}");
    @endforeach
        @endif

        @if(Session::has('error'))
        toastr.options = {
        "closeButton" : true,
        "progressBar" : true,
        "closeDuration" : 5000
    }
    toastr.error("{{ session('error') }}");
    @endif
        @if(Session::has('success'))
        toastr.options = {
        "closeButton" : true,
        "progressBar" : true,
        "closeDuration" : 5000
    }
    toastr.success("{{ session('success') }}");
    @endif

        @if(Session::has('info'))
        toastr.options = {
        "closeButton" : true,
        "progressBar" : true,
        "closeDuration" : 5000
    }
    toastr.info("{{ session('info') }}");
    @endif

        @if(Session::has('warning'))
        toastr.options = {
        "closeButton" : true,
        "progressBar" : true,
        "closeDuration" : 5000
    }
    toastr.warning("{{ session('warning') }}");
    @endif
</script>


{{--@if ($message = Session::get('success'))--}}
{{--    <div class="alert alert-success alert-dismissible fade show" role="alert">--}}
{{--        <strong>{{ $message }}</strong>--}}
{{--        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>--}}
{{--    </div>--}}
{{--@endif--}}

{{--@if ($message = Session::get('error'))--}}
{{--    <div class="alert alert-danger alert-dismissible fade show" role="alert">--}}
{{--        <strong>{{ $message }}</strong>--}}
{{--        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>--}}
{{--    </div>--}}
{{--@endif--}}

{{--@if ($message = Session::get('warning'))--}}
{{--    <div class="alert alert-warning alert-dismissible fade show" role="alert">--}}
{{--        <strong>{{ $message }}</strong>--}}
{{--        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>--}}
{{--    </div>--}}
{{--@endif--}}

{{--@if ($message = Session::get('info'))--}}
{{--    <div class="alert alert-info alert-dismissible fade show" role="alert">--}}
{{--        <strong>{{ $message }}</strong>--}}
{{--        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>--}}
{{--    </div>--}}
{{--@endif--}}

{{--@if ($errors->any())--}}
{{--    <div class="alert alert-danger alert-dismissible fade show" role="alert">--}}
{{--        <strong>Please check the form below for errors</strong>--}}
{{--        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>--}}
{{--    </div>--}}
{{--@endif--}}
