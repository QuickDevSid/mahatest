<?php
include 'connect.inc.php';
$response = array();
@header('Content_Type: application/json');

if (isset($_POST['selected_exams_id'])) {

    $selected_exam_id = $_POST['selected_exams_id'];
    $login_id = $_POST['login_id'];
    
    $query = "SELECT * FROM
    test_series WHERE status = 'Active' AND JSON_CONTAINS(selected_exams_id, '[\"".$selected_exam_id."\"]') ORDER BY test_series DESC";

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
        
        $record_id = $row['test_series'];
        $query_purchased = "SELECT * FROM user_purchased_records WHERE purchased_item_id = '$record_id' AND login_id = '$login_id' AND purchased_item_type = 'Test Series' AND payment_gateway_status = 'success' ORDER BY id DESC";
        $statement_purchased = $connect->query($query_purchased);
        $result_purchased    = $statement_purchased->fetchAll(PDO::FETCH_ASSOC);
    
        if ($result_purchased) {
            $record['test_purchased'] = 'Yes';
        } else {
            $record['test_purchased'] = 'No';
        }
        
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
