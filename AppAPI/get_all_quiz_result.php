<?php
include 'connect.inc.php';
$response = array();
@header('Content_Type: application/json');

if (isset($_POST['login_id'])) {

    $login_id = $_POST['login_id'];

    $query = "SELECT a.*, 
    b.quiz_title, 
    b.quiz_questions, 
    b.quiz_duration 
    FROM 
    quiz_result 
    a INNER JOIN 
    daily_quiz 
    b ON 
    a.quiz_id = b.quiz_id 
    WHERE 
    a.status = 'Active' 
    AND login_id = '$login_id' ORDER BY quiz_result_id DESC";

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
