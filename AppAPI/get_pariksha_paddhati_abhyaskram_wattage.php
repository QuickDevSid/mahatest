<?php
include 'connect.inc.php';
$response = array();
@header( 'Content_Type: application/json' );

if ( isset( $_POST['pariksha_paddhati_abhyaskram_id'] ) ) {

    $pariksha_paddhati_abhyaskram_id = $_POST['pariksha_paddhati_abhyaskram_id'];

    $query = "SELECT * FROM 
    pariksha_paddhati_abhyaskram_wattage WHERE status = 'Active' AND pariksha_paddhati_abhyaskram_id = '$pariksha_paddhati_abhyaskram_id'";

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