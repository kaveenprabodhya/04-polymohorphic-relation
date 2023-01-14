@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="row d-flex">
                <div class="col-10 p-2">
                    <h1>
                        {{-- <a href="{{ route('posts.edit', ['post' => $post->id]) }}"> --}}
                        {{ $post->title }}
                        {{-- @if ((new Carbon\Carbon())->diffInMinutes($post->created_at) < 30) --}}
                        <x-badge :show="now()->diffInMinutes($post->created_at) < 30">
                            Brand New Post
                        </x-badge>
                        {{-- @endif --}}
                        {{-- </a> --}}
                    </h1>
                </div>
                <div class="col-2 my-3 d-flex">
                    <div class="ms-auto">
                        <div class="p-1">
                            <a class="btn btn-primary" href="{{ route('posts.edit', ['post' => $post->id]) }}">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="clearfix">
                    {{-- <img src="{{ asset('storage/' . $post->image->path) }}" class="col-md-6 float-md-end" alt=""
                        style="width: 280px; height: 300;" /> --}}
                    {{-- {{ dd(Storage::url($post->image->path ?? '')) }} --}}
                    <img src="{{ Storage::url($post->image->path ?? '') }}" class="col-md-6 float-md-end" alt=""
                        style="width: 280px; height: 300;" />
                    <p>{{ $post->content }}</p>
                </div>
            </div>


            {{-- <p>Post Added: <span class="badge bg-primary">{{ $post->created_at->diffForHumans() }}</span></p> --}}
            {{-- <p>Added: <x-badge type="primary">
            {{ $post->created_at->diffForHumans() }}
            </x-badge>&nbsp;By: <x-badge type="info">{{ $post->user->name }}</x-badge></p> --}}
            {{-- <x-updated :date="$post->created_at->diffForHumans()" :name="$post->user->name"></x-updated> --}}

            <div class="my-2">
                <x-updated :edited="$post->updated_at" :date="$post->created_at->diffForHumans()" :name="$post->user->name"></x-updated>
            </div>

            <p>Currently read by: {{ $counter }} people</p>

            <x-tags :tags="$post->tags"></x-tags>

            <h3 class="my-4"><u>Comments :)</u></h3>
            <x-comment-list :comments="$post->comments"></x-comment-list>

            <x-comment-form :route="route('posts.comments.store', ['post' => $post->id])"></x-comment-form>
        </div>
        <div class="col-lg-4">
            @include('posts._activity')
        </div>
    </div>
@endsection
