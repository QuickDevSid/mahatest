<?php
include 'connect.inc.php';
$response = array();
@header('Content_Type: application/json');

if (isset($_POST['abhyas_sahitya_category_id'])) {

    $abhyas_sahitya_category_id = $_POST['abhyas_sahitya_category_id'];

    $query = "SELECT * FROM 
    abhyas_sahitya WHERE status = 'Active' AND abhyas_sahitya_category_id = '$abhyas_sahitya_category_id' ORDER BY abhyas_sahitya_id DESC";

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
