<?php
require 'connect.inc.php';
require 'core.inc.php';

$response = array();

@header( 'Content-Type: application/json' );
if ( isset( $_POST['login_id'] ) ) {

    $message = '';
    $message .= empty( trim( @$_POST['login_id'] ) ) ? 'Session has expired, Please login again <br>' : '';

    if ( empty( $message ) ) {
        $login_id = @$_POST['login_id'];
        $query = "SELECT a.*, 
                    b.current_affair_id, 
                    b.current_affair_image, 
                    b.current_affair_title,
                    b.current_affair_description
                    FROM 
                    current_affairs_saved a 
                    INNER JOIN 
                    current_affairs b ON 
                    a.current_affair_id = b.current_affair_id 
                    WHERE a.status = 'Active' AND login_id = '$login_id'";

        $statement = $connect->query( $query );
        if ( $statement ) {
            $data = $statement ->fetchAll( PDO::FETCH_ASSOC );
            $row = count( $data );
            if ( $row > 0 ) {

                for ( $i = 0; $i<$row; $i++ ) {
                    $current_affair_id = $data[$i]['current_affair_id'];
                    $data[$i]['like_status'] = getCurrentAffairsLikeStatus( $connect, $current_affair_id, $login_id );
                    $data[$i]['save_status'] = getCurrentAffairsSaveStatus( $connect, $current_affair_id, $login_id );
                    $data[$i]['post_likes'] = getCurrentAffairsLikeCount( $connect, $data[$i]['current_affair_id'] );
                    $data[$i]['post_comments'] = getCurrentAffairsCommentsCount( $connect, $data[$i]['current_affair_id'] );
                }
                echo json_encode( $data );
            } else {
                $response [0]['status'] = 'Failed';
                $response [0]['message'] = 'No product found';
                echo json_encode( $data );
            }
        } else {
            $response [0]['status'] = 'Failed';
            $response [0]['message'] = 'Could not Fetch';
            echo json_encode( $response );
        }

    } else {
        $response [0]['status'] = 'Failed';
        $response [0]['message'] = $message;
        echo json_encode( $response );
    }

} else {
    $response [0]['status'] = 'Failed';
    $response [0]['message'] = 'Invalid parameters, try again';
    echo json_encode( $response );
}

?>