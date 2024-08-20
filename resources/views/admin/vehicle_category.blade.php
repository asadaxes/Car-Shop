@extends("admin_base")
@section("title") Vehicle Categories @endsection
@section("style")
<style>

</style>
@endsection
@section("content")
<div class="row">
<div class="col-12">
<h5 class="text-dark border-bottom">Vehicles Categories</h5>
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
    <a href="{{ route('admin_vehicle_category') }}" class="text-muted d-none" id="reset_btn"><small>reset</small></a>
</form>
</div>
<div class="col-12 border-top pt-3">
<table class="table table-striped table-bordered text-center">
    <thead class="bg-dark">
        <tr>
            <th>#</th>
            <th>Category</th>
            <th>Total Vehicles</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($categories as $category)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $category->title }}</td>
                <td>{{ $category->vehicles->count() }}</td>
                <td>
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit_category_modal" data-id="{{ $category->id }}" data-title="{{ $category->title }}"><i class="fas fa-edit"></i></button>
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete_category_modal" data-id="{{ $category->id }}"><i class="fas fa-trash-alt"></i></button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center text-muted">no categories found!</td>
            </tr>
        @endforelse
    </tbody>
</table>
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
      <form action="{{ route('admin_vehicle_category_add') }}" method="POST">
        @csrf
        <div class="modal-body bg-light">
            <label for="title" class="mb-0">Category Name</label>
            <input type="text" name="title" class="form-control" id="title" required>
        </div>
        <div class="modal-footer d-flex justify-content-between p-0">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- edit category modal -->
<div class="modal fade" id="edit_category_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin_vehicle_category_edit') }}" method="POST">
        @csrf
        <div class="modal-body bg-light">
            <label for="title" class="mb-0">Category Name</label>
            <input type="text" name="title" class="form-control" id="cat_title" required>
            <input type="hidden" name="id" id="cat_id">
        </div>
        <div class="modal-footer d-flex justify-content-between p-0">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- delete category modal -->
<div class="modal fade" id="delete_category_modal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger"><i class="fas fa-exclamation-triangle"></i> Delete This Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body bg-light">
        Are you sure? do you really want to delete this category?
      </div>
      <div class="modal-footer d-flex justify-content-between p-0">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <form action="{{ route('admin_vehicle_category_delete') }}" method="POST">
            @csrf
            <input type="hidden" name="id" id="category_id">
            <button type="submit" class="btn btn-danger">Confirm</button>
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
$('#edit_category_modal').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget);
    let id = button.data('id');
    let title = button.data('title');
    let modal = $(this);
    modal.find('#cat_title').val(title);
    modal.find('#cat_id').val(id);
});
$('#delete_category_modal').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget);
    let id = button.data('id');
    let modal = $(this);
    modal.find('#category_id').val(id);
});
</script>
@endsection