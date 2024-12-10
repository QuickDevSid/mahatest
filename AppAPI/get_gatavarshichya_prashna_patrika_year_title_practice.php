<?php
include 'connect.inc.php';
$response = array();
@header( 'Content_Type: application/json' );

if ( isset( $_POST['question_paper_year'] ) ) {

    $question_paper_year = $_POST['question_paper_year'];
    $login_id = $_POST['login_id'];

    $query ="SELECT * FROM gatavarshichya_prashna_patrika_year_title_practice WHERE question_paper_year = '$question_paper_year'";

    $statement = $connect->query( $query );
    $result    = $statement->fetchAll( PDO::FETCH_ASSOC );

$quiz = array();

   foreach ($result as $row) {
    $quiz['question_papers_id'] = $row['question_papers_id'];
    $quiz['question_paper_year'] = $row['question_paper_year'];
    $quiz['paper_title'] = $row['paper_title'];
    $quiz['total_questions'] = $row['total_questions'];
    $quiz['duration'] = $row['duration'];
    $quiz['instructions'] = $row['instructions'];
    $quiz['pdf_url'] = $row['pdf_url'];
    $quiz['correct_answer_mark'] = $row['correct_answer_mark'];
    $quiz['wrong_answer_mark'] = $row['wrong_answer_mark'];
    $quiz['status'] = $row['status'];
    $quiz['created_on'] = $row['created_on'];
    $quiz['updated_on'] = $row['updated_on'];

        $quiz_id = $row['question_papers_id'];
        $query_question = "SELECT * FROM previous_exam_result WHERE question_papers_id = '$quiz_id' AND login_id = '$login_id' ORDER BY previous_exam_result_id DESC LIMIT 1";
        $statement_question = $connect->query($query_question);
        $result_questions    = $statement_question->fetch(PDO::FETCH_ASSOC);
        
    $quiz['correct_answer'] = $result_questions['correct_answer'];
    $quiz['wrong_answer'] = $result_questions['wrong_answer'];
    $quiz['quiz_result_id'] = $result_questions['previous_exam_result_id'];
    $quiz['attempted_date'] = $result_questions['created_on'];

array_push($response, $quiz);
    }


    if ( $result ) {
        echo json_encode( $response );
    } else {
        $response [0]['status'] = 'Failed';
        $response [0]['message']  = 'No content found!';
        echo json_encode( $response );
    }
} else {
    $response[0]['status']  = 'Failed';
    $response[0]['message'] = 'Invalid parameters received';
    echo json_encode( $response );
}
?>
