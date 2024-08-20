@extends("admin_base")
@section("stylesheet")
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css">
@endsection
@section("title") Edit Blog Post @endsection
@section("style")
<style>
img.preview_img{
    width: 400px;
}
</style>
@endsection
@section("content")
<div class="row">
<div class="col-12 mb-2">
<h5 class="text-dark border-bottom">Blogs/Edit Post: {{ $blog->title }}</h5>
</div>
<div class="col-12">
<div class="card card-body">
<form action="{{ route('admin_blogs_edit_handler') }}" method="POST" enctype="multipart/form-data">
@csrf
<input type="hidden" name="id" value="{{ $blog->id }}">
<div class="row">
<div class="col-12 mb-3">
<div class="d-flex flex-column align-items-center">
<img src="{{ Storage::url($blog->thumbnail) }}" class="img-fluid rounded preview_img mb-3">
<input type="file" name="thumbnail" id="thumbnail">
</div>
</div>
<div class="col-12 mb-3">
    <label for="title" class="text-dark mb-0">Write a caption for your post</label>
    <input type="text" name="title" class="form-control" id="title" value="{{ $blog->title }}" required>
</div>
<div class="col-12 mb-3">
    <label for="content" class="text-dark mb-0">Content</label>
    <textarea name="content" class="form-control" id="content" required>{!! $blog->content !!}</textarea>
</div>
<div class="col-12 mb-3">
    <label for="tags" class="text-dark mb-0">Add some tags <span class="text-muted">(separate by comma)</span></label>
    <input type="text" name="tags" class="form-control" id="tags" placeholder="eg: tag1, tag2, tag3..." value="{{ implode(', ', json_decode($blog->tags)) }}" required>
</div>
<div class="col-12 text-center">
    <button type="submit" class="btn btn-success">Publish Now</button>
</div>
</div>
</form>
</div>
</div>
</div>
@endsection
@section("script")
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
$(document).ready(function() {
    const thumbnail = $('#thumbnail');
    const preview_img = $('.preview_img');

    thumbnail.on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview_img.attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

    $('#content').summernote({
        tabsize: 2,
        height: 200
    });
});
</script>
@endsection