<?php
include 'connect.inc.php';
$response = array();
@header('Content_Type: application/json');

if (isset($_POST['selected_exams_id'])) {

    $selected_exam_id = $_POST['selected_exams_id'];
    $login_id = $_POST['login_id'];
    
    $query = "SELECT test_series.* FROM
    test_series, user_purchased_records WHERE test_series.status = 'Active' AND JSON_CONTAINS(test_series.selected_exams_id, '[\"".$selected_exam_id."\"]') AND user_purchased_records.purchased_item_id = test_series.test_series AND user_purchased_records.login_id = '$login_id' AND user_purchased_records.purchased_item_type = 'Test Series' AND payment_gateway_status = 'success' ORDER BY test_series.test_series DESC";

    $statement = $connect->query($query);
    $result    = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    $record = array();
    foreach ($result as $row) {
        $record['test_series'] = $row['test_series'];
        $record['selected_exams_id'] = $row['selected_exams_id'];
        $record['test_title'] = $row['test_title'];
        $record['status'] = $row['status'];
        $record['created_on'] = $row['created_on'];
        $record['test_price'] = $row['test_price'];
        $record['test_exams'] = $row['test_exams'];
        $record['test_image'] = $row['test_image'];
        $record['test_details'] = $row['test_details'];
        $record['test_purchased'] = 'Yes';
        
        array_push($response, $record);
    }
    
    if ($result) {
        echo json_encode($response);
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
