@extends("admin_base")
@section("title") Brands @endsection
@section("style")
<style>
img.brand_logo_img{
    width: 100px;
    height: 100px;
    margin-bottom: 5px;
}
</style>
@endsection
@section("content")
<div class="row">
<div class="col-12">
<h5 class="text-dark border-bottom">Brands Management</h5>
</div>
<div class="col-12 d-flex justify-content-end mb-3">
<button type="button" class="btn btn-dark" data-toggle="modal" data-target="#add_brand_modal"><i class="fas fa-plus"></i> Add New Brand</button>
</div>
<div class="col-12 mb-3">
<form method="GET">
    <div class="input-group">
        <input type="text" class="form-control py-4" name="search" id="search_field" placeholder="Search by brand names..." required>
        <div class="input-group-prepend">
            <button type="submit" class="input-group-text bg-light"><i class="fas fa-search"></i></button>
        </div>
    </div>
    <a href="{{ route('admin_brands') }}" class="text-muted d-none" id="reset_btn"><small>reset</small></a>
</form>
</div>
<div class="col-12 border-top pt-3">
@if(!empty($brands_data))
<div class="row">
@foreach($brands_data as $brand)
<div class="col-md-2 col-6">
    <div class="card card-body d-flex flex-column align-items-center cursor_pointer" data-toggle="modal" data-target="#brand_view_modal" data-id="{{ $brand->id }}" data-name="{{ $brand->name }}" data-logo="{{ $brand->logo }}">
        <img src="{{ Storage::url($brand->logo) }}" class="brand_logo_img">
        <span class="text-dark">{{ $brand->name }}</span>
    </div>
</div>
@endforeach
</div>
@endif
</div>
<div class="col-12 d-flex justify-content-between align-items-baseline py-4">
<small class="text-dark">Showing {{ $brands_data->firstItem() }} to {{ $brands_data->lastItem() }} of {{ $brands_data->total() }} results</small>
{{ $brands_data->links("partial.pagination") }}
</div>
</div>

<!-- add brand modal -->
<div class="modal fade" id="add_brand_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Brand</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin_brands_add') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body bg-light">
        <div class="text-center mb-2">
            <img src="{{ asset('admin/assets/placeholder_img.jpg') }}" class="img-fluid border rounded" id="brand_logo_preview" width="150px">
        </div>
        <div class="input-group mb-3">
            <div class="custom-file">
                <input type="file" name="logo" class="custom-file-input" id="brand_logo" onchange="previewLogo(this)">
                <label class="custom-file-label" for="brand_logo">Choose file</label>
            </div>
        </div>
        <label for="brand_name" class="mb-0">Brand Name</label>
        <input type="text" name="name" class="form-control" id="brand_name" required>
        </div>
        <div class="modal-footer d-flex justify-content-between p-0">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- view brand modal -->
<div class="modal fade" id="brand_view_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-body bg-light text-center">
            <img id="brand_view_modal_img" class="img-fluid" width="200px">
            <h6 id="brand_view_modal_name" class="mb-0"></h6>
        </div>
        <div class="modal-footer d-flex justify-content-between p-0">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <form action="{{ route('admin_brands_remove') }}" method="POST">
                @csrf
                <input type="hidden" name="id" id="brand_view_modal_id">
                <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Delete it</button>
            </form>
        </div>
    </div>
  </div>
</div>
@endsection
@section("script")
<script>
function getSearchTermFromUrl() {
  let urlParams = new URLSearchParams(window.location.search);
    return urlParams.get('search') || '';
}
window.onload = function() {
  document.getElementById('search_field').value = getSearchTermFromUrl();
  if(getSearchTermFromUrl()){
    document.getElementById('reset_btn').classList.remove('d-none');
  }
};
function previewLogo(input) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('brand_logo_preview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$('#brand_view_modal').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget);
    let id = button.data('id');
    let name = button.data('name');
    let logo = button.data('logo');
    let modal = $(this);
    modal.find('#brand_view_modal_img').attr('src', "{{ Storage::url('') }}" + logo);
    modal.find('#brand_view_modal_name').text(name);
    modal.find('#brand_view_modal_id').val(id);
});
</script>
@endsection