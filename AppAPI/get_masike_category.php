<?php
include 'connect.inc.php';
$response = array();
@header( 'Content_Type: application/json' );

if ( isset( $_POST['selected_exams_id'] ) ) {

    $selected_exam_id = $_POST['selected_exams_id'];

    $query = "SELECT * FROM masike_category WHERE status = 'Active' AND JSON_CONTAINS(selected_exams_id, '[\"".$selected_exam_id."\"]')";

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