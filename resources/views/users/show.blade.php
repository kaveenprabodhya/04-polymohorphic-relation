@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 d-flex justify-content-center">
                <div class="form-group">
                    <img src="{{ $user->image ? Storage::url($user->image->path) : '' }}" alt="profile"
                        class="img-thumbnail">
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="mt-3 mt-md-0 d-flex justify-content-center justify-content-md-start">
                        <div class="px-2 text-capitalize align-self-center">
                            <h3 class="pt-1">
                                Name:
                                {{ $user->name }}
                            </h3>
                        </div>
                        <div class="align-self-center">
                            <a href="{{ route('users.edit', ['user' => $user->id]) }}"
                                class="btn btn-outline-primary ">Edit</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="p-2">
                        <p>Currently viewed by {{ $counter }} other users.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2 d-flex flex-row">
            <div class="col-md-6">
                <h3 class="my-2"><u>Comments :)</u></h3>
                <x-comment-list :comments="$user->comments"></x-comment-list>

            </div>
            <div class="col-md-6">
                <div class="my-4">
                    <x-comment-form :route="route('users.comments.store', ['user' => $user->id])"></x-comment-form>
                </div>
            </div>
        </div>
    </div>
@endsection
