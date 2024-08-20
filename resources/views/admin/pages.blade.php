@extends("admin_base")
@section("stylesheet")
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css">
@endsection
@section("title") Pages @endsection
@section("content")
<div class="row">
<div class="col-12">
<h5 class="text-dark border-bottom">Pages</h5>
</div>
<div class="col-12 d-flex justify-content-end mb-3">
<button type="button" class="btn btn-dark" data-toggle="modal" data-target="#create_modal"><i class="fas fa-plus"></i> Create New Page</button>
</div>
<div class="col-12 mb-3">
<form method="GET">
@csrf
    <div class="input-group">
        <input type="text" class="form-control py-4" name="search" id="search_field" placeholder="Search pages by name..." required>
        <div class="input-group-prepend">
            <button type="submit" class="input-group-text bg-light"><i class="fas fa-search"></i></button>
        </div>
    </div>
    <a href="{{ route('admin_pages') }}" class="text-muted d-none" id="reset_btn"><small>reset</small></a>
</form>
</div>
<div class="col-md-6 mx-auto">
<ul class="list-group">
    @forelse ($pages as $page)
        <li class="list-group-item d-flex justify-content-between cursor_pointer" data-toggle="modal" data-target="#edit_modal" data-id="{{ $page->id }}" data-content="{{ $page->content }}" data-position="{{ $page->position }}">
          <span>{{ $page->name }}</span>
          <small title="position">
            @if($page->position == 'left')
              <i class="fas fa-circle fa-sm text-danger"></i>
              <i class="fas fa-circle fa-sm text-muted"></i>
            @elseif($page->position == 'right')
              <i class="fas fa-circle fa-sm text-muted"></i>
              <i class="fas fa-circle fa-sm text-danger"></i>
            @endif
          </small>
        </li>
    @empty
        <li class="list-group-item text-center text-muted">no page created yet!</li>
    @endforelse
</ul>
</div>
</div>

<!-- create -->
<div class="modal fade" id="create_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create New Page</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <form action="{{ route('admin_pages_add') }}" method="POST">
    @csrf
      <div class="modal-body bg-light">
        <label for="name" class="text-dark mb-0">Page title</label>
        <input type="text" name="name" class="form-control mb-3" id="name" required>
        <label for="content" class="text-dark mb-0">Write page content</label>
        <textarea name="content" id="content" required></textarea>
        <div>Categorize the page</div>
        <div class="custom-control custom-radio custom-control-inline">
          <input type="radio" id="left" name="position" class="custom-control-input" value="left">
          <label class="custom-control-label" for="left">Left</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
          <input type="radio" id="right" name="position" class="custom-control-input" value="right">
          <label class="custom-control-label" for="right">Right</label>
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-between p-0">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Publish Now</button>
      </div>
    </form>
    </div>
  </div>
</div>
<!-- edit -->
<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title edit_modal_title"></h5>
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin_pages_edit') }}" method="POST">
        @csrf
        <div class="modal-body bg-light">
          <label for="edit_name" class="text-dark mb-0">Page title</label>
          <input type="text" name="name" class="form-control mb-3" id="edit_name" required>
          <label for="content" class="text-dark mb-0">Write page content</label>
          <textarea name="content" id="edit_content" required></textarea>
          <div>Categorize the page</div>
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="position_left" name="position" class="custom-control-input" value="left">
            <label class="custom-control-label" for="position_left">Left</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="position_right" name="position" class="custom-control-input" value="right">
            <label class="custom-control-label" for="position_right">Right</label>
          </div>
          <input type="hidden" name="id" id="edit_id">
        </div>
        <div class="modal-footer d-flex justify-content-between p-0">
          <button type="button" class="btn btn-danger" id="delete_page_btn">Delete</button>
          <button type="submit" class="btn btn-success">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<form action="{{ route('admin_pages_delete') }}" method="POST" id="delete_form">
@csrf
<input type="hidden" name="id" id="delete_id">
</form>
@endsection
@section("script")
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
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

$('#content').summernote({
  tabsize: 2,
  height: 250
});

$('#edit_content').summernote({
  tabsize: 2,
  height: 250
});

$('#edit_modal').on('show.bs.modal', function (event) {
  let button = $(event.relatedTarget);
  let id = button.data('id');
  let name = button.text();
  let content = button.data('content');
  let position = button.data('position');
  let modal = $(this);
  modal.find('#edit_modal_title').text(name);
  modal.find('#edit_name').val(name);
  modal.find('#edit_content').summernote('code', content);
  modal.find('#edit_id').val(id);
  $('#delete_id').val(id);
  modal.find(`input[name="position"][value="${position}"]`).prop('checked', true);
});

$('#delete_page_btn').click(function(){
  $('#delete_form').submit();
});
</script>
@endsection