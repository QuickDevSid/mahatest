<?php
include 'connect.inc.php';
$response = array();
$response_subject = array();
@header('Content_Type: application/json');

if ( isset( $_POST['sarav_prasnasanch_id'] ) ) {

    $sarav_prasnasanch_id = $_POST['sarav_prasnasanch_id'];

    $query = "SELECT * FROM sarav_prashnasanch_question WHERE `sarav_prasnasanch_id` = '$sarav_prasnasanch_id' AND status = 'Active' ORDER BY sarav_prashnasanch_question.sarav_prashnasanch_question_id";

    $statement = $connect->query( $query );
    $result    = $statement->fetchAll( PDO::FETCH_ASSOC );

    //Get questions details for pagination.
    $query1 = "SELECT s.subject_id AS SubjectID, s.subject_name AS SubjectName
    FROM sarav_prashnasanch_question r, quiz_subject s WHERE r.sarav_prasnasanch_id = '$sarav_prasnasanch_id'
    AND r.subject_id = s.subject_id AND r.status = 'Active' GROUP BY s.subject_id ORDER BY r.sarav_prashnasanch_question_id";

$statement1 = $connect->query($query1);
$result1    = $statement1->fetchAll(PDO::FETCH_ASSOC);

$subject = array();

foreach ($result1 as $row) {
    $sid = $row['SubjectID'];
    $query_question = "SELECT sarav_prashnasanch_question_id  as id, question FROM sarav_prashnasanch_question
    WHERE sarav_prasnasanch_id = '$sarav_prasnasanch_id' AND subject_id = '$sid' AND status = 'Active'";
    $statement_question = $connect->query($query_question);
    $result_questions    = $statement_question->fetchAll(PDO::FETCH_ASSOC);

    $subject['SubjectID'] = $row['SubjectID'];
    $subject['SubjectName'] = $row['SubjectName'];
    $subject['Question'] = $result_questions;

    array_push($response_subject, $subject);
}

if ($result) {
    $response[0]['status'] = 'Success';
    $response[0]['message']  = 'Found Data.';
    $response[0]['questions'] = $result;
    $response[0]['questions_pagination'] = $response_subject;
    echo json_encode($response);
} else {
    $response[0]['status'] = 'Failed';
    $response[0]['message']  = 'Failed Fetch Data';
    echo json_encode($response);
}
} else {
    $response[0]['status']  = 'Failed';
    $response[0]['message'] = 'Invalid parameters received';
    echo json_encode( $response );
}
?>