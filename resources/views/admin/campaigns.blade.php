@extends("admin_base")
@section("title") Campaigns @endsection
@section("style")
<style>

</style>
@endsection
@section("content")
<div class="row">
<div class="col-12">
<h5 class="text-dark border-bottom pb-1">Ad Campaigns Management</h5>
</div>
<div class="col-12">
@if($campaigns->isNotEmpty())
<div class="row">
@foreach($campaigns as $campaign)
<div class="col-md-4">
  <div class="card card-body d-flex flex-column py-2">
    <small class="text-muted text-center">Package #{{ $loop->iteration }}</small>
    <h5 class="text-info text-center">{{ $campaign->name }}</h5>
    <?php
      $pricingData = json_decode($campaign->pricing, true);
    ?>
    <table class="table table-sm text-center">
      <thead class="bg-dark">
        <tr>
          <th><i class="fa-regular fa-clock"></i> Duration</th>
          <th><i class="fa-solid fa-bangladeshi-taka-sign"></i> Cost</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($pricingData as $pricing)
          @foreach ($pricing as $duration => $cost)
          <tr>
            <td>{{ $duration }} days</td>
            <td>{{ $cost }} BDT</td>
          </tr>
          @endforeach
        @endforeach
      </tbody>
    </table>
    <div class="d-flex justify-content-end">
      <i class="fas fa-edit text-danger cursor_pointer edit_package_modal_btn" data-id="{{ $campaign->id }}" data-name="{{ $campaign->name }}" data-packages="{{ json_encode($campaign->pricing) }}" data-toggle="modal" data-target="#edit_package_modal"></i>
    </div>
  </div>
</div>
@endforeach
@else
<div class="col-12 text-center mt-4">
  <h4 class="text-muted">no campaigns found!</h4>
</div>
</div>
@endif
</div>
</div>

<!-- edit campaign modal -->
<div class="modal fade" id="edit_package_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Package: <span class="text-info" id="edit_package_title"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin_campaigns_edit') }}" method="POST">
        @csrf
        <div class="modal-body bg-light">
          <label for="edit_campaign_name" class="mb-0">Campaign Name</label>
          <input type="text" name="name" class="form-control" id="edit_campaign_name" required>
          <div class="my-3">
            <label class="text-center w-100 mb-0">Duration & Pricing</label>
            <div class="input-group">
                <input type="number" class="form-control edit_duration" placeholder="Duration in days">
                <input type="number" class="form-control edit_cost" placeholder="Cost in BDT">
                <div class="input-group-prepend cursor_pointer">
                    <span class="input-group-text edit_add_row"><i class="fas fa-plus"></i></span>
                </div>
            </div>
            <input type="hidden" name="pricing" id="edit_pricing">
            <input type="hidden" name="id" id="edit_package_id">
          </div>
          <ul class="list-group edit_pricing_list">
          </ul>
        </div>
        <div class="modal-footer d-flex justify-content-between p-0">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Confirm</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section("script")
<script>
$(document).ready(function() {
  $('.edit_package_modal_btn').click(function() {
    let id = $(this).data('id');
    let name = $(this).data('name');
    let packages = $(this).data('packages');

    $('#edit_package_id').val(id);
    $('#edit_package_title').text(name);
    $('#edit_campaign_name').val(name);
    $('#edit_pricing').val(JSON.parse(packages));

    $('.edit_pricing_list').empty();
    let items = JSON.parse(JSON.parse(packages));
    for (let i = 0; i < items.length; i++) {
        let duration = Object.keys(items[i])[0];
        let cost = items[i][duration];
        let preview = '<li class="list-group-item d-flex justify-content-between">' +
                      '<span><i class="far fa-clock"></i> ' + duration + ' days - ' + cost + ' BDT</span>' +
                      '<i class="fas fa-minus-circle text-danger edit_remove_row cursor_pointer"></i>' +
                      '</li>';
        $('.edit_pricing_list').append(preview);
    }
  });

  $('.edit_add_row').click(function() {
    let duration = $('.edit_duration').val();
    let cost = $('.edit_cost').val();
    if (duration && cost) {
      let item = {};
      item[duration] = cost;
      let pricing = JSON.parse($('#edit_pricing').val() || '[]');
      pricing.push(item);
      $('#edit_pricing').val(JSON.stringify(pricing));
      let preview = '<li class="list-group-item d-flex justify-content-between">' +
                    '<span><i class="far fa-clock"></i> ' + duration + ' days - ' + cost + ' BDT</span>' +
                    '<i class="fas fa-minus-circle text-danger edit_remove_row cursor_pointer"></i>' +
                    '</li>';
      $('.edit_pricing_list').append(preview);
      $('.edit_duration').val('').focus();
      $('.edit_cost').val('');
    }
  });

  $(document).on('click', '.edit_remove_row', function() {
    let index = $(this).closest('li').index();
    let pricing = JSON.parse($('#edit_pricing').val());
    pricing.splice(index, 1);
    $('#edit_pricing').val(JSON.stringify(pricing));
    $(this).closest('li').remove();
  });
});
</script>
@endsection