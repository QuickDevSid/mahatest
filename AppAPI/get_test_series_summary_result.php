<?php
include 'connect.inc.php';
$response = array();
$response_result = array();
@header( 'Content_Type: application/json' );

if ( isset( $_POST['test_series_result_id'] ) ) {

    $test_series_result_id = $_POST['test_series_result_id'];
    
    $query = "SELECT  
(SELECT COUNT(*) FROM test_series_result_details WHERE test_series_result_details.users_answer = 'N/A'AND test_series_result_details.test_series_result_id = '$test_series_result_id') AS NotAttempted, 
(SELECT COUNT(*) FROM test_series_result_details WHERE test_series_result_details.users_answer != 'N/A'AND test_series_result_details.test_series_result_id = '$test_series_result_id') AS TotalAttempted
FROM test_series_result_details r, test_series_result rr WHERE rr.test_series_result_id = '$test_series_result_id' AND rr.test_series_result_id = r.test_series_result_id GROUP BY rr.test_series_result_id";

    $statement = $connect->query( $query );
    $result    = $statement->fetchAll( PDO::FETCH_ASSOC );

    $TotalCorrectAnswer = 0;
    $TotalWrongAnswer = 0;
    $TotalNotAttemptedAnswer = 0;
    $TotalAttemptedAnswer = 0;
    $TotalAnswerCount = 0;
    $TimeTaken = 0;

    foreach ( $result as $row ) {
        $TotalNotAttemptedAnswer = $TotalNotAttemptedAnswer + $row['NotAttempted'];
        $TotalAttemptedAnswer = $TotalAttemptedAnswer + $row['TotalAttempted'];
    }
 
     //Get questions details for pagination.
    $marks_query = "SELECT quiz_id, obtain_marks, time_taken, total_questions, wrong_answer, correct_answer FROM test_series_result WHERE test_series_result_id = '$test_series_result_id'";
    $marks_statement = $connect->query($marks_query);
    $marks_result = $marks_statement ->fetch(PDO::FETCH_ASSOC);

    $score = $marks_result["obtain_marks"];
    $TimeTaken = $marks_result["time_taken"];
    $TotalAnswerCount = $marks_result["total_questions"];
    $TotalWrongAnswer = $marks_result["wrong_answer"];
    $TotalCorrectAnswer = $marks_result["correct_answer"];

    $ExamId = $marks_result["quiz_id"];

    //Get questions details for pagination.
    $rank_query = "SELECT COUNT(test_series_result_id) AS Rank FROM test_series_result WHERE obtain_marks >= '$score' AND quiz_id = '$ExamId'";
    $rank_statement = $connect->query($rank_query);
    $rank_result = $rank_statement ->fetch(PDO::FETCH_ASSOC);
    $rank = $rank_result["Rank"];

        //Get questions details for pagination.
    $total_rank_query = "SELECT COUNT(test_series_result_id) AS TotalRank FROM test_series_result WHERE quiz_id = '$ExamId'";
    $total_rank_statement = $connect->query($total_rank_query);
    $total_rank_result = $total_rank_statement ->fetch(PDO::FETCH_ASSOC);
    $total_rank = $total_rank_result["TotalRank"];

    //Get questions details for pagination.
    $total_marks_query = "SELECT correct_answer_mark FROM test_series_exam_list WHERE test_series_exam_list_id  = '$ExamId'";
    $total_marks_statement = $connect->query($total_marks_query);
    $total_marks_result = $total_marks_statement ->fetch(PDO::FETCH_ASSOC);
    $correct_answer_mark = $total_marks_result["correct_answer_mark"];
    $total_marks = ($correct_answer_mark * $TotalAnswerCount);

    //Get quiz details for Reattempt.
    $reattempt_query = "SELECT * FROM test_series_exam_list WHERE `test_series_exam_list_id` = '$ExamId'";
    $reattempt_statement = $connect->query( $reattempt_query );
    $reattempt_result    = $reattempt_statement->fetchAll( PDO::FETCH_ASSOC );

    if ( $result ) {
        $response[0]['status'] = 'Success';
        $response[0]['message']  = 'Found Data.';
        $response[0]['score']  = $score;
        $response[0]['total_score']  = $total_marks;
        $response[0]['rank']  = $rank;
        $response[0]['total_rank']  = $total_rank;
        $response[0]['time_taken']  = $TimeTaken;
        $response[0]['total_answer_count']  = $TotalAnswerCount;
        $response[0]['total_wrong_answer']  = $TotalWrongAnswer;
        $response[0]['total_correct_answer']  = $TotalCorrectAnswer;
        $response[0]['total_not_attempted_answer']  = $TotalNotAttemptedAnswer;
        $response[0]['total_attempted_answer']  = $TotalAttemptedAnswer;
        $response[0]['reattempt'] = $reattempt_result;

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