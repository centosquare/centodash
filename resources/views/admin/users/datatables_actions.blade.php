<div class='text-start'>
  @can('user.edit')
    <a href="{{ route('user.edit',$id) }}" class="btn btn-icon btn-success btn-sm mr-2"><i class="bi bi-pencil fs-4"></i></a>
  @endcan

  @can('user.delete')
   <a href="{{ route('user.delete',$id) }}" class="btn btn-icon btn-danger btn-sm"><i class="bi bi-trash fs-4"></i></a>
  @endcan
</div>
