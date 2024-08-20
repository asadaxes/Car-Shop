@extends("general_base")
@section("title") CarShop - Search Results @endsection
@section("style")
<style>
img.search_cars_img{
  height: 200px;
  width: 100%;
}
</style>
@endsection
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
<div class="col-12 mb-4">
<form method="GET">
@csrf
  <div class="input-group">
    <input type="text" name="search" class="form-control" id="search_field" placeholder="Search by car name, brand, model or keyword" value="{{ request()->input('search') }}" required>
    <button type="submit" class="input-group-text bg-danger text-light border-0"><i class="fas fa-search"></i></button>
  </div>
</form>
</div>
<div class="col-12">
  @if($results->count() > 0)
        @foreach($results as $car)
        <div class="car-grid mt-3">
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