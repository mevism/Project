@extends('layouts.backend')
@section('content')
    {{ Auth::guard('user')->user()->name }}
@endsection
