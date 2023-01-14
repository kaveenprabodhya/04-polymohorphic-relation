@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li class="my-2 alert alert-danger">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
