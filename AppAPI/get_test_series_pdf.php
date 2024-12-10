<?php
include 'connect.inc.php';
$response = array();
@header('Content_Type: application/json');

if (isset($_POST['testSeriesId'])) {

    $testSeriesId = $_POST['testSeriesId'];

    $query = "SELECT * FROM test_series_pdf WHERE status = 'Active' AND test_series_id = '$testSeriesId' ORDER BY id DESC";

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
