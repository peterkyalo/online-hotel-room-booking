@extends('admin.layout.app')

@section('heading', 'Dashboard')
@section('main_content')
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fa fa-user"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Completed Orders</h4>
                    </div>
                    <div class="card-body">
                        {{ $total_completed_orders }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i class="fa fa-user"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Pending Orders</h4>
                    </div>
                    <div class="card-body">
                        {{ $total_completed_orders }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fa fa-bullhorn"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Active Customers</h4>
                    </div>
                    <div class="card-body">
                        {{ $total_active_customers }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i class="fa fa-user"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Pending Customers</h4>
                    </div>
                    <div class="card-body">
                        {{ $total_pending_customers }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fa fa-user"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Rooms</h4>
                    </div>
                    <div class="card-body">
                        {{ $total_rooms }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i class="fa fa-user"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Subscribers</h4>
                    </div>
                    <div class="card-body">
                        {{ $total_subscribers }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <section class="section">
                <div class="section-header">
                    <h1>Recent Orders</h1>
                </div>
            </section>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="example1">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Order No</th>
                                                <th>Checkout Request ID </th>
                                                <th>Mpesa Receipt Number</th>
                                                <th>Payment Method</th>
                                                <th>Booking Date</th>
                                                <th>Paid Amount</th>
                                                <th>Status</th>
                                                <th>Details</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $row)
                                                <tr>
                                                    <td>
                                                        {{-- {{ $row->id }} --}}
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    <td>
                                                        {{ $row->order_no }}
                                                    </td>
                                                    <td>
                                                        {{ $row->CheckoutRequestID }}
                                                    </td>
                                                    <td>
                                                        {{ $row->MpesaReceiptNumber }}
                                                    </td>
                                                    <td>
                                                        {{ $row->payment_method }}
                                                    </td>
                                                    <td>
                                                        {{ $row->booking_date }}
                                                    </td>
                                                    <td>
                                                        {{ $row->paid_amount }}
                                                    </td>
                                                    <td>
                                                        {{ $row->status }}
                                                    </td>
                                                    <td class="pt_10 pb_10">
                                                        <a href="{{ route('admin_invoice', $row->id) }}"
                                                            class="btn btn-primary btn-sm">Details</a>


                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin_order_delete', $row->id) }}"
                                                            class="btn btn-danger btn-sm"
                                                            onClick="return confirm('Are you sure?');">Delete</a>
                                                    </td>
                                                </tr>
                                            @endforeach

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
