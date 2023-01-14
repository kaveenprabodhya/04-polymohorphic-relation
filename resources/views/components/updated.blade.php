@if (isset($date) && $date)
    Added: <x-badge type="primary">
        {{ $date }}
    </x-badge>
    &nbsp;
@endif
@if (isset($name) && $name)
    @if (isset($userId))
        By: <x-badge type="info">
            <a href="{{ route('users.show', ['user' => $userId]) }}">
                {{ $name }}
            </a>
        </x-badge>
        &nbsp;
    @else
        By: <x-badge type="info">{{ $name }}</x-badge>
        &nbsp;
    @endif
@endif
@if (isset($edited) && $edited)
    Last Edited: <x-badge type="warning">{{ $edited }}</x-badge>
@endif
