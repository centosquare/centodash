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
                                <span class="card-label fw-bold fs-3 mb-1" style="user-select: auto;">All Users</span>
                            </h3>
                            <div class="d-grid gap-2 align-items-center py-1">
                                @can('user.create')
                                    <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary">Add New User</a>
                                @endcan
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body pt-3" style="user-select: auto;">
                            <!--begin::Table container-->
                            {{-- <div class="table-responsive" style="user-select: auto;">
                                <!--begin::Table-->
                                <table
                                    class="table table-bordered table-hover table-row-dashed table-row-gray-300 align-middle gs-0 gy-4"
                                    style="user-select: auto;">
                                    <!--begin::Table head-->
                                    <thead style="user-select: auto;">
                                        <tr class="border-1" style="user-select: auto;">
                                            <th class="p-0 min-w-150px fw-semibold" style="user-select: auto;">User Name</th>
                                            <th class="p-0 min-w-150px fw-semibold" style="user-select: auto;">Email</th>
                                            <th class="p-0 min-w-150px fw-semibold" style="user-select: auto;">Picture</th>
                                            <th class="p-0 min-w-150px fw-semibold" style="user-select: auto;">Roles</th>
                                            @can('user.edit','user.delete')
                                                <th class="p-0 min-w-100px fw-semibold" style="user-select: auto;">Action</th>
                                            @endcan
                                        </tr>
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody style="user-select: auto;">
                                        @foreach ($users as $user)
                                            <tr style="user-select: auto;">
                                                <td class="fw-semibold"style="user-select: auto;">{{ $user['name'] }}</td>
                                                <td>{{ $user['email'] }}</td>
                                                <td class="fw-semibold"style="user-select: auto;"><img src={{ asset($user['avatar']) }} class="image-input-wrapper rounded-circle w-50px h-50px" alt="alt text"></td>
                                                <td>
                                                    @foreach ($user->roles as $role)
                                                        <?php echo $role->name ."<br>" ?>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @can('user.edit')
                                                        <a href="{{  route('user.edit',$user['id']) }}" class="btn btn-icon btn-success btn-sm">
                                                            <i class="bi bi-pencil fs-4"></i>
                                                        </a>
                                                    @endcan
                                                    @can('user.delete')
                                                        <a href="{{  route('user.delete',$user['id']) }}" class="btn btn-icon btn-danger btn-sm">
                                                            <i class="bi bi-trash fs-4"></i>
                                                        </a>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody> --}}

                                    <!--end::Table body-->
                                    <x-table.card.body :headers="['User Name','Email','Picture','Roles','Action']">
                                        <x-slot name="tr">
                                            @foreach ($users as $user)
                                                <tr>
                                                    <x-table.td :value="$user['name']"/>
                                                    <x-table.td :value="$user['email']"/>
                                                    {{-- <x-table.td><img src={{ asset($user['avatar']) }} class="image-input-wrapper rounded-circle w-50px h-50px" alt="alt text"><x-table.td/> --}}
                                                    <x-table.td>
                                                        @foreach ($user->roles as $role)
                                                            <?php echo $role->name ."<br>" ?>
                                                        @endforeach
                                                    </x-table.td>
                                                    <x-table.td>
                                                        @can('user.edit')
                                                            <x-actions.edit :route="route('user.edit',$user['id'])"></x-actions.edit>
                                                        @endcan
                                                        @can('user.delete')
                                                            <x-actions.delete :route="route('user.delete',$user['id'])"></x-actions.delete>
                                                        @endcan
                                                    </x-table.td>
                                                </tr>
                                            @endforeach
                                        </x-slot>
                                    </x-table.card.body>
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table container-->
                        </div>
                        <!--begin::Body-->
                    </div>
                </div>
            </div>
        <!--end:::Main-->
    </x-slot>
    <x-slot name="footer">
        <x-layout.footer/>
    </x-slot>
</x-layout.master>
