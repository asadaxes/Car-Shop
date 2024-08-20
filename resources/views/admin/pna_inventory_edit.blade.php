@extends("admin_base")
@section("stylesheet")
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css">
@endsection
@section("title") Parts/Accessories Edit Product @endsection
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
<h5 class="text-dark border-bottom"><a href="{{ route('admin_pna_inventory') }}" class="text-muted">Parts/Accessories Inventory</a>/Edit Product: {{ $product->id }}</h5>
</div>
<div class="col-12">
<div class="card card-body">
<form action="{{ route('admin_pna_inventory_edit_handler') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="title" class="text-dark mb-0">Product Title</label>
        <input type="text" name="title" class="form-control mb-3" id="title" min="10" max="150" value="{{ $product->title }}" required>
        <label for="description" class="text-dark mb-0">Product Description</label>
        <textarea name="description" class="form-control mb-3" id="description">{{ $product->description }}</textarea>
        <label for="tags" class="text-dark mb-0">Tags <span class="text-muted">(separate by comma)</span></label>
        <input type="text" name="tags" class="form-control" id="tags" placeholder="eg: tag1, tag2, tag3..." value="{{ implode(', ', json_decode($product->tags)) }}" required>
    </div>
    <div class="col-md-6 mb-3">
    <div class="row">
    <div class="col-md-6 mb-3">
        <label for="type" class="text-dark mb-0">Select Type</label>
        <select name="type" class="custom-select" id="type" required>
            <option selected disabled>-- select --</option>
            <option value="Parts" {{ $product->type === 'Parts' ? 'selected' : '' }}>Parts</option>
            <option value="Accessories" {{ $product->type === 'Accessories' ? 'selected' : '' }}>Accessories</option>
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="quantity" class="text-dark mb-0">Quantity</label>
        <input type="number" name="quantity" class="form-control mb-3" id="quantity" min="1" value="{{ $product->quantity }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="brand" class="text-dark mb-0">Select Brand</label>
        <select name="brand_id" class="custom-select" id="brand" required>
            <option selected disabled>-- select --</option>
            @foreach ($pna_brands as $brand)
                <option value="{{ $brand->id }}" {{ ($brand->name === $product->brand->name) ? "selected" : "" }}>{{ $brand->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="category" class="text-dark mb-0">Select Category</label>
        <select name="category_id" class="custom-select" id="category" required>
            <option selected disabled>-- select --</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ ($category->name === $product->category->name) ? "selected" : "" }}>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="regular_price" class="text-dark mb-0">Regular Price</label>
        <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">BDT</span>
            </div>
            <input type="number" name="regular_price" class="form-control" id="regular_price" value="{{ $product->regular_price }}">
        </div>
    </div>
    <div class="col-md-6 mb-2">
        <label for="sale_price" class="text-dark mb-0">Sale Price</label>
        <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">BDT</span>
            </div>
            <input type="number" name="sale_price" class="form-control" id="sale_price" value="{{ $product->sale_price }}" required>
        </div>
    </div>
    <div class="col-md-4 mb-2">
        <input type="checkbox" name="has_warranty" id="has_warranty" {{ $product->has_warranty ? 'checked' : '' }}>
        <label for="has_warranty" class="text-dark mb-0">Provide Warranty</label>
    </div>
    </div>
    <div class="col-12">
        <hr class="mt-0 mb-2">
    </div>
    <div class="col-12">
        <label for="meta_title" class="text-dark mb-0">Meta Title</label>
        <input type="text" name="meta_title" class="form-control mb-3" id="meta_title" min="10" max="150" value="{{ $product->meta_title }}" required>
        <label for="meta_description" class="text-dark mb-0">Meta Description</label>
        <textarea name="meta_description" class="form-control" id="meta_description" rows="3">{{ $product->meta_description }}</textarea>
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
            <input type="hidden" name="images" class="images-data" value="{{ $product->images }}">
            <ul class="list-group list-group-numbered image-previews">
                @php
                    $images = json_decode($product->images, true);
                @endphp
                @foreach($images as $image)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>{{ $loop->iteration }}.</span>
                    <img src="{{ Storage::url($image) }}" class="product_images_preview rounded">
                    <i class="fas fa-trash-alt fa-lg text-danger cursor_pointer remove-image"></i>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    </div>
    <input type="hidden" name="id" value="{{ $product->id }}">
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

    let imageDataArray = @json(json_decode($product->images, true));
    $('#images').change(async function() {
        let existingImagesCount = $('.image-previews li').length;
        for (let index = 0; index < this.files.length; index++) {
            const file = this.files[index];
            const reader = new FileReader();
            await new Promise((resolve, reject) => {
                reader.onload = function(event) {
                    $('.image-previews').append('<li class="list-group-item d-flex justify-content-between align-items-center">' +
                        '<span>'+ (existingImagesCount + index + 1) +'.</span>' +
                        '<img src="' + event.target.result + '" class="product_images_preview rounded">' +
                        '<i class="fas fa-trash-alt fa-lg text-danger cursor_pointer remove-image"></i>' +
                        '</li>');
                    imageDataArray.push(event.target.result);
                    $('.images-data').val(JSON.stringify(imageDataArray));
                    resolve();
                };
                reader.onerror = function(error) {
                    reject(error);
                };
                reader.readAsDataURL(file);
            });
        }
    });
    $(document).on('click', '.remove-image', function() {
        let imageIndex = $(this).parent().index();
        imageDataArray.splice(imageIndex, 1);
        $('.images-data').val(JSON.stringify(imageDataArray));
        $(this).parent().remove();
    });
});
</script>
@endsection