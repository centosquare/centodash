<!--begin::Input group-->
<div class="fv-row">
    <!--begin::Dropzone-->
    <div class="needsclick dropzone" id="kt_dropzonejs_example_2">
        <!--begin::Message-->
        <div class="dz-message needsclick ">
            <!--begin::Icon-->
            <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
            <!--end::Icon-->

            <!--begin::Info-->
            <div class="ms-4">
                <h3 class="fs-5 fw-bold text-gray-900 mb-1">Drop files here or click to upload.</h3>
                <span class="fs-7 fw-semibold text-gray-400">Upload up to 10 files</span>
            </div>
            <!--end::Info-->
        </div>
    </div>
    <!--end::Dropzone-->
    <a type="button" data-bs-toggle="modal" data-bs-target="#mediaModal"
        class="btn btn-primary m-3 btn-sm float-right mt-1">Select from Media Library</a>
    @include('admin.media.media_modal')
</div>
@section('scripts')
    <script type="text/javascript">
        var myDropzone = new Dropzone("#kt_dropzonejs_example_2", {
            url: '{{ route('file.upload') }}',
            maxFilesize: 2, // MB
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function(file, response) {
                $('form').append('<input type="hidden" name="image[]" value="' + response
                    .name +
                    '">')
                uploadedDocumentMap[file.name] = response.name
            },
            removedfile: function(file) {
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedDocumentMap[file.name]
                }
                $('form').find('input[name="image[]"][value="' + name + '"]').remove()
            },
            init: function() {
                @if (isset($file) && $file->image)
                    var files =
                        {!! json_encode($file->image) !!}
                    for (var i in files) {
                        var file = files[i]
                        this.options.addedfile.call(this, file)
                        file.previewElement.classList.add('dz-complete')
                        $('form').append('<input type="hidden" name="image[]"  value="' +
                            file
                            .file_name +
                            '">')
                    }
                @endif
            }
        });
    </script>
@endsection
