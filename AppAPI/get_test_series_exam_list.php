<?php
include 'connect.inc.php';
$response = array();
@header( 'Content_Type: application/json' );

if ( isset( $_POST['test_series'] ) ) {

    $test_series = $_POST['test_series'];
    $login_id = $_POST['login_id'];

    $query = "SELECT * FROM test_series_exam_list WHERE `test_series` = '$test_series'";

    $statement = $connect->query( $query );
    $result    = $statement->fetchAll( PDO::FETCH_ASSOC );

$quiz = array();
   foreach ($result as $row) {
    $quiz['test_series_exam_list_id'] = $row['test_series_exam_list_id'];
    $quiz['test_series'] = $row['test_series'];
    $quiz['exam_title'] = $row['exam_title'];
    $quiz['exam_questions'] = $row['exam_questions'];
    $quiz['exam_duration'] = $row['exam_duration'];
    $quiz['correct_answer_mark'] = $row['correct_answer_mark'];
    $quiz['wrong_answer_mark'] = $row['wrong_answer_mark'];
    $quiz['instructions'] = $row['instructions'];
    $quiz['status'] = $row['status'];
    $quiz['created_on'] = $row['created_on'];

        $quiz_id = $row['test_series_exam_list_id'];
        $query_question = "SELECT * FROM test_series_result WHERE quiz_id = '$quiz_id' AND login_id = '$login_id' ORDER BY test_series_result_id DESC LIMIT 1";
        $statement_question = $connect->query($query_question);
        $result_questions    = $statement_question->fetch(PDO::FETCH_ASSOC);
        
    $quiz['correct_answer'] = $result_questions['correct_answer'];
    $quiz['wrong_answer'] = $result_questions['wrong_answer'];
    $quiz['quiz_result_id'] = $result_questions['test_series_result_id'];
    $quiz['attempted_date'] = $result_questions['created_on'];

array_push($response, $quiz);
    }

    if ( $result ) {
        echo json_encode( $response );
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
