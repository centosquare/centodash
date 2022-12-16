@props([
    'h' => 50,
    'src' => '',
    'alt' => '',
])
<img class="rounded-circle h-{{ $h }}px" src="{{ $src }}" alt="{{ $alt }}">
