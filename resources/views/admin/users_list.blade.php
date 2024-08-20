@extends("admin_base")
@section("title") Users List @endsection
@section("style")
<style>
.avatar_img{
  width: 40px;
  height: 40px;
  border-radius: 50%;   
}
</style>
@endsection
@section("content")
<div class="row">
<div class="col-12">
<h5 class="text-dark border-bottom">Users/List</h5>
</div>
<div class="col-12 mb-3">
<form method="GET">
@csrf
    <div class="input-group">
        <input type="text" class="form-control py-4" name="search" id="search_field" placeholder="Search users by full name, email, phone, whatsapp no, gender, country, city, state or zip code..." required>
        <div class="input-group-prepend">
            <button type="submit" class="input-group-text bg-light"><i class="fas fa-search"></i></button>
        </div>
    </div>
    <a href="{{ route('admin_users_list') }}" class="text-muted d-none" id="reset_btn"><small>reset</small></a>
</form>
</div>
<div class="col-12">
<div class="card card-body p-0">
<table class="table table-bordered table-striped">
<thead class="bg-dark text-center">
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>City</th>
        <th>Country</th>
        <th>Status</th>
        <th>Joined Date</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
@if(!empty($users))
@foreach($users as $user)
<tr>
    <td class="text-center">{{ $loop->iteration }}</td>
    <td>
      <a href="{{ route('admin_users_view', ['uid' => $user->id]) }}" class="text-dark"><img src="{{ Storage::url($user->avatar) }}" class="img-fluid avatar_img">
        {{ $user->full_name }}</a>
    </td>
    <td><a href="{{ route('admin_users_view', ['uid' => $user->id]) }}" class="d-flex flex-column text-dark">{{ $user->email }}</a></td>
    <td>
      <a href="{{ route('admin_users_view', ['uid' => $user->id]) }}" class="d-flex flex-column text-dark">
      <small><i class="fas fa-square-phone text-dark"></i> {{ $user->phone }}</small>
      <small><i class="fab fa-whatsapp text-success"></i> {{ $user->whatsapp_no }}</small>
      </a>
    </td>
    <td>{{ $user->city }}</td>
    <td><img src="{{ asset('flags/'.$user->flag.'.svg') }}" class="img-fluid img-circle" width="18"> {{ $user->country }}</td>
    <td class="text-center">
        @if($user->is_active)
        <i class="fas fa-user-check text-success" title="this user is active"></i>
        @else
        <i class="fas fa-user-times text-danger" title="this user is disabled"></i>
        @endif
        @if($user->is_admin)
        <i class="fas fa-user-tie text-info" title="this is an admin"></i>
        @endif
    </td>
    <td>{{ \Carbon\Carbon::parse($user->joined_date)->format('M d, Y') }}</td>
    <td class="text-center">
        <a href="{{ route('admin_users_view', ['uid' => $user->id]) }}" class="btn btn-info btn-sm"><i class="fas fa-user-edit"></i></a>
        <button type="button" class="btn btn-danger btn-sm delete_user_btn" data-toggle="modal" data-target="#delete_user_modal" data-id="{{ $user->id }}"><i class="fas fa-user-times"></i></button>
    </td>
</tr>    
@endforeach
@endif
</tbody>
</table>

<div class="modal fade" id="delete_user_modal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger"><i class="fas fa-exclamation-triangle"></i> Delete This User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body bg-light">
        Are you sure? do you really want to delete this user?
      </div>
      <div class="modal-footer d-flex justify-content-between p-0">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <form action="{{ route('admin_users_delete_account') }}" method="POST">
            @csrf
            <input type="hidden" name="user_id" id="user_id">
            <button type="submit" class="btn btn-danger">Confirm</button>
        </form>
      </div>
    </div>
  </div>
</div>

</div>
</div>
<div class="col-12 d-flex justify-content-between align-items-baseline py-4">
<small class="text-dark">Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} results</small>
{{ $users->links("partial.pagination") }}
</div>
</div>
@endsection
@section("script")
<script>
$(document).ready(function(){
    $(".delete_user_btn").click(function(){
      $("#user_id").val($(this).data("id"));
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