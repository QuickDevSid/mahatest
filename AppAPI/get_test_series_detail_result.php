<?php
include 'connect.inc.php';
$response = array();
$response_result = array();
@header( 'Content_Type: application/json' );

if ( isset( $_POST['test_series_result_id'] ) ) {
    $test_series_result_id = $_POST['test_series_result_id'];
    
    $query = "SELECT s.subject_id AS SubjectID, s.subject_name AS SubjectName 
FROM test_series_result_details r, quiz_subject s, test_series_result rr 
WHERE rr.test_series_result_id = '$test_series_result_id' AND rr.test_series_result_id = r.test_series_result_id 
  AND r.subject_id = s.subject_id GROUP BY s.subject_id";
/*
$query = "SELECT s.subject_id AS SubjectID, s.subject_name AS SubjectName,
(SELECT COUNT(*) FROM test_series_result_details WHERE test_series_result_details.subject_id = s.subject_id AND test_series_result_details.correct_answer = test_series_result_details.users_answer AND test_series_result_details.test_series_result_id = '$test_series_result_id') AS CorrectAnswer,
(SELECT COUNT(*) FROM test_series_result_details WHERE test_series_result_details.subject_id = s.subject_id AND test_series_result_details.correct_answer != test_series_result_details.users_answer AND test_series_result_details.users_answer != 'N/A'AND test_series_result_details.test_series_result_id = '$test_series_result_id') AS WrongAnswer,
(SELECT COUNT(*) FROM test_series_result_details WHERE test_series_result_details.subject_id = s.subject_id AND test_series_result_details.test_series_result_id = '$test_series_result_id') AS TotalAnswer ,
(SELECT COUNT(*) FROM test_series_result_details WHERE test_series_result_details.subject_id = s.subject_id AND test_series_result_details.users_answer = 'N/A'AND test_series_result_details.test_series_result_id = '$test_series_result_id') AS NotAttempted,
(SELECT COUNT(*) FROM test_series_result_details WHERE test_series_result_details.subject_id = s.subject_id AND test_series_result_details.users_answer != 'N/A'AND test_series_result_details.test_series_result_id = '$test_series_result_id') AS TotalAttempted
FROM test_series_result_details r, quiz_subject s, test_series_result rr WHERE rr.test_series_result_id = '$test_series_result_id' AND rr.test_series_result_id = r.test_series_result_id AND r.subject_id = s.subject_id GROUP BY s.subject_id";
*/
    $statement = $connect->query( $query );
    $result    = $statement->fetchAll( PDO::FETCH_ASSOC );
    $subject = array();

    foreach ( $result as $row ) {
        $sid = $row['SubjectID'];
        $query_question = "SELECT test_series_result_details.*,test_series_result.time_taken  FROM test_series_result_details,test_series_result WHERE test_series_result_details.test_series_result_id = '$test_series_result_id' AND test_series_result_details.subject_id = '$sid' AND test_series_result.test_series_result_id ='$test_series_result_id' ";
        $statement_question = $connect->query( $query_question );
        $result_questions    = $statement_question->fetchAll( PDO::FETCH_ASSOC );

        $subject['SubjectID'] = $row['SubjectID'];
        $subject['SubjectName'] = $row['SubjectName'];

        $correct_query = "SELECT COUNT(test_series_result_id) AS CorrectAnswer FROM test_series_result_details WHERE test_series_result_details.subject_id = '" . $row['SubjectID'] . "' AND test_series_result_details.correct_answer = test_series_result_details.users_answer AND test_series_result_details.test_series_result_id = '" . $test_series_result_id . "'";
        $correct_statement = $connect->query($correct_query);
        $correct_result = $correct_statement->fetch(PDO::FETCH_ASSOC);
        $subject['CorrectAnswer'] = $correct_result["CorrectAnswer"];

        $wrong_query = "SELECT COUNT(test_series_result_id) AS WrongAnswer FROM test_series_result_details WHERE test_series_result_details.subject_id = '" . $row['SubjectID'] . "' AND test_series_result_details.correct_answer != test_series_result_details.users_answer AND test_series_result_details.test_series_result_id = '" . $test_series_result_id . "'";
        $wrong_statement = $connect->query($wrong_query);
        $wrong_result = $wrong_statement->fetch(PDO::FETCH_ASSOC);
        $subject['WrongAnswer'] = $wrong_result["WrongAnswer"];

        $total_query = "SELECT COUNT(test_series_result_id) AS TotalAnswer FROM test_series_result_details WHERE test_series_result_details.subject_id = '" . $row['SubjectID'] . "' AND test_series_result_details.test_series_result_id = '" . $test_series_result_id . "'";
        $total_statement = $connect->query($total_query);
        $total_result = $total_statement->fetch(PDO::FETCH_ASSOC);
        $subject['TotalAnswer'] = $total_result["TotalAnswer"];

        $not_query = "SELECT COUNT(test_series_result_id) AS NotAttempted FROM test_series_result_details WHERE test_series_result_details.subject_id = '" . $row['SubjectID'] . "' AND test_series_result_details.users_answer = 'N/A' AND test_series_result_details.test_series_result_id = '" . $test_series_result_id . "'";
        $not_statement = $connect->query($not_query);
        $not_result = $not_statement->fetch(PDO::FETCH_ASSOC);
        $subject['NotAttempted'] = $not_result["NotAttempted"];

        $total_attempted_query = "SELECT COUNT(test_series_result_id) AS TotalAttempted FROM test_series_result_details WHERE test_series_result_details.subject_id = '" . $row['SubjectID'] . "' AND test_series_result_details.correct_answer != 'N/A' AND test_series_result_details.test_series_result_id = '" . $test_series_result_id . "'";
        $total_attempted_statement = $connect->query($total_attempted_query);
        $total_attempted_result = $total_attempted_statement->fetch(PDO::FETCH_ASSOC);
        $subject['TotalAttempted'] = $total_attempted_result["TotalAttempted"];

        $subject['Question'] = $result_questions;

        array_push( $response_result, $subject );
    }


    if ( $result ) {
        $response[0]['status'] = 'Success';
        $response[0]['message']  = 'Found Data.';
        $response[0]['results'] = $response_result;
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
