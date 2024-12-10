<?php
include 'connect.inc.php';
include 'core.inc.php';
$response = array();
@header('Content_Type: application/json');

if (
    isset($_POST['login_id']) &&
    isset($_POST['message'])
) {
    $message = @$_POST['message'];
    $login_id = @$_POST['login_id'];

    if (
        !empty($message) &&
        !empty($login_id)
    ) {
        
            $query = "INSERT INTO `user_feedback`(
                                        `login_id`,
                                        `message`)
                                        VALUES (
                                        :login_id,
                                        :message)";

            $statment = $connect->prepare($query);
            $result = $statment->execute(
                array(
                    ':login_id' => $login_id,
                    ':message' => $message
                )
            );

            if ($result) {
                $response[0]['status'] = 'Active';
                $response[0]['message'] = 'Feedback Submitted.';
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
