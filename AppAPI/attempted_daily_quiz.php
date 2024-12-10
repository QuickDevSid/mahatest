<?php
include 'connect.inc.php';
include 'core.inc.php';
$response = array();
@header('Content_Type: application/json');

if (
    isset($_POST['quiz_id']) &&
    isset($_POST['login_id'])
) {
    $quiz_id = @$_POST['quiz_id'];
    $login_id = @$_POST['login_id'];

    if (
        !empty($quiz_id) &&
        !empty($login_id)
    ) {

        $status = 'Active';

        $query = "INSERT INTO `daily_quiz_attempted`(`quiz_id`, `login_id`, `status`) 
                    VALUES ( :quiz_id, :login_id, :status)";

        $statment = $connect->prepare($query);
        $result = $statment->execute(
            array(
                ':quiz_id' => $quiz_id,
                ':login_id' => $login_id,
                ':status' => $status
            )
        );

        if ($result) {

            $response[0]['status'] = 'Active';
            $response[0]['message'] = 'Quiz attempted';
            $response[0]['login_id'] = $login_id;
            $response[0]['quiz_id'] = $quiz_id;
            echo json_encode($response);
        } else {
            $response[0]['status'] = 'Failed';
            $response[0]['message'] = 'Failed to like';
            echo json_encode($response);
        }
    }
} else {
    $response[0]['status'] = 'Failed';
    $response[0]['message'] = 'Missing token';
    echo json_encode($response);
}
