<?php

include 'connect.inc.php';
$response = array();
@header('Content_Type: application/json');

if (
    isset($_POST['login_id']) &&
    isset($_POST['place'])
) {
    $login_id = @$_POST['login_id'];
    $place = @$_POST['place'];

    if (
        !empty($login_id) &&
        !empty($place)
    ) {
        $query = "UPDATE `user_login` SET
                `place`=:place WHERE
                `login_id` = :login_id";

        $statment = $connect->prepare($query);

        $result = $statment->execute(
            array(
                ':place' => $place,
                ':login_id' => $login_id
            )
        );
        if ($result) {
            $response[0]['status'] = 'Active';
            $response[0]['message'] = 'Profile updated successfully';

            echo json_encode($response);
        } else {
            $response[0]['status'] = 'Failed';
            $response[0]['message'] = 'Failed to update profile, try again';
            $error = $statment->errorInfo();
            $response[0]['error'] = $error[2];
            echo json_encode($response);
        }
    } else {
        $response[0]['status'] = 'Failed';
        $response[0]['message'] = '* is mandatory';
        echo json_encode($response);
    }
} else {
    $response[0]['status'] = 'Failed';
    $response[0]['message'] = 'Some parameters are missing, try again';
    echo json_encode($response);
}