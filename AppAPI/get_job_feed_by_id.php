<?php
include 'connect.inc.php';
$response  = array();
@header( 'Content-Type:application/json' );

if ( isset( $_POST['job_feed_id'] ) ) {

    $job_feed_id = $_POST['job_feed_id'];
    $message = '';

    $message .= empty( $job_feed_id ) ? '- User name can not be empty ' : '';

    if ( empty( trim( $message ) ) ) {

        $query = "SELECT * FROM `job_feeds` WHERE `job_feed_id` = '$job_feed_id' AND `status` = 'Active'";
        $statement = $connect->prepare( $query );
        $statement->execute();
        $result    = $statement->fetchAll( PDO::FETCH_ASSOC );

        if ( count( $result ) == 0 ) {
            $response[0]['status'] = 'Failed';
            $response[0]['message'] = 'Invalid job_feed_id';
            echo json_encode( $response );
        } else {
            $response[0]['status'] = 'Active';
            $response[0]['message'] = 'User profile found';
            $response[0]['job_feed_id'] = $result[0]['job_feed_id'];
            $response[0]['image'] = $result[0]['image'];
            $response[0]['title'] = $result[0]['title'];
            $response[0]['description'] = $result[0]['description'];

            echo json_encode( $response );
        }
    } else {
        $response[0]['status'] = 'Failed';
        $response[0]['message'] = $message;
        echo json_encode( $response );
    }
} else {
    $response[0]['status']  = 'Failed';
    $response[0]['message'] = 'Invalid parameters received';
    echo json_encode( $response );
}

?>
