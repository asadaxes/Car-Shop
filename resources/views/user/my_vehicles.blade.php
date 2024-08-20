@extends("general_base")
@section("title") CarShop - My Vehicles Store @endsection
@section("style")
<style>
.hr_bg{
    background-color: #c3c3c3;
    border: none;
}
</style>
@endsection
@section("content")
<div class="container mtb_6030">
<div class="row mb-4">
<div class="col-12 mb-3">
    <h5 class="text-danger text-center mb-0">List of My Vehicles</h5>
    <hr class="hr_bg">
</div>
<div class="col-12 table-responsive">
<table class="table table-bordered table-hover table-responsive text-center">
<thead class="bg-dark text-light">
    <tr>
        <th>#</th>
        <th>Image</th>
        <th>Name</th>
        <th>Price</th>
        <th>Category</th>
        <th>Condition</th>
        <th>Campaign</th>
        <th>Publish Date</th>
        <th>Status</th>
    </tr>
</thead>
<tbody>
@forelse ($vehicles as $vehicle)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>
            @if($vehicle->images)
                <?php $images = json_decode($vehicle->images, true); ?>
                <a href="{{ route('vehicle_details', ['car' => $vehicle->slug]) }}"><img src="{{ Storage::url($images[0]) }}" class="img-fluid rounded" width="80"></a>
            @endif
        </td>
        <td>
            <a href="{{ route('vehicle_details', ['car' => $vehicle->slug]) }}" class="d-flex flex-column text-dark">
                <small><img src="{{ Storage::url($vehicle->brand->logo) }}" class="img-fluid" width="20"> {{ $vehicle->brand->name }}</small>
                <small>{{ $vehicle->model }}</small>
            </a>
        </td>
        <td><a href="{{ route('vehicle_details', ['car' => $vehicle->slug]) }}" class="text-dark">{{ $vehicle->price }} BDT</a></td>
        <td><a href="{{ route('vehicle_details', ['car' => $vehicle->slug]) }}" class="text-dark">{{ $vehicle->category->title }}</a></td>
        <td><a href="{{ route('vehicle_details', ['car' => $vehicle->slug]) }}" class="text-dark">{{ ucfirst($vehicle->condition) }}</a></td>
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
        <td><a href="{{ route('vehicle_details', ['car' => $vehicle->slug]) }}" class="text-dark">{{ \Carbon\Carbon::parse($vehicle->publish_date)->format('M d, Y') }}</a></td>
        <td>
            @if($vehicle->status === 'active')
            <form action="{{ route('admin_vehicles_status_updater') }}" method="POST" id="status_updater_form">
                @csrf
                <input type="hidden" name="id" value="{{ $vehicle->id }}">
                <select name="status" class="form-select">
                    <option value="active" {{ $vehicle->status === 'active' ? 'selected' : '' }}>Active for Sale</option>
                    <option value="sold" {{ $vehicle->status === 'sold' ? 'selected' : '' }}>Mark as Sold</option>
                    <option value="closed" {{ $vehicle->status === 'closed' ? 'selected' : '' }}>Close</option>
                </select>
            </form>
            @elseif($vehicle->status === 'sold')
            <span class="text-success">Sold</span>
            @elseif($vehicle->status === 'closed')
            <span class="text-muted">Closed</span>
            @endif
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
<div class="col-12 d-flex justify-content-between align-items-baseline py-4">
<small class="text-dark">Showing {{ $vehicles->firstItem() }} to {{ $vehicles->lastItem() }} of {{ $vehicles->total() }} results</small>
{{ $vehicles->links("partial.pagination") }}
</div>
</div>
</div>
@endsection
@section("script")
<script>
$(document).ready(function() {
    $('select[name="status"]').change(function() {
        $('#status_updater_form').submit();
    });
});
</script>
@endsection