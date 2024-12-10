<?php
include 'connect.inc.php';
include 'core.inc.php';
$response = array();
@header( 'Content_Type: application/json' );

if ( isset( $_POST['quiz_id'] ) &&
isset( $_POST['login_id'] ) &&
isset( $_POST['correct_answer'] ) &&
isset( $_POST['wrong_answer'] ) &&
isset( $_POST['total_questions'] )&&
isset( $_POST['time_taken'] ) ) {

    $quiz_id = @$_POST['quiz_id'];
    $login_id = @$_POST['login_id'];
    $correct_answer = @$_POST['correct_answer'];
    $wrong_answer = @$_POST['wrong_answer'];
    $total_questions = @$_POST['total_questions'];
    $time_taken = @$_POST['time_taken'];
    $quiz_answers = @$_POST['quiz_answers'];

    if ( !empty( $quiz_id ) &&
    !empty( $login_id ) ) {

    //Get questions details for pagination.
    $marks_query = "SELECT correct_answer_mark, wrong_answer_mark FROM daily_quiz WHERE quiz_id = '$quiz_id'";
    $marks_statement = $connect->query($marks_query);
    $marks_result = $marks_statement ->fetch(PDO::FETCH_ASSOC);

    $correct_answer_mark = $marks_result["correct_answer_mark"];
    $wrong_answer_mark = $marks_result["wrong_answer_mark"];
    $total_marks = ($correct_answer_mark * $correct_answer) - ($wrong_answer_mark * $wrong_answer);

        $status = 'Active';
        $created_on = date( 'Y-m-d' );

        $query = "INSERT INTO `quiz_result`(
						`quiz_id`,
						`login_id`,
						`correct_answer`,
						`wrong_answer`,
						`total_questions`,
                        `time_taken`,
                        `obtain_marks`,
						`status`, 
						`created_on`)
						VALUES (
						:quiz_id,
						:login_id,
						:correct_answer,
						:wrong_answer,
						:total_questions,
                        :time_taken,
                        :obtain_marks,
						:status,
						:created_on)";

        $statment = $connect->prepare( $query );
        $result = $statment->execute(
            array(
                ':quiz_id' => $quiz_id,
                ':login_id' => $login_id,
                ':correct_answer' => $correct_answer,
                ':wrong_answer' => $wrong_answer,
                ':total_questions' => $total_questions,
                ':time_taken' => $time_taken,
                ':obtain_marks' => $total_marks,
                ':status' => $status,
                ':created_on' => $created_on
            ) );

            if ( $result ) {
                $id = $connect->lastInsertId();
                $data = json_decode( $quiz_answers, true );

                foreach ( $data as $line ) {

                    $query1 = "INSERT INTO `quiz_result_detail`(
									`quiz_result_id`,
									`question`,
									`correct_answer`,
									`subject_id`,
									`users_answer`)
									VALUES (
									:quiz_result_id,
									:question,
									:correct_answer,
									:subject_id,
									:users_answer)";

                    $statment1 = $connect->prepare( $query1 );
                    $result1 = $statment1->execute(
                        array(
                            ':quiz_result_id' => $id,
                            ':question' => $line['Question'],
                            ':correct_answer' => $line['Answer'],
                            ':subject_id' => $line['subject_id'],
                            ':users_answer' => $line['User_Answer'] ) );
                        }

                        $response [0]['status'] = 'Active';
                        $response [0]['message'] = 'Added to saved list';
                        $response [0]['login_id'] = $login_id;
                        $response [0]['quiz_id'] = $quiz_id;
                        $response [0]['correct_answer'] = $correct_answer;
                        $response [0]['wrong_answer'] = $wrong_answer;
                        $response [0]['total_questions'] = $total_questions;
                        $response [0]['result_id'] = $id;
                        echo json_encode( $response );
                    } else {
                        $response [0]['status'] = 'Failed';
                        $response [0]['message'] = 'Failed to like';
                        echo json_encode( $response );
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