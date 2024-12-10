<?php
include 'connect.inc.php';
include 'core.inc.php';
$response = array();
@header( 'Content_Type: application/json' );

if (
    isset( $_POST['job_feed_id'] ) &&
    isset( $_POST['login_id'] ) ) {

        $job_feed_id = @$_POST['job_feed_id'];
        $login_id = @$_POST['login_id'];

        if ( !empty( $job_feed_id ) &&
        !empty( $login_id ) ) {

            $status = 'Active';
            $created_on = date( 'Y-m-d' );

            //check if already liked
            //unlike if already liked
            if ( unlikeIfAlreayLiked( $job_feed_id, $login_id, $connect ) ) {
                $response [0]['status'] = 'Active';
                $response [0]['message'] = 'Post Unliked';
                echo json_encode( $response );
            } else {

                //like if unliked or not liked yet
                $query = "INSERT INTO `job_feeds_like`(
                            `job_feed_id`,
                            `login_id`,
                            `status`, 
                            `created_on`)
                            VALUES (
                            :job_feed_id,
                            :login_id,
                            :status,
                            :created_on)";

                $statment = $connect->prepare( $query );
                $result = $statment->execute(
                    array(
                        ':job_feed_id' => $job_feed_id,
                        ':login_id' => $login_id,
                        ':status' => $status,
                        ':created_on' => $created_on
                    ) );

                    if ( $result ) {

                        $response [0]['status'] = 'Active';
                        $response [0]['message'] = 'Post liked';
                        $response [0]['login_id'] = $login_id;
                        $response [0]['job_feed_id'] = $job_feed_id;
                        echo json_encode( $response );

                    } else {
                        $response [0]['status'] = 'Failed';
                        $response [0]['message'] = 'Failed to like';
                        echo json_encode( $response );
                    }
                }
            } else {
                $response [0]['status'] = 'Failed';
                $response [0]['message'] = 'Empty param';
                echo json_encode( $response );
            }
        } else {
            $response [0]['status'] = 'Failed';
            $response [0]['message'] = 'Missing token';
            echo json_encode( $response );
        }
        ?>