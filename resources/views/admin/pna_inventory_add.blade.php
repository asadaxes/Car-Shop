@extends("admin_base")
@section("stylesheet")
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css">
@endsection
@section("title") Parts/Accessories Add New Product @endsection
@section("style")
<style>
img.product_images_preview{
    width: 125px;
}
</style>
@endsection
@section("content")
<div class="row">
<div class="col-12 mb-2">
<h5 class="text-dark border-bottom"><a href="{{ route('admin_pna_inventory') }}" class="text-muted">Parts/Accessories Inventory</a>/Add New Product</h5>
</div>
<div class="col-12">
<div class="card card-body">
<form action="{{ route('admin_pna_inventory_add_handler') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="title" class="text-dark mb-0">Product Title</label>
        <input type="text" name="title" class="form-control mb-3" id="title" min="10" max="150" required>
        <label for="description" class="text-dark mb-0">Product Description</label>
        <textarea name="description" class="form-control mb-3" id="description"></textarea>
        <label for="tags" class="text-dark mb-0">Tags <span class="text-muted">(separate by comma)</span></label>
        <input type="text" name="tags" class="form-control" id="tags" placeholder="eg: tag1, tag2, tag3..." required>
    </div>
    <div class="col-md-6 mb-3">
    <div class="row">
    <div class="col-md-6 mb-3">
        <label for="type" class="text-dark mb-0">Select Type</label>
        <select name="type" class="custom-select" id="type" required>
            <option selected disabled>-- select --</option>
            <option value="Parts">Parts</option>
            <option value="Accessories">Accessories</option>
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="quantity" class="text-dark mb-0">Quantity</label>
        <input type="number" name="quantity" class="form-control mb-3" id="quantity" min="1" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="brand" class="text-dark mb-0">Select Brand</label>
        <select name="brand_id" class="custom-select" id="brand" required>
            <option selected disabled>-- select --</option>
            @foreach ($pna_brands as $brand)
                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="category" class="text-dark mb-0">Select Category</label>
        <select name="category_id" class="custom-select" id="category" required>
            <option selected disabled>-- select --</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="regular_price" class="text-dark mb-0">Regular Price</label>
        <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">BDT</span>
            </div>
            <input type="number" name="regular_price" class="form-control" id="regular_price">
        </div>
    </div>
    <div class="col-md-6 mb-2">
        <label for="sale_price" class="text-dark mb-0">Sale Price</label>
        <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">BDT</span>
            </div>
            <input type="number" name="sale_price" class="form-control" id="sale_price" required>
        </div>
    </div>
    <div class="col-md-4 mb-2">
        <input type="checkbox" name="has_warranty" id="has_warranty">
        <label for="has_warranty" class="text-dark mb-0">Provide Warranty</label>
    </div>
    </div>
    <div class="col-12">
        <hr class="mt-0 mb-2">
    </div>
    <div class="col-12">
        <label for="meta_title" class="text-dark mb-0">Meta Title</label>
        <input type="text" name="meta_title" class="form-control mb-3" id="meta_title" min="10" max="150" required>
        <label for="meta_description" class="text-dark mb-0">Meta Description</label>
        <textarea name="meta_description" class="form-control" id="meta_description" rows="3"></textarea>
    </div>
    </div>
    <div class="col-12">
        <hr class="my-2">
    </div>
    <div class="col-12 mb-3">
    <div class="row">
        <div class="col-md-6 d-flex flex-column justify-content-center align-items-center mb-md-0 mb-3">
            <label for="images">Select product images</label>
            <input type="file" id="images" accept=".png, .jpg, .jpeg" multiple>
        </div>
        <div class="col-md-6">
            <input type="hidden" name="images" class="images-data">
            <ul class="list-group list-group-numbered image-previews">
            </ul>
        </div>
    </div>
    </div>
    <div class="col-12 text-center">
        <button type="submit" class="btn btn-primary">Publish Now</button>
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
    $('#description').summernote({
        tabsize: 2,
        height: 250
    });

    $('#images').change(function() {
        let imageDataArray = [];
        $.each(this.files, function(index, file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                $('.image-previews').append('<li class="list-group-item d-flex justify-content-between align-items-center">' +
                    '<div><img src="' + event.target.result + '" class="product_images_preview rounded"></div>' +
                    '<i class="fas fa-circle-minus fa-lg text-danger cursor_pointer remove-image"></i>' +
                    '</li>');
                imageDataArray.push(event.target.result);
                $('.images-data').val(JSON.stringify(imageDataArray));
            };
            reader.readAsDataURL(file);
        });
    });
    $(document).on('click', '.remove-image', function() {
        let imageIndex = $(this).parent().index();
        let imageDataArray = JSON.parse($('.images-data').val() || '[]');
        imageDataArray.splice(imageIndex, 1);
        $('.images-data').val(JSON.stringify(imageDataArray));
        $(this).parent().remove();
    });
});
</script>
@endsection