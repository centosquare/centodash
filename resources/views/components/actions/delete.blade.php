@props([
    'route'  => '',
    'size'  => 'sm',
])
<a href="{{$route}}" class="btn btn-icon btn-danger btn-{{ $size }}">
    <i class="bi bi-trash fs-4"></i>
</a>
