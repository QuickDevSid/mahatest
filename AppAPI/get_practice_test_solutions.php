<?php
include 'connect.inc.php';
$response = array();
$response_subject = array();
@header( 'Content_Type: application/json' );

if ( isset( $_POST['quiz_result_id'] ) ) {

    $quiz_result_id = $_POST['quiz_result_id'];

    $query = "SELECT * FROM 
                    previous_exam_result_details a, previous_exam_result b, gatavarshichya_prashna_patrika_practice_test c 
                    WHERE a.previous_exam_result_id = b.previous_exam_result_id 
                    AND a.question = c.question 
                    AND a.previous_exam_result_id = $quiz_result_id
                    GROUP BY a.id";

    $statement = $connect->query( $query );
    $result    = $statement->fetchAll( PDO::FETCH_ASSOC );

//Get questions details for pagination.
    $id_query = "SELECT question_papers_id FROM previous_exam_result WHERE previous_exam_result_id  = '$quiz_result_id'";
    $id_statement = $connect->query($id_query);
    $id_result = $id_statement ->fetch(PDO::FETCH_ASSOC);
    $quiz_id = $id_result["question_papers_id"];

    //Get questions details for pagination.
    $query1 = "SELECT s.subject_id AS SubjectID, s.subject_name AS SubjectName 
    FROM gatavarshichya_prashna_patrika_practice_test r, quiz_subject s WHERE r.question_papers_id = '$quiz_id' 
    AND r.subject_id = s.subject_id AND r.status = 'Active' GROUP BY s.subject_id";

    $statement1 = $connect->query($query1);
    $result1    = $statement1->fetchAll(PDO::FETCH_ASSOC);

    $subject = array();

    foreach ($result1 as $row) {
        $sid = $row['SubjectID'];
        $query_question = "SELECT practice_test_id  as id, question FROM gatavarshichya_prashna_patrika_practice_test 
        WHERE question_papers_id = '$quiz_id' AND subject_id = '$sid' AND status = 'Active'";
        $statement_question = $connect->query($query_question);
        $result_questions    = $statement_question->fetchAll(PDO::FETCH_ASSOC);

        $subject['SubjectID'] = $row['SubjectID'];
        $subject['SubjectName'] = $row['SubjectName'];
        $subject['Question'] = $result_questions;

        array_push($response_subject, $subject);
    }

    if ( $result ) {
        $response[0]['status'] = 'Success';
        $response[0]['message']  = 'Found Data.';
        $response[0]['questions'] = $result;
        $response[0]['questions_pagination'] = $response_subject;
        echo json_encode($response);
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