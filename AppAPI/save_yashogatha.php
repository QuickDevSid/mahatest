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
        $created_on = date('Y-m-d');
        $updated_on = date('Y-m-d');

        //check if already liked
        //unlike if already liked
        if (unSaveYashoGathaIfAlreaySaved($yashogatha_id, $login_id, $connect)) {
            $response[0]['status'] = 'Active';
            $response[0]['message'] = 'Removed';
            echo json_encode($response);
        } else {

            //like if unliked or not liked yet
            $query = "INSERT INTO `yashogatha_saved`(
            `yashogatha_id`,
            `login_id`,
            `status`, 
            `created_on`)
            VALUES (
            :yashogatha_id,
            :login_id,
            :status,
            :created_on)";

            $statment = $connect->prepare($query);
            $result = $statment->execute(
                array(
                    ':yashogatha_id' => $yashogatha_id,
                    ':login_id' => $login_id,
                    ':status' => $status,
                    ':created_on' => $created_on
                )
            );

            if ($result) {

                $response[0]['status'] = 'Active';
                $response[0]['message'] = 'Added to saved list';
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
