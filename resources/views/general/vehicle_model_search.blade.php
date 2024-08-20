@extends("general_base")
@section("title") CarShop - Search Results @endsection
@section("content")
<!--================================= inner-intro -->
 <section class="inner-intro bg-1 bg-overlay-black-70">
  <div class="container">
     <div class="row text-center intro-title">
           <div class="col-md-6 text-md-start d-inline-block">
            <h3 class="text-white">Results Found: {{ $results->count() }}</h3>
           </div>
           <div class="col-md-6 text-md-end float-end">
            <ul class="page-breadcrumb">
                <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a><i class="fa fa-angle-double-right"></i></li>
                <li><span>Search Result</span></li>
            </ul>
           </div>
     </div>
  </div>
</section>
<!--================================= inner-intro -->
<!--================================= product-listing -->
<section class="product-listing page-section-pb pt-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-9 col-md-8 mx-auto">
        <div class="sorting-options-main">
          <form action="{{ route('vehicle_model_search') }}" method="GET">
            @csrf
            <div class="row">
                  <div class="col-lg-3 col-md-6 col-sm-6">
                    <span>Select Make</span>
                    <select name="brand" class="form-select" id="select-make">
                      <option selected disabled>--Select--</option>
                      @foreach($brands as $brand)
                        <option value="{{ $brand->name }}">{{ $brand->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-lg-3 col-md-6 col-sm-6">
                    <span>Select Model</span>
                    <select name="model" class="form-select" id="select-model" disabled>
                      <option selected disabled>--Select--</option>
                    </select>
                  </div>
                  <div class="col-lg-3 col-md-6 col-sm-6">
                    <span>Select Condition</span>
                    <select name="condition" class="form-select">
                      <option selected disabled>--Select--</option>
                      <option value="new">New</option>
                      <option value="used">Used</option>
                      <option value="recondition">Recondition</option>
                      <option value="modified">Modified</option>
                    </select>
                  </div>
                  <div class="col-lg-3 col-md-6 col-sm-6">
                    <span>Select Price</span>
                    <select name="price" class="form-select">
                      <option selected disabled>--Select--</option>
                      <option value="50000-100000">50k - 1 Lacs</option>
                      <option value="100000-500000">1 Lacs - 5 Lacs</option>
                      <option value="500000-1000000">5 Lacs - 10 Lacs</option>
                      <option value="1000000-2000000">10 Lacs - 20 Lacs</option>
                      <option value="2000000-3000000">20 Lacs - 30 Lacs</option>
                      <option value="3000000-4000000">30 Lacs - 40 Lacs</option>
                      <option value="4000000-5000000">40 Lacs - 50 Lacs</option>
                      <option value="5000000-6000000">50 Lacs - 60 Lacs</option>
                      <option value="6000000-7000000">60 Lacs - 70 Lacs</option>
                      <option value="7000000-8000000">70 Lacs - 80 Lacs</option>
                      <option value="8000000-9000000">80 Lacs - 90 Lacs</option>
                      <option value="9000000-100000000">90 Lacs - 1 Core & Above</option>
                    </select>
                  </div>
                  <div class="col-12 text-center">
                    <button type="submit" class="btn btn-danger mt-3"><i class="fa-solid fa-magnifying-glass"></i> Find Car Again</button>
                  </div>
            </div>
          </form>
        </div>
        @if($results->count() > 0)
        @foreach($results as $car)
        <div class="car-grid">
           <div class="row">
            <div class="col-lg-4 col-md-12">
              <div class="car-item gray-bg text-center">
                <div class="car-image position-relative">
                  <?php 
                    $images = json_decode($car->images, true);
                    $campaigns = json_decode($car->campaign, true);
                  ?>
                  <a href="{{ route('vehicle_details', ['car' => $car->slug]) }}">
                      <img class="img-fluid rounded" src="{{ Storage::url($images[0]) }}">
                      @if($car->status === "active")
                        <span class="badge bg-success position-absolute top-0 end-0 m-3">In Stock</span>
                      @elseif($car->status === "sold")
                        <span class="badge bg-secondary position-absolute top-0 end-0 m-3">Sold</span>
                      @endif
                      @if(isset($campaigns['Urgent']))
                        <span class="badge bg-danger position-absolute top-0 start-0 urgent_label mt-3">Urgent</span>
                      @endif
                  </a>
                </div>
              </div>
             </div>
              <div class="col-lg-8 col-md-12">
                <div class="car-details">
                <div class="car-title">
                 <a href="{{ route('vehicle_details', ['car' => $car->slug]) }}">{{ $car->model }}</a>
                 <p>{{ Str::limit($car->description, 125) }}</p>
                  </div>
                  <div class="price">
                       <span class="new-price">{{ $car->price }} BDT</span>
                       <a class="button red float-end" href="{{ route('vehicle_details', ['car' => $car->slug]) }}">Details</a>
                     </div>
                   <div class="car-list">
                     <ul class="list-inline">
                       <li><i class="fa-solid fa-gauge-high"></i> {{ $car->mileage }}</li>
                       <li><i class="fa-solid fa-gas-pump"></i> {{ $car->fuel_type }}</li>
                       <li><i class="fa-solid fa-car-burst"></i> {{ ucfirst($car->condition) }}</li>
                     </ul>
                   </div>
                  </div>
                </div>
              </div>
        </div>
        @endforeach
        @else
        <div class="card card-body text-center mt-3">
          <h4 class="text-danger">No vehicles found!</h4>
        </div>
        @endif
          </div>
          @if($results->count() > 0)
          <div class="col-12 d-flex justify-content-center align-items-baseline py-4">
            {{ $results->links("partial.pagination") }}
          </div>
          @endif
        </div>
      </div>
</section>
<!--================================= product-listing -->
@endsection
@section("script")
<script>
$(document).ready(function () {
    $('#select-make').change(function () {
        let selectedBrand = $(this).val();
        let models = {!! json_encode($brands_data) !!}[selectedBrand];
        let modelSelect = $('#select-model');
        modelSelect.empty();
        modelSelect.prop('disabled', false);
        if (models.length === 0) {
          modelSelect.append($('<option>').text('No models available'));
          modelSelect.attr('disabled', true);
        } else {
          $.each(models, function (index, model) {
            modelSelect.append($("<option>").val(model).text(model));
          });
        }
    });
});
</script>
@endsection