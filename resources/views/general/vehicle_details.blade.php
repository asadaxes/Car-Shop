@extends("general_base")
@section("title") CarShop - {{ $car->brand->name }} - {{ $car->model }} @endsection
<?php 
$images = json_decode($car->images, true);
$campaigns = json_decode($car->campaign, true);
$details = json_decode($car->details, true);
$features = json_decode($car->features, true);
$totalFeatures = count($features);
$colSize = ceil($totalFeatures / 3);
$featuresChunks = array_chunk($features, $colSize);
?>
@section("style")
<style>
.feature_cars_slider_overlay_icons{
  position: absolute;
  bottom: 0;
  width: 100%;
}
.feature_cars_slider_overlay_icons div{
  padding: 0 10px;
  margin: 0 5px 5px 5px;
  color: #404040e8;
  background-color: #ffffffbf;
  border: 1px solid #c7c7c791;
  border-radius: 5px;
  display: flex;
  justify-content: space-around;
}
section.bg-1{
  background-image: url("{{ Storage::url($images[0]) }}")
}
img.img-fluid.cursor_pointer.slider_img{
  height: 450px;
}
img.img-fluid.cursor_pointer.slider_img_selector{
  height: 90px;
}
img.slider_car_brands_logo{
  width: 10px !important;
}
</style>
@endsection
@section("content")
<!--================================= inner-intro -->
 <section class="inner-intro bg-1 bg-overlay-black-70">
  <div class="container">
     <div class="row text-center intro-title">
       <div class="col-md-6 text-md-start d-inline-block">
         <h1 class="text-white">{{ $car->model }}</h1>
       </div>
       <div class="col-md-6 text-md-end float-end">
         <ul class="page-breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a><i class="fa fa-angle-double-right"></i></li>
            <li><a href="">Vehicles</a> <i class="fa fa-angle-double-right"></i></li>
            <li><span>{{ $car->brand->name }} - {{ $car->model }}</span></li>
         </ul>
       </div>
     </div>
  </div>
</section>
<!--================================= inner-intro -->
<!--================================= car-details  -->
<section class="car-details page-section-ptb">
  <div class="container">
    <div class="row mb-3">
      <div class="col-md-9 mb-md-0 mb-2">
        <h3>{{ $car->brand->name }} - {{ $car->model }}</h3>
        <div>
          @if(isset($campaigns['Urgent']))
            <small class="badge bg-danger">Urgent</small>
          @endif
          @if($car->status === "active")
            <small class="badge bg-success">In Stock</small>
          @elseif($car->status === "sold")
            <small class="badge bg-secondary">Sold</small>
          @endif
        </div>
      </div>
      <div class="col-md-3">
        <div class="car-price text-lg-end">
          <strong>{{ $car->price }} BDT</strong>
        </div>
      </div>
    </div>
    <div class="row">
     <div class="col-md-8">
        <div class="slider-slick">
          <div class="slider slider-for detail-big-car-gallery">
            @foreach ($images as $image)
              <img class="img-fluid cursor_pointer slider_img" src="{{ Storage::url($image) }}">
            @endforeach
          </div>
          <div class="slider slider-nav">
            @foreach ($images as $image)
              <img class="img-fluid cursor_pointer slider_img_selector" src="{{ Storage::url($image) }}">
            @endforeach
          </div>
        </div>
        <div id="tabs">
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item icon-diamond" role="presentation">
              <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#general_information" type="button" role="tab">Description</button>
            </li>
            <li class="nav-item icon-list" role="presentation">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#features_options" type="button" role="tab">Features & Options</button>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade show active" id="general_information" role="tabpanel">
              <p>{{ $car->description }}</p>
            </div>
            <div class="tab-pane fade" id="features_options" role="tabpanel">
              <table class="table table-bordered">
                <tbody>
                  @foreach($details as $detail)
                    @foreach($detail as $key => $value)
                      <tr>
                        <th scope="row">{{ $key }}</th>
                        <td>{{ $value }}</td>
                      </tr>
                    @endforeach
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      <div class="extra-feature">
       <h6>Extra Features</h6>
       <div class="row">
            @foreach($featuresChunks as $chunk)
              <div class="col-lg-4 col-sm-4">
                <ul class="list-style-1">
                  @foreach($chunk as $feature)
                    <li><i class="fa fa-check"></i>{{ $feature }}</li>
                  @endforeach
                </ul>
              </div>
            @endforeach
        </div>
      </div>
@if ($recent_cars->count() > 0)
<div class="feature-car">
    <hr class="w-25 mx-auto mb-3">
    <h6>Recent Vehicles</h6>
    <div class="row">
     <div class="col-md-12">
       <div class="owl-carousel" data-nav-arrow="true" data-nav-dots="true" data-items="3" data-md-items="3" data-sm-items="2" data-space="15">
        @foreach ($recent_cars as $car)
          <div class="item">
            <div class="car-item text-center">
              <div class="car-image position-relative">
                <a href="{{ route('vehicle_details', ['car' => $car->slug]) }}">
                  @if($car->status === "active")
                    <span class="badge bg-success position-absolute top-0 end-0 m-3">In Stock</span>
                  @elseif($car->status === "sold")
                    <span class="badge bg-secondary position-absolute top-0 end-0 m-3">Sold</span>
                  @endif
                <?php 
                  $images = json_decode($car->images, true);
                  $campaigns = json_decode($car->campaign, true);
                ?>
                @if(isset($campaigns['Urgent']))
                  <span class="badge bg-danger position-absolute top-0 start-0 urgent_label mt-3">Urgent</span>
                @endif
                <img src="{{ Storage::url($images[0]) }}" class="img-fluid feature_cars_slider_img">
                <div class="feature_cars_slider_overlay_icons">
                  <div>
                    <small title="Mileage"><i class="fa-solid fa-gauge-high"></i> {{ $car->mileage }}</small>
                    <small title="Fuel Type"><i class="fa-solid fa-gas-pump"></i> {{ $car->fuel_type }}</small>
                  </div>
                </div>
                </a>
              </div>
              <div class="car-content pt-2">
              <div class="d-flex flex-column align-items-start mb-1">
                <small class="text-dark d-flex align-items-center"><img src="{{ Storage::url($car->brand->logo) }}" class="slider_car_brands_logo me-1"> {{ $car->brand->name }}</small>
                <a href="{{ route('vehicle_details', ['car' => $car->slug]) }}">{{ $car->model }}</a>
                <small>Contidion: {{ ucfirst($car->condition) }}</small>
                <small>Model Year: {{ $car->model_year }}</small>
              </div>
              <div class="separator"></div>
              <div class="price">
                <span>{{ $car->price }} BDT</span>
              </div>
              </div>
            </div>
          </div>
        @endforeach
       </div>
      </div>
     </div>
</div>
@endif
   </div>
<div class="col-md-4">
    <div class="car-details-sidebar">
        <div class="details-block details-weight">
            <h5>Details</h5>
            <ul>
              <li><span>Make</span><strong class="text-end">{{ $car->brand->name }}</strong></li>
              <li><span>Model</span><strong class="text-end">{{ $car->model }}</strong></li>
              <li><span>Model Year</span><strong class="text-end">{{ $car->model_year }}</strong></li>
              @if(!empty($car->registration_year))
              <li><span>Registration Year</span><strong class="text-end">{{ $car->registration_year }}</strong></li>
              @endif
              <li><span>Mileage</span><strong class="text-end">{{ $car->mileage }} mi</strong></li>
              <li><span>Condition</span><strong class="text-end">{{ ucfirst($car->condition) }}</strong></li>
              <li><span>Exterior Color</span><strong class="text-end">{{ $car->exterior_color }}</strong></li>
              <li><span>Interior Color</span><strong class="text-end">{{ $car->interior_color }}</strong></li>
              <li><span>Engine</span><strong class="text-end">{{ $car->engine }}</strong></li>
              <li><span>Drivetrain</span><strong class="text-end">{{ $car->drivetrain }}</strong></li>
            </ul>
        </div>
        <div class="details-nav border-top border-bottom py-2">
            <p class="text-center">Contact the dealer for the best price</p>
            <div class="d-flex justify-content-start mb-3">
              <img src="{{ Storage::url($car->dealer->avatar) }}" class="img-fluid img-circle me-2" width="60">
              <div class="d-flex flex-column">
                <h5 class="mb-1">{{ $car->dealer->full_name }}</h5>
                <span>{{ $car->dealer->address }} - {{ $car->dealer->city }}, {{ $car->dealer->country }}</span>
              </div>
            </div>
            <div class="details-phone details-weight mb-2">
              <div class="feature-box-3 grey-border d-flex align-items-center">
                <div class="icon">
                  <a href="tel:{{ $car->dealer->phone }}"><i class="fa fa-phone"></i></a>
                </div>
                <div class="content mt-0">
                  <h4 class="hidden_phone_number cursor_pointer">+8801********<i class="fas fa-eye-slash"></i></h4>
                  <h4 class="visible_full_number cursor_pointer" style="display:none">{{ $car->dealer->phone }}</h4>                  
                </div>
              </div>
            </div>
            <div class="text-center mb-2">
              <a href="mailto:{{ $car->dealer->email }}" class="btn btn-outline-info btn-sm" target="_blank"><i class="fas fa-envelope"></i> Email</a>
              <a href="https://wa.me/{{ $car->dealer->whatsapp_no }}" class="btn btn-outline-success btn-sm" target="_blank"><i class="fab fa-whatsapp"></i> WhatsApp</a>
            </div>
        </div>
        <div class="details-social details-weight">
            <h5>Share now</h5>
            <ul>
              <li>
                  <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::url()) }}" target="_blank">
                      <i class="fab fa-facebook"></i> Facebook
                  </a>
              </li>
              <li>
                  <a href="https://twitter.com/intent/tweet?url={{ urlencode(Request::url()) }}" target="_blank">
                      <i class="fab fa-twitter"></i> Twitter
                  </a>
              </li>
              <li>
                  <a href="https://www.linkedin.com/shareArticle?url={{ urlencode(Request::url()) }}" target="_blank">
                      <i class="fab fa-linkedin"></i> LinkedIn
                  </a>
              </li>
              <li>
                  <a href="https://pinterest.com/pin/create/button/?url={{ urlencode(Request::url()) }}" target="_blank">
                      <i class="fab fa-pinterest"></i> Pinterest
                  </a>
              </li>
              <li>
                  <a href="whatsapp://send?text={{ urlencode(Request::url()) }}" target="_blank">
                      <i class="fab fa-whatsapp"></i> WhatsApp
                  </a>
              </li>
              <li>
                  <a href="mailto:?body={{ urlencode(Request::url()) }}" target="_blank">
                      <i class="fas fa-envelope"></i> Email
                  </a>
              </li>
            </ul>          
        </div>
            <div class="details-form contact-2">
              <form id="financing-calculator-02" class="gray-form">
                <div class="mb-3">
                    <label class="form-label">Vehicle Price (BDT)*</label>
                    <input type="number" class="form-control" placeholder="Price" id="loan-amount-02" name="loan-amount">
                </div>
                <div class="mb-3">
                    <label class="form-label">Down Payment *</label>
                    <input type="number" class="form-control" placeholder="Payment" id="down-payment-02" name="down-payment">
                </div>
                <div class="mb-3">
                    <label class="form-label">Interest Rate (%)</label>
                    <input type="number" class="form-control" placeholder="Rate" id="interest-rate-02" name="interest-rate">
                </div>
                <div class="mb-3">
                    <label class="form-label">Period (Month)*</label>
                    <input type="number" class="form-control" placeholder="Month" id="period-02" name="period">
                </div>
                <div class="mb-3">
                    <label class="form-label">Payment</label>
                    <div class="cal_text payment-box">
                        <div id="txtPayment-02">0 BDT<sup>&#47;mo</sup></div>
                    </div>
                </div>
                <div>
                    <a class="button red calculate_finance_02" href="javascript:void(0)" data-form-id="financing-calculator-02">Estimate Payment</a>
                </div>
              </form>
            </div>
          </div>
        </div>
    </div>
</div>
</section>
<!--================================= car-details -->
@endsection
@section("script")
<script>
$(document).ready(function () {
  $(".hidden_phone_number").click(function() {
    $(".visible_full_number").toggle();
    $(this).toggle();
  });
  $(".visible_full_number").click(function() {
    $(".hidden_phone_number").toggle();
    $(this).toggle();
  });

	function fnisNum(x) {
		let filter = /(^\d+\.?$)|(^\d*\.\d+$)/;
		if (filter.test(x)) {
			return true;
		}
		return false;
	}
	$(document).on('click', '.calculate_finance_02', function(){
      let form_id = $(this).attr('data-form-id');
      let current_form = $('#'+form_id);
      let loan_amount_el = current_form.find('#loan-amount-02');
      let loan_amount = loan_amount_el.val();
      let interest_rate_el = current_form.find('#interest-rate-02');
      let interest_rate = interest_rate_el.val();
      let period_el = current_form.find('#period-02');
      let period = period_el.val();
      let down_payment_el = current_form.find('#down-payment-02');
      let down_payment = down_payment_el.val();
      let currency_symbol = 'BDT';

      let t = down_payment;
      let I = interest_rate;
      let N = period;
      let P = loan_amount;

      let vTempP = String(P).replace(currency_symbol, '').replace(',', '');
      if (!fnisNum(vTempP)) {
          alert("Please enter a valid number for the Loan Amount (P).");
          loan_amount_el.focus();
          return false;
      }

      let vTempT = String(t).replace(currency_symbol, '').replace(',', '');
      if (!fnisNum(vTempT)) {
          alert("Please enter a valid number for the Down Payment (P).");
          down_payment_el.focus();
          return false;
      }

      if (!fnisNum(I)) {
          alert("Enter an Interest Rate (r).");
          interest_rate_el.focus();
          return false;
      }
      if (!fnisNum(N)) {
          alert("Please enter the Total Number of Payments (N).");
          period_el.focus();
          return false;
      }

      P = vTempP;
      t = vTempT;
      let X = (P - t);
      let Y = ((I / 100) / 12);
      let z = (Math.pow((1 + ((I / 100) / 12)), -N));
      let a = (X * Y);
      let b = (1 - z);
      let Tot = (a / b);
      let ans2 = Tot.toFixed();

      $('#txtPayment-02').html(ans2 + " " + currency_symbol + '<sup>&#47;mo</sup>');
  });
});
</script>
@endsection