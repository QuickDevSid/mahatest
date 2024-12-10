
<?php

class Quiz_model extends CI_Model
{
  public function __construct()
    {
        $this->load->database();
    }
    var $table = "quizs";
    var $select_column = array("id", "section",'title',"section_id" , "image_url","pdf_url","can_download","no_of_question","marks_per_question","total_mark","time", "attempt_count",'status','description', 'subject_id', 'sub_subject_id', 'quiz_date', 'passing_marks','created_at');

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);

        if (isset($_POST["search"]["value"])) {
            $this->db->like("title", $_POST["search"]["value"]);
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


    //List of years by Subject and section
    public function getAllDataBySubjectSectionGroupByYear($subject, $section, $limit=false){
        $this->db->select('Year(quizs.quiz_date) as year,COUNT(quizs.quiz_date) as total');
        $this->db->from('quizs');
        $this->db->where('quizs.subject_id',$subject);
        $this->db->where('quizs.section',$section);
        $this->db->where('quizs.status','Active');
        $this->db->group_by('year');
        $this->db->order_by("YEAR(quiz_date)", "desc");
        if($limit){
            $this->db->limit($limit);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    //List of quizzes by Subject, section, Year, Chapter
    public function getAllQuizzesByChapterYearSubjectSection($subject, $section, $yearChapter, $yearChapterValue, $limit=false){
       //All Columns
        // $this->db->select('id as QuizId, section as Section, section_id as SectionId, title as QuizTitle , CONCAT("'.base_url().'","assets/uploads/quiz_images/",image_url) as ImagePath, CONCAT("'.base_url().'","assets/uploads/quiz_pdf/",pdf_url) as pdfPath, can_download as CanDownload, no_of_question as NoOfQuestion,marks_per_question as MarksPerQuestion, total_mark as TotalMark, time as QuizTime, attempt_count as AttemptCount, status as Status, description as Description, subject_id as SubjectId, sub_subject_id as ChapterId, quiz_date as QuizDate');
        $this->db->select('quizs.id as QuizId, quizs.section as Section, quizs.title as QuizTitle , CONCAT("'.base_url().'","assets/uploads/quiz_images/",quizs.image_url) as ImagePath, CONCAT("'.base_url().'","assets/uploads/quiz_pdf/",quizs.pdf_url) as pdfPath, quizs.can_download as CanDownload, quizs.no_of_question as NoOfQuestion, quizs.marks_per_question as MarksPerQuestion, quizs.total_mark as TotalMark, quizs.passing_marks as PassingMarks, quizs.time as QuizTime, quizs.attempt_count as AttemptCount, quizs.status as Status, quizs.description as Description, quizs.quiz_date as QuizDate, quiz_result.id as QuizResultId, quiz_result.status as QuizResultStatus');

        $this->db->from('quizs');
        $this->db->join('quiz_result','quizs.id = quiz_result.quiz_id','left');
       // $this->db->where('quiz_result.quiz_id = quizs.id');
        $this->db->where('quizs.subject_id',$subject);
        $this->db->where('quizs.section',$section);
        if ($yearChapter == "Year"){
            $this->db->where('YEAR(quizs.quiz_date)',$yearChapterValue);
        }else{
            $this->db->where('quizs.sub_subject_id',$yearChapterValue);
        }
        $this->db->where('quizs.status','Active');
        $this->db->group_by('quizs.id');
        $this->db->order_by("quizs.id", "desc");
        if($limit){
            $this->db->limit($limit);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getQuizById($quizId){
        //All Columns
        // $this->db->select('id as QuizId, section as Section, section_id as SectionId, title as QuizTitle , CONCAT("'.base_url().'","assets/uploads/quiz_images/",image_url) as ImagePath, CONCAT("'.base_url().'","assets/uploads/quiz_pdf/",pdf_url) as pdfPath, can_download as CanDownload, no_of_question as NoOfQuestion,marks_per_question as MarksPerQuestion, total_mark as TotalMark, time as QuizTime, attempt_count as AttemptCount, status as Status, description as Description, subject_id as SubjectId, sub_subject_id as ChapterId, quiz_date as QuizDate');
        $this->db->select('quizs.id as QuizId, quizs.section as Section, quizs.title as QuizTitle , 
        quizs.no_of_question as NoOfQuestion, quizs.marks_per_question as MarksPerQuestion, quizs.total_mark as TotalMark, quizs.passing_marks as PassingMarks,
        quizs.time as QuizTime, quizs.attempt_count as AttemptCount, quizs.status as Status, quizs.description as Description, 
        quizs.quiz_date as QuizDate');

        $this->db->from('quizs');
        $this->db->where('quizs.id',$quizId);
        $this->db->where('quizs.status','Active');

        $query = $this->db->get();
//echo $this->db->last_query();die;
        if ($query->num_rows()) {
            return $query->row_array();
        } else {
            return 0;
        }
    }

    public function updateAttempts($id){
        $this->db->set('attempt_count', 'attempt_count + 1', FALSE);
        $this->db->where('id', $id);

        if($this->db->update('quizs')){
            return true;
        }else{
            return false;
        }
    }
}
