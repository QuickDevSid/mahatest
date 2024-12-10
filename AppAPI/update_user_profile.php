<?php

include 'connect.inc.php';
$response = array();
@header('Content_Type: application/json');

if (
    isset($_POST['login_id']) &&
    isset($_POST['profile_image']) &&
    isset($_POST['full_name'])
) {

    $login_id = @$_POST['login_id'];
    $full_name = @$_POST['full_name'];
    $profile_image = @$_POST['profile_image'];

    if (
        !empty($login_id) &&
        !empty($full_name) &&
        !empty($profile_image)
    ) {

        //if profile is not empty upte it
        $fileName =   $login_id . '-' . time() . '.png';

        $base64Image = trim($profile_image);
        $base64Image = str_replace('data:image/png;base64,', '', $base64Image);
        $base64Image = str_replace('data:image/jpg;base64,', '', $base64Image);
        $base64Image = str_replace('data:image/jpeg;base64,', '', $base64Image);
        $base64Image = str_replace('data:image/gif;base64,', '', $base64Image);
        $imageData = base64_decode($base64Image);
        $filePath = './user-profile/' . $fileName;
        file_put_contents($filePath, $imageData);

        $base64Image = str_replace(' ', '+', $base64Image);
        $status = 'Active';
        $created_on = date('Y-m-d');

        $query = "UPDATE `user_login` SET
                `profile_image`=:profile_image,
                `full_name`=:full_name,
                `status`=:status,
                `created_on`=:created_on WHERE
                `login_id` = :login_id";

        $statment = $connect->prepare($query);

        $result = $statment->execute(
            array(
                ':full_name' => $full_name,
                ':profile_image' => $filePath,
                ':status' => 'Active',
                ':created_on' => $created_on,
                ':login_id' => $login_id
            )
        );
        if ($result) {
            $response[0]['status'] = 'Active';
            $response[0]['message'] = 'Profile updated successfully';

            echo json_encode($response);
        } else {
            $response[0]['status'] = 'Failed';
            $response[0]['message'] = 'Failed to update profile, try again';
            $error = $statment->errorInfo();
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
