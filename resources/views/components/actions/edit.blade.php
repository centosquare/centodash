@props([
    'route'  => '',
    'size'  => 'sm',
])
<a href="{{$route}}" class="btn btn-icon btn-success btn-{{ $size }}">
    <i class="bi bi-pencil fs-4"></i>
</a>
