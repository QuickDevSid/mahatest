<?php
require 'connect.inc.php';
require 'core.inc.php';
$response = array();
@header( 'Content_Type: application/json' );

if (
    isset( $_POST['yashogatha_id'] ) &&
    isset( $_POST['login_id'] ) ) {

        $yashogatha_id = $_POST['yashogatha_id'];
        $login_id = $_POST['login_id'];


        $query = "SELECT * FROM yashogatha WHERE `yashogatha_id` = '$yashogatha_id' AND status = 'Active'";

        $statement = $connect->query( $query );
        //  $result    = $statement->fetchAll( PDO::FETCH_ASSOC );
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
                $response [0]['message'] = 'No content found';
                echo json_encode( $response );
            }
        } else {
            $response [0]['status'] = 'Failed';
            $response [0]['message'] = 'Could not Fetch';
            echo json_encode( $response );
        }
    } else {
        $response[0]['status']  = 'Failed';
        $response[0]['message'] = 'Invalid parameters received';
        echo json_encode( $response );
    }
    ?>