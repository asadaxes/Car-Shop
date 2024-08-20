<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $settings->ga_id }}"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', {{ $settings->ga_id }});
</script>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
<meta name="author" content="{{ $settings->meta_author }}" />
@if(isset($product->meta_title))
@yield("product_meta_title")
@endif
@if(isset($product->meta_description))
@yield("product_meta_description")
@else
<meta name="description" content="{{ $settings->meta_description }}" />
@endif
<meta name="keywords" content="{{ $settings->meta_keywords }}" />
<link rel="shortcut icon" href="{{ Storage::url($settings->favicon) }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/flaticon.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/mega-menu/mega_menu.css') }}" />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/slick/slick.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/slick/slick-theme.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/owl-carousel/owl.carousel.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('revolution/css/settings.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/jquery-ui.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/responsive.css') }}" />
<title>{{ $settings->title_site }} - @yield("title")</title>
<style>
.owl-nav button span{
  font-size: 50px;
  margin: 0 -8px;
}
html::-webkit-scrollbar{
  width: 10px;
  height: 10px;
}
html::-webkit-scrollbar-track-piece{
  background-color: #1C1C1C;
}
html::-webkit-scrollbar-thumb:vertical{
  height: 30px;
  background-color: #DB2D2E;
  border-radius: 10px;
}
ul.pagination li.page-item{
  list-style: none;
}
ul.pagination li.page-item .page-link{
  height: 40px;
  display: flex;
  align-items: center;
  margin: 0;
}
.urgent_label{
  rotate: -45deg;
}
.navbar_user_avatar{
  width: 25px;
  height: 25px;
  border-radius: 50%;
}
img.feature_cars_slider_img{
  height: 155px;
}
.bg-1{
  background-image: url("{{ asset('images/section_bg.png') }}");
}
.mtb_6030{
  margin-top: 60px;
  margin-bottom: 30px;
}
.cart_icon{
  position: relative;
  display: inline-block;
}
.cart_badge{
  position: absolute;
  top: 22px;
  right: 5px;
  transform: translate(50%, -50%);
  border-radius: 50%;
  font-size: 8px;
}
img.payment_method_logo{
  width: 50px;
  border-radius: .25rem;
}
</style>
@yield("style")
</head>
<body>
<!--================================= loading -->
 <div id="loading">
    <div id="loading-center">
        <img src="{{ asset('images/loader.gif') }}">
    </div>
</div>
<!--================================= loading -->

<!--================================= header -->
<header id="header" class="fancy">
<div class="topbar">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-md-12">
				<div class="topbar-left text-lg-start text-center">
          <ul class="list-inline">
            <li><i class="fas fa-envelope"></i> {{ $settings->contact_email }}</li>
            <li><i class="fas fa-phone"></i> {{ $settings->contact_phone }}</li>
            @if (!empty($settings->social_ids))
            @php
              $socialLinks = json_decode($settings->social_ids, true);
            @endphp
              @foreach ($socialLinks as $link)
                <li><a href="{{ $link['url'] }}" target="_blank"><i class="{{ $link['platform'] }}"></i></a></li>
              @endforeach
            @endif
          </ul>
				</div>
			</div>
			<div class="col-lg-6 col-md-12">
				<div class="topbar-right text-lg-end text-center">
					<ul class="list-inline">
            <li><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#finance_calculator"><i class="fa-solid fa-calculator"></i></a></li>
            <li>Want to Sell? @if(Auth::check()) <a href="{{ route('vehicle_publish_new') }}">Post Your Car</a> @else <a href="{{ route('vehicle_publish_new') }}">Join as Dealer</a>@endif</li>
          </ul>
				</div>
			</div>
		</div>
	</div>
</div>

<!--================================= mega menu -->
<div class="menu">
  <div class="container">
    <div class="row">
     <div class="col-md-12">
     <!-- menu start -->
       <nav id="menu" class="mega-menu">
        <!-- menu list items container -->
        <section class="menu-list-items">
            <!-- menu logo -->
            <ul class="menu-logo">
                <li>
                    <a href="{{ route('home') }}"><img id="logo_dark_img" src="{{ Storage::url($settings->logo_site) }}" alt="logo"></a>
                </li>
            </ul>
            <!-- menu links -->
            <ul class="menu-links">
              <li>
                <a href="javascript:void(0)">Vehicles <i class="fa fa-angle-down fa-indicator"></i></a>
                <ul class="drop-down-multilevel">
                  @foreach ($vehicle_categories as $category)
                  <li><a href="{{ route('search_query', ['search' => $category->title]) }}">{{ $category->title }}</a></li>
                  @endforeach
                </ul>
              </li>
              <li>
                <a href="javascript:void(0)">Brands <i class="fa fa-angle-down fa-indicator"></i></a>
                <ul class="drop-down-multilevel">
                  @forelse ($brands as $brand)
                      @php
                          $searchTerm = str_replace('%2B', '+', $brand->name);
                      @endphp
                      <li><a href="{{ route('search_query', ['search' => $searchTerm]) }}">{{ $brand->name }}</a></li>
                  @empty
                      <li>No brands found</li>
                  @endforelse
              </ul>              
              </li>
              <li class="{{ isset($active_page) && $active_page == 'pna' ? 'active' : '' }}"><a href="{{ route('pna_landing_page') }}">Parts & Accessories</a></li>
              <li><a href="{{ route('blogs') }}">News</a></li>
              @if(Auth::check())
                <li><a href="{{ route('vehicle_publish_new') }}">Sell Now</a></li>
                <li>
                  <div class="d-flex align-items-center cursor_pointer"><img src="{{ Storage::url( auth()->user()->avatar ) }}" class="img-fluid navbar_user_avatar"> <span class="mx-1">My Account</span> <i class="fa fa-angle-down fa-indicator"></i></div>
                  <ul class="drop-down-multilevel">
                    @if(auth()->user()->is_admin)
                    <li><a href="{{ route('admin_dashboard') }}">Admin Panel</a></li>
                    @endif
                    <li><a href="{{ route('user_profile') }}">Profile</a></li>
                    <li><a href="{{ route('user_my_vehicles') }}">My Vehicles</a></li>
                    <li><a href="{{ route('user_my_orders') }}">Order History</a></li>
                    <li><a href="{{ route('logout') }}">Logout</a></li>
                  </ul>
                </li>
              @else
                <li><a href="{{ route('signin') }}"><i class="fas fa-user"></i> My Account</a></li>
              @endif
              <li>
                  <a href="{{ route('pna_cart') }}" class="cart_icon ps-2 pe-1"><i class="fa-solid fa-cart-shopping fa-lg"></i>
                    <span class="badge bg-danger cart_badge"></span>
                  </a>
              </li>
              <li>
              <div class="search-top"><a class="search-btn not_click d-none d-lg-block" href="javascript:void(0);">Search Button</a>
                <div class="search-box not-click px-2">
                  <form action="{{ route('search_query') }}" method="GET">
                    @csrf
                    <div class="input-group">
                      <input type="text" name="search" class="form-control search_bar_input" placeholder="Search by car name, brand, model or keyword" required>
                      <button type="submit" class="input-group-text border-0">Search</button>
                    </div>
                  </form>
                </div>
              </div>
              </li>
           </section>
         </nav>
       </div>
     </div>
    </div>
   </div>
  <!-- menu end -->
</header>
@if(session("success"))
<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div class="toast @if(session('success')) bg-success @elseif(session('info')) bg-info @else bg-danger @endif text-white" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body d-flex justify-content-between">
      <span>{{ session("success") }}</span>
    </div>
  </div>
</div>
@endif
@if(session("info"))
<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div class="toast @if(session('success')) bg-success @elseif(session('info')) bg-info @else bg-danger @endif text-white" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body d-flex justify-content-between">
      <span>{{ session("info") }}</span>
    </div>
  </div>
</div>
@endif
@if(session("error"))
<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div class="toast @if(session('success')) bg-success @elseif(session('info')) bg-info @else bg-danger @endif text-white" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body d-flex justify-content-between">
      <span>{{ session("error") }}</span>
    </div>
  </div>
</div>
@endif
@if($errors->any())
<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div class="toast bg-danger text-white" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body d-flex justify-content-between">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  </div>
</div>
@endif
<!--================================= header -->
<!--================================= page content -->
@yield("content")
<!--================================= page content -->
<!--================================= footer -->
<footer class="footer-2 page-section-pt">
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-6">
        <div class="about-content">
          <img class="img-fluid" id="logo-footer" src="{{ Storage::url($settings->logo_site) }}">
          <p class="text-gray">{{ $settings->footer_description }}</p>
        </div>
        <div class="social">
        <ul>
          @if (!empty($settings->social_ids))
            @php
              $socialLinks = json_decode($settings->social_ids, true);
            @endphp
            @foreach ($socialLinks as $link)
              <li><a href="{{ $link['url'] }}" target="_blank"><i class="{{ $link['platform'] }}"></i></a></li>
            @endforeach
          @endif
        </ul>
       </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="usefull-link">
        <h6 class="text-white">{{ $settings->footer_link_1 }}</h6>
          <ul>
            @foreach($pages as $page)
              @if($page->position == 'left')
                <li><a href="{{ route('page_details', ['slug' => $page->slug]) }}"><i class="fas fa-angle-right"></i> {{ $page->name }}</a></li>
              @endif
            @endforeach
          </ul>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
       <div class="usefull-link">
        <h6 class="text-white">{{ $settings->footer_link_2 }}</h6>
          <ul>
            @foreach($pages as $page)
              @if($page->position == 'right')
                <li><a href="{{ route('page_details', ['slug' => $page->slug]) }}"><i class="fas fa-angle-right"></i> {{ $page->name }}</a></li>
              @endif
            @endforeach
          </ul>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
      <div class="keep-touch">
        <h6 class="text-white">{{ $settings->footer_link_3 }}</h6>
         <div class="address">
          <ul>
            <li><i class="fas fa-map-marker"></i><span>{{ $settings->contact_address }}</span></li>
            <li><i class="fas fa-phone"></i><span>{{ $settings->contact_phone }}</span></li>
            <li><i class="fas fa-envelope"></i><span>{{ $settings->contact_email }}</span></li>
          </ul>
        </div>
       </div>
      </div>
    </div>
    </div>
    <div class="copyright">
     <div class="container">
      <div class="row">
      <div class="col-lg-6 col-md-12">
       <div class="text-lg-start text-center">
         <p>{!! $settings->footer_copyright !!}</p>
       </div>
      </div>
      <div class="col-lg-6 col-md-12">
        <ul class="list-inline text-lg-end text-center">
          <li>Pay with</li>
          <li><img src="{{ asset('images/payments/bkash.jpg') }}" class="payment_method_logo"></li>
          <li><img src="{{ asset('images/payments/nagad.jpg') }}" class="payment_method_logo"></li>
          <li><img src="{{ asset('images/payments/rocket.jpg') }}" class="payment_method_logo"></li>
          <li><img src="{{ asset('images/payments/upay.png') }}" class="payment_method_logo"></li>
          <li><img src="{{ asset('images/payments/mastercard.jpg') }}" class="payment_method_logo"></li>
          <li><img src="{{ asset('images/payments/visa.jpg') }}" class="payment_method_logo"></li>
          <li><img src="{{ asset('images/payments/american_express.jpg') }}" class="payment_method_logo"></li>
        </ul>
       </div>
      </div>
     </div>
    </div>
</footer>
<!--================================= footer -->
<!--================================= back to top -->
<div class="car-top">
  <span><img src="{{ asset('images/car.png') }}"></span>
</div>
<!--================================= back to top -->
<!-- finance calculator modal -->
<div class="modal fade" id="finance_calculator" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Finance Calculator</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="financing-calculator-01" class="gray-form">
          <div class="mb-3">
              <label class="form-label">Vehicle Price (BDT)*</label>
              <input type="number" class="form-control" placeholder="Price" id="loan-amount-01" name="loan-amount">
          </div>
          <div class="mb-3">
              <label class="form-label">Down Payment *</label>
              <input type="number" class="form-control" placeholder="Payment" id="down-payment-01" name="down-payment">
          </div>
          <div class="mb-3">
              <label class="form-label">Interest Rate (%)</label>
              <input type="number" class="form-control" placeholder="Rate" id="interest-rate-01" name="interest-rate">
          </div>
          <div class="mb-3">
              <label class="form-label">Period (Month)*</label>
              <input type="number" class="form-control" placeholder="Month" id="period-01" name="period">
          </div>
          <div class="mb-3">
              <label class="form-label">Payment</label>
              <div class="cal_text payment-box">
                  <div id="txtPayment-01">0 BDT<sup>&#47;mo</sup></div>
              </div>
          </div>
          <div>
            <a class="button red calculate_finance_01" href="javascript:void(0)" data-form-id="financing-calculator-01">Estimate Payment</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src="{{ env('TAWK_CHAT_URI') }}";
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
<script type="text/javascript" src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/popper.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/mega-menu/mega_menu.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.appear.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/owl-carousel/owl.carousel.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/slick/slick.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('revolution/js/jquery.themepunch.tools.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('revolution/js/jquery.themepunch.revolution.min.js') }}"></script>
@yield("script")
<script>
document.addEventListener("DOMContentLoaded", function() {
  let toastElement = document.querySelector(".toast");
  if (toastElement) {
    let toast = new bootstrap.Toast(toastElement);
    toast.show();
  }

  function updateCartBadge() {
    let cart = JSON.parse(localStorage.getItem('cart')) || []; 
    let totalItems = cart.length;
    if (totalItems > 0) {
      $('.cart_badge').text(totalItems).show();
    } else {
      $('.cart_badge').hide();
    }
  }
  updateCartBadge();

  function isNumberValid(x) {
      let filter = /(^\d+\.?$)|(^\d*\.\d+$)/;
      if (filter.test(x)) {
          return true;
      }
      return false;
  }

  $(document).on('click', '.calculate_finance_01', function(){
      let form_id = $(this).attr('data-form-id');
      let current_form = $('#'+form_id);
      let loan_amount_el = current_form.find('#loan-amount-01');
      let loan_amount = loan_amount_el.val();
      let interest_rate_el = current_form.find('#interest-rate-01');
      let interest_rate = interest_rate_el.val();
      let period_el = current_form.find('#period-01');
      let period = period_el.val();
      let down_payment_el = current_form.find('#down-payment-01');
      let down_payment = down_payment_el.val();
      let currency_symbol = 'BDT';

      let t = down_payment;
      let I = interest_rate;
      let N = period;
      let P = loan_amount;

      let vTempP = String(P).replace(currency_symbol, '').replace(',', '');
      if (!isNumberValid(vTempP)) {
          alert("Please enter a valid number for the Loan Amount (P).");
          loan_amount_el.focus();
          return false;
      }

      let vTempT = String(t).replace(currency_symbol, '').replace(',', '');
      if (!isNumberValid(vTempT)) {
          alert("Please enter a valid number for the Down Payment (P).");
          down_payment_el.focus();
          return false;
      }

      if (!isNumberValid(I)) {
          alert("Enter an Interest Rate (r).");
          interest_rate_el.focus();
          return false;
      }
      if (!isNumberValid(N)) {
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

      $('#txtPayment-01').html(ans2 + " " + currency_symbol + '<sup>&#47;mo</sup>');
  });
});
</script>
<script type="text/javascript" src="{{ asset('js/custom.js') }}"></script>
</body>
</html>