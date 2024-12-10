<?php
include 'connect.inc.php';
$response = array();
@header('Content_Type: application/json');

if (
    isset($_POST['user_id']) &&
    isset($_POST['doubt_question']) &&
    isset($_POST['doubt_image'])
) {
    $user_id = @$_POST['user_id'];
    $doubt_question = @$_POST['doubt_question'];
    $doubt_image = @$_POST['doubt_image'];
    
    if (
        !empty($user_id) &&
        !empty($doubt_question) &&
        !empty($doubt_image)
    ) {
        
        $fileName = $user_id . '-' . time() . '.png';
        $filePath = "N/A";
        if ($doubt_image == "N/A") {

//$filePath = "./user-doubts/placeholder.png";
            $filePath = "N/A";
        }else{
            $doubt_image = @$_POST['doubt_image'];
            
            $base64Image = trim($doubt_image);
            $base64Image = str_replace('data:image/png;base64,', '', $base64Image);
            $base64Image = str_replace('data:image/jpg;base64,', '', $base64Image);
            $base64Image = str_replace('data:image/jpeg;base64,', '', $base64Image);
            $base64Image = str_replace('data:image/gif;base64,', '', $base64Image);
            $imageData = base64_decode($base64Image);
            $filePath = './user-doubts/' . $fileName;
            file_put_contents($filePath, $imageData);
            
            $base64Image = str_replace(' ', '+', $base64Image);
        }
        
        $status = 'Active';
        $created_on = date('Y-m-d');
        
        $query = "INSERT INTO `doubts`(
                                    `user_id`,
                                    `doubt_question`,
                                    `doubt_image`,
                                    `status`,
                                    `created_on`)
                                    VALUES(
                                      :user_id,
                                      :doubt_question,
                                      :doubt_image,
                                      :status,
                                      :created_on)";
        $statment = $connect->prepare($query);
        $result = $statment->execute(
            array(
                
                ':user_id' => $user_id,
                ':doubt_question' => $doubt_question,
                ':doubt_image' => $filePath,
                ':status' => 'Active',
                ':created_on' => $created_on
            )
        );
        
        if ($result) {
            
            $doubt_id = $connect->lastInsertId();
            
            $response[0]['status'] = 'Active';
            $response[0]['message'] = 'Your doubt posted Successfully';
            $response[0]['doubt_question'] = $doubt_question;
            $response[0]['doubt_image'] = $doubt_image;
            $response[0]['user_id'] = $user_id;
            echo json_encode($response);
        } else {
            $response[0]['status'] = 'Failed';
            $response[0]['message'] = 'Failed to add doubt, try again';
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
