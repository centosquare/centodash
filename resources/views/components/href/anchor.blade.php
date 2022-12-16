@props([
    'btn_size' => 'sm',
    'title' => '',
    'url' => '#',
])
<div class="card-toolbar">
    <a href="{{ $url }}" {{ $attributes->merge(['class' => 'btn btn-' . $btn_size . ' btn-info btn-active-primary']) }}>
        {{ $icon ?? '' }}
        {{ $title }}
    </a>
</div>
