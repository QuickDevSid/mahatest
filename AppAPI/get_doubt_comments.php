<?php
include 'connect.inc.php';
$response = array();
@header( 'Content_Type: application/json' );

if ( isset( $_POST['doubt_id'] ) ) {

    $doubt_id = $_POST['doubt_id'];

    // a is job_feeds_comment and b is user_login

    $query =  "SELECT a.*, 
                b.full_name,
                b.profile_image,
                b.gender
                FROM doubts_comment a 
                INNER JOIN user_login b ON
                a.login_id = b.login_id
                WHERE 
                a.status = 'Active' 
                AND 
                a.doubt_id = '$doubt_id' 
                ORDER BY 
                doubts_comment_id DESC";

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