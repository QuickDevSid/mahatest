<?php
include 'connect.inc.php';
$response = array();
@header('Content_Type: application/json');

$selected_exam_id = $_POST['selected_exams_id'];

$query = "SELECT * FROM district_list WHERE status = 'Active'";

$statement = $connect->query($query);
$result    = $statement->fetchAll(PDO::FETCH_ASSOC);

if ($result) {
    echo json_encode($result);
} else {
    $response[0]['status'] = 'Failed';
    $response[0]['message']  = 'Failed Fetch Data';
    echo json_encode($response);
}
