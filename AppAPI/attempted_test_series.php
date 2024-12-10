<?php
include 'connect.inc.php';
include 'core.inc.php';
$response = array();
@header('Content_Type: application/json');

if (
    isset($_POST['test_series_exam_list_id']) &&
    isset($_POST['login_id'])
) {
    $test_series_exam_list_id = @$_POST['test_series_exam_list_id'];
    $login_id = @$_POST['login_id'];

    if (
        !empty($test_series_exam_list_id) &&
        !empty($login_id)
    ) {

        $status = 'Active';

        $query = "INSERT INTO `test_series_attempted`(`test_series_exam_list_id`, `login_id`, `status`) 
                    VALUES ( :test_series_exam_list_id, :login_id, :status)";

        $statment = $connect->prepare($query);
        $result = $statment->execute(
            array(
                ':test_series_exam_list_id' => $test_series_exam_list_id,
                ':login_id' => $login_id,
                ':status' => $status
            )
        );

        if ($result) {

            $response[0]['status'] = 'Active';
            $response[0]['message'] = 'Quiz attempted';
            $response[0]['login_id'] = $login_id;
            $response[0]['test_series_exam_list_id'] = $test_series_exam_list_id;
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
