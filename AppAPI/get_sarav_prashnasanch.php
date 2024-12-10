<?php
include 'connect.inc.php';
$response = array();
@header( 'Content_Type: application/json' );
$sarav_prashnasanch_subjects_id = $_POST['sarav_prashnasanch_subjects_id'];
$login_id = $_POST['login_id'];

$query = "SELECT * FROM sarav_prasnasanch WHERE `sarav_prashnasanch_subjects_id` = '$sarav_prashnasanch_subjects_id' ORDER BY sarav_prasnasanch_id DESC";

$statement = $connect->query( $query );
$result    = $statement->fetchAll( PDO::FETCH_ASSOC );

$quiz = array();
   foreach ($result as $row) {
   	$quiz['sarav_prasnasanch_id'] = $row['sarav_prasnasanch_id'];
   	$quiz['sarav_prashnasanch_subjects_id'] = $row['sarav_prashnasanch_subjects_id'];
   	$quiz['selected_exams_id'] = $row['selected_exams_id'];
   	$quiz['quiz_title'] = $row['quiz_title'];
   	$quiz['quiz_questions'] = $row['quiz_questions'];
   	$quiz['quiz_duration'] = $row['quiz_duration'];
   	$quiz['correct_answer_mark'] = $row['correct_answer_mark'];
   	$quiz['wrong_answer_mark'] = $row['wrong_answer_mark'];
   	$quiz['instructions'] = $row['instructions'];
   	$quiz['status'] = $row['status'];
   	$quiz['created_on'] = $row['created_on'];

        $quiz_id = $row['sarav_prasnasanch_id'];
        $query_question = "SELECT * FROM sarav_prashnasanch_result WHERE quiz_id = '$quiz_id' AND login_id = '$login_id' ORDER BY sarav_prashnasanch_result_id DESC LIMIT 1";
        $statement_question = $connect->query($query_question);
        $result_questions    = $statement_question->fetch(PDO::FETCH_ASSOC);
        
   	$quiz['correct_answer'] = $result_questions['correct_answer'];
    $quiz['wrong_answer'] = $result_questions['wrong_answer'];
    $quiz['quiz_result_id'] = $result_questions['sarav_prashnasanch_result_id'];
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
?>
