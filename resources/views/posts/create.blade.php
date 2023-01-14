@extends('layouts.app')
@section('title')
    Posts
@endsection
@section('content')
    <h3>Create Post</h3>
    <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('posts._form', ['btnName' => 'create!'])
    </form>
@endsection
