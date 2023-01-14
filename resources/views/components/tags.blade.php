<div>
    @foreach ($tags as $tag)
        <a href="{{ route('posts.tags.index', ['tag' => $tag->id]) }}"
            class="badge bg-tertiary badge-lg">{{ $tag->name }}</a>
    @endforeach
</div>
