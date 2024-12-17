<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Razorpay {
    public function generateOrderId($user_id,$amount){
        $ch = curl_init();
        $fields = array();
        $orderData = [
            'receipt'         => "$user_id",
            'amount'          => $amount * 100, // 2000 rupees in paise
            'currency'        => 'INR',
        ];
        curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/orders');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($orderData));
        curl_setopt($ch, CURLOPT_POST, 1);
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization:Basic '.base64_encode(RAZOR_KEY_ID.":".RAZOR_KEY_SECRET);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $data = curl_exec($ch);
        curl_close($ch);
        if (empty($data) OR (curl_getinfo($ch, CURLINFO_HTTP_CODE != 200))) {
            return false;
        } else {
            return json_decode($data, TRUE);
        }
        
    }
}