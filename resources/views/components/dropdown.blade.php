<div class="dropdown">
    <a href="#" class="btn dropdown-toggle {{ $class ?? '' }}" data-bs-toggle="dropdown">{{  $title ?? 'Title' }}</a>
    <div class="dropdown-menu">
        @isset($list)
            @foreach ($list as $item)
                @isset($item->route)
                    <a class="dropdown-item {{ $item->class ?? '' }}" href="{{ route($item->route) }}">{{ $item->name }}</a>
                @else
                    <a class="dropdown-item {{ $item->class ?? '' }}" href="{{ route($item->link) }}">{{ $item->name }}</a>
                @endisset

            @endforeach
        @endisset
    </div>
</div>
