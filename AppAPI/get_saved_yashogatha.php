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
                    b.yashogatha_id, 
                    b.yashogatha_image, 
                    b.yashogatha_title,
                    b.yashogatha_description
                    FROM 
                    yashogatha_saved a 
                    INNER JOIN 
                    yashogatha b ON 
                    a.yashogatha_id = b.yashogatha_id 
                    WHERE a.status = 'Active' AND login_id = '$login_id'";

        $statement = $connect->query( $query );
        if ( $statement ) {
            $data = $statement ->fetchAll( PDO::FETCH_ASSOC );
            $row = count( $data );
            if ( $row > 0 ) {

                for ( $i = 0; $i<$row; $i++ ) {
                    $yashogatha_id = $data[$i]['yashogatha_id'];
                    $data[$i]['like_status'] = getYashoGathaLikeStatus( $connect, $yashogatha_id, $login_id );
                    $data[$i]['save_status'] = getYashoGathaSaveStatus( $connect, $yashogatha_id, $login_id );
                    $data[$i]['post_likes'] = getYashoGathaLikeCount( $connect, $data[$i]['yashogatha_id'] );
                    $data[$i]['post_comments'] = getYashoGathaCommentsCount( $connect, $data[$i]['yashogatha_id'] );
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