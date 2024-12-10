<?php
include 'connect.inc.php';
$response = array();
@header( 'Content_Type: application/json' );

if ( isset( $_POST['login_id'] ) ) {

    $login_id = $_POST['login_id'];

    $query = "SELECT a.*, 
    b.paper_title, 
    b.total_questions, 
    b.duration 
    FROM 
    previous_exam_live_test_result 
    a INNER JOIN 
    gatavarshichya_prashna_patrika_year_title 
    b ON 
    a.question_papers_id = b.question_papers_id 
    WHERE 
    a.status = 'Active' 
    AND login_id = '$login_id' ORDER BY previous_exam_live_test_result_id DESC";

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