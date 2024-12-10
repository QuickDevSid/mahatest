<?php
include 'connect.inc.php';
include 'core.inc.php';
$response = array();
@header('Content_Type: application/json');

if (
    isset($_POST['doubt_id']) &&
    isset($_POST['login_id']) &&
    isset($_POST['comment_body']) &&
    isset($_POST['date']) &&
    isset($_POST['time'])
) {
    $doubt_id = @$_POST['doubt_id'];
    $login_id = @$_POST['login_id'];
    $comment_body = @$_POST['comment_body'];
    $date = @$_POST['date'];
    $time = @$_POST['time'];

    if (
        !empty($doubt_id) &&
        !empty($login_id) &&
        !empty($comment_body)
    ) {

        $status = 'Pending';
        $comment_status = 'Pending';
        $created_on = date('Y-m-d');

        $query = "INSERT INTO
                        `doubts_comment`(
                        `doubt_id`,
                        `login_id`,
                        `comment_body`,
                        `status`,
                        `comment_status`,
                        `date`,
                        `time`,
                        `created_on`)
                        
                        VALUES (
                        :doubt_id,
                        :login_id,
                        :comment_body,
                        :status,
                        :comment_status,
                        :date,
                        :time,
                        :created_on)";

        $statment = $connect->prepare($query);
        $result = $statment->execute(
            array(
                ':doubt_id' => $doubt_id,
                ':login_id' => $login_id,
                ':comment_body' => $comment_body,
                ':status' => $status,
                ':comment_status' => $comment_status,
                ':date' => $date,
                ':time' => $time,
                ':created_on' => $created_on
            )
        );

        if ($result) {

            $response[0]['status'] = 'Active';
            $response[0]['comment_status'] = 'Approved';
            $response[0]['message'] = 'Comment Added';
            $response[0]['login_id'] = $login_id;
            $response[0]['doubt_id'] = $doubt_id;
            $response[0]['comment_body'] = $comment_body;
            $response[0]['date'] = $date;
            $response[0]['time'] = $time;
            echo json_encode($response);
        } else {
            $response[0]['status'] = 'Failed';
            $response[0]['message'] = 'Failed to Comment';
            echo json_encode($response);
        }
    } else {
        $response[0]['status'] = 'Failed';
        $response[0]['message'] = 'Empty parameters';
        echo json_encode($response);
    }
} else {
    $response[0]['status'] = 'Failed';
    $response[0]['message'] = 'Missing token';
    echo json_encode($response);
}
