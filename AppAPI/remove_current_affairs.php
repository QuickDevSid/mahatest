<?php
include 'connect.inc.php';
$response = array();

@header( 'Content-Type:application/json' );

if (
    isset( $_POST['login_id'] ) &&
    isset( $_POST['current_affair_id'] )
) {

    $login_id = $_POST['login_id'];
    $current_affair_id = $_POST['current_affair_id'];

    if (
        !empty( $login_id ) &&
        !empty( $current_affair_id ) ) {

            $updated_on = date( 'Y-m-d' );

            $query = "UPDATE `current_affairs_saved` SET
                `status`=:status,
                `updated_on`=:updated_on
                WHERE current_affair_id = :current_affair_id
                AND login_id = :login_id";

            $statement = $connect->prepare( $query );
            $result = $statement->execute(
                array(
                    ':status' => 'Inactive',
                    ':updated_on' => $updated_on,
                    ':login_id' => $login_id,
                    ':current_affair_id' => $current_affair_id
                ) );

                if ( $result ) {
                    $response [0]['status'] = 'Active';
                    $response [0]['message'] = 'Removed';
                    echo json_encode( $response );

                } else {
                    $response [0]['status'] = 'Failed';
                    $response [0]['message'] = 'Failed to Remove';
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