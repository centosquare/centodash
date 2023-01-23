<div class='text-start'>
  @can('permission.edit')
    <a href="{{ route('permission.edit',$id) }}" class="btn btn-icon btn-success btn-sm mr-2"><i class="bi bi-pencil fs-4"></i></a>
  @endcan

  @can('permission.delete')
   <a href="{{ route('permission.delete',$id) }}" class="btn btn-icon btn-danger btn-sm"><i class="bi bi-trash fs-4"></i></a>
  @endcan
</div>
