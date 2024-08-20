@extends("general_base")
@section("title") CarShop - Biggest Marketplace for Automotive Parts & Accessories @endsection
@section("style")
<style>
img.pna_image{
    height: 150px;
}
div.tp-bullets.uranus.horizontal.nav-pos-hor-right.nav-pos-ver-bottom.nav-dir-horizontal{
    display: none;
}
</style>
@endsection
@section("content")
<!--================================= rev slider -->
<div id="rev_slider_4_1_wrapper" class="rev_slider_wrapper fullwidthbanner-container" data-alias="car-dealer-04" data-source="gallery" style="margin:0px auto;background-color:transparent;padding:0px;margin-top:0px;margin-bottom:0px;">
   <div id="rev_slider_4_1" class="rev_slider fullwidthabanner" style="display:none;" data-version="5.3.0.2">
      <ul>
         <li data-index="rs-5" data-transition="fade" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off"  data-easein="default" data-easeout="default" data-masterspeed="300"  data-thumb="{{ asset('revolution/assets/100x50_75b06-bg-1.jpg') }}"  data-rotate="0"  data-saveperformance="off"  data-title="Slide" data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-param10="" data-description="">
            <!-- MAIN IMAGE -->
            <img src="{{ asset('revolution/assets/75b06-bg-1.jpg') }}" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="off" class="rev-slidebg" data-no-retina>
            <!-- LAYERS -->
            <!-- LAYER NR. 1 -->
            <div class="tp-caption tp-resizeme rs-parallaxlevel-2"
               id="slide-5-layer-4"
               data-x="10"
               data-y="361"
               data-width="['auto']"
               data-height="['auto']"
               data-type="text"
               data-responsive_offset="on"
               data-frames='[{"delay":1450,"speed":1650,"frame":"0","from":"x:left;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"nothing"}]'
               data-textAlign="['left','left','left','left']"
               data-paddingtop="[0,0,0,0]"
               data-paddingright="[0,0,0,0]"
               data-paddingbottom="[0,0,0,0]"
               data-paddingleft="[0,0,0,0]"
               style="z-index: 5; white-space: nowrap; font-size: 120px; line-height: 120px; font-weight: 900; color: rgba(255, 255, 255, 1.00);font-family:Roboto;text-transform:uppercase;">Parts & </div>
            <!-- LAYER NR. 2 -->
            <div class="tp-caption tp-resizeme rs-parallaxlevel-1"
               id="slide-5-layer-2"
               data-x="14"
               data-y="299"
               data-width="['auto']"
               data-height="['auto']"
               data-type="text"
               data-responsive_offset="on"
               data-frames='[{"delay":1410,"speed":1740,"frame":"0","from":"y:top;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"nothing"}]'
               data-textAlign="['left','left','left','left']"
               data-paddingtop="[0,0,0,0]"
               data-paddingright="[0,0,0,0]"
               data-paddingbottom="[0,0,0,0]"
               data-paddingleft="[0,0,0,0]"
               style="z-index: 6; white-space: nowrap; font-size: 50px; line-height: 50px; font-weight: 700; color: rgba(255, 255, 255, 1.00);font-family:Roboto;">Find From <br> 1000+</div>
            <!-- LAYER NR. 3 -->
            <div class="tp-caption tp-resizeme rs-parallaxlevel-1"
               id="slide-5-layer-7"
               data-x="right" data-hoffset="50"
               data-y="bottom" data-voffset="350"
               data-width="['none','none','none','none']"
               data-height="['none','none','none','none']"
               data-type="image"
               data-responsive_offset="on"
               data-frames='[{"delay":3170,"speed":900,"frame":"0","from":"y:top;opacity:0;","to":"o:1;","ease":"Power2.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"nothing"}]'
               data-textAlign="['left','left','left','left']"
               data-paddingtop="[0,0,0,0]"
               data-paddingright="[0,0,0,0]"
               data-paddingbottom="[0,0,0,0]"
               data-paddingleft="[0,0,0,0]"
               style="z-index: 7;"><img src="{{ asset('images/parts.png') }}" data-ww="auto" data-hh="auto" data-no-retina> </div>
            <!-- LAYER NR. 4 -->
            <div class="tp-caption tp-resizeme"
               id="slide-5-layer-3"
               data-x="center" data-hoffset="16"
               data-y="bottom" data-voffset="118"
               data-width="['none','none','none','none']"
               data-height="['none','none','none','none']"
               data-type="image"
               data-responsive_offset="on"
               data-frames='[{"delay":360,"speed":1600,"frame":"0","from":"y:bottom;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"x:left;","ease":"nothing"}]'
               data-textAlign="['left','left','left','left']"
               data-paddingtop="[0,0,0,0]"
               data-paddingright="[0,0,0,0]"
               data-paddingbottom="[0,0,0,0]"
               data-paddingleft="[0,0,0,0]"
               style="z-index: 8;"><img src="{{ asset('revolution/assets/60ede-car-img2.png') }}" data-ww="auto" data-hh="auto" data-no-retina> </div>
            <!-- LAYER NR. 5 -->
            <div class="tp-caption tp-resizeme rs-parallaxlevel-2"
               id="slide-5-layer-5"
               data-x="right" data-hoffset="14"
               data-y="bottom" data-voffset="50"
               data-width="['auto']"
               data-height="['auto']"
               data-type="text"
               data-responsive_offset="on"
               data-frames='[{"delay":1450,"speed":1650,"frame":"0","from":"y:bottom;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"nothing"}]'
               data-textAlign="['left','left','left','left']"
               data-paddingtop="[0,0,0,0]"
               data-paddingright="[0,0,0,0]"
               data-paddingbottom="[0,0,0,0]"
               data-paddingleft="[0,0,0,0]"
               style="z-index: 9; white-space: nowrap; font-size: 120px; line-height: 120px; font-weight: 900; color: rgba(255, 255, 255, 1.00);font-family:Roboto;text-transform:uppercase;">Accessories</div>
         </li>
      </ul>
      <div class="tp-bannertimer tp-bottom" style="visibility: hidden !important;"></div>
   </div>
</div>
<!--================================= rev slider -->
<!--================================= search bar -->
<section class="search gray-bg">
  <div class="container">
    <div class="search-block search-block-new">
        <div class="section-title mb-3">
            <h4>Check out our latest parts & accessories</h4>
            <div class="separator"></div>
        </div>
      <form method="GET">
        @csrf
        <div class="input-group">
            <input type="text" name="search" class="form-control" id="search_field" placeholder="Search parts & accessories..." required>
            <button type="submit" class="input-group-text bg-danger text-white"><i class="fas fa-search"></i></button>
        </div>
        <a href="{{ route('pna_landing_page') }}" class="text-muted d-none" id="reset_btn"><small>reset</small></a>
      </form>
    </div>
  </div>
</section>
<!--================================= search bar -->
<!--================================= featured pna -->
<section class="feature-car gray-bg page-section-ptb">
  <div class="container">
   <div class="row">
    <div class="col-md-3 mb-md-0 mb-3">
        <div class="card card-body">
            <h6 class="text-danger mb-1">Brands</h6>
            <ul class="mb-4">
              @foreach($pna_brands as $brand)
                <li><a href="{{ route('pna_landing_page') }}?search={{ $brand->name }}" class="text-dark">{{ $brand->name }}</a></li>
              @endforeach
            </ul>
            <h6 class="text-danger mb-1">Categories</h6>
            <ul>
              @foreach($pna_categories as $category)
                <li><a href="{{ route('pna_landing_page') }}?search={{ $category->name }}" class="text-dark">{{ $category->name }}</a></li>
              @endforeach
            </ul>
        </div>
    </div>
    <div class="col-md-9">
    <div class="row">
    @forelse ($pnas as $pna)
    <?php 
      $images = json_decode($pna->images, true);
      $averageRating = $pna->averageRating();
      $starRating = $pna->starRating();
    ?>
        <div class="col-md-4 mb-3">
            <div class="card">
                <a href="{{ route('pna_product_view', ['slug' => $pna->slug]) }}"><img src="{{ Storage::url($images[0]) }}" class="card-img-top pna_image"></a>
                <div class="card-body">
                  <h6 class="card-title mb-1"><a href="{{ route('pna_product_view', ['slug' => $pna->slug]) }}">{{ Str::limit($pna->title, 25) }}</a></h6>
                  <div class="mb-2">
                    @for ($i = 0; $i < 5; $i++)
                        @if ($i < $starRating)
                            <i class="fas fa-star text-warning"></i>
                        @else
                            <i class="fas fa-star"></i>
                        @endif
                    @endfor
                    <span>({{ $pna->user_reviews->count() }})</span>
                  </div>
                  <div class="d-flex">
                    <h5 class="text-danger">&#x9F3;{{ $pna->sale_price }}</h5>
                    @if($pna->regular_price) <small class="text-muted mx-1"><s>&#x9F3;{{ $pna->regular_price }}</s></small><small class="text-success">save up to {{ number_format((($pna->regular_price - $pna->sale_price) / $pna->regular_price) * 100, 0) }}%</small> @endif
                  </div>
                  <div class="text-center">
                    @if($pna->quantity > 0)
                    <button type="button" class="btn btn-outline-danger btn-sm add_to_cart_btn" 
                      data-id="{{ $pna->id }}" 
                      data-title="{{ $pna->title }}" 
                      data-slug="{{ $pna->slug }}" 
                      data-type="{{ $pna->type }}" 
                      data-image="{{ Storage::url($images[0]) }}" 
                      data-price="{{ $pna->sale_price }}" 
                      data-quantity="1"><i class="fa-solid fa-cart-shopping"></i> Add to Cart</button>
                    @else
                    <button type="button" class="btn btn-danger btn-sm" disabled><i class="fa-solid fa-cart-shopping"></i> Out of Stock</button>
                    @endif
                  </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center text-muted">
            <h4>no products found!</h4>
        </div>
    @endforelse
    </div>
    </div>
    <div class="col-12 d-flex justify-content-between align-items-baseline pt-5">
        <small class="text-muted">Showing {{ $pnas->firstItem() }} to {{ $pnas->lastItem() }} of {{ $pnas->total() }} results</small>
        {{ $pnas->links("partial.pagination") }}
    </div>
   </div>
  </div>
</section>
<!--================================= featured pna -->
@endsection
@section("script")
<script src="{{ asset('revolution/js/extensions/revolution.extension.actions.min.js') }}"></script>
<script src="{{ asset('revolution/js/extensions/revolution.extension.carousel.min.js') }}"></script>
<script src="{{ asset('revolution/js/extensions/revolution.extension.kenburn.min.js') }}"></script>
<script src="{{ asset('revolution/js/extensions/revolution.extension.layeranimation.min.js') }}"></script>
<script src="{{ asset('revolution/js/extensions/revolution.extension.migration.min.js') }}"></script>
<script src="{{ asset('revolution/js/extensions/revolution.extension.navigation.min.js') }}"></script>
<script src="{{ asset('revolution/js/extensions/revolution.extension.parallax.min.js') }}"></script>
<script src="{{ asset('revolution/js/extensions/revolution.extension.slideanims.min.js') }}"></script>
<script src="{{ asset('revolution/js/extensions/revolution.extension.video.min.js') }}"></script>
<script>
$(document).ready(function() {
  function updateCartBadge() {
    let cart = JSON.parse(localStorage.getItem('cart')) || []; 
    let totalItems = cart.length;
    if (totalItems > 0) {
      $('.cart_badge').text(totalItems).show();
    } else {
      $('.cart_badge').hide();
    }
  }

  function updateButtons() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    $('.add_to_cart_btn').each(function() {
      let productId = $(this).data('id');
      let inCart = cart.some(item => item.id === productId);
      if (inCart) {
        $(this).removeClass('btn-outline-danger');
        $(this).addClass('btn-success');
        $(this).html('<i class="fas fa-check"></i> Added to Cart');
        $(this).attr('disabled', true);
      }
    });
  }
  updateButtons();

  $('.add_to_cart_btn').on('click', function() {
      let product = {
        id: $(this).data('id'),
        title: $(this).data('title'),
        slug: $(this).data('slug'),
        type: $(this).data('type'),
        image: $(this).data('image'),
        price: $(this).data('price'),
        quantity: $(this).data('quantity')
      };
      let cart = JSON.parse(localStorage.getItem('cart')) || [];
      let existingProductIndex = cart.findIndex(item => item.id === product.id);
      if (existingProductIndex !== -1) {
        cart[existingProductIndex].quantity += 1;
      } else {
        cart.push(product);
      }
      localStorage.setItem('cart', JSON.stringify(cart));
      updateButtons();
      updateCartBadge();
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

(function($){
  "use strict";

    var tpj=jQuery;
      var revapi4;
      tpj(document).ready(function() {
        if(tpj("#rev_slider_4_1").revolution == undefined){
          revslider_showDoubleJqueryError("#rev_slider_4_1");
        }else{
          revapi4 = tpj("#rev_slider_4_1").show().revolution({
            sliderType:"standard",
            sliderLayout:"fullwidth",
            dottedOverlay:"none",
            delay:9000,
            navigation: {
              keyboardNavigation:"off",
              keyboard_direction: "horizontal",
              mouseScrollNavigation:"off",
             mouseScrollReverse:"default",
              onHoverStop:"off",
              bullets: {
                enable:true,
                hide_onmobile:false,
                style:"uranus",
                hide_onleave:false,
                direction:"horizontal",
                h_align:"right",
                v_align:"bottom",
                h_offset:40,
                v_offset:40,
                                space:8,
                tmp:'<span class="tp-bullet-inner"></span>'
              }
            },
            visibilityLevels:[1240,1024,778,480],
            gridwidth:1170,
            gridheight:900,
            lazyType:"none",
            parallax: {
              type:"mouse",
              origo:"enterpoint",
              speed:400,
              levels:[2,5,7,10,12,35,40,42,45,46,47,48,49,50,51,55],
              type:"mouse",
            },
            shadow:0,
            spinner:"spinner3",
            stopLoop:"off",
            stopAfterLoops:-1,
            stopAtSlide:-1,
            shuffle:"off",
            autoHeight:"off",
            disableProgressBar:"on",
            hideThumbsOnMobile:"off",
            hideSliderAtLimit:0,
            hideCaptionAtLimit:0,
            hideAllCaptionAtLilmit:0,
            debugMode:false,
            fallbacks: {
              simplifyAll:"off",
              nextSlideOnWindowFocus:"off",
              disableFocusListener:false,
            }
          });
        }
      });
 })(jQuery);
</script>
@endsection