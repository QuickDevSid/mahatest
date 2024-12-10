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
        $job_feed_id = @$_POST['job_feed_id'];
        $selected_exam_id = @$_POST['selected_exams_id'];

        $query = "SELECT * FROM job_feeds WHERE status = 'Active' ORDER BY job_feed_id DESC";

        //$query =  "SELECT a.selected_exams_id, 
       // b.selected_exams,
       // b.selected_exams_id
       // FROM job_feeds a 
       // INNER JOIN user_login b ON
       // a.selected_exams_id = b.selected_exams_id
       // WHERE 
      //  a.status = 'Active' ORDER BY job_feed_id DESC";

        $statement = $connect->query( $query );
        if ( $statement ) {
            $data = $statement ->fetchAll( PDO::FETCH_ASSOC );
            $row = count( $data );
            if ( $row > 0 ) {

                for ( $i = 0; $i<$row; $i++ ) {
                    $job_feed_id = $data[$i]['job_feed_id'];
                    $selected_exam_id = $data[$i]['selected_exams_id'];
                    $data[$i]['like_status'] = getLikeStatus( $connect, $job_feed_id, $login_id );
                    $data[$i]['post_likes'] = getLikeCount( $connect, $data[$i]['job_feed_id'] );
                    $data[$i]['post_comments'] = getCommentsCount( $connect, $data[$i]['job_feed_id'] );
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