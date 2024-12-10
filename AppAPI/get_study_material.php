<?php
include 'connect.inc.php';
$response = array();
@header( 'Content_Type: application/json' );

$query = "SELECT * FROM study_material WHERE status = 'Active'";

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