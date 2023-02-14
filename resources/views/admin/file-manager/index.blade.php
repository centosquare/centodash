<x-layout.master>
    <x-slot name="header">
        <x-layout.header />
    </x-slot>
    <x-slot name="left_side_nav">
        <x-layout.left_side_nav />
    </x-slot>
    <x-slot name="content">
        <!--begin::Main-->
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <h1>File Manager</h1>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form action="{{ route('file.store') }}" method="file" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="name" id="">
                            @include('admin.media.dropdown')
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>
</x-layout.master>
