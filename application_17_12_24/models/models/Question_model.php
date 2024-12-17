
<?php

class Question_model extends CI_Model
{
  public function __construct()
    {
        $this->load->database();
    }
    var $table = "quiz_questions";
    var $select_column = array("id", "subject_id", "question_type", "quiz_id", 'question', "question_image","option1" , "option2","option3","option4","answer","explanation","status", "created_at", "updated_at");

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);

        if (isset($_POST["search"]["value"])) {
            $this->db->like("question", $_POST["search"]["value"]);
        }
        $this->db->order_by('id', 'DESC');
    }

    function make_datatables($condition=null)
    {
        $this->make_query();
        if(isset($condition) && !empty($condition)){
            $this->db->where($condition);
        }
        $query = $this->db->get();
        if (empty($query)){
            return  0;
        }
        return $query->result();
    }

    function get_filtered_data()
    {
        $this->make_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_all_data()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function getAllData(){
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        $query = $this->db->get();
        if (empty($query)){
            return 0;
        }
        if ($query->num_rows()) {
            return $query->result();
        } else {
            return 0;
        }
    }

    public function getPostById($id)
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return 0;
        }
    }
    public function editbyId($id)
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    function save( $data)
    {
        //return $data;
        if ($this->db->insert($this->table, $data)) {
            return "Inserted";
        } else {
            return "Failed";
        }
    }


    function update($id,$data)
    {

        $this->db->where('id', $id);
        if ($this->db->update($this->table, $data)) {
            return "Updated";
        } else {
            return "Failed";
        }
    }
    public function delete($id)
    {
        $this->db->where('id', $id);
        if ($this->db->delete($this->table)) {
            return true;
        } else {
            return false;
        }
    }


    public function getQuestionsByQuizId($quizId){
        $this->db->select('quiz_questions.id as QuestionId, quiz_questions.subject_id as SubjectId, quiz_subject.subject_name as SubjectTitle, quiz_questions.quiz_id as QuizId , 
        quiz_questions.question_type as QuestionType, quiz_questions.question as Question, CONCAT("'.base_url().'","assets/uploads/question_images/",quiz_questions.question_image) as QuestionImage, 
        quiz_questions.option1 as Option1, quiz_questions.option2 as Option2, quiz_questions.option3 as Option3, quiz_questions.option4 as Option4, 
        quiz_questions.answer as Answer, quiz_questions.explanation as Explanation, quiz_questions.status as Status, quiz_questions.created_at as CreatedOn, quiz_questions.updated_at as UpdatedAt');

        $this->db->from('quiz_questions');
        $this->db->join('quiz_subject','quiz_subject.subject_id = quiz_questions.subject_id','left');
        $this->db->where('quiz_questions.quiz_id',$quizId);
        $this->db->where('quiz_questions.status','Active');
        $this->db->order_by("quiz_questions.id", "ASC");

        $query = $this->db->get();
//echo $this->db->last_query();die;
        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getQuestionsGroupedByQuizId($quizId){

        $this->db->select('quiz_subject.subject_id AS SubjectID, quiz_subject.subject_name AS SubjectName, quiz_questions.id AS QuestionId, quiz_questions.question AS Question');
        $this->db->from('quiz_subject');
        $this->db->join('quiz_questions', 'quiz_questions.subject_id = quiz_subject.subject_id');
        $this->db->where('quiz_questions.quiz_id',$quizId);
        $this->db->where('quiz_questions.status','Active');
        $this->db->order_by('quiz_subject.subject_id', 'ASC');
        $query = $this->db->get();

        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getQuestionsResultByQuizResultId($quizId, $resultId){
        $this->db->select('quiz_questions.id as QuestionId, quiz_questions.subject_id as SubjectId, quiz_subject.subject_name as SubjectTitle, quiz_questions.quiz_id as QuizId , 
        quiz_questions.question_type as QuestionType, quiz_questions.question as Question, CONCAT("'.base_url().'","assets/uploads/question_images/", quiz_questions.question_image) as QuestionImage, 
        quiz_questions.option1 as Option1, quiz_questions.option2 as Option2, quiz_questions.option3 as Option3, quiz_questions.option4 as Option4, 
        quiz_questions.answer as Answer, quiz_questions.explanation as Explanation, quiz_questions.status as Status, 
        quiz_questions.created_at as CreatedOn, quiz_questions.updated_at as UpdatedAt, 
        quiz_result_detail.id as ResultQuestionId, quiz_result_detail.user_answered as UserAnswered, quiz_result_detail.users_answer as UsersAnswer, 
        quiz_result_detail.is_correct as IsCorrect');

        $this->db->from('quiz_questions');
       // $this->db->from('quiz_result_detail');
        $this->db->join('quiz_subject','quiz_subject.subject_id = quiz_questions.subject_id','left');
        $this->db->join('quiz_result_detail','quiz_result_detail.question_id = quiz_questions.id','left');
        $this->db->where('quiz_questions.quiz_id',$quizId);
        $this->db->where('quiz_result_detail.quiz_result_id',$resultId);
        $this->db->where('quiz_questions.status','Active');
        $this->db->order_by("quiz_questions.id", "ASC");

        $query = $this->db->get();
//echo $this->db->last_query();die;
        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

}
