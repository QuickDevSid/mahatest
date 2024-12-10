<?php
include 'connect.inc.php';
$response = array();
@header( 'Content-Type:application/json' );

if ( isset( $_POST['current_affairs_comments_id'] ) &&
isset( $_POST['login_id'] ) ) {

    $current_affairs_comments_id = $_POST['current_affairs_comments_id'];
    $login_id = $_POST['login_id'];

    if ( !empty( $current_affairs_comments_id ) &&
    !empty( $login_id ) ) {

        $updated_on = date( 'Y-m-d' );

        $query = 'UPDATE `current_affairs_comments` SET `comment_status`=:comment_status, `updated_on`=:updated_on WHERE login_id = :login_id AND current_affairs_comments_id = :current_affairs_comments_id';

        $statement = $connect->prepare( $query );
        $result = $statement->execute(
            array(
                ':comment_status' => 'Reported',
                ':updated_on' => $updated_on,
                ':current_affairs_comments_id' => $current_affairs_comments_id,
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