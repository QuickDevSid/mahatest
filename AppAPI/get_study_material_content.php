<?php
include 'connect.inc.php';
$response = array();
@header( 'Content_Type: application/json' );

if ( isset( $_POST['study_material_id'] ) ) {

    $study_material_id = $_POST['study_material_id'];

    $query = "SELECT * FROM study_material_content WHERE `study_material_id` = '$study_material_id' AND
    status = 'Active'";

    $statement = $connect->query( $query );
    $result    = $statement->fetchAll( PDO::FETCH_ASSOC );

    if ( $result ) {
        echo json_encode( $result );
    } else {
        $response [0]['status'] = 'Failed';
        $response [0]['message']  = 'No Content found';
        echo json_encode( $response );
    }
} else {
    $response[0]['status']  = 'Failed';
    $response[0]['message'] = 'Invalid parameters received';
    echo json_encode( $response );
}
?>