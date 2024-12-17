<?php
class Api_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }
    public function set_user_doubts_api(){
        $request = json_decode(file_get_contents('php://input'), true);

        if ($request) {
            if (!empty($request['login_id']) && !empty($request['doubt_question'])) {
                $user_id = $request['login_id'];
                $doubt_question = $request['doubt_question'];

                $data = array(
                    'user_id' => $user_id,
                    'doubt_question' => $doubt_question,
                    'status' => 'active'
                );

                $this->db->insert('doubts', $data);

                $json_arr['status'] = 'true';
                $json_arr['message'] = 'Doubt submitted successfully.';
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'User ID and doubt question are required.';
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Invalid request.';
        }

        echo json_encode($json_arr);
    }


   

   
    public function get_user_doubts_api() {
        $request = json_decode(file_get_contents('php://input'), true);
        
        if ($request) {
            if (isset($request['login_id'])) {
                $user_id = $request['login_id'];

                $this->db->select('user_id, doubt_question');
                $this->db->where('user_id', $user_id);
                $this->db->where('status !=', 'deleted'); 
                $exist = $this->db->get('doubts')->result();

                if (!empty($exist)) {
                    $json_arr['status'] = 'true';
                    $json_arr['message'] = 'success';
                    $json_arr['data'] = $exist;
                } else {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'No doubts found for this user.';
                    $json_arr['data'] = [];
                }

                echo json_encode($json_arr);
            } else {
                echo json_encode(['status' => 'false', 'message' => 'User ID is required.']);
            }
        } else {
            echo json_encode(['status' => 'false', 'message' => 'Invalid request.']);
        }
    }


        

public function generate_login_otp_api() {
    $request = json_decode(file_get_contents('php://input'), true);
    if ($request) {
        if (!empty($request['mobile_number'])) {
            $mobile_number = $request['mobile_number'];
            // $this->db->where('is_deleted', '0');
            $this->db->where('mobile_number', $mobile_number);
            $exist = $this->db->get('user_login')->num_rows();

            if ($exist > 0) {
                $otp = rand(1000, 9999); 
                $otpString = (string)$otp;
                $message = $otpString . " is your OTP to login to the application. DO NOT share it with anyone.";
                $response = $this->send_whatsapp_message($message, $mobile_number);

                if ($response) {
                    $json_arr['status'] = 'true';
                    $json_arr['message'] = 'OTP sent successfully.';
                    $json_arr['data'] = [['otp' => $otpString]];
                } else {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'Failed to send OTP. Please try again.';
                    $json_arr['data'] = [];
                }
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Your mobile number is not registered. Please create an account first.';
                $json_arr['data'] = [];
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Mobile number not found. Please try again.';
            $json_arr['data'] = [];
        }
    } else {
        $json_arr['status'] = 'false';
        $json_arr['message'] = 'Request not found. Please try again.';
        $json_arr['data'] = [];
    }

    echo json_encode($json_arr);
}
public function send_whatsapp_message($message,$number){			
    // $username = WP_USERNAME;

    // $token = '';
    // $mobile_nos = $number;
    
    // $token = WP_API_KEY;		
    // $mobile_nos = '919766869071';
    
    // $data = 'username='.$username.'&number='.$mobile_nos.'&message='.$message.'&token='.$token.'';

    // $url = 'https://int.chatway.in/api/send-msg?'.$data;
    
    // $url = preg_replace("/ /", "%20", $url);
    // $api_response = file_get_contents($url);
    
    // $response = json_decode($api_response);

    // if (is_array($response) && isset($response[0])) {
    //     $sending_status	= $response[0]->status;

    // }else{
    //     return false;
    // }

    // return $sending_status;
    return true;
}

public function validate_otp_api() {
    $request = json_decode(file_get_contents('php://input'), true);
    if ($request) {
        if (!empty($request['mobile_number'])) {
            $mobile_number = $request['mobile_number'];
            $push_token = $request['push_token']; 

                $this->db->where('mobile_number', $mobile_number);
               
                $user = $this->db->get('user_login')->row();
                if (!empty($user)) {
                    $update_data = [
                        'push_token'    => $user->push_token                        
                    ];                   
                    $this->db->where('login_id',$login_id);
                    $this->db->update('user_login',$update_data);

                    $data = [
                        'login_id'       => $user->login_id,
                        'full_name'     => $user->full_name,
                        'mobile_number' => $user->mobile_number,
                        'email'         => $user->email,
                        'gender'        => $user->gender                      
                    ];
                    $json_arr['status'] = 'true';
                    $json_arr['message'] = 'Login successful.';
                    $json_arr['data'] = [$data];
                } else {
                    $data = array(
                        'mobile_number' => $request['mobile_number'],
                        'push_token' => $request['push_token'],
                        'created_at'    => date('Y-m-d H:i:s')
                    );
                    $this->db->insert('user_login',$data);
                    $login_id = $this->db->insert_id();

                    $this->db->where('login_id', $login_id);
                $users = $this->db->get('user_login')->row();
                if (!empty($users)) {
                $data = [
                    'login_id'       => $users->login_id,
                    'full_name'     => $users->full_name,
                    'mobile_number' => $users->mobile_number,
                    'email'         => $users->email,
                    'gender'        => $users->gender                      
                     ];
                     
                 }
                
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'User not found. Please register first.';
                    $json_arr['data'] = [
                        'login_id'       => $user->login_id,
                        'full_name'     => '',
                        'mobile_number' => '',
                        'email'         => '',
                        'gender'        => ''
                    ];
                }
            //  } else {
            //     $json_arr['status'] = 'false';
            //     $json_arr['message'] = 'Invalid OTP. Please try again.';
            //     $json_arr['data'] = [];
            // }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Mobile number  not found. Please try again.';
            $json_arr['data'] = [];
        }
    } else {
        $json_arr['status'] = 'false';
        $json_arr['message'] = 'Request not found. Please try again.';
        $json_arr['data'] = [];
    }

    echo json_encode($json_arr);
}




public function get_user_profile_api() {
    $request = json_decode(file_get_contents('php://input'), true);
    // echo "pri";
    // print_r($request);
    // exit;
    
    if ($request) {
        if ($request['login_id'])
         {
            $login_id = $request['login_id'];

            //  echo "pri"; print_r($request['login_id']); exit;

            $this->db->select('login_id, full_name, email, mobile_number, gender, profile_image, selected_exams, selected_exams_id, login_type, place, Address, status, state_id, district_id, plan_id, last_user_login,');
            //$this->db->where('is_deleted', '0');
            $this->db->where('login_id', $login_id);
           
            $exist = $this->db->get('user_login')->result();

            // if (!empty($exist)) {
            //     foreach ($exist as &$row) {
            //         if ($row->gender == '0') {
            //             $row->gender = 'Male';
            //         } elseif ($row->gender == '1') {
            //             $row->gender = 'Female';
            //         } elseif ($row->gender == '2') {
            //             $row->gender = 'Other';
            //         } else {
            //             $row->gender = '';
            //         }
            //         if ($row->last_user_login) {
            //             $row->last_user_login = date('d-m-Y H:i:s', strtotime($row->last_user_login));
            //         } else {
            //             $row->last_user_login = '';
            //         }
            //         if ($row->profile_image != "" && $row->profile_image != null) {
            //             $row->profile_image = base_url('assets/images/' . $row->profile_image);
            //         } else {
            //             $row->profile_image = "";
            //         }
            //     }

                $json_arr['status'] = 'true';
                $json_arr['message'] = 'success';
                $json_arr['data'] = $exist;
                $json_arr['image_path'] = base_url().'assets/images/profile_image/';
            // } else {
            //     $json_arr['status'] = 'false';
            //     $json_arr['message'] = 'Profile details not available.';
            //     $json_arr['data'] = [];
            // }

            echo json_encode($json_arr);
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Login ID not provided.';
            $json_arr['data'] = [];
             $json_arr['image_path'] = base_url().'assets/images/profile_image/';
            echo json_encode([$json_arr]);
        }
    } else {
        $json_arr['status'] = 'false';
        $json_arr['message'] = 'Invalid request.';
        $json_arr['data'] = [];
        echo json_encode($json_arr);
    }
}


public function set_logged_in_user(){
    $request = json_decode(file_get_contents('php://input'), true);
    if($request){
        if(isset($request['username']) && isset($request['project']) && isset($request['device_id']) && isset($request['device_details']) && isset($request['user_id']) && isset($request['permission_details'])){
            $username = $request['username'];
            $password = isset($request['password']) ? $request['password'] : '';
            $mobile_no = isset($request['mobile_no']) ? $request['mobile_no'] : '';
            $email = isset($request['email']) ? $request['email'] : '';
            $name = isset($request['name']) ? $request['name'] : '';
            $project = strtolower(trim($request['project']));
            $user_id = $request['user_id'];
            $device_id = $request['device_id'];
            $device_details = $request['device_details'] != "" ? json_encode($request['device_details']) : '';
            $permission_details = $request['permission_details'] != "" ? json_encode($request['permission_details']) : '';

            $this->db->where('project_user_table_id', $user_id);
            $this->db->where('project', $project);
            $this->db->where('username', $username);
            $this->db->where('device_id', $device_id);
            $this->db->where('is_deleted', '0');
            $result = $this->db->get('tbl_app_users');
            $exist = $result->row();
            if(!empty($exist)){
                $this->db->where('id', $exist->id);
                $this->db->update('tbl_app_users', array(
                                                            'password'          => $password,
                                                            'mobile_no'         => $mobile_no,
                                                            'email'             => $email,
                                                            'name'              => $name,
                                                            'is_active_login'   => '1', 
                                                            'last_login_on'     => date('Y-m-d H:i:s'), 
                                                            'device_details'    => $device_details,
                                                            'permission_details'=> $permission_details,
                                                            'created_at'        => date('Y-m-d H:i:s')
                                                        ));
                $app_panel_user_id = $exist->id;
            }else{
                $this->db->insert('tbl_app_users', array(
                                                            'project'               => $project,
                                                            'device_id'             => $device_id,
                                                            'username'              => $username,
                                                            'password'              => $password,
                                                            'mobile_no'             => $mobile_no,
                                                            'project_user_table_id' => $user_id,
                                                            'email'                 => $email,
                                                            'name'                  => $name,
                                                            'device_details'        => $device_details,
                                                            'permission_details'    => $permission_details,
                                                            'is_active_login'       => '1',
                                                            'last_login_on'         => date('Y-m-d H:i:s')
                                                        ));
                $app_panel_user_id = $this->db->insert_id();
            }
            echo json_encode(array('status' => 'success', 'message' => 'Device details set successfully', 'app_panel_user_id' => $app_panel_user_id));
        }else{
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Username, Device Details, Project, Permission Details, User ID required.';
            echo json_encode($json_arr);
        } 
    }else{
        $json_arr['status'] = 'false';
        $json_arr['message'] = 'Request not found. Please try again.';
        echo json_encode($json_arr);
    }
}    
public function set_user_logout(){
    $request = json_decode(file_get_contents('php://input'), true);
    if($request){
        if(isset($request['device_id']) && isset($request['project']) && isset($request['user_id']) && isset($request['app_panel_user_id'])){
            $project = strtolower(trim($request['project']));
            $user_id = $request['user_id'];
            $device_id = $request['device_id'];
            $app_panel_user_id = $request['app_panel_user_id'];

            $this->db->where('project_user_table_id', $user_id);
            $this->db->where('project', $project);
            $this->db->where('id', $app_panel_user_id);
            $this->db->where('device_id', $device_id);
            $this->db->where('is_deleted', '0');
            $this->db->where('is_active_login', '1');
            $result = $this->db->get('tbl_app_users');
            $exist = $result->row();
            if(!empty($exist)){
                $this->db->where('id', $exist->id);
                $this->db->update('tbl_app_users', array(
                                                            'is_active_login'   => '0', 
                                                            'last_logout_on'    => date('Y-m-d H:i:s')
                                                        ));
                echo json_encode(array('status' => 'success', 'message' => 'Successfully Log Out from device'));
            }else{
                echo json_encode(array('status' => 'error', 'message' => 'Log In device not found'));
            }
        }else{
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'Project, User ID, App Panel User ID, Device ID required.';
            $json_arr['data'] = [];
            echo json_encode($json_arr);
        } 
    }else{
        $json_arr['status'] = 'false';
        $json_arr['message'] = 'Request not found. Please try again.';
        $json_arr['data'] = [];
        echo json_encode($json_arr);
    }
} 
public function get_all_category_current_afair_api(){
    $request = json_decode(file_get_contents('php://input'), true);
    $this->db->where('status','Active');
    $result = $this->db->get('category');
    $result = $result->result();
    $json_arr['status'] = 'true';
    $json_arr['message'] = 'success';
    $json_arr['data'] = $result;
    echo json_encode($json_arr); 
}

public function get_all_news_categories() {
        $request = json_decode(file_get_contents('php://input'), true);
        $this->db->where('status', 'Active');
        $query = $this->db->get('tbl_news_category');
        $result = $query->result();
        $json_arr = [
            'status' => 'true',
            'message' => 'success',
            'data' => $result
        ];
        echo json_encode($json_arr);
    }
public function get_current_afair_api() {
        $request = json_decode(file_get_contents('php://input'), true);
        if (!isset($request['category'])) {
            echo json_encode([
                'status' => 'false',
                'message' => 'Category is required.',
                'data' => []
            ]);
            return;
        }
        if (!isset($request['login_id'])) {
            echo json_encode([
                'status' => 'false',
                'message' => 'Login ID is required.',
                'data' => []
            ]);
            return;
        }
        $offset = $request['offset'];   
        $limit = $request['limit']; 
        $this->db->select('current_affairs.*, category.title');
        if($request['category'] != ""){
            $this->db->where('current_affairs.category', $request['category']); 
        }
        $this->db->where('current_affairs.status', 'Active');
        $this->db->join('category', 'category.id = current_affairs.category'); 
        $this->db->order_by('current_affairs.sequence_no', 'ASC');
        $this->db->limit($limit,$offset);
        $result = $this->db->get('current_affairs');
        $result = $result->result();
        if (!empty($result)) {
            foreach ($result as $item) {
                //$item->current_affair_image_path = base_url('AppAPI/current-affairs/' . $item->current_affair_image);
                $item->issave = $this->isBookmarked($item->current_affair_id, $request['login_id']);
            }
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'success';
            $json_arr['image_path'] =  base_url().'AppAPI/current-affairs/';
            $json_arr['data'] = $result;
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'No Data Found.';
            $json_arr['image_path'] =  base_url().'AppAPI/current-affairs/';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr);
    }
    public function isBookmarked($current_affair_id, $login_id) {
        $this->db->where('current_affair_id', $current_affair_id);
        $this->db->where('login_id', $login_id);
        $query = $this->db->get('current_affairs_saved');
        $query = $query->row();
      
        $isAvailable = '0';
        if(!empty($query)) {
            $isAvailable = '1';
        } else {
            $isAvailable = '0';
        }
        return $isAvailable;
    }

    public function get_saved_current_affair(){
        $request = json_decode(file_get_contents('php://input'), true); 
 $offset = $request['offset'];   
        $limit = $request['limit']; 
    $this->db->select('current_affairs.*, category.title, 1 AS issave');
    $this->db->from('current_affairs_saved');

    if($request['category'] != ""){
        $this->db->where('current_affairs.category', $request['category']); 
    }
    // if (isset($request['category'])) {
    //  $this->db->where('current_affairs.category', $request['category']);
    // }
    $this->db->where('current_affairs_saved.login_id', $request['login_id']);
    $this->db->join('current_affairs', 'current_affairs.current_affair_id  = current_affairs_saved.current_affair_id');
    $this->db->join('category', 'category.id = current_affairs.category','left'); 
    $this->db->where('current_affairs.status', 'Active');
    $this->db->order_by('current_affairs.sequence_no', 'ASC');
    $this->db->limit($limit, $offset);

    $result = $this->db->get(); 
    $result = $result->result();    
        if (!empty($result)) { 
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'success';
            $json_arr['image_path'] =  base_url().'AppAPI/current-affairs/';
            $json_arr['data'] = $result;
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'No Data Found.';
            $json_arr['image_path'] =  base_url().'AppAPI/current-affairs/';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr);
    }
  
    
public function get_news_api() {
        $request = json_decode(file_get_contents('php://input'), true);
        if (!isset($request['category'])) 
       {
            echo json_encode([
                'status' => 'false',
                'message' => 'Category is required.',
                'data' => []
            ]);
            return;
        }
        if (!isset($request['login_id'])) {
            echo json_encode([
                'status' => 'false',
                'message' => 'Login ID is required.',
                'data' => []
            ]);
            return;
        }
        $offset = $request['offset'];   
        $limit = $request['limit']; 
            $this->db->select('tbl_news.*,tbl_news_category.title');
            if($request['category'] != ""){
                $this->db->where('tbl_news.category', $request['category']); 
            }
             $this->db->where('tbl_news.status', 'Active');
             $this->db->join('tbl_news_category', 'tbl_news_category.id = tbl_news.category');
             $this->db->order_by('tbl_news.sequence_no', 'ASC');
             $this->db->limit($limit,$offset);
        $result = $this->db->get('tbl_news');
        $result = $result->result();
        if (!empty($result))
         {
            foreach ($result as $item) {
                // $item->news_image_path = base_url('AppAPI/current-affairs/'. $item->news_image);
                $item->issave = $this->isBookmarked_news($item->id, $request['login_id']);
            }
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'success';
            $json_arr['image_path'] =  base_url().'AppAPI/current-affairs/';
            $json_arr['data'] = $result;
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'No Data Found.';
            $json_arr['image_path'] =  base_url().'AppAPI/current-affairs/';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr);
    }
    public function isBookmarked_news($news_id, $login_id) {
        $this->db->where('news_id', $news_id);
        $this->db->where('login_id', $login_id);
        $query = $this->db->get('tbl_news_saved'); 
        $query = $query->row();
       
        $isAvailable = '0';
        if(!empty($query)) {
            $isAvailable = '1';
        } else {
            $isAvailable = '0';
        }
        return $isAvailable;
    }

    public function get_saved_news(){
        $request = json_decode(file_get_contents('php://input'), true); 
        $offset = $request['offset'];   
        $limit = $request['limit']; 
        $this->db->select('tbl_news.*,tbl_news_category.title, 1 AS issave');
        $this->db->from('tbl_news_saved');
        if($request['category'] != ""){
            $this->db->where('tbl_news.category', $request['category']); 
        }
    //     if (isset($request['category'])){
    //      $this->db->where('tbl_news.category', $request['category']);
    //    }
    $this->db->where('tbl_news_saved.login_id', $request['login_id']);
    $this->db->where('tbl_news.status', 'Active');
    $this->db->join('tbl_news', 'tbl_news.id  = tbl_news_saved.news_id');
    $this->db->join('tbl_news_category', 'tbl_news_category.id = tbl_news.category','left'); 
    $this->db->order_by('tbl_news.sequence_no', 'ASC');
    $this->db->limit($limit, $offset);
    $result = $this->db->get();
    $result = $result->result();  
   // echo $this->db->last_query();
    // echo "<pre>";
    // print_r($result);
    // exit;
        if (!empty($result)) { 
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'success';
            $json_arr['image_path'] =  base_url().'AppAPI/current-affairs/';
            $json_arr['data'] = $result;
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'No Data Found.';
            $json_arr['image_path'] =  base_url().'AppAPI/current-affairs/';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr);
    }

 public function get_districts_list_api() {
    $request = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($request['state_id']) || empty($request['state_id'])) {
        echo json_encode([
            'status' => 'false',
            'message' => 'State ID is required.',
            'data' => []
        ]);
        return;
    }
    $this->db->where('state_id', $request['state_id']);
    $this->db->where('status', 'Active');
    $result = $this->db->get('district_list');
    $result = $result->result();
    if (!empty($result)) {
        $json_arr['status'] = 'true';
        $json_arr['message'] = 'Success';
        $json_arr['data'] = $result;
    } else {
        $json_arr['status'] = 'false';
        $json_arr['message'] = 'No Data Found.';
        $json_arr['data'] = [];
    }
    echo json_encode($json_arr);
 }
    public function get_states_list_api() {
        $this->db->select('state_id, state_name, status, created_at');
        $exist = $this->db->get('state_list')->result();
        if (!empty($exist)) {
            foreach ($exist as &$row) {
            }
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'success';
            $json_arr['data'] = $exist;
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'State details not available.';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr);
    }

 public function get_banner_image_api() {
    $this->db->select('banner_id, banner_image');
    $exist = $this->db->get('banner')->result();

    if (!empty($exist)) {
        foreach ($exist as &$row) {
            if ($row->banner_image != "" && $row->banner_image != null) {
                $row->banner_image = base_url('AppAPI/banner-images/' . $row->banner_image);
            } else {
                $row->banner_image = "";
            }
        }
        $json_arr['status'] = 'true';
        $json_arr['message'] = 'success';
        $json_arr['data'] = $exist;
    } else {
        $json_arr['status'] = 'false';
        $json_arr['message'] = 'Banner details not available.';
        $json_arr['data'] = [];
    }
    echo json_encode($json_arr);
 }
 
   
 public function get_yashogatha_data_api() {
    $this->db->select('yashogatha_id, category, yashogatha_image, yashogatha_title, yashogatha_description, status, created_at');
    $data = $this->db->get('yashogatha')->result();

    if (!empty($data)) {
        foreach ($data as &$row) {
            if ($row->yashogatha_image != "" && $row->yashogatha_image != null) {
                $row->yashogatha_image = base_url('AppAPI/yashogatha/' . $row->yashogatha_image);
            } else {
                $row->yashogatha_image = "";
            }
        }
        $response = [
            'status' => 'true',
            'message' => 'success',
            'data' => $data
        ];
    } else {
        $response = [
            'status' => 'false',
            'message' => 'Yashogatha details not available.',
            'data' => []
        ];
    }
    echo json_encode($response);
}



public function cerate_account_api(){
    $request = json_decode(file_get_contents('php://input'), true);
    if ($request) {
             $this->db->where('mobile_number', $request['mobile_number']);
            $exist = $this->db->get('user_login')->result();
            if (empty($exist)) {
                $data = array(
                    'full_name'     => $request['full_name'],
                    'gender'     => $request['gender'],
                    'mobile_number' => $request['mobile_number'],
                    'email'         => $request['email'],
                    'district_id'   => $request['district_id'],
                    'state_id'   => $request['state_id'], 
                    'Address'   => $request['Address'],                     
                );
                $this->db->insert('user_login',$data);
                $login_id = $this->db->insert_id();
                $json_arr['status'] = 'true';
                $json_arr['message'] = 'Success';
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Mobile number already registered, please try another mobile number .';
                
            }
            echo json_encode($json_arr);
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Requst Not Found.';
            echo json_encode($json_arr);
        }
}


public function update_profile_api() {
    $request = json_decode(file_get_contents('php://input'), true);
    
    if ($request){
        if (isset($request['login_id'])) {
            $profile_image = '';	
            if(isset($request['profile_image']) && $request['profile_image'] != ''){
    			$date = new DateTime();
    			$startDate = date("YmdHis");
    			$newName = str_replace('/','',$startDate);
    			$profile_image = $newName.'.jpg';
    			$target_path = './assets/images/profile_image/'.$profile_image;
    			
    			$imagedata = $request['profile_image'];
    			$imagedata = str_replace('data:image/jpeg;base64,','',$imagedata);
    			$imagedata = str_replace('data:image/jpg;base64,','',$imagedata);
    			$imagedata = str_replace(' ','+',$imagedata);
    			$imagedata = base64_decode($imagedata);
    			file_put_contents($target_path, $imagedata);
    			
    		}
            $login_id = $request['login_id'];
            $data = array(
                'full_name'             => $request['full_name'],
                'state_id'              => $request['state_id'],
                'district_id'           => $request['district_id'],
                'Address'               => $request['Address'],
                'mobile_number'         => $request['mobile_number'],
                'email'                 => $request['email'],
                'profile_image'         => $profile_image,
            );
            if (!empty($data)) {
                $this->db->where('login_id', $login_id);
                $this->db->update('user_login', $data);
                if ($this->db->affected_rows() > 0) {
                    $json_arr['status'] = 'true';
                    $json_arr['message'] = 'Profile updated successfully.';
                } else {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'No changes were made to the profile.';
                }
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'No data provided for update.';
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Login ID not provided.';
        }
    } else {
        $json_arr['status'] = 'false';
        $json_arr['message'] = 'Invalid request.';
    }
    echo json_encode($json_arr);
}


public function set_user_current_affairs_bookmark_api() {
    $request = json_decode(file_get_contents('php://input'), true);
    if ($request) {
        if (!empty($request['login_id']) && !empty($request['current_affair_id'])) {
            $login_id = $request['login_id'];
            $current_affair_id = $request['current_affair_id'];
            
            $this->db->where('current_affair_id', $current_affair_id); 
            $this->db->where('login_id', $login_id);
            $result = $this->db->get('current_affairs_saved');
            $result = $result->row(); 
            
            if(!empty($result)) {
                $this->db->where('current_affairs_saved_id', $result->current_affairs_saved_id);
                $this->db->delete('current_affairs_saved');

                $json_arr['status'] = 'true';
                $json_arr['message'] = 'Current affair removed successfully.';
            }else{
                $data = array(
                    'login_id' => $login_id,
                    'current_affair_id' => $current_affair_id,
                    'status' => 'Active'  
                );
                $this->db->insert('current_affairs_saved', $data);
                $json_arr['status'] = 'true';
                $json_arr['message'] = 'Current affair saved successfully.';
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'User ID and current affair ID are required.';
        }
    } else {
        $json_arr['status'] = 'false';
        $json_arr['message'] = 'Invalid request.';
    }
    echo json_encode($json_arr);
}
public function set_user_news_bookmark_api() {
    $request = json_decode(file_get_contents('php://input'), true);
    if ($request) {
        if (!empty($request['login_id']) && !empty($request['news_id'])) {
            $login_id = $request['login_id'];
            $news_id = $request['news_id'];
            
            $this->db->where('news_id', $news_id); 
            $this->db->where('login_id', $login_id);
            $result = $this->db->get('tbl_news_saved');
            $result = $result->row(); 
            
            if(!empty($result)) {
                $this->db->where('news_saved_id ', $result->news_saved_id );
                $this->db->delete('tbl_news_saved');

                $json_arr['status'] = 'true';
                $json_arr['message'] = 'News removed successfully.';
            }else{
                $data = array(
                    'login_id' => $login_id,
                    'news_id' => $news_id,
                    'status' => 'Active'  
                );
                $this->db->insert('tbl_news_saved', $data);
                $json_arr['status'] = 'true';
                $json_arr['message'] = 'News saved successfully.';
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Login ID and  News ID are required.';
        }
    } else {
        $json_arr['status'] = 'false';
        $json_arr['message'] = 'Invalid request.';
    }
    echo json_encode($json_arr);
}

// public function get_manage_courses_api() {
//     $this->db->select('id, title, description, sub_headings, banner_image, mrp, sale_price, discount, status, usage_count, created_at, updated_at');
//     $exist = $this->db->get('courses')->result();

//     if (!empty($exist)) {
//         foreach ($exist as &$row) {
//             // if (!empty($row->banner_image)) {
//             //     $row->banner_image = base_url('assets/uploads/courses/images/' . $row->banner_image);
//             // } else {
//             //     $row->banner_image = "";
//             // }
//         }

//         $json_arr['status'] = 'true';
//         $json_arr['message'] = 'Courses retrieved successfully.';
//         $json_arr['image_path'] =  base_url().'assets/uploads/courses/images/';
//         $json_arr['data'] = $exist;
//     } else {
//         $json_arr['status'] = 'false';
//         $json_arr['message'] = 'No courses available.';
//         $json_arr['image_path'] =  base_url().'assets/uploads/courses/images/';
//         $json_arr['data'] = [];
//     }

//     echo json_encode($json_arr);
// }

public function get_manage_courses_api() {
    $request = json_decode(file_get_contents('php://input'), true); 
    $offset = $request['offset'];   
    $limit = $request['limit']; 

    $this->db->select('id, title, description, sub_headings, banner_image, mrp, sale_price, discount, status, usage_count, created_at, updated_at');
    $this->db->from('courses');
    $this->db->limit($limit, $offset);

    $exist = $this->db->get()->result();

    if (!empty($exist)) {
        foreach ($exist as &$row) {
        }

        $json_arr['status'] = 'true';
        $json_arr['message'] = 'Courses retrieved successfully.';
        $json_arr['image_path'] = base_url().'assets/uploads/courses/images/';
        $json_arr['data'] = $exist;
    } else {
        $json_arr['status'] = 'false';
        $json_arr['message'] = 'No courses available.';
        $json_arr['image_path'] = base_url().'assets/uploads/courses/images/';
        $json_arr['data'] = [];
    }

    echo json_encode($json_arr);
}


}

