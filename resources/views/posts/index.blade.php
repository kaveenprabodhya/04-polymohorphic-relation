@extends('layouts.app')
@section('title')
    Posts
@endsection
@section('content')
    <a type="button" class="btn btn-primary" href="{{ route('posts.create') }}">Add New Post</a>
    <hr>
    <div class="row">
        <div class="col col-lg-8">
            @forelse ($posts as $post)
                {{-- <li><a href="/posts/{{ $post->id }}">{{ $post->title }}</a></li> --}}
                <div>
                    <div class="d-flex">
                        <div class="align-self-center">
                            @if ($post->trashed())
                                <del>
                            @endif
                            <a href="{{ route('posts.show', ['post' => $post->id]) }}"
                                class="{{ $post->trashed() ? 'text-muted' : '' }}">
                                {{ $post->title }}
                            </a>
                            @if ($post->trashed())
                                </del>
                            @endif

                            @if ($post->comments_count)
                                <span class="ms-2 badge bg-warning">
                                    {{ $post->comments_count }} comments
                                </span>
                            @else
                                <span class="ms-2 badge bg-secondary">No Comments.</span>
                            @endif
                        </div>

                        <div class="ms-auto d-flex">
                            @auth
                                @if (!$post->trashed())
                                    @can('update', $post)
                                        <div class="ps-1">
                                            <a class="btn btn-primary"
                                                href="{{ route('posts.edit', ['post' => $post->id]) }}">Edit</a>
                                        </div>
                                    @endcan
                                    @can('delete', $post)
                                        <div class="ps-1">
                                            <form action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="submit" class="btn btn-danger" value="Delete">
                                            </form>
                                        </div>
                                    @endcan
                                    @cannot('delete', $post)
                                        <p>You cannot delete this post</p>
                                    @endcannot
                                @endif
                            @endauth
                        </div>
                    </div>
                    <div class="m-1">
                        <x-updated :date="$post->created_at->diffForHumans()" :name="$post->user->name" :user-id="$post->user->id">
                        </x-updated>
                    </div>
                    <div class="m-1">
                        <x-tags :tags="$post->tags"></x-tags>
                    </div>
                </div>
            @empty
                <p>No posts found.</p>
            @endforelse
        </div>
        <div class="col col-lg-4">
            @include('posts._activity')
        </div>
    </div>
@endsection
