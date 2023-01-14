<div class="form-group">
    <label class="form-label" for="title">Title</label>
    <input type="text" class="form-control" name="title" id="title"
        value="{{ old('title', $post->title ?? null) }}" />
</div>
<div class="form-group">
    <label class="form-label" for="content">Content</label>
    <input type="text" class="form-control" name="content" id="content"
        value="{{ old('content', $post->content ?? null) }}" />
</div>
<div class="form-group">
    <label class="form-label" for="thumbnail">Choose Thumbnail</label>
    <input type="file" name="thumbnail" class="form-control" id="thumbnail">
</div>
<input type="submit" class="btn btn-primary my-3" value="{{ $btnName }}">
@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
