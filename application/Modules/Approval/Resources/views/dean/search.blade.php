@extends('approval::layouts.backend')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="{{ asset('css/admissions.css') }}" rel="stylesheet" />
<link href="{{ asset('css/index.css') }}" rel="stylesheet" />
<script src = "{{ asset('js/select.js') }}" defer></script>
<script src = "{{ asset('js/jquery.js') }}" ></script>

<div class = 'content-force'>
    <div id = 'search-section'>
        <div id = 'search-section-left'>
            <form accept-charset=utf8 id = 'search-form'>
                <input type = 'search' id = 'search-input' placeholder = 'Search Here'>
                <button type = 'submit' id = 'search-query-button'><i class='fas fa-search'></i></button>
            </form>
        </div>
    </div>
    <div id = 'candidate-page'></div>
</div>

<script src = "{{ asset('js/build.js') }}"></script>

<!-- END Page Content -->
@endsection
