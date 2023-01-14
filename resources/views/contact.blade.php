@extends('layouts.app')
@section('title')
    Contact
@endsection
@section('content')
    <h1>Contact</h1>
    @can('home.secret')
        <a href="{{ route('secret') }}">
            Go to Special Contact details
        </a>
    @endcan
@endsection
