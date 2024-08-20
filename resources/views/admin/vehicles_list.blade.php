@extends("admin_base")
@section("title") Vehicles List @endsection
@section("style")
<style>
img.dealer_img{
    width: 30px;
    height: 30px;
    border-radius: 50%;
}
img.vehicle_list_img{
    width: 80px;
    height: 45px;
}
</style>
@endsection
@section("content")
<div class="row">
<div class="col-12">
<h5 class="text-dark border-bottom">Vehicles/List</h5>
</div>
<div class="col-12 mb-3">
<form method="GET">
@csrf
    <div class="input-group">
        <input type="text" class="form-control py-4" name="search" id="search_field" placeholder="Search users by vehicles brand, model, category, price, mileage, fuel type, condition, exterior/interior color, model year, or status..." required>
        <div class="input-group-prepend">
            <button type="submit" class="input-group-text bg-light"><i class="fas fa-search"></i></button>
        </div>
    </div>
    <a href="{{ route('admin_vehicles_list') }}" class="text-muted d-none" id="reset_btn"><small>reset</small></a>
</form>
</div>
<div class="col-12">
<div class="card card-body p-0">
<table class="table table-bordered text-center">
<thead class="bg-dark">
    <tr>
        <th>#</th>
        <th>Image</th>
        <th>Name</th>
        <th>Dealer</th>
        <th>Price</th>
        <th>Category</th>
        <th>Condition</th>
        <th>Status</th>
        <th>Campaign</th>
        <th>Publish Date</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
@forelse ($vehicles as $vehicle)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>
            @if($vehicle->images)
                <?php $images = json_decode($vehicle->images, true); ?>
                <img src="{{ Storage::url($images[0]) }}" class="img-fluid rounded vehicle_list_img">
            @endif
        </td>
        <td>
            <div class="d-flex flex-column">
                <small><img src="{{ Storage::url($vehicle->brand->logo) }}" class="img-fluid" width="20"> {{ $vehicle->brand->name }}</small>
                <small>{{ $vehicle->model }}</small>
            </div>
        </td>
        <td>
            <a href="{{ route('admin_users_view', ['uid' => $vehicle->dealer->id]) }}" class="text-dark">
                <img src="{{ Storage::url($vehicle->dealer->avatar) }}" class="dealer_img">
                {{ $vehicle->dealer->full_name }}
            </a>
        </td>
        <td>{{ $vehicle->price }} BDT</td>
        <td>{{ $vehicle->category->title }}</td>
        <td>{{ ucfirst($vehicle->condition) }}</td>
        <td>
            <form action="{{ route('admin_vehicles_status_updater') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $vehicle->id }}">
                <select name="status" class="custom-select">
                    <option value="active" {{ $vehicle->status === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="closed" {{ $vehicle->status === 'closed' ? 'selected' : '' }}>Closed</option>
                    <option value="sold" {{ $vehicle->status === 'sold' ? 'selected' : '' }}>Sold</option>
                </select>
            </form>
        </td>
        <td>
            <div class="d-flex flex-column">
                <?php $campaign = json_decode($vehicle->campaign, true) ?>
                @if($campaign)
                    @foreach($campaign as $key => $value)
                        <small>{{ $key }}</small>
                        @if(is_array($value))
                            @foreach($value as $duration => $cost)
                                <small><i class="fa-regular fa-clock"></i> {{ $duration }} - {{ $cost }} BDT</small>
                            @endforeach
                        @else
                            <span>not found!</span>
                        @endif
                    @endforeach
                @else
                    <span>not found!</span>
                @endif
            </div>
        </td>
        <td>{{ \Carbon\Carbon::parse($vehicle->publish_date)->format('M d, Y') }}</td>
        <td>
            <a href="{{ route('admin_vehicles_view', ['id' => $vehicle->id]) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
            <button type="button" class="btn btn-danger btn-sm delete_vehicle_btn" data-toggle="modal" data-target="#delete_vehicle_modal" data-id="{{ $vehicle->id }}"><i class="fas fa-trash-alt"></i></button>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="10" class="text-center text-muted">no vehicles found!</td>
    </tr>
@endforelse
</tbody>
</table>
</div>
</div>
<div class="col-12 d-flex justify-content-between align-items-baseline py-4">
<small class="text-dark">Showing {{ $vehicles->firstItem() }} to {{ $vehicles->lastItem() }} of {{ $vehicles->total() }} results</small>
{{ $vehicles->links("partial.pagination") }}
</div>
</div>
<div class="modal fade" id="delete_vehicle_modal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger"><i class="fas fa-exclamation-triangle"></i> Delete This Vehicle</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body bg-light">
        Are you sure? do you really want to delete this vehicle?
      </div>
      <div class="modal-footer d-flex justify-content-between p-0">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <form action="{{ route('admin_vehicles_delete') }}" method="POST">
            @csrf
            <input type="hidden" name="vehicle_id" id="vehicle_id">
            <button type="submit" class="btn btn-danger">Confirm</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@section("script")
<script>
$(document).ready(function() {
    $('select[name="status"]').change(function() {
        $(this).closest('form').submit();
    });
    $(".delete_vehicle_btn").click(function(){
        $("#vehicle_id").val($(this).data("id"));
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