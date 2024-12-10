<?php
include 'connect.inc.php';
include 'core.inc.php';
$response = array();
@header('Content_Type: application/json');

if (
    isset($_POST['login_id']) &&
    isset($_POST['purchased_item_id'])
) {
    $login_id = @$_POST['login_id'];
    $purchased_item_id = @$_POST['purchased_item_id'];
    $purchased_item_type = @$_POST['purchased_item_type'];
    $users_exam_group = @$_POST['users_exam_group'];
    $payment_gateway = @$_POST['payment_gateway'];
    $payment_gateway_date = @$_POST['payment_gateway_date'];
    $payment_gateway_status = @$_POST['payment_gateway_status'];
    $payment_gateway_method = @$_POST['payment_gateway_method'];
    $payment_gateway_id = @$_POST['payment_gateway_id'];
    $payment_gateway_amount = @$_POST['payment_gateway_amount'];
    $payment_gateway_currency = @$_POST['payment_gateway_currency'];
    $payment_gateway_charges = @$_POST['payment_gateway_charges'];
    $payment_gateway_order_id = @$_POST['payment_gateway_order_id'];
    $payment_gateway_order_description = @$_POST['payment_gateway_order_description'];
    if (
        !empty($purchased_item_id) &&
        !empty($login_id)
    ) {
        
            $query = "INSERT INTO `user_purchased_records`(
                                     `login_id`,
                                     `purchased_item_id`,
                                     `purchased_item_type`,
                                     `users_exam_group`,
                                     `payment_gateway`,
                                     `payment_gateway_date`,
                                     `payment_gateway_status`,
                                     `payment_gateway_method`,
                                     `payment_gateway_id`,
                                     `payment_gateway_amount`,
                                     `payment_gateway_currency`,
                                     `payment_gateway_charges`,
                                     `payment_gateway_order_id`,
                                     `payment_gateway_order_description`)
                                        VALUES (
                                        :login_id,
                                        :purchased_item_id,
                                        :purchased_item_type,
                                        :users_exam_group,
                                        :payment_gateway,
                                        :payment_gateway_date,
                                        :payment_gateway_status,
                                        :payment_gateway_method,
                                        :payment_gateway_id,
                                        :payment_gateway_amount,
                                        :payment_gateway_currency,
                                        :payment_gateway_charges,
                                        :payment_gateway_order_id,
                                        :payment_gateway_order_description)";

            $statment = $connect->prepare($query);
            $result = $statment->execute(
                array(
                    ':login_id' => $login_id,
                    ':purchased_item_id' => $purchased_item_id,
                    ':purchased_item_type' => $purchased_item_type,
                    ':users_exam_group' => $users_exam_group,
                    ':payment_gateway' => $payment_gateway,
                    ':payment_gateway_date' => $payment_gateway_date,
                    ':payment_gateway_status' => $payment_gateway_status,
                    ':payment_gateway_method' => $payment_gateway_method,
                    ':payment_gateway_id' => $payment_gateway_id,
                    ':payment_gateway_amount' => $payment_gateway_amount,
                    ':payment_gateway_currency' => $payment_gateway_currency,
                    ':payment_gateway_charges' => $payment_gateway_charges,
                    ':payment_gateway_order_id' => $payment_gateway_order_id,
                    ':payment_gateway_order_description' => $payment_gateway_order_description
                )
            );

            if ($result) {
                $response[0]['status'] = 'Active';
                $response[0]['message'] = 'Payment Record Submitted.';
                echo json_encode($response);
            } else {
                $response[0]['status'] = 'Failed';
                $response[0]['message'] = 'Failed to Submit';
                echo json_encode($response);
            }
        
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
