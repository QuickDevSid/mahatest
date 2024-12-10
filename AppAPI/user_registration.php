<?php
include 'connect.inc.php';
$response = array();

@header('Content-Type:application/json');

if (
    isset($_POST['full_name']) &&
    ($_POST['email']) &&
    ($_POST['mobile_number']) &&
    ($_POST['login_type']) &&
    ($_POST['password']) &&
    ($_POST['device_id']) &&
    ($_POST['place'])
) {
    $full_name   = @$_POST['full_name'];
    $email   = @$_POST['email'];
    $mobile_number   = @$_POST['mobile_number'];
    $login_type   = @$_POST['login_type'];
    $password = @$_POST['password'];
    $device_id = @$_POST['device_id'];
    $place = @$_POST['place'];
    $password = md5($password);

    if (
        !empty($full_name) &&
        !empty($email) &&
        !empty($mobile_number) &&
        !empty($login_type) &&
        !empty($password) &&
        !empty($device_id) &&
        !empty($place)
    ) {

        $status = 'Active';

        $query = "SELECT * FROM `user_login` WHERE `email` = '$email' AND `mobile_number` = '$mobile_number' AND status='Active'";
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
                                        `mobile_number`,
                                        `password`,
                                        `login_type`,
                                        `device_id`,
                                        `place`,
                                        `status`)
                                        VALUES(
                                        :full_name,
                                        :email,
                                        :mobile_number,
                                        :password,
                                        :login_type,
                                        :device_id,
                                        :place,
                                        :status)";

            $statement = $connect->prepare($query);
            $result = $statement->execute(

                array(
                    ':full_name' => $full_name,
                    ':email' => $email,
                    ':mobile_number' => $mobile_number,
                    ':login_type' => $login_type,
                    ':device_id' => $device_id,
                    ':place' => $place,
                    ':password' => $password,
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
                $response[0]['place'] = $place;
                $response[0]['password'] = $password;
                $response[0]['selected_exams_id'] = 'null';

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
