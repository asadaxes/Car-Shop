@extends("admin_base")
@section("title") Parts/Accessories Category @endsection
@section("content")
<div class="row">
<div class="col-12">
<h5 class="text-dark border-bottom">Parts/Accessories Category</h5>
</div>
<div class="col-12 d-flex justify-content-end mb-3">
<button type="button" class="btn btn-dark" data-toggle="modal" data-target="#add_category_modal"><i class="fas fa-plus"></i> Add New Category</button>
</div>
<div class="col-12 mb-3">
<form method="GET">
    <div class="input-group">
        <input type="text" class="form-control py-4" name="search" id="search_field" placeholder="Search by category names..." required>
        <div class="input-group-prepend">
            <button type="submit" class="input-group-text bg-light"><i class="fas fa-search"></i></button>
        </div>
    </div>
    <a href="{{ route('admin_pna_categories') }}" class="text-muted d-none" id="reset_btn"><small>reset</small></a>
</form>
</div>
<div class="col-12 border-top pt-3">
@if(!empty($categories))
<div class="card card-body p-0">
<table class="table table-bordered text-center">
<thead class="bg-dark">
  <tr>
    <th>#</th>
    <th>Name</th>
    <th>Remove</th>
  </tr>
</thead>
<tbody>
@foreach($categories as $category)
<tr>
  <td>{{ $loop->iteration }}</td>
  <td>{{ $category->name }}</td>
  <td><button type="button" class="btn btn-danger btn-sm cursor_pointer" data-toggle="modal" data-target="#category_remove_modal" data-id="{{ $category->id }}" data-name="{{ $category->name }}"><i class="fas fa-trash"></i></button></td>
</tr>
@endforeach
</tbody>
</table>
</div>
@endif
</div>
<div class="col-12 d-flex justify-content-between align-items-baseline py-4">
<small class="text-dark">Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }} results</small>
{{ $categories->links("partial.pagination") }}
</div>
</div>

<!-- add category modal -->
<div class="modal fade" id="add_category_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin_pna_categories_add') }}" method="POST">
        @csrf
        <div class="modal-body bg-light">
        <label for="name" class="mb-0">Category Name</label>
        <input type="text" name="name" class="form-control" id="name" required>
        </div>
        <div class="modal-footer d-flex justify-content-between p-0">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- remove category modal -->
<div class="modal fade" id="category_remove_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-body bg-light text-center">
            <h4 class="text-danger">Are you sure?</h4>
            <div class="d-flex justify-content-center">
              <h6 id="category_remove_modal_name" class="text-dark mb-0"></h6>
              <i class="fa-solid fa-recycle text-info mx-2"></i>
              <i class="fa-solid fa-equals text-muted mr-2"></i>
              <i class="fa-solid fa-trash-can text-danger"></i>
            </div>
        </div>
        <div class="modal-footer d-flex justify-content-between p-0">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <form action="{{ route('admin_pna_categories_remove') }}" method="POST">
                @csrf
                <input type="hidden" name="id" id="category_remove_modal_id">
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

$('#category_remove_modal').on('show.bs.modal', function (event) {
  let button = $(event.relatedTarget);
  let id = button.data('id');
  let name = button.data('name');
  let modal = $(this);
  modal.find('#category_remove_modal_name').text(name);
  modal.find('#category_remove_modal_id').val(id);
});
</script>
@endsection