<?php
include 'connect.inc.php';
$response = array();
@header( 'Content-Type:application/json' );

if ( isset( $_POST['job_feeds_comment_id'] ) &&
isset( $_POST['login_id'] ) ) {

    $job_feeds_comment_id = $_POST['job_feeds_comment_id'];
    $login_id = $_POST['login_id'];

    if ( !empty( $job_feeds_comment_id ) &&
    !empty( $login_id ) ) {

        $updated_on = date( 'Y-m-d' );

        $query = 'UPDATE `job_feeds_comment` SET `comment_status`=:comment_status, `updated_on`=:updated_on WHERE login_id = :login_id AND job_feeds_comment_id = :job_feeds_comment_id';

        $statement = $connect->prepare( $query );
        $result = $statement->execute(
            array(
                ':comment_status' => 'Reported',
                ':updated_on' => $updated_on,
                ':job_feeds_comment_id' => $job_feeds_comment_id,
                ':login_id' => $login_id ) );

                if ( $result ) {
                    $response [0]['status'] = 'Active';
                    $response [0]['message'] = 'Comment Reported';
                    echo json_encode( $response );

                } else {
                    $response [0]['status'] = 'Failed';
                    $response [0]['message'] = 'Failed to Report';
                    echo json_encode( $response );
                }
            } else {
                $response [0]['status'] = 'Failed';
                $response [0]['message'] = 'Empty parameters received';
                echo json_encode( $response );
            }
        } else {
            $response [0]['status'] = 'Failed';
            $response [0]['message'] = 'Invalid parameters, try again';
            echo json_encode( $response );
        }
        ?>