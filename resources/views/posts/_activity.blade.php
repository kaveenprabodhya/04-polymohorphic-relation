<div class="container">
    <div class="card mt-2">
        <div class="card-body">
            <div class="card-title">Most Commented</div>
            <div class="card-text">What people are currently talking about</div>
            <ul class="list-group list-group-flush">
                @foreach ($mostCommented as $post)
                    <li class="list-group-item">
                        <a href="{{ route('posts.show', ['post' => $post->id]) }}">
                            {{ $post->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-body">
            <div class="card-title">Most Active</div>
            <div class="card-text">Users, most post written</div>
            <ul class="list-group list-group-flush">
                @foreach ($mostActiveLastMonth as $user)
                    <li class="list-group-item">
                        {{ $user->name }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-body">
            <div class="card-title">Most Active Last Month</div>
            <div class="card-text">Users, most post written in the last month</div>
            <ul class="list-group list-group-flush">
                @foreach ($mostActive as $user)
                    <li class="list-group-item">
                        {{ $user->name }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
