@component('mail::message')
    # Comment was posted on your blog post

    HI {{ $comment->commentable->user->name }}

    Someone has commented on your blog post.

    @component('mail::button', ['url' => route('posts.show', ['post' => $comment->commentable->id])])
        View Blog Post
    @endcomponent

    @component('mail::button', ['url' => route('users.show', ['user' => $comment->user->id])])
        Visit {{ $comment->user->name }} Profile
    @endcomponent

    @component('mail::panel')
        {{ $comment->content }}
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
