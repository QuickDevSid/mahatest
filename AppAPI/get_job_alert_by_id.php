<?php
include 'connect.inc.php';
$response = array();
@header( 'Content_Type: application/json' );

if ( isset( $_POST['job_alert_id'] ) ) {

    $job_alert_id = $_POST['job_alert_id'];

    $query = "SELECT * FROM job_alert WHERE `job_alert_id` = '$job_alert_id' AND status = 'Active'";

    $statement = $connect->query( $query );
    $result    = $statement->fetchAll( PDO::FETCH_ASSOC );

    if ( $result ) {
        echo json_encode( $result );
    } else {
        $response [0]['status'] = 'Failed';
        $response [0]['message']  = 'Failed Fetch Data';
        echo json_encode( $response );
    }
} else {
    $response[0]['status']  = 'Failed';
    $response[0]['message'] = 'Invalid parameters received';
    echo json_encode( $response );
}
?>