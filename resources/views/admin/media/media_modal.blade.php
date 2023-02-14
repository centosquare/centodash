<div id="mediaModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header align-items-stretch">
                <h5 class="modal-title flex-grow-1">Upload From Media Library</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    @foreach ($images as $image)
                        <div class="col-sm-3 shadow-lg" id="file-manager">
                            <div class="card clickble cursor-pointer">
                                <img class="card-img p-3 image-collection img-responsive" style="height:30vh"
                                    data-bs-dismiss="modal" src="{{ asset($image->getUrl()) }}" alt="Card image"
                                    data-image-id="{{ $image->id }}">
                                <div class="card-footer text-center">
                                    <small>{{ $image['mime_type'] }}</small><br> <small
                                        class="text-muted">{{ $image['created_at'] }}</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.querySelectorAll(".image-collection").forEach(function(image) {
        image.addEventListener("click", function() {
            var selectedImageId = this.getAttribute("data-image-id");
            $.ajax({
                url: '/file/get-image/' + selectedImageId,
                type: 'GET',
                success: function(data) {
                    var file = {
                        name: "selected-image.jpg",
                        size: 12345
                    };
                    myDropzone.emit("addedfile", file);
                    myDropzone.emit("thumbnail", file, data.image_url);
                    myDropzone.emit("complete", file);
                }
            });
        });
    });
</script>
