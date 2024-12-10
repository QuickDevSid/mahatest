<?php
include 'connect.inc.php';
$response = array();
@header( 'Content_Type: application/json' );
$selected_exam_id = $_POST['selected_exams_id'];

//$query = "SELECT * FROM sarav_prashnasanch_subjects WHERE status = 'Active' AND `selected_exams_id` = '$selected_exam_id'";

$query = "SELECT * FROM sarav_prashnasanch_subjects WHERE status = 'Active' AND JSON_CONTAINS(selected_exams_id, '[\"".$selected_exam_id."\"]') ";

$statement = $connect->query( $query );
$result    = $statement->fetchAll( PDO::FETCH_ASSOC );

if ( $result ) {
    echo json_encode( $result );
} else {
    $response [0]['status'] = 'Failed';
    $response [0]['message']  = 'Failed Fetch Data';
    echo json_encode( $response );
}
?>