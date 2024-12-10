<?php
include 'connect.inc.php';
require 'core.inc.php';
$response = array();
@header('Content_Type: application/json');

if (isset($_POST['current_affair_id'])) {

    $current_affair_id = $_POST['current_affair_id'];
    $selected_exam_id = $_POST['selected_exams_id'];
    
    $query = "SELECT * FROM
    current_affairs
    WHERE `current_affair_id` = '$current_affair_id'
    AND
    status = 'Active'";

    $statement = $connect->query($query);
    $result    = $statement->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
        $result[0]['like_status'] = getCurrentAffairsLikeStatus($connect, $current_affair_id, $login_id);
        $result[0]['save_status'] = getCurrentAffairsSaveStatus($connect, $current_affair_id, $login_id);
        $result[0]['post_likes'] = getCurrentAffairsLikeCount($connect, $current_affair_id);
        $result[0]['post_comments'] = getCurrentAffairsCommentsCount($connect, $current_affair_id);
        $result[0]['CurrentAffairsNextId'] = getCurrentAffairsNextId($connect, $current_affair_id, $selected_exam_id);
        $result[0]['CurrentAffairsPreviousId'] = getCurrentAffairsPreviousId($connect, $current_affair_id, $selected_exam_id);
        
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
