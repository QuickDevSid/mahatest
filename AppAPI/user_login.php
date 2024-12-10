<?php
include "connect.inc.php";
$response  = array();
$message = '';

@header('Content-Type:application/json');

if (
    isset($_POST["email"]) &&
    isset($_POST["password"])
) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $message = "";

    $message .= empty($email) ? "- User name can not be empty " : "";
    $message .= empty($password) ? "- Password can not be empty "  : "";

    if (empty(trim($message))) {

        $password = md5($password);

        $query = "SELECT * FROM `user_login` WHERE `email` = '$email' AND `password` ='$password'AND `status` = 'Active'";
        $statement = $connect->prepare($query);
        $statement->execute();
        $result    = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) == 0) {
            $response[0]['status'] = 'Failed';
            $response[0]['message'] = 'Invalid email & Password.';
            echo json_encode($response);
        } else {

            $response[0]['status']            = 'Active';
            $response[0]['message']          = 'Login Succesfully';
            $response[0]['login_id'] = $result[0]['login_id'];
            $response[0]['email'] = $result[0]['email'];
            $response[0]['mobile_number'] = $result[0]['mobile_number'];
            $response[0]['password'] = $result[0]['password'];
            $response[0]['full_name'] = $result[0]['full_name'];
            $response[0]['selected_exams_id'] = $result[0]['selected_exams_id'];

            echo json_encode($response);
        }
    } else {
        $response[0]['status'] = 'Failed';
        $response[0]['message'] = $message;
        echo json_encode($response);
    }
} else {
    $response[0]['status']  = 'Failed';
    $response[0]['message'] = 'Invalid parameters received';
    echo json_encode($response);
}
