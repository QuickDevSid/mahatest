<?php
include 'connect.inc.php';
$response  = array();
@header('Content-Type:application/json');

if (isset($_POST['login_id'])) {

    $login_id = $_POST['login_id'];
    $message = '';

    $message .= empty($login_id) ? '- User name can not be empty ' : '';

    if (empty(trim($message))) {

        $query = "SELECT * FROM `user_login` WHERE `login_id` = '$login_id' AND `status` = 'Active'";
        $statement = $connect->prepare($query);
        $statement->execute();
        $result    = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) == 0) {
            $response[0]['status'] = 'Failed';
            $response[0]['message'] = 'Invalid login_id';
            echo json_encode($response);
        } else {
            $response[0]['status'] = 'Active';
            $response[0]['message'] = 'User profile found';
            $response[0]['login_id'] = $result[0]['login_id'];
            $response[0]['selected_exams_id'] = $result[0]['selected_exams_id'];
            $response[0]['selected_exams'] = $result[0]['selected_exams'];
            $response[0]['place'] = $result[0]['place'];

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
