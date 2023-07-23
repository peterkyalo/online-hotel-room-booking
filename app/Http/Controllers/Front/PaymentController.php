<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mpesa;

class PaymentController extends Controller
{


    public function lipaNaMpesaPassword()
    {
        $lipa_time = Carbon::rawParse('now')->format('YmdHms');
        $passkey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
        $BusinessShortCode = 174379;
        $timestamp =$lipa_time;
        $lipa_na_mpesa_password = base64_encode($BusinessShortCode.$passkey.$timestamp);
        return $lipa_na_mpesa_password;
    }


    /*
     * Lipa na M-PESA STK Push method
     * */

    public function customerMpesaSTKPush(Request $request)
    {
                $amount =$request->amount;//'0704Request $request987401';//$request->amount;
                $phone =$request->phone;//  $request->shipping_phone;
                $formatedPhone = substr($phone, 1);//726582228
                $code = "254";
                $phoneNumber = $code.$formatedPhone;

                $initiate_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
                $transaction_status_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query';
                $headers = ['Content-Type:application/json; charset=utf8'];
                $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Accept:application/json','Authorization:Bearer '.$this->generateAccessToken()));
                $curl_post_data = [
                    //Fill in the request parameters with valid values
                    'BusinessShortCode' => 174379,
                    'Password' => $this->lipaNaMpesaPassword(),
                    'Timestamp' => Carbon::rawParse('now')->format('YmdHms'),
                    'TransactionType' => 'CustomerPayBillOnline',
                    'Amount' => 1,
                    'PartyA' => 254705376543, // replace this with your phone number
                    'PartyB' => 174379,
                    'PhoneNumber' => 254705376543, // replace this with your phone number
                    'CallBackURL' => 'http://mestalla.api.qccurves.com/api/callback/data',
                    'AccountReference' => "eHotel",
                    'TransactionDesc' => "Testing stk push on sandbox"
                ];
                $data_string = json_encode($curl_post_data);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
                $curl_response = curl_exec($curl);
                $access_token=json_decode($curl_response,true);
                // dd($access_token);
                $cid=$access_token['CheckoutRequestID'];
            //return $cid;
            do{
                sleep(15);
                $status_curl = curl_init();
            curl_setopt($status_curl, CURLOPT_URL, $transaction_status_url);
            curl_setopt($status_curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Accept:application/json','Authorization:Bearer '.$this->generateAccessToken())); //setting custom header

            $status_post_data = array(
                //Fill in the request parameters with valid values
                "BusinessShortCode" => 174379,
                "Password" => $this->lipaNaMpesaPassword(),
                "Timestamp" => Carbon::rawParse('now')->format('YmdHms'),
                "CheckoutRequestID" => $cid
            );

            $status_string = json_encode($status_post_data);
            curl_setopt($status_curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($status_curl, CURLOPT_POST, true);
            curl_setopt($status_curl, CURLOPT_POSTFIELDS, $status_string);
            $status_response = curl_exec($status_curl);

            // print_r($curl_response);
            $status_data = json_decode($status_response,true);

            $ResultCode = $status_data['ResultCode'];


        } while (!isset($ResultCode));
        if ($ResultCode==0) {
            // return 'payment successful';
            return to_route('customer_home')->with('success', 'Payment was success.');
        }else{
            return $status_data['ResultDesc'];
        }
    }


    public function generateAccessToken()
    {
        $consumer_key="sMpgnYW62glBlxPXbyTBEGdPib8eJLOL";
        $consumer_secret="IcK2PkAFArVVVffU";
        $credentials = base64_encode($consumer_key.":".$consumer_secret);
        $url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Basic ".$credentials));
        curl_setopt($curl, CURLOPT_HEADER,false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        $access_token=json_decode($curl_response);
        return $access_token->access_token;
    }


}
