@extends("general_base")
@section("title") CarShop - Checkout @endsection
@section("style")
<style>
.text_transform_none{
    text-transform: none;
}
.selected_deliver_option_active {
    border: 3px #db2d2e70 solid !important;
}
</style>
@endsection
@section("content")
<section class="gray-bg page-section-pt pb-4">
<form action="{{ route('pna_checkout_handler') }}" method="POST">
@csrf
<div class="container">
<div class="row">
<div class="col-12 d-flex justify-content-between mb-2">
<h5 class="text-danger"><a href="{{ route('pna_cart') }}" class="text-muted"><i class="fa-solid fa-cart-shopping text-muted"></i> My Cart</a>/Checkout</h5>
<a href="{{ route('pna_cart') }}" class="btn btn-sm border">Edit Cart</a>
</div>

<div class="col-md-8">
    <div class="card card-body mb-3">
        <div class="d-flex justify-content-between border-bottom pb-1 mb-2">
            <h6 class="text-dark text_transform_none mb-0">Shipping Address</h6>
            <a href="{{ route('user_profile') }}" class="text-muted"><i class="fas fa-edit"></i></a>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="full_name" class="text-dark mb-0">Full Name</label>
                <input type="text" name="full_name" class="form-control" id="full_name" value="{{ auth()->user()->full_name }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="email" class="text-dark mb-0">Email</label>
                <input type="email" name="email" class="form-control" id="email" value="{{ auth()->user()->email }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="phone" class="text-dark mb-0">Contact Number</label>
                <input type="tel" name="phone" class="form-control" id="phone" value="{{ auth()->user()->phone }}" required>
            </div>
            <div class="col-md-12 mb-3">
                <label for="address" class="text-dark mb-0">Address</label>
                <textarea name="address" class="form-control" id="address" rows="2" required>{{ auth()->user()->address }}</textarea>
            </div>
            <div class="col-md-6 mb-3">
                <label for="city" class="text-dark mb-0">City</label>
                <select name="city" class="form-select py-2" id="city" required>
                    <option value="default" selected>Select a city</option>
                    <option value="Dhaka">Dhaka</option>
                    <option value="Chittagong">Chittagong</option>
                    <option value="Khulna">Khulna</option>
                    <option value="Rajshahi">Rajshahi</option>
                    <option value="Comilla">Comilla</option>
                    <option value="Mymensingh">Mymensingh</option>
                    <option value="Barisal">Barisal</option>
                    <option value="Sylhet">Sylhet</option>
                    <option value="Rangpur">Rangpur</option>
                    <option value="Cox's Bazar">Cox's Bazar</option>
                    <option value="Jessore">Jessore</option>
                    <option value="Narayanganj">Narayanganj</option>
                    <option value="Dinajpur">Dinajpur</option>
                    <option value="Pabna">Pabna</option>
                    <option value="Tangail">Tangail</option>
                    <option value="Bogra">Bogra</option>
                    <option value="Narsingdi">Narsingdi</option>
                    <option value="Jhenaidah">Jhenaidah</option>
                    <option value="Faridpur">Faridpur</option>
                    <option value="Jamalpur">Jamalpur</option>
                    <option value="Saidpur">Saidpur</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="state" class="text-dark mb-0">State</label>
                <input type="text" name="state" class="form-control" id="state" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="country" class="text-dark mb-0">Country</label>
                <input type="text" name="country" class="form-control" id="country" value="Bangladesh" required readonly>
            </div>
            <div class="col-md-6">
                <label for="zip_code" class="text-dark mb-0">Zip Code</label>
                <input type="tel" name="zip_code" class="form-control" id="zip_code" required>
            </div>
        </div>
        <input type="hidden" name="delivery_method" id="delivery_method" value="pay_with_ssl">
        <input type="hidden" name="products" id="delivery_products">
    </div>
    <div class="card card-body">
        <h6 class="text-dark border-bottom text_transform_none">Select Delivery Option</h6>
        <span class="btn btn-light border selected_deliver_option mb-2" data-method="pay_with_ssl">
            <ul class="list-inline mb-2">
                <li>Pay with</li>
                <li><img src="{{ asset('images/payments/bkash.jpg') }}" class="payment_method_logo border"></li>
                <li><img src="{{ asset('images/payments/nagad.jpg') }}" class="payment_method_logo border"></li>
                <li><img src="{{ asset('images/payments/rocket.jpg') }}" class="payment_method_logo border"></li>
                <li><img src="{{ asset('images/payments/upay.png') }}" class="payment_method_logo border"></li>
                <li><img src="{{ asset('images/payments/mastercard.jpg') }}" class="payment_method_logo border"></li>
                <li><img src="{{ asset('images/payments/visa.jpg') }}" class="payment_method_logo border"></li>
                <li><img src="{{ asset('images/payments/american_express.jpg') }}" class="payment_method_logo border"></li>
            </ul>
            <small class="text-muted"><i class="fa-solid fa-shield-halved"></i> Secured by SSLCOMMERZ</small>
        </span>
        <span class="btn btn-light border selected_deliver_option" data-method="cash_on_delivery">
            <h6 class="text_transform_none mb-0">Cash on Delivery <i class="fa-solid fa-people-carry-box"></i></h6>
        </span>
    </div>
</div>
<div class="col-md-4">
    <ul class="list-group">
        <li class="list-group-item">
            <h6 class="text_transform_none text-muted mb-0">Order Summary</h6>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Items</span>
            <span id="summary_items">0</span>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Subtotal</span>
            <span id="summary_subtotal">&#x9F3;0</span>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Tax</span>
            <span>&#x9F3;{{ $charges->tax }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Delivery Charge</span>
            <span id="summary_delivery_charge">&#x9F3;0</span>
        </li>
        <li class="list-group-item fw-bold d-flex justify-content-end">
            Total Cost: &nbsp;<span id="summary_total_cost">0</span>&nbsp; BDT
        </li>
    </ul>
    <div class="text-center mt-3">
        <button class="btn btn-outline-success btn-lg">Confirm & Place Order <i class="fa-solid fa-check"></i></button>
    </div>
</div>

</div>
</div>
</form>
</section>
@endsection
@section("script")
<script>
$(document).ready(function() {
    $('.selected_deliver_option').on('click', function() {
        $('.selected_deliver_option').removeClass('selected_deliver_option_active');
        $(this).addClass('selected_deliver_option_active');
        $('#delivery_method').val($(this).data('method'));
    });

    let cartData = JSON.parse(localStorage.getItem('cart')) || [];
    let cartDataString = JSON.stringify(cartData);
    $('#delivery_products').val(cartDataString);

    let taxValue = parseInt("{{ $charges->tax }}");
    let deliveryChargeDhaka = parseInt("{{ $charges->delivery_charge_inside }}");
    let deliveryChargeOutside = parseInt("{{ $charges->delivery_charge_outside }}");

    function updateDeliveryCharge(selectedCity) {
        let deliveryChargeValue = 0;
        if(selectedCity === 'Dhaka'){
            deliveryChargeValue = deliveryChargeDhaka;
        }else if(selectedCity === 'default'){
            deliveryChargeValue = 0;
        }else{
            deliveryChargeValue = deliveryChargeOutside;
        }
        $('#summary_delivery_charge').html('&#x9F3;' + deliveryChargeValue);
        return deliveryChargeValue;
    }
    
    $('#city').change(function() {
        let selectedCity = $(this).val();
        let deliveryChargeValue = updateDeliveryCharge(selectedCity);
        calculateTotalCost(deliveryChargeValue);
    });

    function calculateTotalCost(deliveryChargeValue) {
        let cartData = JSON.parse(localStorage.getItem('cart')) || [];
        let itemsValue = cartData.reduce((total, product) => total + product.quantity, 0);
        $('#summary_items').text(itemsValue);
        let subtotalValue = cartData.reduce((total, product) => total + (product.price * product.quantity), 0);
        $('#summary_subtotal').html('&#x9F3;' + subtotalValue);
        let totalCostValue = subtotalValue + taxValue + deliveryChargeValue;
        $('#summary_total_cost').html('&#x9F3;' + totalCostValue);
    }

    let selectedCity = $('#city').val();
    let initialDeliveryCharge = updateDeliveryCharge(selectedCity);
    calculateTotalCost(initialDeliveryCharge);
});
</script>
@endsection