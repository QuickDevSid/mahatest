<?php
include 'connect.inc.php';
$response = array();
@header('Content_Type: application/json');

if (isset($_POST['quiz_id'])) {

    $quiz_id = $_POST['quiz_id'];

    $query = "SELECT * FROM daily_quiz WHERE `quiz_id` = '$quiz_id' AND status = 'Active'";

    $statement = $connect->query($query);
    $result    = $statement->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
        echo json_encode($result);
    } else {
        $response[0]['status'] = 'Failed';
        $response[0]['message']  = 'Failed Fetch Data';
        echo json_encode($response);
    }
} else {
    $response[0]['status']  = 'Failed';
    $response[0]['message'] = 'Invalid parameters received';
    echo json_encode($response);
}
