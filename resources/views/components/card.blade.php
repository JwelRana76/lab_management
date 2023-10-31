<div class="card">
    <div class="card-header">
        <h3>{{ $header }}
            @if ($links)
                <a href="{{ $links }}" class="btn btn-sm btn-primary float-right">{{ $title }}</a>
            @endif
        </h3>
    </div>
    <div class="card-body">
        {{ $slot }}
    </div>
</div>