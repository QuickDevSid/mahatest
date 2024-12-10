<?php
include 'connect.inc.php';
$response = array();

@header('Content-Type:application/json');

if (
    isset($_POST['full_name']) &&
    ($_POST['email']) &&
    ($_POST['login_type']) &&
    ($_POST['device_id'])
) {
    $full_name   = @$_POST['full_name'];
    $email   = @$_POST['email'];
    $login_type   = @$_POST['login_type'];
    $device_id = @$_POST['device_id'];

    if (
        !empty($full_name) &&
        !empty($email) &&
        !empty($login_type) &&
        !empty($device_id)
    ) {

        $status = 'Active';

        $query = "SELECT * FROM `user_login` WHERE `email` = '$email' AND status='Active'";
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            $response[0]['status'] = 'Failed';
            $response[0]['message'] = 'Email already Exist, please try a different email';
            echo json_encode($response);
        } else {

            $query = "INSERT INTO `user_login`(
                                        `full_name`,
                                        `email`,
                                        `login_type`,
                                        `device_id`,
                                        `status`)
                                        VALUES(
                                        :full_name,
                                        :email,
                                        :login_type,
                                        :device_id,
                                        :status)";

            $statement = $connect->prepare($query);
            $result = $statement->execute(

                array(
                    ':full_name' => $full_name,
                    ':email' => $email,
                    ':login_type' => $login_type,
                    ':device_id' => $device_id,
                    ':status' => 'Active'
                )
            );

            if ($result) {
                $login_id = $connect->lastInsertId();
                $response[0]['login_id'] = $login_id;
                $response[0]['full_name'] = $full_name;
                $response[0]['email'] = $email;
                $response[0]['mobile_number'] = $mobile_number;
                $response[0]['login_type'] = $login_type;
                $response[0]['device_id'] = $device_id;
                $response[0]['selected_exams_id'] = 'null';
                $response[0]['password'] = 'null';
                
                $response[0]['status'] = 'Active';
                $response[0]['message'] = 'Registered successfully';
                echo json_encode($response);
            } else {
                $response[0]['status'] = 'Failed';
                $response[0]['message'] = 'Failed to register, try again';
                echo json_encode($response);
            }
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
