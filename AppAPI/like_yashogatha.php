<?php
include 'connect.inc.php';
include 'core.inc.php';
$response = array();
@header('Content_Type: application/json');

if (
    isset($_POST['yashogatha_id']) &&
    isset($_POST['login_id'])
) {
    $yashogatha_id = @$_POST['yashogatha_id'];
    $login_id = @$_POST['login_id'];

    if (
        !empty($yashogatha_id) &&
        !empty($login_id)
    ) {
        $status = 'Active';

        if (unlikeYashoGathaIfAlreayLiked($yashogatha_id, $login_id, $connect)) {
            $response[0]['status'] = 'Active';
            $response[0]['message'] = 'Post Unliked';
            echo json_encode($response);
        } else {
            $query = "INSERT INTO `yashogatha_likes`(
                                        `yashogatha_id`,
                                        `login_id`,
                                        `status`)
                                        VALUES (
                                        :yashogatha_id,
                                        :login_id,
                                        :status)";

            $statment = $connect->prepare($query);
            $result = $statment->execute(
                array(
                    ':yashogatha_id' => $yashogatha_id,
                    ':login_id' => $login_id,
                    ':status' => $status
                )
            );

            if ($result) {
                $response[0]['status'] = 'Active';
                $response[0]['message'] = 'Post liked';
                $response[0]['login_id'] = $login_id;
                $response[0]['yashogatha_id'] = $yashogatha_id;
                echo json_encode($response);
            } else {
                $response[0]['status'] = 'Failed';
                $response[0]['message'] = 'Failed to like';
                echo json_encode($response);
            }
        }
    } else {
        $response[0]['status'] = 'Failed';
        $response[0]['message'] = 'Empty param';
        echo json_encode($response);
    }
} else {
    $response[0]['status'] = 'Failed';
    $response[0]['message'] = 'Missing token';
    echo json_encode($response);
}
