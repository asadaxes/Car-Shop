@extends("admin_base")
@section("title") Orders @endsection
@section("style")
<style>
img.user_img{
    width: 25px;
    height: 25px;
    border-radius: 50%;
}
img.product_list_img{
    width: 25px;
}
img.invoice_logo{
    width: 125px;
}
div.signature_border{
    border-top: 1px solid #9d9d9d;
    width: 150px;
    text-align: center;
}
@media print {
    #invoice_print_content {        
        color-adjust: exact;
        -webkit-print-color-adjust: exact;
    }
}
</style>
@endsection
@section("content")
<div class="row">
<div class="col-12">
<h5 class="text-dark border-bottom">Parts/Accessories Orders</h5>
</div>
<div class="col-12 mb-3">
<form method="GET">
@csrf
    <div class="input-group">
        <input type="text" class="form-control py-4" name="search" id="search_field" placeholder="Search orders by order ID, user, amount or progress..." required>
        <div class="input-group-prepend">
            <button type="submit" class="input-group-text bg-light"><i class="fas fa-search"></i></button>
        </div>
    </div>
    <a href="{{ route('admin_pna_orders') }}" class="text-muted d-none" id="reset_btn"><small>reset</small></a>
</form>
</div>
<div class="col-12">
<div class="card card-body p-0">
<table class="table table-bordered table-hover text-center">
<thead class="bg-dark text-light">
    <tr>
        <th>#</th>
        <th>Order ID</th>
        <th>User</th>
        <th class="text-left">Products</th>
        <th>Quantity</th>
        <th>
            <span>Total Amount</span>
            <br>
            <small>(vat + tax included)</small>
        </th>
        <th>Shipping & Delivery</th>
        <th>Progress</th>
        <th>Order Placed at</th>
        <th>Invoice</th>
    </tr>
</thead>
<tbody>
    @php
        $orderQuantities = [];
        foreach ($orders as $order) {
            if (!isset($orderQuantities[$order->order_id])) {
                $orderQuantities[$order->order_id] = 0;
            }
            $orderQuantities[$order->order_id] += $order->quantity;
        }
    @endphp
    @forelse ($orders as $index => $order)
    @if ($index == 0 || $order->order_id != $orders[$index - 1]->order_id)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $order->order_id }}</td>
            <td>
                <a href="{{ route('admin_users_view', ['uid' => $order->user->id]) }}" class="text-dark">
                    <img src="{{ Storage::url($order->user->avatar) }}" class="user_img">
                    {{ $order->user->full_name }}
                </a>
            </td>
            <td class="text-left">
                <div class="d-flex flex-column align-items-start">
                    @foreach ($orders->where('order_id', $order->order_id) as $item)
                        <?php $images = json_decode($item->pna->images, true); ?>
                        <a href="{{ route('pna_product_view', ['slug' => $item->pna->slug]) }}" class="text-dark">
                            <img src="{{ Storage::url($images[0]) }}" class="img-fluid rounded product_list_img mr-1">
                            <small>{{ Str::limit($item->pna->title, 40) }}</small>
                        </a>
                    @endforeach
                </div>
            </td>
            <td>{{ $orderQuantities[$order->order_id] }}</td>
            <td>&#x9F3;{{ $order->amount }}</td>
            <td>
                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#shipping_and_delivert_view" data-snd="{{ $order->shipping_address }}" data-dm="{{ $order->delivery_method }}">view</button>
            </td>
            <td>
                <form action="{{ route('admin_pna_orders_status_updater') }}" method="POST">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                    <select name="deliver_status" class="custom-select">
                        <option value="preparing" {{ $order->deliver_status === 'preparing' ? 'selected' : '' }}>Preparing</option>
                        <option value="on_the_way" {{ $order->deliver_status === 'on_the_way' ? 'selected' : '' }}>On The way</option>
                        <option value="delivered" {{ $order->deliver_status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                    </select>
                </form>
            </td>
            <td>
                <div class="d-flex flex-column">
                    <small>{{ \Carbon\Carbon::parse($order->issued_at)->format('h:i A') }}</small>
                    <small>{{ \Carbon\Carbon::parse($order->issued_at)->format('M d, Y') }}</small>
                </div>
            </td>
            <td>
                @php
                    $productTitles = [];
                @endphp
                @foreach ($orders->where('order_id', $order->order_id) as $item)
                    @php
                        $products[] = [
                            'title' => $item->pna->title,
                            'sale_price' => $item->pna->sale_price,
                            'quantity' => $item->quantity
                        ];
                    @endphp
                @endforeach
                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#invoice_print" 
                data-id="{{ $order->order_id }}"
                data-date="{{ \Carbon\Carbon::parse($order->issued_at)->format('M d, Y') }}"
                data-shipping_address="{{ $order->shipping_address }}"
                data-products="{{ json_encode($products) }}"
                ><i class="fas fa-print"></i></button>
            </td>
        </tr>
    @endif
@empty
    <tr>
        <td colspan="4" class="text-center text-muted">No orders made yet!</td>
    </tr>
@endforelse
</tbody>
</table>
</div>
</div>
<div class="col-12 d-flex justify-content-between align-items-baseline py-4">
<small class="text-dark">Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} results</small>
{{ $orders->links("partial.pagination") }}
</div>
</div>

<div class="modal fade" id="shipping_and_delivert_view" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Shipping & Delivery Address</h5>
        <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body shipping_and_delivert_modal_body bg-light rounded pb-0">
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="invoice_print" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Print Invoice</h5>
        <button type="button" class="btn btn-info" id="invoice_print_btn">Print</button>
      </div>
      <div class="modal-body bg-light rounded pb-0">
        <div class="row" id="invoice_print_content">
           <div class="col-md-12">
              <div class="card">
                 <div class="card-body">
                    <div class="row">
                       <div class="col-sm-6">
                          <div class="mb-4 pull-left">
                             <img src="{{ Storage::url($settings->logo_site) }}" class="img-fluid invoice_logo mb-2">
                             <h6 class="text-dark">Sales Tax Invoice</h6>
                          </div>
                       </div>
                       <div class="col-sm-6">
                            <div class="text-sm-right mb-4">
                                <h4 class="text-danger mb-2 mt-md-2">Invoice <span id="invoice_modal_id"></span></h4>
                                <ul class="list list-unstyled mb-0">
                                    <li>Date: <span id="invoice_modal_date">March 15, 2020</span></li>
                                </ul>
                            </div>
                       </div>
                    </div>
                    <div class="d-flex flex-wrap mb-3">
                       <div class="mb-4 mb-md-2 text-left">
                          <span class="text-muted">Invoice From:</span>
                          <ul class="list list-unstyled mb-0">
                             <li>
                                <h5 class="my-2">{{ env("APP_NAME") }}</h5>
                             </li>
                             <li><i class="fas fa-location-dot text-dark"></i> {{ $settings->contact_address }}</li>
                             <li><i class="fas fa-phone text-dark"></i> {{ $settings->contact_phone }}</li>
                             <li><i class="fas fa-envelope text-dark"></i> {{ $settings->contact_email }}</li>
                          </ul>
                       </div>
                       <div class="mb-2 ml-sm-auto">
                          <span class="text-muted">Invoice To:</span>
                          <h5 class="my-2">Customer Details</h5>
                          <div class="d-flex flex-wrap wmin-md-400">
                             <ul class="list list-unstyled mb-0 text-left">
                                <li>Full Name:</li>
                                <li>Email:</li>
                                <li>Phone:</li>
                                <li>Address:</li>
                                <li>City:</li>
                                <li>Zip Code:</li>
                             </ul>
                             <ul class="list list-unstyled text-right mb-0 ml-auto" id="invoice_modal_shipping_info">
                             </ul>
                          </div>
                       </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm">
                           <thead>
                              <tr>
                                 <th>Products</th>
                                 <th class="text-center">Quantity</th>
                                 <th class="text-center">Unit Price</th>
                                 <th class="text-center">Total</th>
                              </tr>
                           </thead>
                           <tbody id="invoice_modal_items_table">
                           </tbody>
                        </table>
                    </div>
                 </div>
                 <div class="card-body">
                    <div class="d-flex justify-content-end mb-5">
                        <div>
                            <h6 class="text-dark">Total Due</h6>
                            <table class="table table-responsive">
                                <tbody>
                                    <tr>
                                        <th class="text-left">Subtotal:</th>
                                        <td class="text-right" id="invoice_modal_subtotal">0</td>
                                    </tr>
                                    <tr>
                                        <th class="text-left">Delivery Charge:</th>
                                        <td class="text-right" id="invoice_modal_delivery_charge">0</td>
                                    </tr>
                                    <tr>
                                        <th class="text-left">Tax:</th>
                                        <td class="text-right">&#x9F3;{{ $config->tax }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-left">Grand Total:</th>
                                        <td class="text-right text-danger">
                                        <h5 id="invoice_modal_grand_total">0</h5>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="signature_border">
                            <small>Authorized Signatory</small>
                        </div>
                        <div class="signature_border">
                            <small>Recipient Signature</small>
                        </div>
                    </div>
                 </div>
                 <div class="card-footer text-muted d-flex flex-column align-items-center">
                    <small>If you have any questions concerning this invoice, feel free to contact us: {{ $settings->contact_phone }} or {{ $settings->contact_email }}</small>
                    <small>Thank you for your purchasing.</small>
                 </div>
              </div>
           </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section("script")
<script src="{{ asset('js/printThis.js') }}"></script>
<script>
$(document).ready(function() {
    $('select[name="deliver_status"]').change(function() {
        $(this).closest('form').submit();
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

$('#shipping_and_delivert_view').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget);
    let snd = button.data('snd');
    let dm = button.data('dm');
    let delivery_method = dm === 'pay_with_ssl' ? 'Digital Payment' : 'Cash on Delivery';
    let modal = $(this);
    modal.find('.shipping_and_delivert_modal_body').html(`
        <div><i class="fa-solid fa-truck"></i> Payment Option: ${delivery_method}</div>
        <table class="table mb-0">
            <tbody>
                <tr>
                    <td class="fw-bold text-dark">Full Name</td>
                    <td>:</td>
                    <td>${snd.full_name}</td>
                </tr>
                <tr>
                    <td class="fw-bold text-dark">Email</td>
                    <td>:</td>
                    <td>${snd.email}</td>
                </tr>
                <tr>
                    <td class="fw-bold text-dark">Phone</td>
                    <td>:</td>
                    <td>${snd.phone}</td>
                </tr>
                <tr>
                    <td class="fw-bold text-dark">Address</td>
                    <td>:</td>
                    <td>${snd.address}</td>
                </tr>
                <tr>
                    <td class="fw-bold text-dark">City</td>
                    <td>:</td>
                    <td>${snd.city}</td>
                </tr>
                <tr>
                    <td class="fw-bold text-dark">State</td>
                    <td>:</td>
                    <td>${snd.state}</td>
                </tr>
                <tr>
                    <td class="fw-bold text-dark">Country</td>
                    <td>:</td>
                    <td>${snd.country}</td>
                </tr>
                <tr>
                    <td class="fw-bold text-dark">Zip Code</td>
                    <td>:</td>
                    <td>${snd.zip_code}</td>
                </tr>
            </tbody>
         </table>
    `);
});

$("#invoice_print_btn").click(function() {
    $("#invoice_print_content").printThis({
        importCSS: true,
        importStyle: true,
        pageTitle: "Invoice",
        printDelay: 1000,
        canvas: true
    });
});

$('#invoice_print').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget);
    let id = button.data('id');
    let date = button.data('date');
    let shipping_address = JSON.parse(JSON.stringify(button.data('shipping_address')));
    let products = JSON.parse(JSON.stringify(button.data('products')));
    let quantity = button.data('quantity');
    let amount = button.data('amount');
    let modal = $(this);
    modal.find('#invoice_modal_id').text(id);
    modal.find('#invoice_modal_date').text(date);

    let shipping_info_ul = modal.find('#invoice_modal_shipping_info');
    shipping_info_ul.empty();
    let shipping_info_items = [];
    $('<li>').text(shipping_address.full_name).appendTo(shipping_info_ul);
    $('<li>').text(shipping_address.email).appendTo(shipping_info_ul);
    $('<li>').text(shipping_address.phone).appendTo(shipping_info_ul);
    $('<li>').text(shipping_address.address).appendTo(shipping_info_ul);
    $('<li>').text(shipping_address.city + ", " + shipping_address.state).appendTo(shipping_info_ul);
    $('<li>').text(shipping_address.zip_code).appendTo(shipping_info_ul);

    let subtotal = 0;
    let items_table = modal.find('#invoice_modal_items_table');
    items_table.empty();
    products.forEach(function(product) {
        let tr = $("<tr>");
        let total = product.sale_price * product.quantity;
        subtotal += total;
        tr.append($("<td>").text(product.title));
        tr.append($("<td class='text-center'>").text(product.quantity));
        tr.append($("<td class='text-center'>").text(product.sale_price));
        tr.append($("<td class='text-center'>").text(total));
        items_table.append(tr);
    });

    let delivery_charge = parseInt(shipping_address.city === "Dhaka" ? "{{ $config->delivery_charge_inside }}" : "{{ $config->delivery_charge_outside }}");

    $('#invoice_modal_subtotal').html("&#x9F3;" + subtotal);
    $('#invoice_modal_delivery_charge').html("&#x9F3;" + delivery_charge);
    $('#invoice_modal_grand_total').html("&#x9F3;" + (subtotal + delivery_charge + parseInt("{{ $config->tax }}")));
});
</script>
@endsection