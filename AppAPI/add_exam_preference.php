<?php
require 'connect.inc.php';
require 'core.inc.php';

$response = array();

@header('Content_Type: application/json');
if (isset($_POST['selected_exams'])) {
    $login_id = @$_POST['login_id'];
    $selected_exams = @$_POST['selected_exams'];
    $selected_exam_id = @$_POST['selected_exams_id'];

    if (
        !empty($login_id) &&
        !empty($selected_exams)
    ) {

        $query = 'UPDATE `user_login` SET `selected_exams`=:selected_exams, `selected_exams_id`=:selected_exams_id WHERE `login_id` = :login_id';

        $last_namement = $connect->prepare($query);
        $result = $last_namement->execute(
            array(
                ':selected_exams' => $selected_exams,
                ':selected_exams_id' => $selected_exam_id,
                ':login_id' => $login_id
            )
        );

        if ($result) {
            $response[0]['status'] = 'Active';
            $response[0]['message'] = 'Updated successfully';

            $response[0]['selected_exams'] = $selected_exams;
            echo json_encode($response);
        } else {
            $response[0]['status'] = 'Failed';
            $response[0]['message'] = 'Try again';
            $error = $last_namement->errorInfo();
            $response[0]['error'] = $error[2];
            echo json_encode($response);
        }
    } else {
        $response[0]['status'] = 'Failed';
        $response[0]['message'] = '* is mandatory';
        echo json_encode($response);
    }
} else {
    $response[0]['status'] = 'Failed';
    $response[0]['message'] = 'Some parameters are missing, try again';

    echo json_encode($response);
}
