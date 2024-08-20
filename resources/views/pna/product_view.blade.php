@extends("general_base")
@section("product_meta_title")
<meta name="title" content="{{ $product->meta_title }}" />
@endsection
@section("product_meta_description")
<meta name="description" content="{{ $product->meta_description }}" />
@endsection
@section("title") CarShop - {{ $product->title }} @endsection
<?php 
$images = json_decode($product->images, true);
$averageRating = $product->averageRating();
$starRating = $product->starRating();
?>
@section("style")
<style>
img.img-fluid.cursor_pointer.slider_img{
  height: 350px;
}
img.img-fluid.cursor_pointer.slider_img_selector{
  height: 60px;
}
div.progress{
    width: 125px;
}
</style>
@endsection
@section("content")
<section class="page-section-pt pb-5">
<div class="container">
<div class="row">

<div class="col-12">
<div class="row">
<div class="col-md-9">
<div class="row">
    <div class="col-md-6 mb-md-0 mb-4">
        <div class="slider-slick">
            <div class="slider slider-for detail-big-car-gallery mb-2">
            @foreach ($images as $image)
                <img class="img-fluid rounded cursor_pointer slider_img" src="{{ Storage::url($image) }}">
            @endforeach
            </div>
            <div class="slider slider-nav">
            @foreach ($images as $image)
                <img class="img-fluid cursor_pointer slider_img_selector" src="{{ Storage::url($image) }}">
            @endforeach
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <h2 class="text-danger fw-normal">{{ $product->title }}</h2>
        <div>
            <span>{{ number_format($averageRating, 1) }}</span>
            @for ($i = 0; $i < 5; $i++)
                @if ($i < $starRating)
                    <i class="fas fa-star text-warning"></i>
                @else
                    <i class="fas fa-star"></i>
                @endif
            @endfor
            <span>({{ $product->user_reviews->count() }} ratings)</span>
        </div>
        <span>Brand: <a href="">{{ $product->brand->name }}</a></span>
        <span> | </span>
        <span>Category: <a href="">{{ $product->category->name }}</a></span>
        <div class="d-flex flex-column border-top mt-2 pt-2">
            <h3 class="text-danger fw-normal">&#x9F3;{{ $product->sale_price }}</h3>
            @if($product->regular_price)
                <div>
                    <span class="text-muted mx-1"><s>&#x9F3;{{ $product->regular_price }}</s></span>
                    <span class="text-success">save up to {{ number_format((($product->regular_price - $product->sale_price) / $product->regular_price) * 100, 0) }}%</span>
                </div>
            @endif
        </div>
        <div class="row mt-3 mb-4">
        <div class="col-md-6">
            <div class="text-dark">Quantity</div>
            <div class="input-group">
                <span class="input-group-text update_quantity_btn_minus cursor_pointer"><i class="fa-solid fa-minus"></i></span>
                <input type="number" class="form-control text-center update_quantity_field" min="1" max="{{ $product->quantity }}" value="{{ $product->quantity === 0 ? 0 : 1 }}">
                <span class="input-group-text update_quantity_btn_plus cursor_pointer"><i class="fa-solid fa-plus"></i></span>
            </div>
        </div>
        </div>
        <div class="text-center">
            @if($product->quantity > 0)
                <button type="button" class="btn btn-outline-danger add_to_cart_btn" 
                    data-id="{{ $product->id }}" 
                    data-title="{{ $product->title }}" 
                    data-slug="{{ $product->slug }}" 
                    data-type="{{ $product->type }}" 
                    data-image="{{ Storage::url($images[0]) }}" 
                    data-price="{{ $product->sale_price }}" 
                    data-quantity="1"><i class="fas fa-shopping-cart"></i> Add to Cart</button>
            @else
                <h4 class="text-danger">Out of Stock</h4>
            @endif
        </div>
    </div>
</div>
</div>
<div class="col-md-3">
<ul class="list-group">
    <li class="list-group-item bg-light">
        <h6 class="fw-normal text-muted">Delivery Charges</h6>
        <div class="d-flex justify-content-between mb-2">
            <span class="fw-bold text-dark">Inside Dhaka</span>
            <span class="text-danger">{{ $charges->delivery_charge_inside }} BDT</span>
        </div>
        <div class="d-flex justify-content-between">
            <span class="fw-bold text-dark">Outside of Dhaka</span>
            <span class="text-danger">{{ $charges->delivery_charge_outside }} BDT</span>
        </div>
    </li>
    <li class="list-group-item bg-light">
        <i class="fas fa-hand-holding-dollar"></i> Cash on Delivery Available
    </li>
    <li class="list-group-item bg-light">
        @if($product->has_warranty)
            <span><i class="fas fa-award"></i> Warranty</span>
        @else
            <span class="text-muted"><i class="fas fa-circle-xmark"></i> No Warranty</span>
        @endif
    </li>
</ul>
</div>
</div>
</div>

<div class="col-12 border-top border-bottom my-4 pt-2">
    <h6 class="text-dark">About this product</h6>
    <p>{!! $product->description !!}</p>
    <div class="mt-4 mb-2">
        @foreach(json_decode($product->tags) as $tag)
            <span class="badge bg-light border text-dark">{{ $tag }}</span>
        @endforeach
    </div>    
</div>

<div class="col-12 border-bottom mb-4 pb-3">
<h6 class="text-dark">Customers Feedback</h6>
<div class="row">
    <div class="col-md-3 d-flex flex-column align-items-center justify-content-center border-end mt-3">
        <h1 class="fw-normal text-dark">{{ number_format($averageRating, 1) }}</h1>
        <span>({{ $product->user_reviews->count() }} reviews)</span>
    </div>
    <div class="col-md-4">
        <?php
            $distribution = $product->starRatingDistribution();
            $totalReviews = $product->user_reviews->count();
        ?>
        @foreach ([5, 4, 3, 2, 1] as $stars)
            <?php 
                $count = $distribution[$stars] ?? 0; 
                $percentage = $totalReviews ? ($count / $totalReviews) * 100 : 0;
            ?>
            <div class="d-flex align-items-center">
                <div class="me-3">
                    @for ($i = 0; $i < 5; $i++)
                        <i class="fas fa-star {{ $i < $stars ? 'text-warning' : '' }}"></i>
                    @endfor
                </div>
                <div class="progress mt-0 me-2" role="progressbar" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar bg-warning" style="width: {{ $percentage }}%;"></div>
                </div>
                <span>{{ $count }}</span>
            </div>
        @endforeach
    </div>
</div>
</div>

<div class="col-12">
<ul class="list-group">
    @if(auth()->check() && auth()->user()->hasPurchased($product->id, auth()->id()) && !$userReview)
        <li class="list-group-item">
            <form action="{{ route('pna_product_review_handler') }}" method="POST">
            @csrf
                <input type="hidden" name="pna_id" value="{{ $product->id }}">
                <h6 class="text-muted">Feel free to leave a feedback...</h6>
                <div class="rating_stars text-center mb-2">
                    <i class="fas fa-star fa-2x cursor_pointer" data-value="1"></i>
                    <i class="fas fa-star fa-2x cursor_pointer" data-value="2"></i>
                    <i class="fas fa-star fa-2x cursor_pointer" data-value="3"></i>
                    <i class="fas fa-star fa-2x cursor_pointer" data-value="4"></i>
                    <i class="fas fa-star fa-2x cursor_pointer" data-value="5"></i>
                    <input type="hidden" name="rating">
                </div>
                <div class="d-flex">
                    <input type="text" name="feedback" class="form-control" placeholder="write here..." required>
                    <button type="submit" class="btn btn-danger">Submit</button>
                </div>
            </form>
        </li>
    @endif
    @foreach ($reviews as $review)
        <li class="list-group-item">
            <div>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        @for ($i = 0; $i < 5; $i++)
                            @if ($i < $review->rating)
                                <i class="fas fa-star fa-sm text-warning"></i>
                            @else
                                <i class="fas fa-star fa-sm"></i>
                            @endif
                        @endfor
                        <small class="text-muted ms-2">{{ $review->user->full_name }}</small>
                    </div>
                    <small class="text-muted">{{ \Carbon\Carbon::parse($review->issued_at)->diffForHumans() }}</small>
                </div>
                <p class="mb-0">{{ $review->feedback }}</p>
            </div>
        </li>
    @endforeach
</ul>
@if($reviews->count() > 10)
<div class="col-12 d-flex justify-content-between align-items-baseline pt-5">
<small class="text-muted">Showing {{ $reviews->firstItem() }} to {{ $reviews->lastItem() }} of {{ $reviews->total() }} reviews</small>
{{ $reviews->links("partial.pagination") }}
</div>
@endif
</div>

</div>
</div>
</section>
@endsection
@section("script")
<script>
$(document).ready(function() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let productId = $('.add_to_cart_btn').data('id');
    let productIndex = cart.findIndex(item => item.id === productId);
    if (productIndex !== -1 && cart !== null) {
        let quantityToShow = cart[productIndex].quantity;
        if (quantityToShow > 1) {
            $('.add_to_cart_btn').removeAttr('data-quantity');
            $('.add_to_cart_btn').attr('data-quantity', quantityToShow);
            $('.update_quantity_field').attr('value', quantityToShow);
        } else {
            $('.add_to_cart_btn').removeAttr('data-quantity');
            $('.add_to_cart_btn').attr('data-quantity', 1);
            $('.update_quantity_field').attr('value', 1);
        }
    }

    $('.update_quantity_btn_minus').click(function() {
        let currentValue = parseInt($('.update_quantity_field').val());
        let maxValue = parseInt($('.update_quantity_field').attr('max'));
        if (currentValue > 1) {
            $('.update_quantity_field').removeAttr('value');
            $('.update_quantity_field').attr('value', currentValue - 1);
            $('.add_to_cart_btn').removeAttr('data-quantity');
            $('.add_to_cart_btn').attr('data-quantity', currentValue - 1);
            if (productIndex !== -1 && cart !== null) {
                cart[productIndex].quantity = currentValue - 1;
                localStorage.setItem('cart', JSON.stringify(cart));
            }
        }
    });

    $('.update_quantity_btn_plus').click(function() {
        let currentValue = parseInt($('.update_quantity_field').val());
        let maxValue = parseInt($('.update_quantity_field').attr('max'));
        if (currentValue < maxValue) {
            $('.update_quantity_field').removeAttr('value');
            $('.update_quantity_field').attr('value', currentValue + 1);
            $('.add_to_cart_btn').removeAttr('data-quantity');
            $('.add_to_cart_btn').attr('data-quantity', currentValue + 1);
            if (productIndex !== -1 && cart !== null) {
                cart[productIndex].quantity = currentValue + 1;
                localStorage.setItem('cart', JSON.stringify(cart));
            }
        }
    });

    $('.rating_stars i').mouseover(function() {
        const value = parseInt($(this).attr('data-value'));
        highlightStars(value);
    });

    $('.rating_stars i').mouseleave(function() {
        const currentValue = parseInt($('input[name="rating"]').val());
        highlightStars(currentValue);
    });

    $('.rating_stars i').click(function() {
        const value = parseInt($(this).attr('data-value'));
        $('input[name="rating"]').val(value);
        highlightStars(value);
    });

    function highlightStars(value) {
        $('.rating_stars i').each(function() {
            const starValue = parseInt($(this).attr('data-value'));
            $(this).toggleClass('text-warning', starValue <= value);
        });
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
</script>
@endsection