@forelse ($comments as $comment)
    <div class="bg-secondary border border-5 text-white">
        <div class="col m-1 p-3">
            <p>{{ $comment->content }}</p>
        </div>
        <div class="m-2 p-1">
            <x-tags :tags="$comment->tags"></x-tags>
        </div>
        <div class="col m-1 d-flex">
            <div class="ms-auto">
                {{-- Added: <span class="badge bg-primary">{{ $comment->created_at->diffForHumans() }}</span> --}}
                <x-updated :date="$comment->created_at->diffForHumans()" :name="$comment->user->name"></x-updated>
            </div>
        </div>
    </div>
    <hr class="m-2 border-5">
@empty
    <p class="p-2 m-2">No Comments Found.</p>
@endforelse
