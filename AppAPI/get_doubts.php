<?php
include 'connect.inc.php';
$response = array();
@header( 'Content_Type: application/json' );

$query = "SELECT a.*, 
                b.full_name,
                b.profile_image
                FROM doubts a 
                INNER JOIN user_login b ON
                a.user_id = b.login_id
                WHERE 
                a.status = 'Active' ORDER BY doubt_id DESC";

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