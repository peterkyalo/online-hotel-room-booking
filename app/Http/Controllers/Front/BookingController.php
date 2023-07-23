<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\Websitemail;
use App\Models\BookedRoom;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Throwable;

class BookingController extends Controller
{

    public function cart_view()
    {
        return view('front.cart');
    }
    public function cart_submit(Request $request)
    {
        $request->validate([
            'room_id' => 'required',
            'checkin_checkout' => 'required',
            'adult' => 'required'
        ]);

        $dates = explode(' - ',$request->checkin_checkout);
        $checkin_date = $dates[0];
        $checkout_date = $dates[1];

        $d1 = explode('/',$checkin_date);
        $d2 = explode('/',$checkout_date);
        $d1_new = $d1[2].'-'.$d1[1].'-'.$d1[0];
        $d2_new = $d2[2].'-'.$d2[1].'-'.$d2[0];
        $t1 = strtotime($d1_new);
        $t2 = strtotime($d2_new);

        $cnt = 1;
        while(1) {
            if($t1>=$t2) {
                break;
            }
            $single_date = date('d/m/Y',$t1);
            $total_already_booked_rooms = BookedRoom::where('booking_date',$single_date)->where('room_id',$request->room_id)->count();

            $arr = Room::where('id',$request->room_id)->first();
            $total_allowed_rooms = $arr->total_rooms;

            if($total_already_booked_rooms == $total_allowed_rooms) {
                $cnt = 0;
                break;
            }
            $t1 = strtotime('+1 day',$t1);
        }

        if($cnt == 0) {
            return redirect()->back()->with('error', 'Maximum number of this room is already booked');
        }

        session()->push('cart_room_id',$request->room_id);
        session()->push('cart_checkin_date',$checkin_date);
        session()->push('cart_checkout_date',$checkout_date);
        session()->push('cart_adult',$request->adult);
        session()->push('cart_children',$request->children);

        return redirect()->back()->with('success', 'Room is added to the cart successfully.');
    }



    public function cart_delete($id)
    {
        //move all items from session array to normal PHP array

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
        //clear all the session using forget()
        session()->forget('cart_room_id');
        session()->forget('cart_checkin_date');
        session()->forget('cart_checkout_date');
        session()->forget('cart_adult');
        session()->forget('cart_children');

        for($i=0;$i<count($arr_cart_room_id);$i++)
        {
            //if the room id is equal to the id that was passed in then delete the room
            if($arr_cart_room_id[$i] == $id)
            {
                continue;
            }
            //Otherwise add the room to the global session variable
            else
            {
                session()->push('cart_room_id',$arr_cart_room_id[$i]);
                session()->push('cart_checkin_date',$arr_cart_checkin_date[$i]);
                session()->push('cart_checkout_date',$arr_cart_checkout_date[$i]);
                session()->push('cart_adult',$arr_cart_adult[$i]);
                session()->push('cart_children',$arr_cart_children[$i]);
            }
        }

        return redirect()->back()->with('success', 'Cart item is deleted.');

    }

    public function checkout()
    {
        //check if the user is logged in
        if(!Auth::guard('customer')->check()) {
            return redirect()->back()->with('error', 'You must have to login in order to checkout');
        }
    //check if there is at an item in the cart
        if(!session()->has('cart_room_id')) {
            return redirect()->back()->with('error', 'There is no item in the cart');
        }

        return view('front.checkout');
    }

    public function paymentOption(Request $request)
    {
        if(!Auth::guard('customer')->check()) {
            return redirect()->back()->with('error', 'You must have to login in order to checkout');
        }

        if(!session()->has('cart_room_id')) {
            return redirect()->back()->with('error', 'There is no item in the cart');
        }

        $request->validate([
            'billing_name' => 'required',
            'billing_email' => 'required|email',
            'billing_phone' => 'required',
            'billing_country' => 'required',
            'billing_address' => 'required',
            'billing_state' => 'required',
            'billing_city' => 'required',
            'billing_zip' => 'required'
        ]);

        //Store all the billing information into a session variable
        session()->put('billing_name',$request->billing_name);
        session()->put('billing_email',$request->billing_email);
        session()->put('billing_phone',$request->billing_phone);
        session()->put('billing_country',$request->billing_country);
        session()->put('billing_address',$request->billing_address);
        session()->put('billing_state',$request->billing_state);
        session()->put('billing_city',$request->billing_city);
        session()->put('billing_zip',$request->billing_zip);

        return view('front.payment');
    }

    public function choose_option(Request $request)
    {
        if ($request->payment == 'stk') {
            return redirect('/payment/stk-push');
        } else if ($request->payment == 'cash') {
            return to_route('cash');
        }
    }


    public function token()
    {
        $consumerKey = 'soVxYrWsJyGb2rDlVylwZCfWQb43tHA5';
        $consumerSecret = 'rcdii5ZpLr5gv87X';
        $url= 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        $response = Http::withBasicAuth($consumerKey, $consumerSecret)->get($url);
        return $response['access_token'];
    }

    public function initiateStkPush()
    {
        $phone = session()->get('billing_phone');

        $FormattedPhone = "254" . substr($phone, 1);
        $accessToken = $this->token();
        $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $PassKey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
        $BusinessShortCode = 174379;
        $Timestamp = Carbon::now()->format('YmdHis');
        $Password = base64_encode($BusinessShortCode.$PassKey.$Timestamp);
        $TransactionType = 'CustomerPayBillOnline';
        // $Amount = 1;
        $Amount = session()->get('total_price');
        $PartyA = $FormattedPhone;
        $PartyB = 174379;
        $PhoneNumber = $FormattedPhone;
        $CallBackURL = 'https://aed0-2c0f-fe38-2241-372f-c433-fbd6-2ba0-bcd9.ngrok-free.app/payment/stk-callback';
        $AccountReference = 'eHotelService';
        $TransactionDesc = 'Payment for hotel room booking';

        try {
            $response = Http::withToken($accessToken)->post($url, [
                'BusinessShortCode' => $BusinessShortCode,
                'Password' => $Password,
                'Timestamp' => $Timestamp,
                'TransactionType' => $TransactionType,
                'Amount' => $Amount,
                'PartyA' => $PartyA,
                'PartyB' => $PartyB,
                'PhoneNumber' => $PhoneNumber,
                'CallBackURL' => $CallBackURL,
                'AccountReference' => $AccountReference,
                'TransactionDesc' => $TransactionDesc

            ]);

            // return $response;
        $res = json_decode($response);
        // dd($res);

        $ResponseCode = $res->ResponseCode;

        if ($ResponseCode == 0){
            $MerchantRequestID = $res->MerchantRequestID;
            $CheckoutRequestID = $res->CheckoutRequestID;
            $CustomerMessage = $res->CustomerMessage;

            // save initial response to Database
            $order_no = (time());

            $stm = DB::select("SHOW TABLE STATUS LIKE 'orders'");
            $ai_id = $stm[0]->Auto_increment;

            $payment = new Order();
            $payment->customer_id = Auth::guard('customer')->user()->id;
            $payment->order_no = $order_no;
            $payment->phone = $PhoneNumber;
            $payment->paid_amount = $Amount;
            $payment->reference	 = $AccountReference;
            $payment->description = $TransactionDesc;
            $payment->MerchantRequestID = $MerchantRequestID;
            $payment->CheckoutRequestID = $CheckoutRequestID;
            $payment->payment_method = "Mpesa";
            $payment->booking_date = date('d/m/Y');
            $payment->status = "Requested";

            $payment->save();

            //save data to order_details table
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

            for($i=0;$i<count($arr_cart_room_id);$i++)
            {
                $r_info = Room::where('id',$arr_cart_room_id[$i])->first();

                $d1 = explode('/',$arr_cart_checkin_date[$i]);
                $d2 = explode('/',$arr_cart_checkout_date[$i]);
                $d1_new = $d1[2].'-'.$d1[1].'-'.$d1[0];
                $d2_new = $d2[2].'-'.$d2[1].'-'.$d2[0];
                $t1 = strtotime($d1_new);
                $t2 = strtotime($d2_new);
                $diff = ($t2-$t1)/60/60/24;
                $sub_total = $r_info->price*$diff;

              $order = new OrderDetail();
              $order->order_id = $ai_id;
              $order->room_id = $arr_cart_room_id[$i];
              $order->order_no = $order_no;
              $order->checkin_date = $arr_cart_checkin_date[$i];
              $order->checkout_date	 = $arr_cart_checkout_date[$i];
              $order->adult = $arr_cart_adult[$i];
              $order->children = $arr_cart_children[$i];
              $order->subtotal = $sub_total;
              $order->save();


                while(1) {
                    if($t1>=$t2) {
                        break;
                    }

                    $obj = new BookedRoom();
                    $obj->booking_date = date('d/m/Y',$t1);
                    $obj->order_no = $order_no;
                    $obj->room_id = $arr_cart_room_id[$i];
                    $obj->save();
                    $t1 = strtotime('+1 day',$t1);
                }

            }

            // Send email
            $subject = 'New Order';
            $body = 'You have made an order for hotel booking.The booking information is given below';
            $body .= 'CheckoutRequestID: '.$CheckoutRequestID;
            $body .= 'Payment Method: Mpesa';
            $body .= 'Paid Amount: '.$Amount;
            $body .= 'Booking Date: '.date('d/m/Y');

            for($i=0;$i<count($arr_cart_room_id);$i++)
            {
                $r_info = Room::where('id',$arr_cart_room_id[$i])->first();

                $body .= 'Room Name: '.$r_info->name;
                $body .= 'Price Per Night: Ksh'.$r_info->price;
                $body .= 'Checkin Date: '.$arr_cart_checkin_date[$i];
                $body .= 'Checkout Date: '.$arr_cart_checkout_date[$i];
                $body .= 'Adult: '.$arr_cart_adult[$i];
                $body .= 'Children: '.$arr_cart_children[$i];
            }



            $customer_email = Auth::guard('customer')->user()->email;;

            Mail::to($customer_email)->send(new Websitemail($subject, $body));

            session()->forget('cart_room_id');
            session()->forget('cart_checkin_date');
            session()->forget('cart_checkout_date');
            session()->forget('cart_adult');
            session()->forget('cart_children');

            session()->forget('billing_name');
            session()->forget('billing_email');
            session()->forget('billing_phone');
            session()->forget('billing_country');
            session()->forget('billing_address');
            session()->forget('billing_state');
            session()->forget('billing_city');
            session()->forget('billing_zip');


            return to_route('customer_home')->with('success', $CustomerMessage);
        }
        } catch (Throwable $e) {
            return $e->getMessage();

        }



    }

    public function stkCallback()
    {
        $data = file_get_contents('php://input'); //get the response json data only without the headers
        Storage::disk('local')->put('stk.txt', $data);

        $response = json_decode($data);
        $ResultCode = $response->Body->stkCallback->ResultCode;

        if ($ResultCode == 0){
            $MerchantRequestID = $response->Body->stkCallback->MerchantRequestID;
            $CheckoutRequestID = $response->Body->stkCallback->CheckoutRequestID;
            $ResultDesc = $response->Body->stkCallback->ResultDesc;
            $Amount = $response->Body->stkCallback->CallbackMetadata->Item[0]->Value;
            $MpesaReceiptNumber = $response->Body->stkCallback->CallbackMetadata->Item[1]->Value;
            $TransactionDate = $response->Body->stkCallback->CallbackMetadata->Item[3]->Value;
            $PhoneNumber = $response->Body->stkCallback->CallbackMetadata->Item[4]->Value;

            $payment = Order::where('CheckoutRequestID', $CheckoutRequestID)->firstOrFail();
            $payment->status = 'Paid';
            $payment->TransactionDate =  $TransactionDate;
            $payment->MpesaReceiptNumber =  $MpesaReceiptNumber;
            $payment->ResultDesc =  $ResultDesc;
            $payment->save();
        } else {
            $CheckoutRequestID = $response->Body->stkCallback->CheckoutRequestID;
            $ResultDesc = $response->Body->stkCallback->ResultDesc;

            $payment = Order::where('CheckoutRequestID', $CheckoutRequestID)->firstOrFail();
            $payment->ResultDesc = $ResultDesc;
            $payment->status = 'Failed';
            $payment->save();
        }

    }

    public function getStkQuery()
    {
        return view('admin.payment_status');
    }

    public function stkQuery(Request $request)
    {
        $accessToken = $this->token();
        $BusinessShortCode = 174379;
        $PassKey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
        $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query';
        $Timestamp = Carbon::now()->format('YmdHis');
        $Password = base64_encode($BusinessShortCode.$PassKey.$Timestamp);
        $CheckoutRequestID = $request->checkout_request_id;
        // $CheckoutRequestID = 'ws_CO_09062023150942502705376543';

        $response = Http::withToken($accessToken)->post($url, [
            'BusinessShortCode' => $BusinessShortCode,
            'Timestamp' => $Timestamp,
            'Password' => $Password,
            'CheckoutRequestID' => $CheckoutRequestID,

        ]);

        // return $response;

       echo '<b>'."Checkout Request Id".'</b>'. ' :' .$response['requestId'] .'<br>';
       echo '<b>'."Error Code".'</b>'.' :' .$response['errorCode'].'<br>';
       echo '<b>'."Error Message".'</b>'.' :'.$response['errorMessage'];


    }

    public function payment_option(Request $request)
    {

        // dd($request->payment);
        // $payment = new PaymentController();

        if ($request->payment == 'mpesa') {
            // $mpesa = $payment->customerMpesaSTKPush($request);
            // return $mpesa;
            // return to_route('initiate_push');
            return redirect('payment/initiate-stk-push');
        } else if ($request->payment == 'cash') {
            return redirect('payment/cash');
        }


    }
    public function cash()
    {
        return "Paid with cash";
    }


}
