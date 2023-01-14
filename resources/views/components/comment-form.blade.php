@auth
    <form action="{{ $route }}" method="POST">
        @csrf
        <div class="form-group">
            <textarea rows="6" class="form-control" name="content" id="content" placeholder="Add comment"></textarea>
        </div>
        <input type="submit" class="btn btn-primary my-2" value="Add Comment!">
        <x-errors></x-errors>
    </form>
@else
    <div class="col border border-4">
        <p class="text-center" style="font-size: 1.5rem;"><a href="{{ route('login') }}">Sign in</a> to comment.</p>
    </div>
@endauth
