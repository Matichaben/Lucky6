<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * Phone Number form
 */
class PhoneForm extends Model
{
    public $phonenumber;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['phonenumber', 'trim'],
            ['phonenumber', 'required'],
            // ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['phonenumber', 'integer'],
        ];
    }
    // private function debug_to_console($data)
    // {
    //     $output = $data;
    //     if (is_array($output))
    //         $output = implode(',', $output);

    //     echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    // }
    public function sendStkPush()
    {
        // GET ACCESS TOKEN
        $consumerKey = "NERWmiAEU5ssirMdZqMBz4vOEORwBgqA"; //Fill with your app Consumer Key
        $consumerSecret = "Dg35MWxdGBjJTexp"; //Fill with your app Consumer Secret
        // ACCESS TOKEN URL
        $access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        $headers = ['Content-Type:application/json; charset=utf8'];
        $curl = curl_init($access_token_url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_HEADER, FALSE);
        curl_setopt($curl, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);
        $result = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        $result = json_decode($result);
        // ASSIGN ACCESS TOKEN TO A VARIABLE
        $access_token = $result->access_token;

        // SENDING STK PUSH
        date_default_timezone_set('Africa/Nairobi');
        $processrequestUrl = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $callbackurl = 'http://luckysita.test/site/callback';
        $passkey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
        $BusinessShortCode = '174379';
        $Timestamp = date('YmdHis');
        // ENCRYPT  DATA TO GET PASSWORD
        $Password = base64_encode($BusinessShortCode . $passkey . $Timestamp);
        $str = (string) $this->phonenumber;
        $result = (int) $str[0];
        // $this->debug_to_console($result);
        if ($result == 0) {
            $char = "254";
            $str = ltrim($str, "0");
            $number = $char . $str;
            $final = (int) $number;
            // $this->debug_to_console($final);

            $phone = $final; //phone number to receive the stk push
        } else {
            $phone = $this->phonenumber;
        }
        $money = '1';
        $PartyA = $phone;
        $PartyB = '254708374149';
        $AccountReference = 'Lucky Sita';
        $TransactionDesc = 'stkpush test';
        $Amount = $money;
        $stkpushheader = ['Content-Type:application/json', 'Authorization:Bearer ' . $access_token];

        //INITIATE CURL
        // $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $processrequestUrl);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $stkpushheader); //setting custom header
        $curl_post_data = array(
            //Fill in the request parameters with valid values
            'BusinessShortCode' => $BusinessShortCode,
            'Password' => $Password,
            'Timestamp' => $Timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $Amount,
            'PartyA' => $PartyA,
            'PartyB' => $BusinessShortCode,
            'PhoneNumber' => $PartyA,
            'CallBackURL' => $callbackurl,
            'AccountReference' => $AccountReference,
            'TransactionDesc' => $TransactionDesc
        );

        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = curl_exec($curl);
        // //ECHO  RESPONSE
        // $data = json_decode($curl_response);
        // $CheckoutRequestID = $data->CheckoutRequestID;
        // $ResponseCode = $data->ResponseCode;
        // if ($ResponseCode == "0") {
        //     echo "The CheckoutRequestID for this transaction is : " . $CheckoutRequestID;
        // }

        curl_close($curl);

        return 0;
    }
}