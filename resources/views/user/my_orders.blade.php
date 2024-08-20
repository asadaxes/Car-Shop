@extends("general_base")
@section("title") CarShop - My Order History @endsection
@section("style")
<style>
.hr_bg{
    background-color: #c3c3c3;
    border: none;
}
img.product_list_img{
    width: 25px;
}
</style>
@endsection
@section("content")
<div class="container mtb_6030">
<div class="row mb-4">
<div class="col-12 mb-3">
    <h5 class="text-danger text-center mb-0">Order History</h5>
    <hr class="hr_bg">
</div>
<div class="col-12 table-responsive">
<table class="table table-bordered table-hover table-responsive text-center">
<thead class="bg-dark text-light">
    <tr>
        <th>Order ID</th>
        <th class="text-left">Products</th>
        <th>Quantity</th>
        <th>Amount</th>
        <th>Shipping & Delivery</th>
        <th>Progress</th>
        <th>Date</th>
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
            <td>{{ $order->order_id }}</td>
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
                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#shipping_and_delivert_view" data-snd="{{ $order->shipping_address }}" data-dm="{{ $order->delivery_method }}">view</button>
            </td>
            <td>
                @if($order->deliver_status == "preparing")
                    <span class="text-danger"><i class="fa-solid fa-dolly"></i> {{ ucfirst($order->deliver_status) }}</span>
                @elseif($order->deliver_status == "on_the_way")
                    <span class="text-primary"><i class="fa-solid fa-truck"></i> On The way</span>
                @elseif($order->deliver_status == "delivered")
                    <span class="text-success"><i class="fa-solid fa-square-check"></i> {{ ucfirst($order->deliver_status) }}</span>
                @endif
            </td>
            <td>
                <div class="d-flex flex-column">
                    <small>{{ \Carbon\Carbon::parse($order->issued_at)->format('h:i A') }}</small>
                    <small>{{ \Carbon\Carbon::parse($order->issued_at)->format('M d, Y') }}</small>
                </div>
            </td>
        </tr>
    @endif
@empty
    <tr>
        <td colspan="7" class="text-center text-muted">No orders made yet!</td>
    </tr>
@endforelse
</tbody>
</table>
</div>
<div class="col-12 d-flex justify-content-between align-items-baseline py-4">
<small class="text-dark">Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} results</small>
{{ $orders->links("partial.pagination") }}
</div>
</div>
</div>

<div class="modal fade" id="shipping_and_delivert_view" tabindex="-1" >
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Shipping & Delivery Address</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body shipping_and_delivert_modal_body bg-light rounded pb-0">
      </div>
    </div>
  </div>
</div>
@endsection
@section("script")
<script>
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

@if(session('payment_successful_clean_cart'))
    document.addEventListener('DOMContentLoaded', function() {
    localStorage.removeItem('cart');
    fetch('{{ route('clear_payment_success_session') }}')
        .then(response => response.json())
        .then(data => console.log(data.message))
        .catch(error => console.error('Error:', error));
    });
@endif
</script>
@endsection