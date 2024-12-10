<?php
require('config.php');
require('razorpay-php/Razorpay.php');

$response = array();
@header('Content_Type: application/json');

// Create the Razorpay Order

use Razorpay\Api\Api;
$api = new Api($keyId, $keySecret);

if (isset($_POST['user_id']) && isset($_POST['amount'])) {

    $user_id = @$_POST['user_id'];
    $amount = @$_POST['amount'];

    if (!empty($user_id) && !empty($amount)) {

//
// We create an razorpay order using orders api
// Docs: https://docs.razorpay.com/docs/orders
//
$orderData = [
    'receipt'         => $user_id,
    'amount'          => $amount * 100, // 2000 rupees in paise
    'currency'        => 'INR',
    'payment_capture' => 1 // auto capture
];

$razorpayOrder = $api->order->create($orderData);

$razorpayOrderId = $razorpayOrder['id'];

$_SESSION['razorpay_order_id'] = $razorpayOrderId;

$response[0]['razorpay_order_id'] = $razorpayOrderId;
$response[0]['status'] = 'Success';
$response[0]['message'] = 'Id Generated';
echo json_encode($response);
     
    } else {
        $response[0]['status'] = 'Failed';
        $response[0]['message'] = 'Empty param';
        echo json_encode($response);
    }
} else {
    $response[0]['status'] = 'Failed';
    $response[0]['message'] = 'Missing token';
    echo json_encode($response);
}
