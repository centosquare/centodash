<div class='text-start'>
  @can('role.edit')
    <a href="{{ route('role.edit',$id) }}" class="btn btn-icon btn-success btn-sm mr-2"><i class="bi bi-pencil fs-4"></i></a>
  @endcan

  @can('role.delete')
   <a href="{{ route('role.delete',$id) }}" class="btn btn-icon btn-danger btn-sm"><i class="bi bi-trash fs-4"></i></a>
  @endcan
</div>
