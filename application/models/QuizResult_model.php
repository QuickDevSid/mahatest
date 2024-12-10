
<?php

class QuizResult_model extends CI_Model
{
  public function __construct()
    {
        $this->load->database();
    }
    var $table = "quiz_result";
    var $select_column = array("id", "quiz_id", "user_id", "correct_answer", "wrong_answer", "attempted_questions", "not_attempted_question", "attempted_percentage", "total_questions", "time_taken", "obtain_marks", "percentage", "status", "created_at");

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);

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

    public function get_last_id(){
        $query = $this->db->select('id')
            ->order_by('id', 'DESC')
            ->get($this->table);
        if($query->num_rows() > 0){
            return $query->row()->id;
        }
        return 0;
    }


    public function getResultById($resultId){
        //All Columns
        // `id`, `quiz_id`, `login_id`, `correct_answer`, `wrong_answer`, `attempted_questions`,
        // `not_attempted_question`, `attempted_percentage`, `total_questions`, `time_taken`,
        // `obtain_marks`, `percentage`, `status`, `result_status`, `created_at`
        $this->db->select('quiz_result.id as ResultId, quiz_result.quiz_id as QuizId, quiz_result.correct_answer as CorrectAnswers,
        quiz_result.wrong_answer as WrongAnswers, quiz_result.attempted_questions as AttemptedQuestions, quiz_result.not_attempted_question as NotAttemptedQuestions, 
        quiz_result.attempted_percentage as AttemptedQuestionPercentage, quiz_result.total_questions as TotalQuestions, 
        quiz_result.time_taken as TimeTaken, quiz_result.obtain_marks as ObtainMarks, quiz_result.percentage as Percentage, 
        quiz_result.status as QuizAttemptStatus, quiz_result.result_status as Result, created_at as SubmittedAt');

        $this->db->from('quiz_result');
        $this->db->where('quiz_result.id',$resultId);
        $this->db->where('quiz_result.status','Completed');

        $query = $this->db->get();
//echo $this->db->last_query();die;
        if ($query->num_rows()) {
            return $query->row_array();
        } else {
            return 0;
        }
    }

}
