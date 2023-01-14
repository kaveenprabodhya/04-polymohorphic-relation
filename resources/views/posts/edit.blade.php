@extends('layouts.app')
@section('title')
    Posts
@endsection
@section('content')
    <h3>Edit Post</h3>
    <form action="{{ route('posts.update', ['post' => $post->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('posts._form', ['btnName' => 'Edit'])
    </form>
@endsection
