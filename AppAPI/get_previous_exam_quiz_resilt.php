<?php
include 'connect.inc.php';
$response = array();
$response_result = array();
@header( 'Content_Type: application/json' );

if ( isset( $_POST['previous_exam_result_id'] ) ) {

    $previous_exam_result_id = $_POST['previous_exam_result_id'];
    
    $query = "SELECT s.subject_id AS SubjectID, s.subject_name AS SubjectName,
(SELECT COUNT(*) FROM previous_exam_result_details WHERE previous_exam_result_details.subject_id = s.subject_id AND previous_exam_result_details.correct_answer = previous_exam_result_details.users_answer AND previous_exam_result_details.previous_exam_result_id = '$previous_exam_result_id') AS CorrectAnswer,
(SELECT COUNT(*) FROM previous_exam_result_details WHERE previous_exam_result_details.subject_id = s.subject_id AND previous_exam_result_details.correct_answer != previous_exam_result_details.users_answer AND previous_exam_result_details.users_answer != 'N/A'AND previous_exam_result_details.previous_exam_result_id = '$previous_exam_result_id') AS WrongAnswer,
(SELECT COUNT(*) FROM previous_exam_result_details WHERE previous_exam_result_details.subject_id = s.subject_id AND previous_exam_result_details.previous_exam_result_id = '$previous_exam_result_id') AS TotalAnswer ,
(SELECT COUNT(*) FROM previous_exam_result_details WHERE previous_exam_result_details.subject_id = s.subject_id AND previous_exam_result_details.users_answer = 'N/A'AND previous_exam_result_details.previous_exam_result_id = '$previous_exam_result_id') AS NotAttempted,
(SELECT COUNT(*) FROM previous_exam_result_details WHERE previous_exam_result_details.subject_id = s.subject_id AND previous_exam_result_details.users_answer != 'N/A'AND previous_exam_result_details.previous_exam_result_id = '$previous_exam_result_id') AS TotalAttempted
FROM previous_exam_result_details r, quiz_subject s, previous_exam_result rr WHERE rr.previous_exam_result_id = '$previous_exam_result_id' AND rr.previous_exam_result_id = r.previous_exam_result_id AND r.subject_id = s.subject_id GROUP BY s.subject_id";

    $statement = $connect->query( $query );
    $result    = $statement->fetchAll( PDO::FETCH_ASSOC );
    
    $subject = array();
    $TotalCorrectAnswer = 0;
    $TotalWrongAnswer = 0;
    $TotalNotAttemptedAnswer = 0;
    $TotalAttemptedAnswer = 0;
    $TotalAnswerCount = 0;
    $TimeTaken = 0;
    
    foreach ( $result as $row ) {
        $sid = $row['SubjectID'];
        $query_question = "SELECT previous_exam_result_details.*  FROM previous_exam_result_details,previous_exam_result WHERE previous_exam_result_details.previous_exam_result_id = '$previous_exam_result_id' AND previous_exam_result_details.subject_id = '$sid' AND previous_exam_result.previous_exam_result_id ='$previous_exam_result_id' ";
        $statement_question = $connect->query( $query_question );
        $result_questions    = $statement_question->fetchAll( PDO::FETCH_ASSOC );

        $subject['SubjectID'] = $row['SubjectID'];
        $subject['SubjectName'] = $row['SubjectName'];
        $subject['CorrectAnswer'] = $row['CorrectAnswer'];
        $subject['WrongAnswer'] = $row['WrongAnswer'];
        $subject['TotalAnswer'] = $row['TotalAnswer'];
        $subject['NotAttempted'] = $row['NotAttempted'];
        $subject['TotalAttempted'] = $row['TotalAttempted'];
        $subject['Question'] = $result_questions;

        $TotalNotAttemptedAnswer = $TotalNotAttemptedAnswer + $row['NotAttempted'];
        $TotalAttemptedAnswer = $TotalAttemptedAnswer + $row['TotalAttempted'];

        array_push( $response_result, $subject );
    }

        //Get questions details for pagination.
    $marks_query = "SELECT question_papers_id, obtain_marks, total_questions, wrong_answer, correct_answer FROM previous_exam_result WHERE previous_exam_result_id = '$previous_exam_result_id'";
    $marks_statement = $connect->query($marks_query);
    $marks_result = $marks_statement ->fetch(PDO::FETCH_ASSOC);

    $score = $marks_result["obtain_marks"];
    $TotalAnswerCount = $marks_result["total_questions"];
    $TotalWrongAnswer = $marks_result["wrong_answer"];
    $TotalCorrectAnswer = $marks_result["correct_answer"];

    $ExamId = $marks_result["question_papers_id"];

    //Get questions details for pagination.
    $rank_query = "SELECT COUNT(previous_exam_result_id) AS Rank FROM previous_exam_result WHERE obtain_marks >= '$score' AND question_papers_id = '$ExamId'";
    $rank_statement = $connect->query($rank_query);
    $rank_result = $rank_statement ->fetch(PDO::FETCH_ASSOC);
    $rank = $rank_result["Rank"];

        //Get questions details for pagination.
    $total_rank_query = "SELECT COUNT(previous_exam_result_id) AS TotalRank FROM previous_exam_result WHERE question_papers_id = '$ExamId'";
    $total_rank_statement = $connect->query($total_rank_query);
    $total_rank_result = $total_rank_statement ->fetch(PDO::FETCH_ASSOC);
    $total_rank = $total_rank_result["TotalRank"];

    //Get questions details for pagination.
    $total_marks_query = "SELECT correct_answer_mark FROM gatavarshichya_prashna_patrika_year_title_practice WHERE question_papers_id  = '$ExamId'";
    $total_marks_statement = $connect->query($total_marks_query);
    $total_marks_result = $total_marks_statement ->fetch(PDO::FETCH_ASSOC);
    $correct_answer_mark = $total_marks_result["correct_answer_mark"];
    $total_marks = ($correct_answer_mark * $TotalAnswerCount);

//Get quiz details for Reattempt.
    $reattempt_query = "SELECT * FROM gatavarshichya_prashna_patrika_year_title_practice WHERE `question_papers_id` = '$ExamId'";
    $reattempt_statement = $connect->query( $reattempt_query );
    $reattempt_result    = $reattempt_statement->fetchAll( PDO::FETCH_ASSOC );

    if ( $result ) {
        $response[0]['status'] = 'Success';
        $response[0]['message']  = 'Found Data.';
        $response[0]['score']  = $score;
        $response[0]['total_score']  = $total_marks;
        $response[0]['rank']  = $rank;
        $response[0]['total_rank']  = $total_rank;
        $response[0]['total_answer_count']  = $TotalAnswerCount;
        $response[0]['total_wrong_answer']  = $TotalWrongAnswer;
        $response[0]['total_correct_answer']  = $TotalCorrectAnswer;
        $response[0]['total_not_attempted_answer']  = $TotalNotAttemptedAnswer;
        $response[0]['total_attempted_answer']  = $TotalAttemptedAnswer;
        $response[0]['results'] = $response_result;
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