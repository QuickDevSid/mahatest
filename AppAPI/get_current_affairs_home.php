<?php
require 'connect.inc.php';
require 'core.inc.php';

$response = array();

@header('Content-Type: application/json');
if (isset($_POST['login_id'])) {
    
    $message = '';
    $message .= empty(trim(@$_POST['login_id'])) ? 'Session has expired, Please login again <br>' : '';
    
    if (empty($message)) {
        $selected_exam_id = $_POST['selected_exams_id'];
        
        $login_id = @$_POST['login_id'];
        $current_affair_id = @$_POST['current_affair_id'];
        $query = "SELECT current_affair_id, selected_exams_id, category, current_affair_image, current_affair_title, SUBSTRING(`current_affair_description`, 1, 500) as current_affair_description, status, created_on FROM current_affairs WHERE status = 'Active' AND JSON_CONTAINS(selected_exams_id, '[\"".$selected_exam_id."\"]') ORDER BY STR_TO_DATE(created_on, '%Y-%m-%d') DESC LIMIT 2";
        
        $statement = $connect->query($query);
        if ($statement) {
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);
            $row = count($data);
            if ($row > 0) {
                
                for ($i = 0; $i < $row; $i++) {
                    $current_affair_id = $data[$i]['current_affair_id'];
                    $data[$i]['like_status'] = getCurrentAffairsLikeStatus($connect, $current_affair_id, $login_id);
                    $data[$i]['save_status'] = getCurrentAffairsSaveStatus($connect, $current_affair_id, $login_id);
                    $data[$i]['post_likes'] = getCurrentAffairsLikeCount($connect, $data[$i]['current_affair_id']);
                    $data[$i]['post_comments'] = getCurrentAffairsCommentsCount($connect, $data[$i]['current_affair_id']);
                }
                
                echo json_encode($data);
            } else {
                $response[0]['status'] = 'Failed';
                $response[0]['message'] = 'No content found';
                echo json_encode($response);
            }
        } else {
            $response[0]['status'] = 'Failed';
            $response[0]['message'] = 'Could not Fetch';
            echo json_encode($response);
        }
    } else {
        $response[0]['status'] = 'Failed';
        $response[0]['message'] = $message;
        echo json_encode($response);
    }
} else {
    $response[0]['status'] = 'Failed';
    $response[0]['message'] = 'Invalid parameters, try again';
    echo json_encode($response);
}
