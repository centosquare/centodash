<x-layout.master>
    <x-slot name="header">
        <x-layout.header/>
    </x-slot>
    <x-slot name="left_side_nav">
        <x-layout.left_side_nav/>
    </x-slot>
    <x-slot name="content">
        <!--begin::Main-->
            <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                <div class="p-5">
                    @if (Session::has('error'))
                        <div class="alert alert-danger">{{ Session::get('error') }}</div>
                    @endif
                    @if (Session::has('success'))
                        <div class="alert alert-success">{{ Session::get('success') }}</div>
                    @endif
                    <div class="card mb-5 mb-xl-8" style="user-select: auto;">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5" style="user-select: auto;">
                            <h3 class="card-title align-items-start flex-column" style="user-select: auto;">
                                <span class="card-label fw-bold fs-3 mb-1" style="user-select: auto;">All Permissions</span>
                            </h3>
                            <div class="d-flex gap-2 align-items-center py-1">
                                @can('permission.create')
                                    <a href="{{ route('permission.create') }}" class="btn btn-sm btn-primary">Add New Permission</a>
                                @endcan
                                @can('permission.synchronize')
                                    <a href="{{ route('permission.synchronize') }}" class="btn btn-sm btn-primary">Synchronize Permissions</a>
                                @endcan
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->

                        <x-table.card.body :headers="['Permission Name','Guard Name','Action']">
                            <x-slot name='tr'>
                                @foreach ($permissions as $permission)
                                        <tr>
                                            <x-table.td :value="$permission['name']"/>
                                            <x-table.td :value="$permission['guard_name']"/>
                                            <x-table.td>
                                                @can('permission.edit')
                                                    <x-actions.edit :route="route('permission.edit',$permission['id'])" ></x-actions.edit>                           
                                                @endcan
                                                @can('permission.delete')
                                                    <x-actions.delete :route="route('permission.delete',$permission['id'])" ></x-actions.delete>
                                                @endcan
                                            </x-table.td>
                                        </tr>
                                @endforeach
                            </x-slot>
                        </x-table.card.body>
                        <!--end::Body-->
                    </div>
                </div>
            </div>
        <!--end:::Main-->
    </x-slot>
    <x-slot name="footer">
        <x-layout.footer/>
    </x-slot>
</x-layout.master>
