<x-layout.master>
    <x-slot name="header">
        <x-layout.header />
    </x-slot>
    <x-slot name="left_side_nav">
        <x-layout.left_side_nav />
    </x-slot>
    <x-slot name="content">
        <!--begin::Main-->
        
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
            <form action="{{ route('createLanguage') }}" method="POST">
                @csrf
                <div class="p-5">
                    <div class="card mb-5 mb-xl-8" style="user-select: auto;">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5" style="user-select: auto;">
                            <h3 class="card-title align-items-start flex-column" style="user-select: auto;">
                                <span class="card-label fw-bold fs-3 mb-1" style="user-select: auto;">Add
                                    Language</span>
                            </h3>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body pt-3" style="user-select: auto;">
                            <!--begin::Table container-->
                            <div class="modal-body">
                                <!--begin::Label-->
                                <!--end::Label-->
                                <div class="row">
                                    <x-cento-dash-input type="text" name="name" label="Language"
                                        placeholder="Enter Language" :message="$errors->first('name')" />
                                    <x-cento-dash-input type="text" name="code" label="Code"
                                        placeholder="Enter Code" :message="$errors->first('code')" />
                                </div>
                            </div>
                            <div class="modal-footer gap-2">
                                <x-cento-dash-input type="submit" label="Add Lanuage" />
                                <a class="btn btn-light-danger" href={{ route('languages') }}> Cancel </a>
                            </div>
                            <!--end::Table container-->
                        </div>
                        <!--begin::Body-->
                    </div>
                </div>
            </form>
        </div>
        <!--end:::Main-->
    </x-slot>
    <x-slot name="footer">
        <x-layout.footer />
    </x-slot>
</x-layout.master>
