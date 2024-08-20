@extends("general_base")
@section("title") CarShop - My Cart @endsection
@section("style")
<style>
img.cart_product_img{
    width: 80px;
}
.subtotal_label{
    text-transform: none;
}
.shipping_address_table{
    width: auto;
}
</style>
@endsection
@section("content")
<section class="gray-bg page-section-pt pb-4">
<div class="container">
<div class="card card-body">
<div class="row">
<div class="col-12 border-bottom mb-2">
    <h5 class="text-danger"><i class="fa-solid fa-cart-shopping text-muted"></i> My Cart</h5>
</div>

<div class="col-12">
<table class="table">
    <thead>
        <tr>
            <th scope="col">Product</th>
            <th scope="col">Price</th>
            <th scope="col">Quantity</th>
            <th scope="col">Total</th>
            <th scope="col"><i class="fas fa-minus-circle"></i></th>
        </tr>
    </thead>
    <tbody id="cart_container">
    </tbody>
</table>
</div>
<div class="col-12 d-flex justify-content-end">
    <h5 class="text-danger subtotal_label">Subtotal: <span id="subtotal_amount">0</span> BDT</h5>
</div>
<div class="col-12 text-center">
<a href="{{ route('pna_checkout') }}" class="btn btn-success">Proceed to Checkout <i class="fa-solid fa-angle-right"></i></a>
</div>

</div>
</div>
</div>
</section>
@endsection
@section("script")
<script>
$(document).ready(function() {
    let productURL = "{{ route('pna_product_view', ['slug' => '88removethisfromurl88']) }}".split("88removethisfromurl88")[0];
    function updateCartBadge() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let totalItems = cart.length;
        if (totalItems > 0) {
            $('.cart_badge').text(totalItems).show();
        } else {
            $('.cart_badge').hide();
        }
    }

    let cartContainer = $("#cart_container");
    let subtotalAmount = $("#subtotal_amount");

    let products = JSON.parse(localStorage.getItem("cart"));
    if (products && products.length > 0) {
        let subtotal = 0;
        products.forEach(function(product) {
            let totalPrice = product.price * product.quantity;
            subtotal += totalPrice;
            let trHtml = `
                <tr>
                    <td>
                        <a href="${productURL+product.slug}" class="d-flex text-dark">
                            <img src="${product.image}" class="img-fluid rounded cart_product_img me-2">${product.title}
                        </a>
                    </td>
                    <td>&#x9F3;${product.price}</td>
                    <td class="text-center">${product.quantity}</td>
                    <td>&#x9F3;${totalPrice}</td>
                    <td><a href="javascript:void(0)" class="delete_item" data-id="${product.id}"><i class="fas fa-trash-alt text-danger"></i></a></td>
                </tr>
            `;
            cartContainer.append(trHtml);
        });
        subtotalAmount.text(subtotal);
    } else {
        cartContainer.html("<tr><td colspan='5' class='text-center'>Your cart is empty.</td></tr>");
    }

    cartContainer.on('click', '.delete_item', function() {
        let productId = $(this).data('id');
        let updatedCart = products.filter(item => item.id !== productId);
        localStorage.setItem('cart', JSON.stringify(updatedCart));
        $(this).closest('tr').remove();
        products = updatedCart;
        let subtotal = 0;
        updatedCart.forEach(function(product) {
            subtotal += product.price * product.quantity;
        });
        subtotalAmount.text(subtotal);
        updateCartBadge();
        if (updatedCart.length === 0) {
            cartContainer.html("<tr><td colspan='5' class='text-center'>Your cart is empty.</td></tr>");
            subtotalAmount.text("0.00");
        }
    });
});
</script>
@endsection