<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
    }
</style>
<p>Hi, {{ $comment->commentable->user->name }}</p>
<p>Someone has commented on your blog post <a href="{{ route('posts.show', ['post' => $comment->commentable->id]) }}">
        {{ $comment->commentable->title }}
    </a>
</p>
<hr>
<p>
    {{-- {{ dump($comment->user->image->url()) }} --}}
    {{-- {{ dump($message->embed($comment->user->image->url())) }} --}}
    {{-- {{ dd($message->embed(public_path() . '//storage/' . $comment->user->image->path)) }} --}}
    {{-- {{ dd('storage/' . $comment->user->image->path) }} --}}

    <img src="{{ $message->embed('storage/' . $comment->user->image->path) }}">
    {{-- <img src="{{ $message->embed(Storage::url($comment->user->image->path)) }}"> --}}
    <a href="{{ route('users.show', ['user' => $comment->user->id]) }}">
        {{ $comment->user->name }}
    </a>
</p>

<p>
    {{ $comment->content }}
</p>
