<?php
include 'connect.inc.php';
$response = array();
@header('Content_Type: application/json');

if (isset($_POST['masike_category_id'])) {

    $masike_category_id = $_POST['masike_category_id'];

    $query = "SELECT * FROM masike WHERE status = 'Active' AND masike_category_id = '$masike_category_id' ORDER BY masike_id DESC";

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
