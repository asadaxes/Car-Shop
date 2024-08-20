@extends("admin_base")
@section("title") Dashboard @endsection
@section("style")
<style>
.avatar_img{
    width: 25px;
    height: 25px;
    border-radius: 50%;   
}
</style>
@endsection
@section("content")
<div class="row">
<div class="col-12">
<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Users</span>
                <span class="info-box-number">{{ $total_users }}</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-car"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Vehicles Listed</span>
                <span class="info-box-number">{{ $total_vehicles }}</span>
            </div>
        </div>
    </div>
    <div class="clearfix hidden-md-up"></div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-car-on"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Parts & Accessories</span>
                <span class="info-box-number">{{ $total_pna }}</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fa-solid fa-clipboard-list"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Active Orders</span>
                <span class="info-box-number">{{ $incomplete_orders }}</span>
            </div>
        </div>
    </div>
</div>
</div>
<div class="col-md-6">
<div class="card card-body">
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#vehicles_chart" role="tab">Vehicle Ads</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#pna_chart" role="tab">Parts & Accessories</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="vehicles_chart" role="tabpanel">
            <canvas id="vehiclesChart" height="375"></canvas>
        </div>
        <div class="tab-pane fade" id="pna_chart" role="tabpanel">
            <canvas id="pnaChart" height="375"></canvas>
        </div>
    </div>
</div>
</div>
<div class="col-md-6">
<div class="card card-body">
    <span class="text-muted text-center">Monthly Profit Comparison</span>
    <div>
        <canvas id="profit_compare_chart" height="393"></canvas>
    </div>
</div>
</div>
</div>

<div class="row mb-3">
<div class="col-md-4 mb-md-0 mb-3">
<div class="card card-body">
    <small class="text-muted"><i class="fas fa-car"></i> Total Vehicles Based on Condition</small>
    <table class="table text-center">
        <thead>
            <tr>
                <th>New</th>
                <th>Used</th>
                <th>Reconditioned</th>
                <th>Modified</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $total_new_vehicles }}</td>
                <td>{{ $total_used_vehicles }}</td>
                <td>{{ $total_recondition_vehicles }}</td>
                <td>{{ $total_modified_vehicles }}</td>
            </tr>
        </tbody>
    </table>
</div>
<ul class="list-group">
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Total Payments
    <span class="text-danger">{{ $total_payments }} BDT</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Total Brands
    <span class="badge badge-danger badge-pill">{{ $total_brands }}</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Total Blogs
    <span class="badge badge-danger badge-pill">{{ $total_blogs }}</span>
  </li>
</ul>
</div>
<div class="col-md-8">
<div class="card card-body">
    <small class="text-muted"><i class="fa-solid fa-landmark"></i> Recent Payments</small>
    <table class="table table-striped text-center">
        <thead>
            <tr>
                <th>User</th>
                <th>Source</th>
                <th><i class="fa-solid fa-bangladeshi-taka-sign"></i> Amount</th>
                <th>Transaction ID</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($recent_payments as $payment)
                <tr>
                    <td>
                        <a href="{{ route('admin_users_view', ['uid' => $payment->user->id]) }}" class="text-dark"><img src="{{ Storage::url($payment->user->avatar) }}" class="img-fluid avatar_img">
                        {{ $payment->user->full_name }}</a>
                    </td>
                    <td>
                        @if ($payment->vehicle_id !== null)
                            Vehicle
                        @elseif ($payment->pna_order_id !== null)
                            Product
                        @endif
                    </td>
                    <td>{{ $payment->amount }}</td>
                    <td>{{ $payment->tran_id }}</td>
                    <td>
                        @if ($payment->status == 'Pending')
                            <span class="badge badge-warning">Pending</span>
                        @elseif ($payment->status == 'Failed')
                            <span class="badge badge-danger">Failed</span>
                        @elseif ($payment->status == 'Cancel')
                            <span class="badge badge-secondary">Cancelled</span>
                        @elseif ($payment->status == 'Complete' || $payment->status == 'Processing')
                            <span class="badge badge-success">{{ ucfirst($payment->status) }}</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">no payments!</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</div>
</div>
@endsection
@section("script")
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const currentDate = new Date();
    const currentMonth = currentDate.getMonth() + 1;
    const currentYear = currentDate.getFullYear();
    const numDaysInMonth = new Date(currentYear, currentMonth, 0).getDate();

    let paymentsByDayVehicles = Array.from({ length: numDaysInMonth }, () => 0);
    let paymentsByDayPna = Array.from({ length: numDaysInMonth }, () => 0);

    {!! $payments_vehicles->toJson() !!}.forEach(payment => {
        let day = new Date(payment.issued_at).getDate();
        paymentsByDayVehicles[day - 1] += parseFloat(payment.amount);
    });
    {!! $payments_pna->toJson() !!}.forEach(payment => {
        let day = new Date(payment.issued_at).getDate();
        paymentsByDayPna[day - 1] += payment.amount;
    });

    let labels = Array.from({ length: numDaysInMonth }, (_, index) => (index + 1).toString());

    let vehiclesChart = new Chart(document.getElementById('vehiclesChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Monthly Payments from Vehicle Ad Campaigns',
                data: paymentsByDayVehicles,
                backgroundColor: 'rgba(255, 99, 132, 1)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Day of the Month'
                    }
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Amount'
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                },
            },
        },
    });

    let pna_chart = new Chart(document.getElementById('pnaChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Monthly Payments from Parts & Accessories Sell',
                data: paymentsByDayPna,
                backgroundColor: 'rgba(40, 167, 69, 0.9)',
                borderColor: 'rgba(40, 167, 69, 0.9)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Day of the Month'
                    }
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Amount'
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                },
            },
        },
    });
    

    const paymentsVehicles = {!! $payments_vehicles->toJson() !!};
    const paymentsPna = {!! $payments_pna->toJson() !!};
    const calculateTotalAmount = (payments) => {
        return payments.reduce((total, payment) => total + payment.amount, 0);
    };
    const totalVehicles = calculateTotalAmount(paymentsVehicles);
    const totalPna = calculateTotalAmount(paymentsPna);

    let profitCompareChart = new Chart(document.getElementById('profit_compare_chart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: [
                'Vehicles',
                'Parts & Accessories'
            ],
            datasets: [{
                label: 'Profit Comparison',
                data: [totalVehicles, totalPna],
                backgroundColor: [
                    'rgba(220, 53, 69, 0.9)',
                    'rgba(40, 167, 69, 0.9)'
                ],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return 'Total Amount: ' + tooltipItem.raw + ' BDT';
                        }
                    }
                }
            }
        }
    });
});
</script>
@endsection