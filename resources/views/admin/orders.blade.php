@extends('admin.layout.app')

@section('heading', 'Customer Orders')
@section('main_content')
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
@endsection
