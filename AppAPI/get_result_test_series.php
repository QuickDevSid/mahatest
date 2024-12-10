<?php
include 'connect.inc.php';
$response = array();
@header( 'Content_Type: application/json' );

if ( isset( $_POST['login_id'] ) ) {

    $login_id = $_POST['login_id'];

    $query = "SELECT a.*, 
    b.exam_title, 
    b.exam_questions, 
    b.exam_duration  
    FROM 
    test_series_result 
    a INNER JOIN 
    test_series_exam_list 
    b ON 
    a.quiz_id = b.test_series_exam_list_id  
    WHERE 
    a.status = 'Active' 
    AND login_id = '$login_id' ORDER BY test_series_result_id DESC";

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