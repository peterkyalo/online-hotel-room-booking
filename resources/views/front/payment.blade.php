@extends('front.layout.app')

@section('main_content')
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
    <div class="page-top">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{ $global_page_data->payment_heading }}</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 checkout-left mb_30">
                    <h4>Make Payment</h4>
                    {{-- <select name="payment_method" class="form-control select2" id="paymentMethodChange" autocomplete="off">
                        <option value="">Select Payment Method</option>
                        <option value="PayPal">PayPal</option>
                        <option value="Stripe">Stripe</option>
                        <option value="Mpesa">Mpesa</option>
                        <option value="Cash">Cash</option>
                    </select> --}}
                        <form action="{{ route('choose_option') }}" method="post">
                            @csrf
                            <input type="hidden" name="total_amount" value=" session()->get('total_price')">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment" id="paypal" value="paypal" >
                                <label class="form-check-label" for="paypal">
                                  Paypal
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment" id="stripe" value="stripe">
                                <label class="form-check-label" for="stripe">
                                  Stripe
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment" id="stk" value="stk">
                                <label class="form-check-label" for="stk">
                                  Mpesa
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment" id="cash" value="cash">
                                <label class="form-check-label" for="cash">
                                  Cash
                                </label>
                              </div>
                              <div class="form-group mb-5">
                                <button type="submit" class="btn btn-primary btn-sm ms-auto">Proceed to Pay</button>
                              </div>
                        </form>

                    <div class="paypal mt_20">
                        <h4>Pay with PayPal</h4>
                        <p>Write necessary code here</p>
                        <div id="paypal-button"></div>
                    </div>

                    <div class="stripe mt_20">
                        <h4>Pay with Stripe</h4>
                        <p>Write necessary code here</p>
                    </div>
                    <div class="mpesa mt_20">
                        <h4>Pay with Mpesa</h4>
                        <p>Write necessary code here</p>
                    </div>
                    <div class="cash mt_20">
                        <h4>Pay with Cash</h4>
                        <p>Write necessary code here</p>
                    </div>

                </div>
                <div class="col-lg-4 col-md-4 checkout-right">
                    <div class="inner">
                        <h4 class="mb_10">Billing Details</h4>
                        <div>
                            Name: {{ session()->get('billing_name') }}
                        </div>
                        <div>
                            Email: {{ session()->get('billing_email') }}
                        </div>
                        <div>
                            Phone: {{ session()->get('billing_phone') }}
                        </div>
                        <div>
                            Country: {{ session()->get('billing_country') }}
                        </div>
                        <div>
                            Address: {{ session()->get('billing_address') }}
                        </div>
                        <div>
                            State: {{ session()->get('billing_state') }}
                        </div>
                        <div>
                            City: {{ session()->get('billing_city') }}
                        </div>
                        <div>
                            Zip: {{ session()->get('billing_zip') }}
                        </div>
                    </div>
                </div>
                    <div class="col-lg-4 col-md-6 checkout-right">
                        <div class="inner">
                            <h4 class="mb_10">Cart Details</h4>
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>

                                        @php
                                        $arr_cart_room_id = array();
                                        $i=0;
                                        foreach(session()->get('cart_room_id') as $value) {
                                            $arr_cart_room_id[$i] = $value;
                                            $i++;
                                        }

                                        $arr_cart_checkin_date = array();
                                        $i=0;
                                        foreach(session()->get('cart_checkin_date') as $value) {
                                            $arr_cart_checkin_date[$i] = $value;
                                            $i++;
                                        }

                                        $arr_cart_checkout_date = array();
                                        $i=0;
                                        foreach(session()->get('cart_checkout_date') as $value) {
                                            $arr_cart_checkout_date[$i] = $value;
                                            $i++;
                                        }

                                        $arr_cart_adult = array();
                                        $i=0;
                                        foreach(session()->get('cart_adult') as $value) {
                                            $arr_cart_adult[$i] = $value;
                                            $i++;
                                        }

                                        $arr_cart_children = array();
                                        $i=0;
                                        foreach(session()->get('cart_children') as $value) {
                                            $arr_cart_children[$i] = $value;
                                            $i++;
                                        }

                                        $total_price = 0;
                                        for($i=0;$i<count($arr_cart_room_id);$i++)
                                        {
                                            $room_data = DB::table('rooms')->where('id',$arr_cart_room_id[$i])->first();
                                            @endphp

                                            <tr>
                                                <td>
                                                    {{ $room_data->name }}
                                                    <br>
                                                    ({{ $arr_cart_checkin_date[$i] }} - {{ $arr_cart_checkout_date[$i] }})
                                                    <br>
                                                    Adult: {{ $arr_cart_adult[$i] }}, Children: {{ $arr_cart_children[$i] }}
                                                </td>
                                                <td class="p_price">
                                                    @php
                                                        $d1 = explode('/',$arr_cart_checkin_date[$i]);
                                                        $d2 = explode('/',$arr_cart_checkout_date[$i]);
                                                        $d1_new = $d1[2].'-'.$d1[1].'-'.$d1[0];
                                                        $d2_new = $d2[2].'-'.$d2[1].'-'.$d2[0];
                                                        $t1 = strtotime($d1_new);
                                                        $t2 = strtotime($d2_new);
                                                        $diff = ($t2-$t1)/60/60/24;
                                                        echo 'Ksh '.$room_data->price*$diff;

                                                    @endphp
                                                </td>
                                            </tr>
                                            @php

                                            $total_price = $total_price+($room_data->price*$diff);
                                            session()->put('total_price', $total_price);

                                        }
                                        @endphp
                                        <tr>
                                            <td><b>Total:</b></td>
                                            <td class="p_price">
                                                <b>
                                                {{-- Ksh {{ $total_price }} --}}
                                                Ksh {{ session()->get('total_price') }}

                                            </b>
                                        </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        {{-- @php
        $client = 'ARw2VtkTvo3aT7DILgPWeSUPjMK_AS5RlMKkUmB78O8rFCJcfX6jFSmTDpgdV3bOFLG2WE-s11AcCGTD';
        $total_price = 500;
        @endphp
        <script>
            paypal.Button.render({
                env: 'sandbox',
                client: {
                    sandbox: '{{ $client }}',
                    production: '{{ $client }}'
                },
                locale: 'en_US',
                style: {
                    size: 'medium',
                    color: 'blue',
                    shape: 'rect',
                },
                // Set up a payment
                payment: function (data, actions) {
                    return actions.payment.create({
                        redirect_urls:{
                            return_url: '{{ url("payment/paypal") }}'
                            return_url: '{{ url("payment/paypal/$total_price") }}'
                        },
                        transactions: [{
                            amount: {
                                total: '{{ $total_price }}',
                                currency: 'Ksh'
                            }
                        }]
                    });
                },
                // Execute the payment
                onAuthorize: function (data, actions) {
                    return actions.redirect();
                }
            }, '#paypal-button');
        </script> --}}
@endsection
