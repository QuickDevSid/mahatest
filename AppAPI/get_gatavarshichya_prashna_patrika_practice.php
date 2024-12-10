<?php
include 'connect.inc.php';
$response = array();
@header( 'Content_Type: application/json' );

if ( isset( $_POST['selected_exam_id'] ) ) {

    $selected_exam_id = $_POST['selected_exam_id'];

    $query = "SELECT * FROM gatavarshiche_prashna_subjects WHERE JSON_CONTAINS(selected_exam_id, '[\"".$selected_exam_id."\"]') AND status = 'Active'";

    $statement = $connect->query( $query );
    $result    = $statement->fetchAll( PDO::FETCH_ASSOC );

    if ( $result ) {
        echo json_encode( $result );
    } else {
        $response [0]['status'] = 'Failed';
        $response [0]['message']  = 'No content found!';
        echo json_encode( $response );
    }
} else {
    $response[0]['status']  = 'Failed';
    $response[0]['message'] = 'Invalid parameters received';
    echo json_encode( $response );
}
?>
