@extends("admin_base")
@section("title") Blogs List @endsection
@section("style")
<style>
img.thumbnail_img{
    height: 40px;
}
</style>
@endsection
@section("content")
<div class="row">
<div class="col-12">
<h5 class="text-dark border-bottom">Blogs/List</h5>
</div>
<div class="col-12 mb-3">
<form method="GET">
@csrf
    <div class="input-group">
        <input type="text" class="form-control py-4" name="search" id="search_field" placeholder="Search users by title or tags..." required>
        <div class="input-group-prepend">
            <button type="submit" class="input-group-text bg-light"><i class="fas fa-search"></i></button>
        </div>
    </div>
    <a href="{{ route('admin_blogs_list') }}" class="text-muted d-none" id="reset_btn"><small>reset</small></a>
</form>
</div>
<div class="col-12">
<div class="card card-body p-0">
<table class="table table-bordered table-striped text-center">
<thead class="bg-dark">
    <tr>
        <th>#</th>
        <th>Thumbnail</th>
        <th>Ttile</th>
        <th>Publish Date</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
@forelse ($blogs as $blog)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td><img src="{{ Storage::url($blog->thumbnail) }}" class="img-fluid rounded thumbnail_img"></td>
        <td>{{ Str::limit($blog->title, 50) }}</td>
        <td>{{ \Carbon\Carbon::parse($blog->publish_date)->format('M d, Y') }}</td>
        <td>
            <a class="btn btn-secondary btn-sm" href="{{ route('blogs_details', ['article' => $blog->slug]) }}" target="_blank"><i class="fas fa-eye"></i></a>
            <a class="btn btn-info btn-sm" href="{{ route('admin_blogs_edit', ['id' => $blog->id]) }}" class="mx-2"><i class="fas fa-edit"></i></a>
            <button type="button" class="btn btn-danger btn-sm delete_blog_btn" data-toggle="modal" data-target="#delete_blog_modal" data-id="{{ $blog->id }}"><i class="fas fa-trash"></i></button>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5">no post found!</td>
    </tr>
@endforelse
</tbody>
</table>
</div>

<div class="modal fade" id="delete_blog_modal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger"><i class="fas fa-exclamation-triangle"></i> Delete This Post</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body bg-light">
        Are you sure? do you really want to delete this post?
      </div>
      <div class="modal-footer d-flex justify-content-between p-0">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <form action="{{ route('admin_blogs_delete') }}" method="POST">
            @csrf
            <input type="hidden" name="id" id="blog_id">
            <button type="submit" class="btn btn-danger">Confirm</button>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
<div class="col-12 d-flex justify-content-between align-items-baseline py-4">
<small class="text-dark">Showing {{ $blogs->firstItem() }} to {{ $blogs->lastItem() }} of {{ $blogs->total() }} results</small>
{{ $blogs->links("partial.pagination") }}
</div>
</div>
@endsection
@section("script")
<script>
$(document).ready(function(){
    $(".delete_blog_btn").click(function(){
      $("#blog_id").val($(this).data("id"));
    });
});
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
</script>
@endsection