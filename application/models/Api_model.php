<?php
class Api_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }
    public function set_user_doubts_api()
    {
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





    public function get_user_doubts_api()
    {
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

    public function generate_login_otp_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        if ($request) {
            if (!empty($request['mobile_number'])) {
                $mobile_number = $request['mobile_number'];
                // $this->db->where('is_deleted', '0');
                $this->db->where('status', 'Active');
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

    public function send_whatsapp_message($message, $number)
    {
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

    public function validate_otp_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        if ($request) {
            if (!empty($request['mobile_number']) && !empty($request['push_token'])) {
                $mobile_number = $request['mobile_number'];
                $fcm_token = $request['push_token'];
                $device_id = isset($request['device_id']) ? $request['device_id'] : '';

                $this->db->where('mobile_number', $mobile_number);
                $this->db->where('status', 'Active');

                $user = $this->db->get('user_login')->row();
                if (!empty($user)) {
                    $update_data = [
                        'fcm_token'     => $fcm_token,
                        'push_token'    => $fcm_token,
                        'device_id'     => $device_id,
                        'last_logged_in'        => date('Y-m-d H:i:s'),
                        'is_logged_in'          => '1',
                    ];
                    $this->db->where('login_id', $user->login_id);
                    $this->db->update('user_login', $update_data);

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
                        'fcm_token'     => $fcm_token,
                        'push_token'    => $fcm_token,
                        'device_id'     => $device_id,
                        'last_logged_in'        => date('Y-m-d H:i:s'),
                        'is_logged_in'          => '1',
                        'status'          => 'Active',
                        'created_at'    => date('Y-m-d H:i:s')
                    );
                    $this->db->insert('user_login', $data);
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
                        'login_id'       => '',
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
                $json_arr['message'] = 'Mobile number, Push Token required. Please try again.';
                $json_arr['data'] = [];
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Request not found. Please try again.';
            $json_arr['data'] = [];
        }

        echo json_encode($json_arr);
    }




    public function get_user_profile_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        // echo "pri";
        // print_r($request);
        // exit;

        if ($request) {
            if ($request['login_id']) {
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
                $json_arr['image_path'] = base_url() . 'assets/images/profile_image/';
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
                $json_arr['image_path'] = base_url() . 'assets/images/profile_image/';
                echo json_encode([$json_arr]);
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Invalid request.';
            $json_arr['data'] = [];
            echo json_encode($json_arr);
        }
    }


    public function set_logged_in_user()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        if ($request) {
            if (isset($request['username']) && isset($request['project']) && isset($request['device_id']) && isset($request['device_details']) && isset($request['user_id']) && isset($request['permission_details'])) {
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
                if (!empty($exist)) {
                    $this->db->where('id', $exist->id);
                    $this->db->update('tbl_app_users', array(
                        'password'          => $password,
                        'mobile_no'         => $mobile_no,
                        'email'             => $email,
                        'name'              => $name,
                        'is_active_login'   => '1',
                        'last_login_on'     => date('Y-m-d H:i:s'),
                        'device_details'    => $device_details,
                        'permission_details' => $permission_details,
                        'created_on'        => date('Y-m-d H:i:s')
                    ));
                    $app_panel_user_id = $exist->id;
                } else {
                    $this->db->insert('tbl_app_users', array(
                        'project'               => 'mahatest',
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
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Username, Device Details, Project, Permission Details, User ID required.';
                echo json_encode($json_arr);
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Request not found. Please try again.';
            echo json_encode($json_arr);
        }
    }
    public function set_user_logout()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        if ($request) {
            if (isset($request['device_id']) && isset($request['project']) && isset($request['user_id']) && isset($request['app_panel_user_id'])) {
                $project = strtolower(trim($request['project']));
                $user_id = $request['user_id'];
                $device_id = $request['device_id'];
                $app_panel_user_id = $request['app_panel_user_id'];

                $this->db->where('project_user_table_id', $user_id);
                $this->db->where('project', 'mahatest');
                $this->db->where('id', $app_panel_user_id);
                $this->db->where('device_id', $device_id);
                $this->db->where('is_deleted', '0');
                $this->db->where('is_active_login', '1');
                $result = $this->db->get('tbl_app_users');
                $exist = $result->row();
                if (!empty($exist)) {
                    $this->db->where('id', $exist->id);
                    $this->db->update('tbl_app_users', array(
                        'is_active_login'   => '0',
                        'last_logout_on'    => date('Y-m-d H:i:s')
                    ));
                    echo json_encode(array('status' => 'success', 'message' => 'Successfully Log Out from device'));
                } else {
                    echo json_encode(array('status' => 'error', 'message' => 'Log In device not found'));
                }
            } else {
                $json_arr['status'] = 'true';
                $json_arr['message'] = 'Project, User ID, App Panel User ID, Device ID required.';
                $json_arr['data'] = [];
                echo json_encode($json_arr);
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Request not found. Please try again.';
            $json_arr['data'] = [];
            echo json_encode($json_arr);
        }
    }
    public function get_all_category_current_afair_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $this->db->select('id,section,icon_img,status, category_name as title, created_on as created_at');
        $this->db->where('is_deleted', '0');
        $result = $this->db->get('current_affairs_category');
        $result = $result->result();
        $json_arr['status'] = 'true';
        $json_arr['message'] = 'success';
        $json_arr['data'] = $result;
        echo json_encode($json_arr);
    }

    public function get_all_news_categories()
    {
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
    public function get_current_afair_api()
    {
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
        $this->db->select('current_affairs.*, current_affairs_category.category_name as title');
        if ($request['category'] != "") {
            $this->db->where('current_affairs.category', $request['category']);
        }
        $this->db->where('current_affairs.status', 'Active');
        $this->db->join('current_affairs_category', 'current_affairs_category.id = current_affairs.category');
        $this->db->order_by('current_affairs.sequence_no', 'ASC');
        $this->db->limit($limit, $offset);
        $result = $this->db->get('current_affairs');
        $result = $result->result();
        if (!empty($result)) {
            foreach ($result as $item) {
                //$item->current_affair_image_path = base_url('AppAPI/current-affairs/' . $item->current_affair_image);
                $item->issave = $this->isBookmarked($item->current_affair_id, $request['login_id']);
            }
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'success';
            $json_arr['image_path'] = base_url() . 'assets/uploads/current_affairs/images/';
            $json_arr['data'] = $result;
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'No Data Found.';
            $json_arr['image_path'] = base_url() . 'assets/uploads/current_affairs/images/';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr);
    }
    public function isBookmarked($current_affair_id, $login_id)
    {
        $this->db->where('current_affair_id', $current_affair_id);
        $this->db->where('login_id', $login_id);
        $query = $this->db->get('current_affairs_saved');
        $query = $query->row();

        $isAvailable = '0';
        if (!empty($query)) {
            $isAvailable = '1';
        } else {
            $isAvailable = '0';
        }
        return $isAvailable;
    }

    public function get_saved_current_affair()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $offset = $request['offset'];
        $limit = $request['limit'];
        $this->db->select('current_affairs.*, current_affairs_category.category_name as title, 1 AS issave');
        $this->db->from('current_affairs_saved');

        if ($request['category'] != "") {
            $this->db->where('current_affairs.category', $request['category']);
        }

        $this->db->where('current_affairs_saved.login_id', $request['login_id']);
        $this->db->join('current_affairs', 'current_affairs.current_affair_id  = current_affairs_saved.current_affair_id');
        $this->db->join('current_affairs_category', 'current_affairs_category.id = current_affairs.category', 'left');
        $this->db->where('current_affairs.status', 'Active');
        $this->db->order_by('current_affairs.sequence_no', 'ASC');
        $this->db->limit($limit, $offset);

        $result = $this->db->get();
        $result = $result->result();

        if (!empty($result)) {
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'success';
            $json_arr['image_path'] = base_url() . 'assets/uploads/current_affairs/images/';
            $json_arr['data'] = $result;
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'No Data Found.';
            $json_arr['image_path'] = base_url() . 'assets/uploads/current_affairs/images/';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr);
    }


    public function get_news_api()
    {
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
        $this->db->select('tbl_news.*,tbl_news_category.title,tbl_news_category.id');
        if ($request['category'] != "") {
            $this->db->where('tbl_news.category', $request['category']);
        }
        $this->db->where('tbl_news.new_status', 'Active');
        $this->db->join('tbl_news_category', 'tbl_news_category.id = tbl_news.category');
        $this->db->order_by('tbl_news.sequence_no', 'ASC');
        $this->db->limit($limit, $offset);
        $result = $this->db->get('tbl_news');
        $result = $result->result();
        // echo $this->db->last_query();
        // exit;
        if (!empty($result)) {
            foreach ($result as $item) {
                // $item->news_image_path = base_url('AppAPI/current-affairs/'. $item->news_image);
                $item->issave = $this->isBookmarked_news($item->id, $request['login_id']);
            }
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'success';
            $json_arr['image_path'] = base_url() . 'assets/uploads/news/images/';
            $json_arr['data'] = $result;
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'No Data Found.';
            $json_arr['image_path'] = base_url() . 'assets/uploads/news/images/';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr);
    }
    public function isBookmarked_news($news_id, $login_id)
    {
        $this->db->where('news_id', $news_id);
        $this->db->where('login_id', $login_id);
        $query = $this->db->get('tbl_news_saved');
        $query = $query->row();

        $isAvailable = '0';
        if (!empty($query)) {
            $isAvailable = '1';
        } else {
            $isAvailable = '0';
        }
        return $isAvailable;
    }

    public function get_saved_news()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $offset = $request['offset'];
        $limit = $request['limit'];
        $this->db->select('tbl_news.*,tbl_news_category.title, 1 AS issave');
        $this->db->join('tbl_news', 'tbl_news.id  = tbl_news_saved.news_id');
        $this->db->join('tbl_news_category', 'tbl_news_category.id = tbl_news.category');
        if ($request['category'] != "") {
            $this->db->where('tbl_news.category', $request['category']);
        }
        $this->db->where('tbl_news_saved.login_id', $request['login_id']);
        $this->db->where('tbl_news.status', '1');
        $this->db->order_by('tbl_news.sequence_no', 'ASC');
        $this->db->limit($limit, $offset);
        $result = $this->db->get('tbl_news_saved');
        $result = $result->result();
        if (!empty($result)) {
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'success';
            $json_arr['image_path'] = base_url() . 'assets/uploads/news/images/';
            $json_arr['data'] = $result;
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'No Data Found.';
            $json_arr['image_path'] = base_url() . 'assets/uploads/news/images/';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr);
    }

    public function get_districts_list_api()
    {
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
    public function get_states_list_api()
    {
        $this->db->select('state_id, state_name, status, created_on');
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

    public function get_banner_image_api()
    {
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


    public function get_yashogatha_data_api()
    {
        $this->db->select('yashogatha_id, category, yashogatha_image, yashogatha_title, yashogatha_description, status, created_on');
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



    public function cerate_account_api()
    {
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
                $this->db->insert('user_login', $data);
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


    public function update_profile_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);

        if ($request) {
            if (isset($request['login_id'])) {
                $profile_image = '';
                if (isset($request['profile_image']) && $request['profile_image'] != '') {
                    $date = new DateTime();
                    $startDate = date("YmdHis");
                    $newName = str_replace('/', '', $startDate);
                    $profile_image = $newName . '.jpg';
                    $target_path = './assets/images/profile_image/' . $profile_image;

                    $imagedata = $request['profile_image'];
                    $imagedata = str_replace('data:image/jpeg;base64,', '', $imagedata);
                    $imagedata = str_replace('data:image/jpg;base64,', '', $imagedata);
                    $imagedata = str_replace(' ', '+', $imagedata);
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


    public function set_user_current_affairs_bookmark_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        if ($request) {
            if (!empty($request['login_id']) && !empty($request['current_affair_id'])) {
                $login_id = $request['login_id'];
                $current_affair_id = $request['current_affair_id'];

                $this->db->where('current_affair_id', $current_affair_id);
                $this->db->where('login_id', $login_id);
                $result = $this->db->get('current_affairs_saved');
                $result = $result->row();

                if (!empty($result)) {
                    $this->db->where('current_affairs_saved_id', $result->current_affairs_saved_id);
                    $this->db->delete('current_affairs_saved');

                    $json_arr['status'] = 'true';
                    $json_arr['message'] = 'Current affair removed successfully.';
                } else {
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
    public function set_user_news_bookmark_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        if ($request) {
            if (!empty($request['login_id']) && !empty($request['news_id'])) {
                $login_id = $request['login_id'];
                $news_id = $request['news_id'];

                $this->db->where('news_id', $news_id);
                $this->db->where('login_id', $login_id);
                $result = $this->db->get('tbl_news_saved');
                $result = $result->row();

                if (!empty($result)) {
                    $this->db->where('news_saved_id ', $result->news_saved_id);
                    $this->db->delete('tbl_news_saved');

                    $json_arr['status'] = 'true';
                    $json_arr['message'] = 'News removed successfully.';
                } else {
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


    public function get_manage_courses_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $offset = $request['offset'];
        $limit = $request['limit'];
        $user_id = isset($request['login_id']) ? $request['login_id'] : '';

        $this->db->select('*');
        $this->db->from('courses');
        $this->db->limit($limit, $offset);

        $exist = $this->db->get()->result();

        if (!empty($exist)) {
            foreach ($exist as &$row) {
                $is_course_bought = '0';
                $course_bought_id = '';
                $this->db->where('is_deleted', '0');
                $this->db->where('user_id', $user_id);
                $this->db->where('course_id', $row->id);
                $course_bought = $this->db->get('tbl_bought_courses')->row();
                if (!empty($course_bought)) {
                    $is_course_bought = '1';
                    $course_bought_id = $course_bought->id;
                }

                $row->is_course_bought = $is_course_bought;
                $row->course_bought_id = $course_bought_id;
            }
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'Courses retrieved successfully.';
            // $json_arr['image_path'] = base_url();
            $json_arr['image_path'] = base_url() . 'assets/uploads/courses/images/';
            $json_arr['data'] = $exist;
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'No courses available.';
            $json_arr['image_path'] = base_url() . 'assets/uploads/courses/images/';
            $json_arr['data'] = [];
        }

        echo json_encode($json_arr);
    }

    public function get_single_courses_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $course_id = $request['course_id'];

        $this->db->select('*');
        $this->db->from('courses');
        $this->db->where('id', $course_id);

        $exist = $this->db->get()->row();

        if (!empty($exist)) {
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'Course details retrieved successfully.';
            $json_arr['image_path'] = base_url() . 'assets/uploads/courses/images/';
            $json_arr['data'] = $exist;
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'No courses available.';
            $json_arr['image_path'] = base_url() . 'assets/uploads/courses/images/';
            $json_arr['data'] = [];
        }

        echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
    }

    public function get_courses_pdf_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $course_id = $request['course_id'];
        $offset = $request['offset'];
        $limit = $request['limit'];

        $this->db->select('id, title, description, can_download, image_url, pdf_url, created_at');
        $this->db->from('docs_videos');
        $this->db->where('source_id', $course_id);
        $this->db->where('source_type', 'courses');
        $this->db->where('type', 'Pdf');
        $this->db->limit($limit, $offset);

        $exist = $this->db->get()->result();

        if (!empty($exist)) {
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'Courses PDF retrieved successfully.';
            $json_arr['pdf_path'] = base_url() . 'assets/uploads/courses/pdfs/';
            $json_arr['image_path'] = base_url() . 'assets/uploads/courses/images/';

            $json_arr['data'] = $exist;
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Course Pdf not available.';
            $json_arr['pdf_path'] = base_url() . 'assets/uploads/courses/pdfs/';
            $json_arr['image_path'] = base_url() . 'assets/uploads/courses/images/';

            $json_arr['data'] = [];
        }

        echo json_encode($json_arr);
    }
    public function get_courses_videos_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $course_id = (string)$request['course_id'];
        $offset = $request['offset'];
        $limit = $request['limit'];

        $this->db->select('id, title, source_id as course_id, description, video_source, image_url, video_url, created_at');
        $this->db->from('docs_videos');
        $this->db->where('source_id', $course_id);
        $this->db->where('source_type', 'courses');
        $this->db->where('type', 'Video');
        $this->db->limit($limit, $offset);

        $exist = $this->db->get()->result();

        if (!empty($exist)) {
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'Course videos retrieved successfully.';
            $json_arr['video_path'] = base_url();
            $json_arr['image_path'] = base_url() . 'assets/uploads/courses/images/';

            $json_arr['data'] = $exist;
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Course videos not available.';
            $json_arr['video_path'] = base_url();
            $json_arr['image_path'] = base_url() . 'assets/uploads/courses/images/';
            $json_arr['data'] = [];
        }

        echo json_encode($json_arr);
    }
    public function get_courses_text_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $course_id = $request['course_id'];
        $offset = $request['offset'];
        $limit = $request['limit'];

        $this->db->select('id, title, description, image_url, created_at');
        $this->db->from('docs_videos');
        $this->db->where('source_id', $course_id);
        $this->db->where('source_type', 'courses');
        $this->db->where('type', 'Texts');
        $this->db->limit($limit, $offset);

        $exist = $this->db->get()->result();

        if (!empty($exist)) {
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'Courses texts retrieved successfully.';
            $json_arr['image_path'] = base_url() . 'assets/uploads/courses/images/';
            $json_arr['data'] = $exist;
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Course texts not available.';
            $json_arr['image_path'] = base_url() . 'assets/uploads/courses/images/';
            $json_arr['data'] = [];
        }

        echo json_encode($json_arr);
    }
    public function get_courses_test_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $course_id = $request['course_id'];
        $user_id = $request['login_id'];

        $this->db->from('courses');
        $this->db->where('id', $course_id);
        $exist = $this->db->get()->row();

        if (!empty($exist)) {
            if ($exist->tests != "") {
                $test = explode(',', $exist->tests);
                $tests = array();
                if (!empty($test)) {
                    for ($i = 0; $i < count($test); $i++) {
                        $this->db->where('id', $test[$i]);
                        $this->db->where('is_deleted', '0');
                        $single_test = $this->db->get('tbl_test_setups')->row();
                        if (!empty($single_test)) {
                            $this->db->where('test_id', $single_test->id);
                            $this->db->where('user_id', $user_id);
                            $this->db->where('is_deleted', '0');
                            $this->db->where('parent_module', 'course');
                            $attempted_test = $this->db->get('tbl_attempted_test')->row();
                            if (!empty($attempted_test)) {
                                $is_test_attempted = '1';
                                $attempted_test_id = $attempted_test->id;
                            } else {
                                $is_test_attempted = '0';
                                $attempted_test_id = '';
                            }

                            if ($single_test->show_ans == 'Yes') {
                                $show_correct_ans = '1';
                            } else {
                                $show_correct_ans = '0';
                            }

                            if ($single_test->download_test_pdf == 'Yes') {
                                $download_test_pdf = '1';
                                $test_pdf_link = $single_test->test_pdf != '' ? (base_url() . 'assets/uploads/test_pdfs/' . $single_test->test_pdf) : '';
                            } else {
                                $download_test_pdf = '0';
                                $test_pdf_link = '';
                            }

                            $tests[] = array(
                                'course_id'             =>  $exist->id,
                                'is_test_attempted'     =>  $is_test_attempted,
                                'attempted_test_id'     =>  $attempted_test_id,
                                'test_id'               =>  $single_test->id,
                                'topic'                 =>  $single_test->topic,
                                'short_note'            =>  $single_test->short_note,
                                'short_description'     =>  $single_test->short_description,
                                'duration'              =>  $single_test->duration,
                                'total_questions'       =>  $single_test->total_questions,
                                'total_marks'           =>  $single_test->total_marks,
                                'image'                 =>  $single_test->image,

                                'is_show_correct_ans'  => $show_correct_ans,
                                'is_download_test_pdf' => $download_test_pdf,
                                'test_pdf_link'        => $test_pdf_link,
                            );
                        }
                    }
                }

                if (!empty($tests)) {
                    $json_arr['status'] = 'true';
                    $json_arr['message'] = 'Courses tests retrieved successfully.';
                    $json_arr['data'] = $tests;
                    $json_arr['image_path'] = base_url() . 'assets/uploads/test_setup/images/';
                } else {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'Course tests not available.';
                    $json_arr['data'] = [];
                    $json_arr['image_path'] = base_url() . 'assets/uploads/test_setup/images/';
                }
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Course tests not available.';
                $json_arr['data'] = [];
                $json_arr['image_path'] = base_url() . 'assets/uploads/test_setup/images/';
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Course not available.';
            $json_arr['data'] = [];
            $json_arr['image_path'] = base_url() . 'assets/uploads/test_setup/images/';
        }

        echo json_encode($json_arr);
    }


    public function get_manage_docs_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $offset = isset($request['offset']) ? (int) $request['offset'] : 0;
        $limit = isset($request['limit']) ? (int) $request['limit'] : 10;
        $type = isset($request['type']) ? (string)$request['type'] : null;
        $login_id = isset($request['login_id']) ? (int) $request['login_id'] : null;
        $source_type = isset($request['source_type']) ? (string)$request['source_type'] : null;

        $this->db->select('id,type,title, status, video_source, image_url, video_url, description,source_type,can_download,pdf_url,views_count,source_id,num_of_questions,time');
        if ($type != '') {
            $this->db->where('type', (string)$type);
        }
        $this->db->where('source_type', 'doc_video');
        $this->db->where('is_deleted', '0');
        $this->db->where('status', '1');
        $this->db->limit($limit, $offset);
        $results = $this->db->get('docs_videos')->result();

        $is_membership = 0;
        $this->db->select('tbl_my_membership.id, tbl_my_membership.membership_id, tbl_my_membership.login_id, tbl_my_membership.start_date, tbl_my_membership.end_date, tbl_my_membership.amount, tbl_my_membership.payment_id, tbl_my_membership.status, tbl_my_membership.is_deleted, tbl_my_membership.created_at, tbl_my_membership.updated_at, membership_plans.title as membership_title');
        $this->db->join('membership_plans', 'membership_plans.id = tbl_my_membership.membership_id');
        $this->db->join('user_login', 'user_login.login_id = tbl_my_membership.login_id');
        $this->db->where('tbl_my_membership.is_deleted', '0');
        $this->db->where('user_login.is_active_membership', '1');
        $this->db->where('tbl_my_membership.login_id', $login_id);
        $this->db->order_by('tbl_my_membership.id', 'desc');
        $this->db->where('CURDATE() BETWEEN tbl_my_membership.start_date AND tbl_my_membership.end_date');
        $membership_details = $this->db->get('tbl_my_membership')->row();
        if (!empty($membership_details)) {
            $is_membership = 1;
        }

        if (!empty($results)) {
            $response = [
                'status' => 'true',
                'message' => 'Docs/Videos retrieved successfully.',
                'image_path' => base_url() . 'assets/uploads/doc_n_videos/images',
                'video_path' => base_url() . 'assets/uploads/doc_n_videos/videos',
                'is_membership' => $is_membership,
                'data' => $results
            ];
        } else {
            $response = [
                'status' => 'false',
                'message' => 'No docs/videos available.',
                'image_path' => base_url() . 'assets/uploads/doc_n_videos/images',
                'video_path' => base_url() . 'assets/uploads/doc_n_videos/videos',
                'is_membership' => $is_membership,
                'data' => []
            ];
        }
        echo json_encode($response);
    }

    public function get_all_abhyas_sahitya_category_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $this->db->where('status', '1');
        // $this->db->where('is_deleted', '0');
        $query = $this->db->get('abhyas_sahitya_category');
        $result = $query->result();
        $json_arr = [
            'status' => 'true',
            'message' => 'success',
            'data' => $result
        ];
        echo json_encode($json_arr);
    }

    public function get_all_other_option_category_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $this->db->where('status', 'Active');
        $this->db->where('id !=', '4');
        $query = $this->db->get('tbl_other_option_category');
        $result = $query->result();
        $json_arr = [
            'status' => 'true',
            'message' => 'success',
            'data' => $result
        ];
        echo json_encode($json_arr);
    }


    public function get_other_options_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $other_option_category_id = $request['other_option_category_id'];
        $offset = $request['offset'];
        $limit = $request['limit'];
        $this->db->select('id, other_option_category_id, title, short_description, description, image_url, pdf_url, status, created_on, can_download, other_option_type as type');
        $this->db->from('tbl_other_option');
        $this->db->where('other_option_category_id', $other_option_category_id);
        $this->db->where('other_option_category_id !=', '4');
        $this->db->limit($limit, $offset);

        $result = $this->db->get()->result();
        $json_arr = array();
        if (!empty($result)) {
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'Other options retrieved successfully.';
            $json_arr['image_path'] = base_url() . 'assets/uploads/other_options/images/';
            $json_arr['pdf_path'] = base_url() . 'assets/uploads/other_options/pdfs/';
            $json_arr['data'] = $result;
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'No other options available.';
            $json_arr['image_path'] = base_url() . 'assets/uploads/other_options/images/';
            $json_arr['pdf_path'] = base_url() . 'assets/uploads/other_options/pdfs/';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr);
    }

    public function get_syllabus_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $offset = $request['offset'];
        $limit = $request['limit'];
        $this->db->select('id, title, short_description, description, image_url, pdf_url, status, created_on, can_download, other_option_type as type');
        $this->db->from('tbl_other_option');
        $this->db->where('other_option_category_id', '4');
        $this->db->limit($limit, $offset);

        $result = $this->db->get()->result();
        $json_arr = array();
        if (!empty($result)) {
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'Syllabus retrieved successfully.';
            $json_arr['image_path'] = base_url() . 'assets/uploads/other_options/images/';
            $json_arr['pdf_path'] = base_url() . 'assets/uploads/other_options/pdfs/';
            $json_arr['data'] = $result;
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Syllabus not available.';
            $json_arr['image_path'] = base_url() . 'assets/uploads/other_options/images/';
            $json_arr['pdf_path'] = base_url() . 'assets/uploads/other_options/pdfs/';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr);
    }

    public function get_membership_plans_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $login_id = $this->input->post('login_id');

        // if (empty($login_id)) {
        //     $json_arr['status'] = 'false';
        //     $json_arr['message'] = 'login_id is required';
        //     $json_arr['data'] = [];
        //     echo json_encode($json_arr);
        //     return;
        // }
        $this->db->select('id, title, sub_heading, description, price, actual_price, discount_per, no_of_months, status, usage_count, created_at, updated_at');
        $plans = $this->db->get('membership_plans')->result();

        if (!empty($plans)) {
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'Success';
            $json_arr['data'] = $plans;
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'No membership plans available.';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr);
    }

    public function get_help_master_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);

        // Ensure type is treated as a string for comparison
        $type = isset($request['type']) ? strval($request['type']) : '';

        // Check if the type value is valid
        if ($type === '' || !in_array($type, ['0', '1'])) {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Invalid type value.';
            $json_arr['data'] = [];
            echo json_encode($json_arr);
            return;
        }

        $this->db->select('id, title, description');
        $this->db->from('tbl_help_master');
        $this->db->order_by('id', 'DESC');
        $this->db->where('is_deleted', '0');
        $this->db->where('type', $type); // Compare the string value

        $result = $this->db->get()->result();

        $json_arr = array();
        if (!empty($result)) {
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'Data retrieved successfully.';
            $json_arr['data'] = $result;
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Data not available.';
            $json_arr['data'] = [];
        }

        echo json_encode($json_arr);
    }

    public function get_my_membership()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $login_id = $request['login_id'];

        if (empty($login_id)) {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'login_id is required';
            $json_arr['data'] = [];
            echo json_encode($json_arr);
            return;
        }

        $is_membership = 0;
        $this->db->select('tbl_my_membership.id, tbl_my_membership.membership_id, tbl_my_membership.login_id, tbl_my_membership.start_date, tbl_my_membership.end_date, tbl_my_membership.amount, tbl_my_membership.payment_id, tbl_my_membership.status, tbl_my_membership.is_deleted, tbl_my_membership.created_at, tbl_my_membership.updated_at, membership_plans.title as membership_title');
        $this->db->join('membership_plans', 'membership_plans.id = tbl_my_membership.membership_id');
        $this->db->join('user_login', 'user_login.login_id = tbl_my_membership.login_id');
        $this->db->where('tbl_my_membership.is_deleted', '0');
        $this->db->where('tbl_my_membership.login_id', $login_id);
        $this->db->where('user_login.is_active_membership', '1');
        $this->db->order_by('tbl_my_membership.id', 'desc');
        $this->db->where('CURDATE() BETWEEN tbl_my_membership.start_date AND tbl_my_membership.end_date');
        $membership_details = $this->db->get('tbl_my_membership')->row();
        if (!empty($membership_details)) {
            $is_membership = 1;
        }

        if (!empty($membership_details)) {
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'Success';
            $json_arr['is_membership'] = $is_membership;
            $json_arr['data'] = $membership_details;
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Membership not available';
            $json_arr['is_membership'] = $is_membership;
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr);
    }
    ///New work

    public function get_ebooks_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        if ($request) {
            if ($request['login_id']) {
                $user_id = $request['login_id'];
                $this->db->where('login_id', $user_id);
                $single = $this->db->get('user_login')->row();
                if (!empty($single)) {
                    $this->db->where('tbl_ebook_category.is_deleted', '0');
                    $this->db->where('tbl_ebook_category.status', '1');
                    $this->db->order_by('tbl_ebook_category.id', 'DESC');
                    $result = $this->db->get('tbl_ebook_category');
                    $ebook_cat = $result->result();

                    if (!empty($ebook_cat)) {
                        $data = [];
                        foreach ($ebook_cat as $ebook_cat_result) {
                            $data[] = array(
                                'id'         =>  $ebook_cat_result->id,
                                'title'      =>  $ebook_cat_result->title,
                                'icon'       =>  $ebook_cat_result->icon != "" ? base_url('/assets/ebook_images/' . $ebook_cat_result->icon) : '',
                            );
                        }
                        $json_arr['status'] = 'true';
                        $json_arr['message'] = 'Success';
                        $json_arr['data'] = $data;
                    } else {
                        $json_arr['status'] = 'false';
                        $json_arr['message'] = 'Ebook Category not found';
                        $json_arr['data'] = [];
                    }
                } else {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'User not found';
                    $json_arr['data'] = [];
                }
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Login not available.';
                $json_arr['data'] = [];
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Request not found.';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
    }

    public function get_ebooks_sub_category_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        if ($request) {
            if (!empty($request['login_id'])) {
                $user_id = $request['login_id'];
                $this->db->where('login_id', $user_id);
                $single = $this->db->get('user_login')->row();
                if (!empty($single)) {
                    if (!empty($request['category_id'])) {
                        $category_id = $request['category_id'];
                        $this->db->where('tbl_ebook_sub_category.is_deleted', '0');
                        $this->db->where('tbl_ebook_sub_category.status', '1');
                        $this->db->where('tbl_ebook_sub_category.category_id', $category_id);
                        $this->db->order_by('tbl_ebook_sub_category.id', 'DESC');
                        $result = $this->db->get('tbl_ebook_sub_category');
                        $ebook_sub_cat = $result->result();

                        if (!empty($ebook_sub_cat)) {
                            $data = [];
                            foreach ($ebook_sub_cat as $ebook_sub_cat_result) {
                                $data[] = array(
                                    'id'         =>  $ebook_sub_cat_result->id,
                                    'category_id'         =>  $ebook_sub_cat_result->category_id,
                                    'title'      =>  $ebook_sub_cat_result->title,
                                    'icon'       =>  $ebook_sub_cat_result->icon != "" ? base_url('/assets/ebook_images/' . $ebook_sub_cat_result->icon) : '',
                                );
                            }
                            $json_arr['status'] = 'true';
                            $json_arr['message'] = 'Success';
                            $json_arr['data'] = $data;
                        } else {
                            $json_arr['status'] = 'false';
                            $json_arr['message'] = 'Ebook Sub Category not found';
                            $json_arr['data'] = [];
                        }
                    } else {
                        $json_arr['status'] = 'false';
                        $json_arr['message'] = 'Category not found';
                        $json_arr['data'] = [];
                    }
                } else {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'User not found';
                    $json_arr['data'] = [];
                }
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Login not available.';
                $json_arr['data'] = [];
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Request not found.';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
    }

    public function get_ebooks_list_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        if ($request) {
            if (!empty($request['login_id'])) {
                $user_id = $request['login_id'];
                $category_id = $request['category_id'];
                $sub_category_id = $request['sub_category_id'];
                $this->db->where('login_id', $user_id);
                $single = $this->db->get('user_login')->row();
                if (!empty($single)) {
                    if (!empty($category_id) && !empty($sub_category_id)) {

                        $this->db->select('tbl_ebooks.id AS ebook_id, tbl_ebooks.title, tbl_ebooks.image, tbl_ebook_category.id AS category_id, tbl_ebook_sub_category.id AS sub_category_id');
                        $this->db->from('tbl_ebooks');
                        $this->db->join('tbl_ebook_category', 'tbl_ebook_category.id = tbl_ebooks.category_id', 'left');
                        $this->db->join('tbl_ebook_sub_category', 'tbl_ebook_sub_category.id = tbl_ebooks.sub_category_id', 'left');
                        $this->db->where('tbl_ebooks.is_deleted', '0');
                        $this->db->where('tbl_ebooks.status', '1');
                        if (isset($category_id)) {
                            $this->db->where('tbl_ebooks.category_id', $category_id);
                        }
                        if (isset($sub_category_id)) {
                            $this->db->where('tbl_ebooks.sub_category_id', $sub_category_id);
                        }
                        $this->db->order_by('tbl_ebooks.id', 'DESC');
                        $result = $this->db->get();
                        $ebook_list = $result->result();

                        if (!empty($ebook_list)) {
                            $data = [];
                            foreach ($ebook_list as $ebook_list_result) {
                                $data[] = array(
                                    'id'         =>  $ebook_list_result->ebook_id,
                                    'category_id'         =>  $ebook_list_result->category_id,
                                    'sub_category_id'         =>  $ebook_list_result->sub_category_id,
                                    'title'      =>  $ebook_list_result->title,
                                    'image'       =>  $ebook_list_result->image != "" ? base_url('/assets/ebook_images/' . $ebook_list_result->image) : '',
                                );
                            }
                            $json_arr['status'] = 'true';
                            $json_arr['message'] = 'Success';
                            $json_arr['data'] = $data;
                        } else {
                            $json_arr['status'] = 'false';
                            $json_arr['message'] = 'Ebook not found';
                            $json_arr['data'] = [];
                        }
                    } else {
                        $json_arr['status'] = 'false';
                        $json_arr['message'] = 'Category and Sub-Category not found';
                        $json_arr['data'] = [];
                    }
                } else {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'User not found';
                    $json_arr['data'] = [];
                }
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Login not available.';
                $json_arr['data'] = [];
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Request not found.';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
    }

    public function get_ebooks_chapter_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        if ($request) {
            if (!empty($request['login_id'])) {
                $user_id = $request['login_id'];
                $ebook_id = $request['ebook_id'];
                $this->db->where('login_id', $user_id);
                $single = $this->db->get('user_login')->row();
                if (!empty($single)) {
                    if (!empty($ebook_id)) {
                        $this->db->select('tbl_ebook_chapters.*, tbl_ebooks.id AS ebook_id');
                        $this->db->from('tbl_ebook_chapters');
                        $this->db->join('tbl_ebooks', 'tbl_ebooks.id = tbl_ebook_chapters.ebook_id', 'left');
                        $this->db->where('tbl_ebook_chapters.is_deleted', '0');
                        $this->db->where('tbl_ebook_chapters.status', '1');
                        if (isset($ebook_id)) {
                            $this->db->where('tbl_ebook_chapters.ebook_id', $ebook_id);
                        }
                        $this->db->order_by('tbl_ebook_chapters.id', 'DESC');
                        $result = $this->db->get();
                        $ebook_chapter = $result->result();
                        if (!empty($ebook_chapter)) {
                            $data = [];
                            foreach ($ebook_chapter as $ebook_chapter_result) {
                                $data[] = array(
                                    'id'          => $ebook_chapter_result->id,         // ID from tbl_ebook_chapters
                                    'ebook_id'    => $ebook_chapter_result->ebook_id,   // Aliased ID from tbl_ebooks
                                    'title'       => $ebook_chapter_result->chapter_name,
                                    'image'       => $ebook_chapter_result->chapter_image != "" ? base_url('/assets/ebook_images/' . $ebook_chapter_result->chapter_image) : '',
                                    'description' => $ebook_chapter_result->chapter_description,
                                    'chapter_solution' => $ebook_chapter_result->chapter_solution,
                                );
                            }
                            $json_arr['status'] = 'true';
                            $json_arr['message'] = 'Success';
                            $json_arr['data'] = $data;
                        } else {
                            $json_arr['status'] = 'false';
                            $json_arr['message'] = 'Ebook Chapter not found';
                            $json_arr['data'] = [];
                        }
                    } else {
                        $json_arr['status'] = 'false';
                        $json_arr['message'] = 'Ebook not found';
                        $json_arr['data'] = [];
                    }
                } else {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'User not found';
                    $json_arr['data'] = [];
                }
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Login not available.';
                $json_arr['data'] = [];
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Request not found.';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
    }

    public function get_ebooks_solution_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        if ($request) {
            if (!empty($request['login_id'])) {
                $user_id = $request['login_id'];
                $ebook_id = $request['ebook_id'];
                $this->db->where('login_id', $user_id);
                $single = $this->db->get('user_login')->row();
                if (!empty($single)) {
                    if (!empty($ebook_id)) {
                        $this->db->select('tbl_ebook_chapters.*, tbl_ebooks.id AS ebook_id');
                        $this->db->from('tbl_ebook_chapters');
                        $this->db->join('tbl_ebooks', 'tbl_ebooks.id = tbl_ebook_chapters.ebook_id', 'left');
                        $this->db->where('tbl_ebook_chapters.is_deleted', '0');
                        $this->db->where('tbl_ebook_chapters.status', '1');
                        if (isset($ebook_id)) {
                            $this->db->where('tbl_ebook_chapters.ebook_id', $ebook_id);
                        }
                        $this->db->order_by('tbl_ebook_chapters.id', 'DESC');
                        $result = $this->db->get();
                        $ebook_chapter = $result->result();

                        if (!empty($ebook_chapter)) {
                            $data = [];
                            foreach ($ebook_chapter as $ebook_chapter_result) {
                                $data[] = array(
                                    'id'          => $ebook_chapter_result->id,         // ID from tbl_ebook_chapters
                                    'ebook_id'    => $ebook_chapter_result->ebook_id,   // Aliased ID from tbl_ebooks
                                    'title'       => $ebook_chapter_result->chapter_name,
                                    'image'       => $ebook_chapter_result->chapter_image != "" ? base_url('/assets/ebook_images/' . $ebook_chapter_result->chapter_image) : '',
                                    'description' => $ebook_chapter_result->chapter_description,
                                    'solution'    => $ebook_chapter_result->chapter_solution,
                                );
                            }
                            $json_arr['status'] = 'true';
                            $json_arr['message'] = 'Success';
                            $json_arr['data'] = $data;
                        } else {
                            $json_arr['status'] = 'false';
                            $json_arr['message'] = 'Ebook Chapter not found';
                            $json_arr['data'] = [];
                        }
                    } else {
                        $json_arr['status'] = 'false';
                        $json_arr['message'] = 'Ebook not found';
                        $json_arr['data'] = [];
                    }
                } else {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'User not found';
                    $json_arr['data'] = [];
                }
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Login not available.';
                $json_arr['data'] = [];
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Request not found.';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
    }


    public function get_ebooks_tests_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        if ($request) {
            if (!empty($request['login_id'])) {
                $user_id = $request['login_id'];
                $ebook_id = $request['ebook_id'];
                $chapter_id = isset($request['chapter_id']) ? $request['chapter_id'] : '';
                $offset = $request['offset'];
                $limit = $request['limit'];
                $this->db->where('login_id', $user_id);
                $single = $this->db->get('user_login')->row();
                if (!empty($single)) {
                    if (!empty($ebook_id)) {
                        $this->db->select('tbl_ebooks.*');
                        $this->db->from('tbl_ebooks');
                        // $this->db->join('tbl_ebooks', 'tbl_ebooks.id = tbl_ebook_chapters.ebook_id', 'left');
                        $this->db->where('tbl_ebooks.is_deleted', '0');
                        $this->db->where('tbl_ebooks.status', '1');
                        // if ($chapter_id != "") {
                        //     $this->db->where('tbl_ebook_chapters.id', $chapter_id);
                        // }
                        // if ($ebook_id != "") {
                        //     $this->db->where('tbl_ebook_chapters.ebook_id', $ebook_id);
                        // }
                        $this->db->order_by('tbl_ebooks.id', 'DESC');
                        $result = $this->db->get();
                        $ebook_chapter = $result->result();

                        if (!empty($ebook_chapter)) {
                            $data = [];
                            foreach ($ebook_chapter as $ebook_chapter_result) {
                                $all_tests = [];
                                $test = explode(',', $ebook_chapter_result->tests);
                                if (!empty($test)) {
                                    $tests = array_slice($test, $offset, $limit);
                                    for ($i = 0; $i < count($test); $i++) {
                                        $this->db->where('id', $test[$i]);
                                        $this->db->where('is_deleted', '0');
                                        $single_test = $this->db->get('tbl_test_setups')->row();
                                        if (!empty($single_test)) {
                                            $this->db->where('test_id', $single_test->id);
                                            $this->db->where('user_id', $user_id);
                                            $this->db->where('is_deleted', '0');
                                            $this->db->where('parent_module', 'ebooks');
                                            $attempted_test = $this->db->get('tbl_attempted_test')->row();
                                            if (!empty($attempted_test)) {
                                                $is_test_attempted = '1';
                                                $attempted_test_id = $attempted_test->id;
                                            } else {
                                                $is_test_attempted = '0';
                                                $attempted_test_id = '';
                                            }

                                            if ($single_test->show_ans == 'Yes') {
                                                $show_correct_ans = '1';
                                            } else {
                                                $show_correct_ans = '0';
                                            }

                                            if ($single_test->download_test_pdf == 'Yes') {
                                                $download_test_pdf = '1';
                                                $test_pdf_link = $single_test->test_pdf != '' ? (base_url() . 'assets/uploads/test_pdfs/' . $single_test->test_pdf) : '';
                                            } else {
                                                $download_test_pdf = '0';
                                                $test_pdf_link = '';
                                            }

                                            $all_tests[] = array(
                                                'is_test_attempted'     =>  $is_test_attempted,
                                                'attempted_test_id'     =>  $attempted_test_id,
                                                'test_id'               =>  $single_test->id,
                                                'topic'                 =>  $single_test->topic,
                                                'short_note'            =>  $single_test->short_note,
                                                'short_description'     =>  $single_test->short_description,
                                                'duration'              =>  $single_test->duration,
                                                'total_questions'       =>  $single_test->total_questions,
                                                'total_marks'           =>  $single_test->total_marks,

                                                'is_show_correct_ans'  => $show_correct_ans,
                                                'is_download_test_pdf' => $download_test_pdf,
                                                'test_pdf_link'        => $test_pdf_link,
                                            );
                                        }
                                    }
                                }
                                $data[] = array(
                                    'id'          => $ebook_chapter_result->id,         // ID from tbl_ebook_chapters
                                    'ebook_id'    => $ebook_chapter_result->id,   // Aliased ID from tbl_ebooks
                                    'title'       => $ebook_chapter_result->title,
                                    'image'       => $ebook_chapter_result->image != "" ? base_url('/assets/ebook_images/' . $ebook_chapter_result->image) : '',
                                    'tests'       => $all_tests,
                                );
                            }
                            $json_arr['status'] = 'true';
                            $json_arr['message'] = 'Success';
                            $json_arr['data'] = $data;
                        } else {
                            $json_arr['status'] = 'false';
                            $json_arr['message'] = 'Ebook Chapter not found';
                            $json_arr['data'] = [];
                        }
                    } else {
                        $json_arr['status'] = 'false';
                        $json_arr['message'] = 'Ebook not found';
                        $json_arr['data'] = [];
                    }
                } else {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'User not found';
                    $json_arr['data'] = [];
                }
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Login not available.';
                $json_arr['data'] = [];
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Request not found.';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
    }


    // public function get_ebooks_video_separate_api()
    // {
    //     $request = json_decode(file_get_contents('php://input'), true);
    //     if ($request) {
    //         if (!empty($request['login_id'])) {
    //             $user_id = $request['login_id'];
    //             $ebook_id = $request['ebook_id'];
    //             $this->db->where('login_id', $user_id);
    //             $single = $this->db->get('user_login')->row();
    //             if (!empty($single)) {
    //                 if (!empty($ebook_id)) {
    //                     $this->db->select('tbl_ebook_chapters.*, tbl_ebooks.title as ebook_title, tbl_ebooks.id AS ebook_id');
    //                     $this->db->from('tbl_ebook_chapters');
    //                     $this->db->join('tbl_ebooks', 'tbl_ebooks.id = tbl_ebook_chapters.ebook_id', 'left');
    //                     $this->db->where('tbl_ebook_chapters.is_deleted', '0');
    //                     $this->db->where('tbl_ebook_chapters.status', '1');
    //                     if (isset($ebook_id)) {
    //                         $this->db->where('tbl_ebook_chapters.ebook_id', $ebook_id);
    //                     }
    //                     $this->db->order_by('tbl_ebook_chapters.id', 'DESC');
    //                     $result = $this->db->get();
    //                     $ebook_chapter = $result->result();

    //                     if (!empty($ebook_chapter)) {
    //                         $data = [];
    //                         foreach ($ebook_chapter as $ebook_chapter_result) {
    //                             $this->db->select('tbl_ebook_videos.*, tbl_ebooks.title as ebook_title, tbl_ebooks.id AS ebook_id');
    //                             $this->db->from('tbl_ebook_videos');
    //                             $this->db->join('tbl_ebooks', 'tbl_ebooks.id = tbl_ebook_videos.ebook_id', 'left');
    //                             $this->db->where('tbl_ebook_videos.is_deleted', '0');
    //                             $this->db->where('tbl_ebook_videos.status', '1');
    //                             $this->db->where('tbl_ebook_videos.ebook_id', $ebook_chapter_result->ebook_id);
    //                             $this->db->where('tbl_ebook_videos.ebook_chapter_id', $ebook_chapter_result->id);
    //                             $this->db->order_by('tbl_ebook_videos.id', 'DESC');
    //                             $result = $this->db->get();
    //                             $ebook_solution = $result->result();
    //                             $all_videos = [];
    //                             if (!empty($ebook_solution)) {
    //                                 foreach ($ebook_solution as $ebook_solution_result) {
    //                                     if ($ebook_solution_result->file_name  != "") {
    //                                         $all_videos[] = array(
    //                                             'title'     =>  $ebook_solution_result->title != "" ? $ebook_solution_result->title : '',
    //                                             'file_path' =>  base_url('/assets/ebook_images/' . $ebook_solution_result->file_name)
    //                                         );
    //                                     }
    //                                 }
    //                                 $data[] = array(
    //                                     'id'          => $ebook_chapter_result->id,
    //                                     'ebook_id'    => $ebook_chapter_result->ebook_id,
    //                                     'title'       => $ebook_chapter_result->ebook_title,
    //                                     'image'       => $ebook_chapter_result->image != "" ? base_url('/assets/ebook_images/' . $ebook_chapter_result->image) : '',
    //                                     'videos'      => $all_videos
    //                                 );
    //                             }
    //                         }
    //                         $json_arr['status'] = 'true';
    //                         $json_arr['message'] = 'Success';
    //                         $json_arr['data'] = $data;
    //                     } else {
    //                         $json_arr['status'] = 'false';
    //                         $json_arr['message'] = 'Ebook Videos not found';
    //                         $json_arr['data'] = [];
    //                     }
    //                 } else {
    //                     $json_arr['status'] = 'false';
    //                     $json_arr['message'] = 'Ebook not found';
    //                     $json_arr['data'] = [];
    //                 }
    //             } else {
    //                 $json_arr['status'] = 'false';
    //                 $json_arr['message'] = 'User not found';
    //                 $json_arr['data'] = [];
    //             }
    //         } else {
    //             $json_arr['status'] = 'false';
    //             $json_arr['message'] = 'Login not available.';
    //             $json_arr['data'] = [];
    //         }
    //     } else {
    //         $json_arr['status'] = 'false';
    //         $json_arr['message'] = 'Request not found.';
    //         $json_arr['data'] = [];
    //     }
    //     echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
    // }

    public function get_ebooks_video_separate_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        if ($request) {
            if (!empty($request['login_id'])) {
                $user_id = $request['login_id'];
                $ebook_id = $request['ebook_id'];
                $this->db->where('login_id', $user_id);
                $single = $this->db->get('user_login')->row();
                if (!empty($single)) {
                    if (!empty($ebook_id)) {
                        $this->db->select('tbl_ebook_chapters.*, tbl_ebooks.title as ebook_title, tbl_ebooks.id AS ebook_id');
                        $this->db->from('tbl_ebook_chapters');
                        $this->db->join('tbl_ebooks', 'tbl_ebooks.id = tbl_ebook_chapters.ebook_id', 'left');
                        $this->db->where('tbl_ebook_chapters.is_deleted', '0');
                        $this->db->where('tbl_ebook_chapters.status', '1');
                        if (isset($ebook_id)) {
                            $this->db->where('tbl_ebook_chapters.ebook_id', $ebook_id);
                        }
                        $this->db->order_by('tbl_ebook_chapters.id', 'DESC');
                        $result = $this->db->get();
                        $ebook_chapter = $result->result();

                        if (!empty($ebook_chapter)) {
                            $data = [];
                            foreach ($ebook_chapter as $ebook_chapter_result) {
                                $this->db->select('tbl_ebook_videos.*, tbl_ebooks.title as ebook_title, tbl_ebooks.id AS ebook_id');
                                $this->db->from('tbl_ebook_videos');
                                $this->db->join('tbl_ebooks', 'tbl_ebooks.id = tbl_ebook_videos.ebook_id', 'left');
                                $this->db->where('tbl_ebook_videos.is_deleted', '0');
                                $this->db->where('tbl_ebook_videos.status', '1');
                                $this->db->where('tbl_ebook_videos.ebook_id', $ebook_chapter_result->ebook_id);
                                $this->db->order_by('tbl_ebook_videos.id', 'DESC');
                                $result = $this->db->get();
                                $ebook_solution = $result->result();
                                $all_videos = [];
                                if (!empty($ebook_solution)) {
                                    foreach ($ebook_solution as $ebook_solution_result) {
                                        if ($ebook_solution_result->file_name  != "") {
                                            $all_videos[] = array(
                                                'title'     =>  $ebook_solution_result->title != "" ? $ebook_solution_result->title : '',
                                                'file_path' =>  base_url('/assets/ebook_images/' . $ebook_solution_result->file_name)
                                            );
                                        }
                                    }
                                    $data[] = array(
                                        'id'          => $ebook_chapter_result->id,
                                        'ebook_id'    => $ebook_chapter_result->ebook_id,
                                        'title'       => $ebook_chapter_result->chapter_name,
                                        'image'       => $ebook_chapter_result->chapter_image != "" ? base_url('/assets/ebook_images/' . $ebook_chapter_result->chapter_image) : '',
                                        'videos'      => $all_videos
                                    );
                                }
                            }
                            $json_arr['status'] = 'true';
                            $json_arr['message'] = 'Success';
                            $json_arr['data'] = $data;
                        } else {
                            $json_arr['status'] = 'false';
                            $json_arr['message'] = 'Ebook Videos not found';
                            $json_arr['data'] = [];
                        }
                    } else {
                        $json_arr['status'] = 'false';
                        $json_arr['message'] = 'Ebook not found';
                        $json_arr['data'] = [];
                    }
                } else {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'User not found';
                    $json_arr['data'] = [];
                }
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Login not available.';
                $json_arr['data'] = [];
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Request not found.';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
    }
    public function get_test_details()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        if ($request) {
            if (!empty($request['login_id'])) {
                $user_id = $request['login_id'];
                $test_id = isset($request['test_id']) ? $request['test_id'] : '';
                $limit = isset($request['limit']) ? intval($request['limit']) : '';
                $offset = isset($request['offset']) ? intval($request['offset']) : '';
                $this->db->where('login_id', $user_id);
                $single = $this->db->get('user_login')->row();
                if (!empty($single)) {
                    if ($test_id != "") {
                        $this->db->select('tbl_test_setups.*');
                        $this->db->from('tbl_test_setups');
                        $this->db->where('tbl_test_setups.is_deleted', '0');
                        $this->db->where('tbl_test_setups.status', '1');
                        if ($test_id != "") {
                            $this->db->where('tbl_test_setups.id', $test_id);
                        }
                        $this->db->order_by('tbl_test_setups.id', 'DESC');
                        $result = $this->db->get();
                        $tests = $result->result();

                        if (!empty($tests)) {
                            $data = [];
                            foreach ($tests as $tests_result) {
                                $test_id = $tests_result->id;
                                if ($tests_result->questions_shuffle == 'Yes') {
                                    $questions_shuffle = '1';
                                } else {
                                    $questions_shuffle = '0';
                                }

                                $this->db->select('tbl_test_questions.*');
                                $this->db->from('tbl_test_questions');
                                $this->db->where('tbl_test_questions.is_deleted', '0');
                                $this->db->where('tbl_test_questions.status', '1');
                                if ($test_id != "") {
                                    $this->db->where('tbl_test_questions.test_id', $test_id);
                                }
                                if ($limit != "" && $offset != "") {
                                    $this->db->limit($limit, $offset);
                                }

                                if ($questions_shuffle == '1') {
                                    $this->db->order_by('RAND()');
                                } else {
                                    $this->db->order_by('tbl_test_questions.id', 'DESC');
                                }

                                $result = $this->db->get();
                                $test_questions = $result->result();
                                $all_questions = [];
                                foreach ($test_questions as $test_questions_result) {
                                    $all_questions[] = array(
                                        'question_id'       =>  $test_questions_result->id,
                                        'question_type'     =>  $test_questions_result->type,
                                        'group_id'          =>  $test_questions_result->group_id,
                                        'question'          =>  $test_questions_result->question,
                                        'question_image'    =>  $test_questions_result->question_image != "" ? (base_url() . 'assets/uploads/master_gallary/' . $test_questions_result->question_image) : '',
                                        'option_1'          =>  $test_questions_result->option_1,
                                        'option_1_image'    =>  $test_questions_result->option_1_image != "" ? (base_url() . 'assets/uploads/master_gallary/' . $test_questions_result->option_1_image) : '',
                                        'option_2'          =>  $test_questions_result->option_2,
                                        'option_2_image'    =>  $test_questions_result->option_2_image != "" ? (base_url() . 'assets/uploads/master_gallary/' . $test_questions_result->option_2_image) : '',
                                        'option_3'          =>  $test_questions_result->option_3,
                                        'option_3_image'    =>  $test_questions_result->option_3_image != "" ? (base_url() . 'assets/uploads/master_gallary/' . $test_questions_result->option_3_image) : '',
                                        'option_4'          =>  $test_questions_result->option_4,
                                        'option_4_image'    =>  $test_questions_result->option_4_image != "" ? (base_url() . 'assets/uploads/master_gallary/' . $test_questions_result->option_4_image) : '',
                                        'answer'            =>  $test_questions_result->answer,
                                        'answer_key'        =>  $test_questions_result->answer_column,
                                        'solution'          =>  $test_questions_result->solution,
                                        'positive_mark'     =>  $test_questions_result->positive_mark,
                                        'negative_mark'     =>  $test_questions_result->negative_mark,
                                    );
                                }

                                $this->db->select('tbl_test_groups.*');
                                $this->db->from('tbl_test_groups');
                                $this->db->where('tbl_test_groups.is_deleted', '0');
                                $this->db->where('tbl_test_groups.status', '1');
                                if ($test_id != "") {
                                    $this->db->where('tbl_test_groups.test_id', $test_id);
                                }
                                $this->db->order_by('tbl_test_groups.id', 'DESC');
                                $groups_result = $this->db->get();
                                $groups_result = $groups_result->result();
                                $all_groups = [];
                                foreach ($groups_result as $test_questions_result) {
                                    $all_groups[] = array(
                                        'group_id'          =>  $test_questions_result->id,
                                        'group_type'        =>  $test_questions_result->group_type,
                                        'group_title'       =>  $test_questions_result->group_title,
                                        'group_description' =>  $test_questions_result->group_description,
                                        'group_image'       =>  $test_questions_result->group_image != "" ? (base_url() . 'assets/uploads/master_gallary/' . $test_questions_result->group_image) : '',
                                    );
                                }

                                if ($tests_result->show_ans == 'Yes') {
                                    $show_correct_ans = '1';
                                } else {
                                    $show_correct_ans = '0';
                                }

                                if ($tests_result->download_test_pdf == 'Yes') {
                                    $download_test_pdf = '1';
                                    $test_pdf_link = $tests_result->test_pdf != '' ? (base_url() . 'assets/uploads/test_pdfs/' . $tests_result->test_pdf) : '';
                                } else {
                                    $download_test_pdf = '0';
                                    $test_pdf_link = '';
                                }

                                $data[] = array(
                                    'test_id'          => $tests_result->id,
                                    'title'            => $tests_result->topic,
                                    'short_note'       => $tests_result->short_note,
                                    'short_description' => $tests_result->short_description,
                                    'duration'          => $tests_result->duration,
                                    'description'       => $tests_result->description,
                                    'total_questions'   => $tests_result->total_questions,
                                    'total_marks'       => $tests_result->total_marks,
                                    'is_show_correct_ans'  => $show_correct_ans,
                                    'is_download_test_pdf' => $download_test_pdf,
                                    'test_pdf_link'        => $test_pdf_link,
                                    'questions'            => $all_questions,
                                    'all_groups'           => $all_groups,
                                );
                            }
                            $json_arr['status'] = 'true';
                            $json_arr['message'] = 'Success';
                            $json_arr['data'] = $data;
                        } else {
                            $json_arr['status'] = 'false';
                            $json_arr['message'] = 'Tests not found';
                            $json_arr['data'] = [];
                        }
                    } else {
                        $json_arr['status'] = 'false';
                        $json_arr['message'] = 'Test ID Required';
                        $json_arr['data'] = [];
                    }
                } else {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'User not found';
                    $json_arr['data'] = [];
                }
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Login not available.';
                $json_arr['data'] = [];
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Request not found.';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
    }
    public function buy_course()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        if ($request) {
            if (!empty($request['login_id'])) {
                $user_id = $request['login_id'];
                $course_id = isset($request['course_id']) ? $request['course_id'] : '';
                $transaction_id = isset($request['transaction_id']) ? $request['transaction_id'] : '';
                $this->db->where('login_id', $user_id);
                $single = $this->db->get('user_login')->row();
                if (!empty($single)) {
                    if ($course_id != "") {
                        $this->db->select('courses.*');
                        $this->db->from('courses');
                        $this->db->where('id', $course_id);
                        $result = $this->db->get();
                        $course = $result->row();

                        if (!empty($course)) {
                            $payment_status = $request['payment_status'];
                            $is_coupon_applied = $request['is_coupon_applied'];
                            $applied_coupon_id = $request['applied_coupon_id'];
                            $payment_amount = $request['payment_amount'];
                            if ($payment_status == '1') {
                                $mrp = $course->mrp != "" ? (float)$course->mrp : 0;
                                $course_discount = $course->discount != "" ? (float)$course->discount : 0;
                                $sale_price = $course->sale_price != "" ? (float)$course->sale_price : 0;
                                $coupon_discount_amount = 0;
                                $coupons_discount_type = null;
                                $discount = 0;
                                if ($is_coupon_applied == '1') {
                                    $this->db->where('id', $applied_coupon_id);
                                    $coupons = $this->db->get('tbl_coupons')->row();
                                    if (!empty($coupons)) {
                                        $applied_coupon_id = $coupons->id;
                                        $discount = $coupons->discount != "" ? $coupons->discount : 0;
                                        if ($coupons->discount_type == '0') {
                                            $coupon_discount_amount = $mrp * $discount;
                                        } elseif ($coupons->discount_type == '1') {
                                            $coupon_discount_amount = $discount;
                                        } else {
                                            $coupon_discount_amount = 0;
                                        }
                                    }
                                }
                                $original_sale_pice = $sale_price - $coupon_discount_amount;
                                $total_discount_amount = $coupon_discount_amount + $course_discount;
                                if ($payment_amount == $original_sale_pice) {
                                    $buy_data = array(
                                        'user_id'           => $user_id,
                                        'course_id'         => $course_id,
                                        'course_mrp'        => $mrp,
                                        'course_discount'   => $course_discount,
                                        'course_buy_price'  => $sale_price,
                                        'payment_status'    => $payment_status,
                                        'is_coupon_applied' => $is_coupon_applied,
                                        'applied_coupon_id' => $applied_coupon_id,
                                        'coupon_discount_type'      => $coupons_discount_type,
                                        'coupon_discount'           => $discount,
                                        'coupon_discount_amount'    => $coupon_discount_amount,
                                        'total_discount_amount'     => $total_discount_amount,
                                        'payment_amount'    => $payment_amount,
                                        'transaction_id'    => $transaction_id,
                                        'created_on'        => date('Y-m-d H:i:s'),
                                        'payment_on'        => date('Y-m-d H:i:s'),
                                    );
                                    $this->db->insert('tbl_bought_courses', $buy_data);
                                    $insert_id = $this->db->insert_id();

                                    $my_buy_data = array(
                                        'user_id'           => $user_id,
                                        'type'              => '1',
                                        'primary_table_id'  => $insert_id,
                                        'primary_table'     => 'tbl_bought_courses',
                                        'content_primary_table_id'  => $course_id,
                                        'content_primary_table'     => 'courses',
                                        'payment_amount'    => $payment_amount,
                                        'transaction_id'    => $transaction_id,
                                        'payment_status'    => $payment_status,
                                        'content_status'    => '1',
                                        'created_on'        => date('Y-m-d H:i:s'),
                                        'payment_on'        => date('Y-m-d H:i:s'),
                                    );
                                    $this->db->insert('tbl_user_contents', $my_buy_data);
                                    $content_id = $this->db->insert_id();

                                    $payment_data = array(
                                        'user_id'           => $user_id,
                                        'payment_for'       => '1',
                                        'payment_on'        => date('Y-m-d H:i:s'),
                                        'transaction_id'    => $transaction_id,
                                        'payment_status'    => $payment_status,
                                        'payment_amount'    => $payment_amount,
                                        'primary_table_id'  => $insert_id,
                                        'primary_table_name' => 'tbl_bought_courses'
                                    );
                                    $payment_id = $this->set_user_payment($payment_data);

                                    $this->db->where('id', $insert_id);
                                    $this->db->update('tbl_bought_courses', array('payment_table_id' => $payment_id));

                                    $type = '1';
                                    $app_message = "Hello, " . $single->full_name . "!\n\n🎉 Your course payment successful!";
                                    $title = 'Course Payment Successfull';
                                    $notification_data = [
                                        "landing_page"  => 'my_contents',
                                        "redirect_id"   => (string)$content_id
                                    ];

                                    $this->Notification_model->send_notification($app_message, $title, $notification_data, $type, $user_id);

                                    $json_arr['status'] = 'true';
                                    $json_arr['message'] = 'Success';
                                    $json_arr['data'] = [$insert_id];
                                } else {
                                    $json_arr['status'] = 'false';
                                    $json_arr['message'] = 'Payment amount is not correct. It should be Rs. ' . $original_sale_pice;
                                    $json_arr['data'] = [];
                                }
                            } else {
                                $json_arr['status'] = 'false';
                                $json_arr['message'] = 'Payment is not successfull';
                                $json_arr['data'] = [];
                            }
                        } else {
                            $json_arr['status'] = 'false';
                            $json_arr['message'] = 'Course Details not found';
                            $json_arr['data'] = [];
                        }
                    } else {
                        $json_arr['status'] = 'false';
                        $json_arr['message'] = 'Course ID Required';
                        $json_arr['data'] = [];
                    }
                } else {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'User not found';
                    $json_arr['data'] = [];
                }
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Login not available.';
                $json_arr['data'] = [];
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Request not found.';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
    }

    public function get_coupon_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        // print_r($request);
        if ($request) {
            if (!empty($request['login_id'])) {
                $user_id = (int)$request['login_id'];
                $type = (string)$request['type'];
                $this->db->where('login_id', $user_id);
                $single = $this->db->get('user_login')->row();

                if (!empty($single)) {
                    if ($type != '') {

                        $this->db->select('id, type, name, code, discount_type, discount, description');
                        $this->db->from('tbl_coupons');
                        $this->db->where('tbl_coupons.is_deleted', '0');
                        $this->db->where('tbl_coupons.type', $type);
                        $this->db->order_by('tbl_coupons.id', 'DESC');
                        $result = $this->db->get();

                        $coupon = $result->result();
                        if (!empty($coupon)) {
                            $json_arr['status'] = 'true';
                            $json_arr['message'] = 'Success';
                            $json_arr['data'] = $coupon;
                        } else {
                            $json_arr['status'] = 'false';
                            $json_arr['message'] = 'Coupon not found';
                            $json_arr['data'] = [];
                        }
                    } else {
                        $json_arr['status'] = 'false';
                        $json_arr['message'] = 'Type not found';
                        $json_arr['data'] = [];
                    }
                } else {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'User not found';
                    $json_arr['data'] = [];
                }
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Login not available.';
                $json_arr['data'] = [];
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Request not found.';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
    }
    public function my_contents()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        if ($request) {
            if (!empty($request['login_id'])) {
                $user_id = $request['login_id'];
                $this->db->where('login_id', $user_id);
                $single = $this->db->get('user_login')->row();
                if (!empty($single)) {
                    $this->db->select('tbl_user_contents.*');
                    $this->db->from('tbl_user_contents');
                    $this->db->where('tbl_user_contents.is_deleted', '0');
                    $this->db->where('tbl_user_contents.user_id', $user_id);
                    $result = $this->db->get();
                    $course = $result->result();
                    $data = [];
                    if (!empty($course)) {
                        foreach ($course as $course_result) {
                            $this->db->where('is_deleted', '0');
                            $this->db->where('id', $course_result->content_primary_table_id);
                            $content_single = $this->db->get($course_result->content_primary_table)->row();
                            if (!empty($content_single)) {
                                $data[] = array(
                                    'content_allocation_id' => $course_result->id,
                                    'type'              => $course_result->type,
                                    'payment_on'        => $course_result->payment_on,
                                    'payment_amount'    => $course_result->payment_amount,
                                    'transaction_id'    => $course_result->transaction_id,
                                    'payment_status'    => $course_result->payment_status,
                                    'content_status'    => $course_result->content_status,
                                    'content_primary_id'            => $course_result->content_primary_table_id,
                                    'content_payment_details_id'    => $course_result->primary_table_id,
                                    'title'             => $content_single->title,
                                    'description'       => $content_single->sub_headings,
                                    'image_path'        => $content_single->banner_image != "" ? base_url() . '' . $content_single->banner_image : '',
                                );
                            }
                        }
                        $json_arr['status'] = 'true';
                        $json_arr['message'] = 'Success';
                        $json_arr['data'] = $data;
                    } else {
                        $json_arr['status'] = 'false';
                        $json_arr['message'] = 'Content not found';
                        $json_arr['data'] = [];
                    }
                } else {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'User not found';
                    $json_arr['data'] = [];
                }
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Login not available.';
                $json_arr['data'] = [];
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Request not found.';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
    }
    public function bought_content_details()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        if ($request) {
            if (!empty($request['login_id'])) {
                $user_id = $request['login_id'];
                $this->db->where('login_id', $user_id);
                $customer_single = $this->db->get('user_login')->row();
                if (!empty($customer_single)) {
                    $content_allocation_id = $request['content_allocation_id'];
                    $this->db->select('tbl_user_contents.*');
                    $this->db->from('tbl_user_contents');
                    $this->db->where('tbl_user_contents.is_deleted', '0');
                    $this->db->where('tbl_user_contents.id', $content_allocation_id);
                    $result = $this->db->get();
                    $row = $result->row();
                    $data = [];
                    if (!empty($row)) {
                        $this->db->where('is_deleted', '0');
                        $this->db->where('id', $row->content_primary_table_id);
                        $single = $this->db->get($row->content_primary_table)->row();
                        if (!empty($single)) {
                            $data = array(
                                'id'                => $row->id,
                                'type'              => $row->type,
                                'payment_on'        => $row->payment_on,
                                'payment_amount'    => $row->payment_amount,
                                'transaction_id'    => $row->transaction_id,
                                'payment_status'    => $row->payment_status,
                                'content_status'    => $row->content_status,
                                'content_primary_id'            => $row->content_primary_table_id,
                                'content_payment_details_id'    => $row->primary_table_id,
                                'title'             => $single->title,
                                'description'       => $single->sub_headings,
                                'image_path'        => $single->banner_image != "" ? base_url() . '' . $single->banner_image : '',
                            );
                        }
                        if (!empty($data)) {
                            $json_arr['status'] = 'true';
                            $json_arr['message'] = 'Success';
                            $json_arr['data'] = $data;
                        } else {
                            $json_arr['status'] = 'false';
                            $json_arr['message'] = 'Details not available';
                            $json_arr['data'] = [];
                        }
                    } else {
                        $json_arr['status'] = 'false';
                        $json_arr['message'] = 'Content not found';
                        $json_arr['data'] = [];
                    }
                } else {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'User not found';
                    $json_arr['data'] = [];
                }
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Login not available.';
                $json_arr['data'] = [];
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Request not found.';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
    }

    public function get_free_mock_tests()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        if ($request) {
            if (!empty($request['login_id'])) {
                $user_id = $request['login_id'];
                $offset = $request['offset'];
                $limit = $request['limit'];
                $this->db->where('login_id', $user_id);
                $single = $this->db->get('user_login')->row();
                if (!empty($single)) {
                    $this->db->select('tbl_free_test.*,tbl_test_setups.show_ans, tbl_test_setups.questions_shuffle, tbl_test_setups.download_test_pdf, tbl_test_setups.test_pdf, tbl_test_setups.topic,tbl_test_setups.short_note,tbl_test_setups.short_description,tbl_test_setups.duration,tbl_test_setups.description,tbl_test_setups.total_questions,tbl_test_setups.total_marks');
                    $this->db->join('tbl_test_setups', 'tbl_free_test.test_id = tbl_test_setups.id');
                    $this->db->select('tbl_free_test.*');
                    $this->db->from('tbl_free_test');
                    $this->db->limit($limit, $offset);
                    $this->db->where('tbl_free_test.is_deleted', '0');
                    $result = $this->db->get();
                    $course = $result->result();
                    $data = [];
                    if (!empty($course)) {
                        foreach ($course as $course_result) {
                            $this->db->where('test_id', $course_result->test_id);
                            $this->db->where('user_id', $user_id);
                            $this->db->where('is_deleted', '0');
                            $this->db->where('parent_module', 'free_mock');
                            $attempted_test = $this->db->get('tbl_attempted_test')->row();
                            if (!empty($attempted_test)) {
                                $is_test_attempted = '1';
                                $attempted_test_id = $attempted_test->id;
                            } else {
                                $is_test_attempted = '0';
                                $attempted_test_id = '';
                            }

                            if ($course_result->show_ans == 'Yes') {
                                $show_correct_ans = '1';
                            } else {
                                $show_correct_ans = '0';
                            }

                            if ($course_result->download_test_pdf == 'Yes') {
                                $download_test_pdf = '1';
                                $test_pdf_link = $course_result->test_pdf != '' ? (base_url() . 'assets/uploads/test_pdfs/' . $course_result->test_pdf) : '';
                            } else {
                                $download_test_pdf = '0';
                                $test_pdf_link = '';
                            }

                            $data[] = array(
                                'free_mock_allocation_id'   => $course_result->id,
                                'is_test_attempted'         => $is_test_attempted,
                                'attempted_test_id'         => $attempted_test_id,
                                'test_id'                   => $course_result->test_id,
                                'topic'                     => $course_result->topic,
                                'short_note'                => $course_result->short_note,
                                'short_description' => $course_result->short_description,
                                'duration'          => $course_result->duration,
                                'description'       => $course_result->description,
                                'total_questions'   => $course_result->total_questions,
                                'total_marks'       => $course_result->total_marks,

                                'is_show_correct_ans'  => $show_correct_ans,
                                'is_download_test_pdf' => $download_test_pdf,
                                'test_pdf_link'        => $test_pdf_link,
                            );
                        }

                        $json_arr['status'] = 'true';
                        $json_arr['message'] = 'Success';
                        $json_arr['data'] = $data;
                    } else {
                        $json_arr['status'] = 'false';
                        $json_arr['message'] = 'Test not found';
                        $json_arr['data'] = [];
                    }
                } else {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'User not found';
                    $json_arr['data'] = [];
                }
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Login not available.';
                $json_arr['data'] = [];
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Request not found.';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
    }

    public function get_doc_videos_tests()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        if ($request) {
            if (!empty($request['login_id'])) {
                $user_id = $request['login_id'];
                $offset = $request['offset'];
                $limit = $request['limit'];
                $this->db->where('login_id', $user_id);
                $single = $this->db->get('user_login')->row();
                if (!empty($single)) {
                    $this->db->select('tbl_docs_videos_test.*,tbl_test_setups.show_ans, tbl_test_setups.questions_shuffle, tbl_test_setups.download_test_pdf, tbl_test_setups.test_pdf,tbl_test_setups.topic,tbl_test_setups.short_note,tbl_test_setups.short_description,tbl_test_setups.duration,tbl_test_setups.description,tbl_test_setups.total_questions,tbl_test_setups.total_marks');
                    $this->db->join('tbl_test_setups', 'tbl_docs_videos_test.test_id = tbl_test_setups.id');
                    $this->db->select('tbl_docs_videos_test.*');
                    $this->db->from('tbl_docs_videos_test');
                    $this->db->limit($limit, $offset);
                    $this->db->where('tbl_docs_videos_test.is_deleted', '0');
                    $result = $this->db->get();
                    $course = $result->result();
                    $data = [];
                    if (!empty($course)) {
                        foreach ($course as $course_result) {
                            $this->db->where('test_id', $course_result->test_id);
                            $this->db->where('user_id', $user_id);
                            $this->db->where('is_deleted', '0');
                            $this->db->where('parent_module', 'doc&videos');
                            $attempted_test = $this->db->get('tbl_attempted_test')->row();
                            if (!empty($attempted_test)) {
                                $is_test_attempted = '1';
                                $attempted_test_id = $attempted_test->id;
                            } else {
                                $is_test_attempted = '0';
                                $attempted_test_id = '';
                            }

                            if ($course_result->show_ans == 'Yes') {
                                $show_correct_ans = '1';
                            } else {
                                $show_correct_ans = '0';
                            }

                            if ($course_result->questions_shuffle == 'Yes') {
                                $questions_shuffle = '1';
                            } else {
                                $questions_shuffle = '0';
                            }

                            if ($course_result->download_test_pdf == 'Yes') {
                                $download_test_pdf = '1';
                                $test_pdf_link = $course_result->test_pdf != '' ? (base_url() . 'assets/uploads/test_pdfs/' . $course_result->test_pdf) : '';
                            } else {
                                $download_test_pdf = '0';
                                $test_pdf_link = '';
                            }

                            $data[] = array(
                                'doc_video_allocation_id'   => $course_result->id,
                                'is_test_attempted'         => $is_test_attempted,
                                'attempted_test_id'         => $attempted_test_id,
                                'test_id'                   => $course_result->test_id,
                                'topic'                     => $course_result->topic,
                                'short_note'                => $course_result->short_note,
                                'short_description' => $course_result->short_description,
                                'duration'          => $course_result->duration,
                                'description'       => $course_result->description,
                                'total_questions'   => $course_result->total_questions,
                                'total_marks'       => $course_result->total_marks,

                                'is_show_correct_ans'  => $show_correct_ans,
                                'is_download_test_pdf' => $download_test_pdf,
                                'test_pdf_link'        => $test_pdf_link,
                            );
                        }

                        $json_arr['status'] = 'true';
                        $json_arr['message'] = 'Success';
                        $json_arr['data'] = $data;
                    } else {
                        $json_arr['status'] = 'false';
                        $json_arr['message'] = 'Test not found';
                        $json_arr['data'] = [];
                    }
                } else {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'User not found';
                    $json_arr['data'] = [];
                }
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Login not available.';
                $json_arr['data'] = [];
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Request not found.';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
    }

    public function test_submit()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        if ($request) {
            if (!empty($request['login_id'])) {
                $user_id = $request['login_id'];
                $attempted_test_id = isset($request['attempted_test_id']) ? $request['attempted_test_id'] : '';
                $parent_module = $request['parent_module'];
                $this->db->where('login_id', $user_id);
                $single = $this->db->get('user_login')->row();
                if (!empty($single)) {
                    $received_positive_marks = 0;
                    $received_negative_marks = 0;
                    $received_total_marks = 0;

                    $test_id = $request['test_id'];
                    $this->db->where('id', $test_id);
                    $this->db->where('is_deleted', '0');
                    $single_test = $this->db->get('tbl_test_setups')->row();
                    if (!empty($single_test)) {
                        $answer_list = $request['answer_list'];
                        $this->db->where('test_id', $test_id);
                        $this->db->where('is_deleted', '0');
                        $total_questions = $this->db->get('tbl_test_questions')->num_rows();
                        if ($total_questions == count($answer_list)) {
                            if ($attempted_test_id == '') {
                                $this->db->where('user_id', $user_id);
                                $this->db->where('test_id', $test_id);
                                $this->db->where('parent_module', $parent_module);
                                $this->db->where('is_deleted', '0');
                                $single_attempted_test = $this->db->get('tbl_attempted_test')->row();
                                if (!empty($single_attempted_test)) {
                                    $submitted_on = $request['submitted_on'] != "" ? date('Y-m-d H:i:s', strtotime($request['submitted_on'])) : date('Y-m-d H:i:s');
                                    $attempted_test_data = array(
                                        'user_id'       =>  $user_id,
                                        'parent_module' =>  $parent_module,
                                        'test_id'       =>  $test_id,
                                        'submited_on'   =>  $submitted_on,
                                        'topic'         =>  $single_test->topic,
                                        'short_note'            =>  $single_test->short_note,
                                        'short_description'     =>  $single_test->short_description,
                                        'duration'              =>  $single_test->duration,
                                        'description'           =>  $single_test->description,
                                        'total_questions'       =>  $single_test->total_questions,
                                        'total_marks'           =>  $single_test->total_marks,

                                        'questions_shuffle'     =>  $single_test->questions_shuffle,
                                        'show_ans'              =>  $single_test->show_ans,
                                        'test_pdf'              =>  $single_test->test_pdf,
                                        'download_test_pdf'     =>  $single_test->download_test_pdf,
                                    );
                                    $this->db->where('id', $single_attempted_test->id);
                                    $this->db->update('tbl_attempted_test', $attempted_test_data);
                                    $attempted_id = $single_attempted_test->id;

                                    foreach ($answer_list as $answer) {
                                        $single_received_positive_marks = 0;
                                        $single_received_negative_marks = 0;
                                        $single_received_marks = 0;

                                        $question_id = $answer['question_id'];
                                        $student_answer = $answer['student_answer'];
                                        $answer_image = '';
                                        $correct_answer_image = '';
                                        $student_answer_text = '';
                                        $this->db->where('id', $question_id);
                                        $this->db->where('is_deleted', '0');
                                        $question_data = $this->db->get('tbl_test_questions')->row();
                                        if (!empty($question_data)) {
                                            $this->db->where('attempted_test_id', $attempted_id);
                                            $this->db->where('test_id', $test_id);
                                            $this->db->where('question_id', $question_data->id);
                                            $this->db->where('is_deleted', '0');
                                            $single_attempted_test_question = $this->db->get('tbl_attempted_test_questions')->row();
                                            if (!empty($single_attempted_test_question)) {
                                                $correct_answer = $question_data->answer;
                                                $correct_answer_col = $question_data->answer_column;
                                                $solution = $question_data->solution;
                                                if ($student_answer == '') {
                                                    $question_status = '0';
                                                    $single_received_positive_marks = 0;
                                                    $single_received_negative_marks = 0;
                                                } else {
                                                    if ($student_answer == $correct_answer_col) {
                                                        $question_status = '1';
                                                        $single_received_positive_marks = $question_data->positive_mark != "" ? (int)$question_data->positive_mark : 0;
                                                        $single_received_negative_marks = 0;
                                                    } else {
                                                        $question_status = '2';
                                                        $single_received_positive_marks = 0;
                                                        $single_received_negative_marks = $question_data->negative_mark != "" ? (int)$question_data->negative_mark : 0;
                                                    }
                                                    if ($student_answer == 'option_1') {
                                                        $answer_image = $question_data->option_1_image;
                                                        $student_answer_text = $question_data->option_1;
                                                    } elseif ($student_answer == 'option_2') {
                                                        $answer_image = $question_data->option_2_image;
                                                        $student_answer_text = $question_data->option_2;
                                                    } elseif ($student_answer == 'option_3') {
                                                        $answer_image = $question_data->option_3_image;
                                                        $student_answer_text = $question_data->option_3;
                                                    } elseif ($student_answer == 'option_4') {
                                                        $answer_image = $question_data->option_4_image;
                                                        $student_answer_text = $question_data->option_4;
                                                    }
                                                }

                                                if ($question_data->answer_column == 'option_1') {
                                                    $correct_answer_image = $question_data->option_1_image;
                                                } elseif ($question_data->answer_column == 'option_2') {
                                                    $correct_answer_image = $question_data->option_2_image;
                                                } elseif ($question_data->answer_column == 'option_3') {
                                                    $correct_answer_image = $question_data->option_3_image;
                                                } elseif ($question_data->answer_column == 'option_4') {
                                                    $correct_answer_image = $question_data->option_4_image;
                                                }

                                                $single_received_marks = $single_received_positive_marks - $single_received_negative_marks;

                                                $attempted_group_id = '';
                                                if ($question_data->type == '2') {
                                                    $this->db->where('is_deleted', '0');
                                                    $this->db->where('status', '1');
                                                    $this->db->where('id', $question_data->group_id);
                                                    $single_group = $this->db->get('tbl_test_groups')->row();
                                                    if (!empty($single_group)) {
                                                        $this->db->where('is_deleted', '0');
                                                        $this->db->where('status', '1');
                                                        $this->db->where('test_id', $test_id);
                                                        $this->db->where('group_id', $single_group->id);
                                                        $this->db->where('attempted_test_id', $attempted_id);
                                                        $single_attempted_group = $this->db->get('tbl_attempted_test_groups')->row();
                                                        if (empty($single_attempted_group)) {
                                                            $single_attempted_group_data = array(
                                                                'group_id'          =>  $single_group->id,
                                                                'test_id'           =>  $test_id,
                                                                'attempted_test_id' =>  $attempted_id,
                                                                'group_type'        =>  $single_group->group_type,
                                                                'group_title'       =>  $single_group->group_title,
                                                                'group_description' =>  $single_group->group_description,
                                                                'group_image'       =>  $single_group->group_image,
                                                                'created_on'        =>  date('Y-m-d H:i:s')
                                                            );
                                                            $this->db->insert('tbl_attempted_test_groups', $single_attempted_group_data);
                                                            $attempted_group_id = $this->db->insert_id();
                                                        } else {
                                                            $attempted_group_id = $single_attempted_group->id;
                                                        }
                                                    }
                                                }

                                                $attempted_test_questions_data = array(
                                                    'test_id'          => $test_id,
                                                    'attempted_test_id' => $attempted_id,
                                                    'question_id'      => $question_id,
                                                    'question_status'  => $question_status,
                                                    'correct_answer'   => $correct_answer,
                                                    'correct_answer_col'    => $correct_answer_col,
                                                    'solution'              => $solution,

                                                    'question'         => $question_data->question,
                                                    'option_1'         => $question_data->option_1,
                                                    'option_2'         => $question_data->option_2,
                                                    'option_3'         => $question_data->option_3,
                                                    'option_4'         => $question_data->option_4,
                                                    'correct_answer_image'     => $correct_answer_image,
                                                    'answer'           => $student_answer_text,
                                                    'answer_image'     => $answer_image,
                                                    'positive_mark'    => $question_data->positive_mark,
                                                    'negative_mark'    => $question_data->negative_mark,

                                                    'received_positive_marks'   =>  $single_received_positive_marks,
                                                    'received_negative_marks'   =>  $single_received_negative_marks,
                                                    'received_marks'            =>  $single_received_marks,

                                                    'type'              =>  $question_data->type,
                                                    'group_id'          =>  $question_data->group_id,
                                                    'attempted_group_id' =>  $attempted_group_id,
                                                    'group_type'        =>  $question_data->group_type,
                                                    'question_image'    =>  $question_data->question_image,
                                                    'option_1_image'    =>  $question_data->option_1_image,
                                                    'option_2_image'    =>  $question_data->option_2_image,
                                                    'option_3_image'    =>  $question_data->option_3_image,
                                                    'option_4_image'    =>  $question_data->option_4_image,
                                                );
                                                $this->db->where('id', $single_attempted_test_question->id);
                                                $this->db->update('tbl_attempted_test_questions', $attempted_test_questions_data);

                                                $received_positive_marks += $single_received_positive_marks;
                                                $received_negative_marks += $single_received_negative_marks;
                                                $received_total_marks += $single_received_marks;
                                            } else {
                                                $correct_answer = $question_data->answer;
                                                $correct_answer_col = $question_data->answer_column;
                                                $solution = $question_data->solution;
                                                if ($student_answer == '') {
                                                    $question_status = '0';
                                                    $single_received_positive_marks = 0;
                                                    $single_received_negative_marks = 0;
                                                } else {
                                                    if ($student_answer == $correct_answer_col) {
                                                        $question_status = '1';
                                                        $single_received_positive_marks = $question_data->positive_mark != "" ? (int)$question_data->positive_mark : 0;
                                                        $single_received_negative_marks = 0;
                                                    } else {
                                                        $question_status = '2';
                                                        $single_received_positive_marks = 0;
                                                        $single_received_negative_marks = $question_data->negative_mark != "" ? (int)$question_data->negative_mark : 0;
                                                    }
                                                    if ($student_answer == 'option_1') {
                                                        $answer_image = $question_data->option_1_image;
                                                        $student_answer_text = $question_data->option_1;
                                                    } elseif ($student_answer == 'option_2') {
                                                        $answer_image = $question_data->option_2_image;
                                                        $student_answer_text = $question_data->option_2;
                                                    } elseif ($student_answer == 'option_3') {
                                                        $answer_image = $question_data->option_3_image;
                                                        $student_answer_text = $question_data->option_3;
                                                    } elseif ($student_answer == 'option_4') {
                                                        $answer_image = $question_data->option_4_image;
                                                        $student_answer_text = $question_data->option_4;
                                                    }
                                                }

                                                if ($question_data->answer_column == 'option_1') {
                                                    $correct_answer_image = $question_data->option_1_image;
                                                } elseif ($question_data->answer_column == 'option_2') {
                                                    $correct_answer_image = $question_data->option_2_image;
                                                } elseif ($question_data->answer_column == 'option_3') {
                                                    $correct_answer_image = $question_data->option_3_image;
                                                } elseif ($question_data->answer_column == 'option_4') {
                                                    $correct_answer_image = $question_data->option_4_image;
                                                }

                                                $single_received_marks = $single_received_positive_marks - $single_received_negative_marks;

                                                $attempted_group_id = '';
                                                if ($question_data->type == '2') {
                                                    $this->db->where('is_deleted', '0');
                                                    $this->db->where('status', '1');
                                                    $this->db->where('id', $question_data->group_id);
                                                    $single_group = $this->db->get('tbl_test_groups')->row();
                                                    if (!empty($single_group)) {
                                                        $this->db->where('is_deleted', '0');
                                                        $this->db->where('status', '1');
                                                        $this->db->where('test_id', $test_id);
                                                        $this->db->where('group_id', $single_group->id);
                                                        $this->db->where('attempted_test_id', $attempted_id);
                                                        $single_attempted_group = $this->db->get('tbl_attempted_test_groups')->row();
                                                        if (empty($single_attempted_group)) {
                                                            $single_attempted_group_data = array(
                                                                'group_id'          =>  $single_group->id,
                                                                'test_id'           =>  $test_id,
                                                                'attempted_test_id' =>  $attempted_id,
                                                                'group_type'        =>  $single_group->group_type,
                                                                'group_title'       =>  $single_group->group_title,
                                                                'group_description' =>  $single_group->group_description,
                                                                'group_image'       =>  $single_group->group_image,
                                                                'created_on'        =>  date('Y-m-d H:i:s')
                                                            );
                                                            $this->db->insert('tbl_attempted_test_groups', $single_attempted_group_data);
                                                            $attempted_group_id = $this->db->insert_id();
                                                        } else {
                                                            $attempted_group_id = $single_attempted_group->id;
                                                        }
                                                    }
                                                }

                                                $attempted_test_questions_data = array(
                                                    'test_id'          => $test_id,
                                                    'attempted_test_id' => $attempted_id,
                                                    'question_id'      => $question_id,
                                                    'question_status'  => $question_status,
                                                    'correct_answer'   => $correct_answer,
                                                    'correct_answer_col'    => $correct_answer_col,
                                                    'solution'              => $solution,

                                                    'question'         => $question_data->question,
                                                    'option_1'         => $question_data->option_1,
                                                    'option_2'         => $question_data->option_2,
                                                    'option_3'         => $question_data->option_3,
                                                    'option_4'         => $question_data->option_4,
                                                    'answer'           => $student_answer_text,
                                                    'correct_answer_image'     => $correct_answer_image,
                                                    'answer_image'           => $answer_image,
                                                    'positive_mark'    => $question_data->positive_mark,
                                                    'negative_mark'    => $question_data->negative_mark,

                                                    'received_positive_marks'   =>  $single_received_positive_marks,
                                                    'received_negative_marks'   =>  $single_received_negative_marks,
                                                    'received_marks'            =>  $single_received_marks,

                                                    'type'              =>  $question_data->type,
                                                    'group_id'          =>  $question_data->group_id,
                                                    'attempted_group_id' =>  $attempted_group_id,
                                                    'group_type'        =>  $question_data->group_type,
                                                    'question_image'    =>  $question_data->question_image,
                                                    'option_1_image'    =>  $question_data->option_1_image,
                                                    'option_2_image'    =>  $question_data->option_2_image,
                                                    'option_3_image'    =>  $question_data->option_3_image,
                                                    'option_4_image'    =>  $question_data->option_4_image,

                                                    'created_on'       => date('Y-m-d H:i:s'),
                                                );
                                                $this->db->insert('tbl_attempted_test_questions', $attempted_test_questions_data);

                                                $received_positive_marks += $single_received_positive_marks;
                                                $received_negative_marks += $single_received_negative_marks;
                                                $received_total_marks += $single_received_marks;
                                            }
                                        }
                                    }

                                    $calculated_received_total_marks = $received_positive_marks - $received_negative_marks;
                                    $marks_array = array(
                                        'received_positive_marks'   =>  $received_positive_marks,
                                        'received_negative_marks'   =>  $received_negative_marks,
                                        'received_total_marks'      =>  $calculated_received_total_marks,
                                        'result'                    =>  '1',
                                    );
                                    $this->db->where('id', $attempted_id);
                                    $this->db->update('tbl_attempted_test', $marks_array);
                                } else {
                                    $submitted_on = $request['submitted_on'] != "" ? date('Y-m-d H:i:s', strtotime($request['submitted_on'])) : date('Y-m-d H:i:s');
                                    $attempted_test_data = array(
                                        'user_id'       =>  $user_id,
                                        'parent_module' =>  $parent_module,
                                        'test_id'       =>  $test_id,
                                        'submited_on'   =>  $submitted_on,
                                        'topic'         =>  $single_test->topic,
                                        'short_note'            =>  $single_test->short_note,
                                        'short_description'     =>  $single_test->short_description,
                                        'duration'              =>  $single_test->duration,
                                        'description'           =>  $single_test->description,
                                        'total_questions'       =>  $single_test->total_questions,
                                        'total_marks'           =>  $single_test->total_marks,
                                        'created_on'    => date('Y-m-d H:i:s'),
                                    );
                                    $this->db->insert('tbl_attempted_test', $attempted_test_data);
                                    $attempted_id = $this->db->insert_id();

                                    foreach ($answer_list as $answer) {
                                        $single_received_positive_marks = 0;
                                        $single_received_negative_marks = 0;
                                        $single_received_marks = 0;
                                        $question_id = $answer['question_id'];
                                        $student_answer = $answer['student_answer'];
                                        $answer_image = '';
                                        $correct_answer_image = '';
                                        $student_answer_text = '';
                                        $this->db->where('id', $question_id);
                                        $this->db->where('is_deleted', '0');
                                        $question_data = $this->db->get('tbl_test_questions')->row();
                                        if (!empty($question_data)) {
                                            $correct_answer = $question_data->answer;
                                            $correct_answer_col = $question_data->answer_column;
                                            $solution = $question_data->solution;
                                            if ($student_answer == '') {
                                                $question_status = '0';
                                                $single_received_positive_marks = 0;
                                                $single_received_negative_marks = 0;
                                            } else {
                                                if ($student_answer == $correct_answer_col) {
                                                    $question_status = '1';
                                                    $single_received_positive_marks = $question_data->positive_mark != "" ? (int)$question_data->positive_mark : 0;
                                                    $single_received_negative_marks = 0;
                                                } else {
                                                    $question_status = '2';
                                                    $single_received_positive_marks = 0;
                                                    $single_received_negative_marks = $question_data->negative_mark != "" ? (int)$question_data->negative_mark : 0;
                                                }
                                                if ($student_answer == 'option_1') {
                                                    $answer_image = $question_data->option_1_image;
                                                    $student_answer_text = $question_data->option_1;
                                                } elseif ($student_answer == 'option_2') {
                                                    $answer_image = $question_data->option_2_image;
                                                    $student_answer_text = $question_data->option_2;
                                                } elseif ($student_answer == 'option_3') {
                                                    $answer_image = $question_data->option_3_image;
                                                    $student_answer_text = $question_data->option_3;
                                                } elseif ($student_answer == 'option_4') {
                                                    $answer_image = $question_data->option_4_image;
                                                    $student_answer_text = $question_data->option_4;
                                                }
                                            }

                                            if ($question_data->answer_column == 'option_1') {
                                                $correct_answer_image = $question_data->option_1_image;
                                            } elseif ($question_data->answer_column == 'option_2') {
                                                $correct_answer_image = $question_data->option_2_image;
                                            } elseif ($question_data->answer_column == 'option_3') {
                                                $correct_answer_image = $question_data->option_3_image;
                                            } elseif ($question_data->answer_column == 'option_4') {
                                                $correct_answer_image = $question_data->option_4_image;
                                            }

                                            $single_received_marks = $single_received_positive_marks - $single_received_negative_marks;

                                            $attempted_group_id = '';
                                            if ($question_data->type == '2') {
                                                $this->db->where('is_deleted', '0');
                                                $this->db->where('status', '1');
                                                $this->db->where('id', $question_data->group_id);
                                                $single_group = $this->db->get('tbl_test_groups')->row();
                                                if (!empty($single_group)) {
                                                    $this->db->where('is_deleted', '0');
                                                    $this->db->where('status', '1');
                                                    $this->db->where('test_id', $test_id);
                                                    $this->db->where('group_id', $single_group->id);
                                                    $this->db->where('attempted_test_id', $attempted_id);
                                                    $single_attempted_group = $this->db->get('tbl_attempted_test_groups')->row();
                                                    if (empty($single_attempted_group)) {
                                                        $single_attempted_group_data = array(
                                                            'group_id'          =>  $single_group->id,
                                                            'test_id'           =>  $test_id,
                                                            'attempted_test_id' =>  $attempted_id,
                                                            'group_type'        =>  $single_group->group_type,
                                                            'group_title'       =>  $single_group->group_title,
                                                            'group_description' =>  $single_group->group_description,
                                                            'group_image'       =>  $single_group->group_image,
                                                            'created_on'        =>  date('Y-m-d H:i:s')
                                                        );
                                                        $this->db->insert('tbl_attempted_test_groups', $single_attempted_group_data);
                                                        $attempted_group_id = $this->db->insert_id();
                                                    } else {
                                                        $attempted_group_id = $single_attempted_group->id;
                                                    }
                                                }
                                            }

                                            $attempted_test_questions_data = array(
                                                'test_id'          => $test_id,
                                                'attempted_test_id' => $attempted_id,
                                                'question_id'      => $question_id,
                                                'question_status'  => $question_status,
                                                'correct_answer'   => $correct_answer,
                                                'correct_answer_col'    => $correct_answer_col,
                                                'solution'              => $solution,

                                                'question'         => $question_data->question,
                                                'option_1'         => $question_data->option_1,
                                                'option_2'         => $question_data->option_2,
                                                'option_3'         => $question_data->option_3,
                                                'option_4'         => $question_data->option_4,
                                                'answer'           => $student_answer_text,
                                                'correct_answer_image'     => $correct_answer_image,
                                                'answer_image'           => $answer_image,
                                                'positive_mark'    => $question_data->positive_mark,
                                                'negative_mark'    => $question_data->negative_mark,

                                                'received_positive_marks'   =>  $single_received_positive_marks,
                                                'received_negative_marks'   =>  $single_received_negative_marks,
                                                'received_marks'            =>  $single_received_marks,

                                                'type'              =>  $question_data->type,
                                                'group_id'          =>  $question_data->group_id,
                                                'attempted_group_id' =>  $attempted_group_id,
                                                'group_type'        =>  $question_data->group_type,
                                                'question_image'    =>  $question_data->question_image,
                                                'option_1_image'    =>  $question_data->option_1_image,
                                                'option_2_image'    =>  $question_data->option_2_image,
                                                'option_3_image'    =>  $question_data->option_3_image,
                                                'option_4_image'    =>  $question_data->option_4_image,

                                                'created_on'       => date('Y-m-d H:i:s'),
                                            );
                                            $this->db->insert('tbl_attempted_test_questions', $attempted_test_questions_data);

                                            $received_positive_marks += $single_received_positive_marks;
                                            $received_negative_marks += $single_received_negative_marks;
                                            $received_total_marks += $single_received_marks;
                                        }
                                    }

                                    $calculated_received_total_marks = $received_positive_marks - $received_negative_marks;
                                    $marks_array = array(
                                        'received_positive_marks'   =>  $received_positive_marks,
                                        'received_negative_marks'   =>  $received_negative_marks,
                                        'received_total_marks'      =>  $calculated_received_total_marks,
                                        'result'                    => '1',
                                    );
                                    $this->db->where('id', $attempted_id);
                                    $this->db->update('tbl_attempted_test', $marks_array);
                                }
                            } else {
                                $this->db->where('test_id', $test_id);
                                $this->db->where('id', $attempted_test_id);
                                $this->db->where('parent_module', $parent_module);
                                $this->db->where('is_deleted', '0');
                                $single_attempted_test = $this->db->get('tbl_attempted_test')->row();
                                if (!empty($single_attempted_test)) {
                                    $submitted_on = $request['submitted_on'] != "" ? date('Y-m-d H:i:s', strtotime($request['submitted_on'])) : date('Y-m-d H:i:s');
                                    $attempted_test_data = array(
                                        'user_id'       =>  $user_id,
                                        'parent_module' =>  $parent_module,
                                        'test_id'       =>  $test_id,
                                        'submited_on'   =>  $submitted_on,
                                        'topic'         =>  $single_test->topic,
                                        'short_note'            =>  $single_test->short_note,
                                        'short_description'     =>  $single_test->short_description,
                                        'duration'              =>  $single_test->duration,
                                        'description'           =>  $single_test->description,
                                        'total_questions'       =>  $single_test->total_questions,
                                        'total_marks'           =>  $single_test->total_marks,
                                    );
                                    $this->db->where('id', $single_attempted_test->id);
                                    $this->db->update('tbl_attempted_test', $attempted_test_data);
                                    $attempted_id = $single_attempted_test->id;

                                    foreach ($answer_list as $answer) {
                                        $single_received_positive_marks = 0;
                                        $single_received_negative_marks = 0;
                                        $single_received_marks = 0;

                                        $question_id = $answer['question_id'];
                                        $student_answer = $answer['student_answer'];
                                        $answer_image = '';
                                        $correct_answer_image = '';
                                        $student_answer_text = '';
                                        $this->db->where('id', $question_id);
                                        $this->db->where('is_deleted', '0');
                                        $question_data = $this->db->get('tbl_test_questions')->row();
                                        if (!empty($question_data)) {
                                            $this->db->where('attempted_test_id', $attempted_id);
                                            $this->db->where('test_id', $test_id);
                                            $this->db->where('question_id', $question_data->id);
                                            $this->db->where('is_deleted', '0');
                                            $single_attempted_test_question = $this->db->get('tbl_attempted_test_questions')->row();
                                            if (!empty($single_attempted_test_question)) {
                                                $correct_answer = $question_data->answer;
                                                $correct_answer_col = $question_data->answer_column;
                                                $solution = $question_data->solution;
                                                if ($student_answer == '') {
                                                    $question_status = '0';
                                                    $single_received_positive_marks = 0;
                                                    $single_received_negative_marks = 0;
                                                } else {
                                                    if ($student_answer == $correct_answer_col) {
                                                        $question_status = '1';
                                                        $single_received_positive_marks = $question_data->positive_mark != "" ? (int)$question_data->positive_mark : 0;
                                                        $single_received_negative_marks = 0;
                                                    } else {
                                                        $question_status = '2';
                                                        $single_received_positive_marks = 0;
                                                        $single_received_negative_marks = $question_data->negative_mark != "" ? (int)$question_data->negative_mark : 0;
                                                    }
                                                    if ($student_answer == 'option_1') {
                                                        $answer_image = $question_data->option_1_image;
                                                        $student_answer_text = $question_data->option_1;
                                                    } elseif ($student_answer == 'option_2') {
                                                        $answer_image = $question_data->option_2_image;
                                                        $student_answer_text = $question_data->option_2;
                                                    } elseif ($student_answer == 'option_3') {
                                                        $answer_image = $question_data->option_3_image;
                                                        $student_answer_text = $question_data->option_3;
                                                    } elseif ($student_answer == 'option_4') {
                                                        $answer_image = $question_data->option_4_image;
                                                        $student_answer_text = $question_data->option_4;
                                                    }
                                                }

                                                if ($question_data->answer_column == 'option_1') {
                                                    $correct_answer_image = $question_data->option_1_image;
                                                } elseif ($question_data->answer_column == 'option_2') {
                                                    $correct_answer_image = $question_data->option_2_image;
                                                } elseif ($question_data->answer_column == 'option_3') {
                                                    $correct_answer_image = $question_data->option_3_image;
                                                } elseif ($question_data->answer_column == 'option_4') {
                                                    $correct_answer_image = $question_data->option_4_image;
                                                }

                                                $single_received_marks = $single_received_positive_marks - $single_received_negative_marks;

                                                $attempted_group_id = '';
                                                if ($question_data->type == '2') {
                                                    $this->db->where('is_deleted', '0');
                                                    $this->db->where('status', '1');
                                                    $this->db->where('id', $question_data->group_id);
                                                    $single_group = $this->db->get('tbl_test_groups')->row();
                                                    if (!empty($single_group)) {
                                                        $this->db->where('is_deleted', '0');
                                                        $this->db->where('status', '1');
                                                        $this->db->where('test_id', $test_id);
                                                        $this->db->where('group_id', $single_group->id);
                                                        $this->db->where('attempted_test_id', $attempted_id);
                                                        $single_attempted_group = $this->db->get('tbl_attempted_test_groups')->row();
                                                        if (empty($single_attempted_group)) {
                                                            $single_attempted_group_data = array(
                                                                'group_id'          =>  $single_group->id,
                                                                'test_id'           =>  $test_id,
                                                                'attempted_test_id' =>  $attempted_id,
                                                                'group_type'        =>  $single_group->group_type,
                                                                'group_title'       =>  $single_group->group_title,
                                                                'group_description' =>  $single_group->group_description,
                                                                'group_image'       =>  $single_group->group_image,
                                                                'created_on'        =>  date('Y-m-d H:i:s')
                                                            );
                                                            $this->db->insert('tbl_attempted_test_groups', $single_attempted_group_data);
                                                            $attempted_group_id = $this->db->insert_id();
                                                        } else {
                                                            $attempted_group_id = $single_attempted_group->id;
                                                        }
                                                    }
                                                }

                                                $attempted_test_questions_data = array(
                                                    'test_id'          => $test_id,
                                                    'attempted_test_id' => $attempted_id,
                                                    'question_id'      => $question_id,
                                                    'question_status'  => $question_status,
                                                    'correct_answer'   => $correct_answer,
                                                    'correct_answer_col'    => $correct_answer_col,
                                                    'solution'              => $solution,

                                                    'question'         => $question_data->question,
                                                    'option_1'         => $question_data->option_1,
                                                    'option_2'         => $question_data->option_2,
                                                    'option_3'         => $question_data->option_3,
                                                    'option_4'         => $question_data->option_4,
                                                    'answer'           => $student_answer_text,
                                                    'correct_answer_image'     => $correct_answer_image,
                                                    'answer_image'           => $answer_image,
                                                    'positive_mark'    => $question_data->positive_mark,
                                                    'negative_mark'    => $question_data->negative_mark,

                                                    'received_positive_marks'   =>  $single_received_positive_marks,
                                                    'received_negative_marks'   =>  $single_received_negative_marks,
                                                    'received_marks'            =>  $single_received_marks,

                                                    'type'              =>  $question_data->type,
                                                    'group_id'          =>  $question_data->group_id,
                                                    'attempted_group_id' =>  $attempted_group_id,
                                                    'group_type'        =>  $question_data->group_type,
                                                    'question_image'    =>  $question_data->question_image,
                                                    'option_1_image'    =>  $question_data->option_1_image,
                                                    'option_2_image'    =>  $question_data->option_2_image,
                                                    'option_3_image'    =>  $question_data->option_3_image,
                                                    'option_4_image'    =>  $question_data->option_4_image,
                                                );
                                                // echo '<pre>'; print_r($attempted_test_questions_data);
                                                $this->db->where('id', $single_attempted_test_question->id);
                                                $this->db->update('tbl_attempted_test_questions', $attempted_test_questions_data);

                                                $received_positive_marks += $single_received_positive_marks;
                                                $received_negative_marks += $single_received_negative_marks;
                                                $received_total_marks += $single_received_marks;
                                            } else {
                                                $correct_answer = $question_data->answer;
                                                $correct_answer_col = $question_data->answer_column;
                                                $solution = $question_data->solution;
                                                if ($student_answer == '') {
                                                    $question_status = '0';
                                                    $single_received_positive_marks = 0;
                                                    $single_received_negative_marks = 0;
                                                } else {
                                                    if ($student_answer == $correct_answer_col) {
                                                        $question_status = '1';
                                                        $single_received_positive_marks = $question_data->positive_mark != "" ? (int)$question_data->positive_mark : 0;
                                                        $single_received_negative_marks = 0;
                                                    } else {
                                                        $question_status = '2';
                                                        $single_received_positive_marks = 0;
                                                        $single_received_negative_marks = $question_data->negative_mark != "" ? (int)$question_data->negative_mark : 0;
                                                    }
                                                    if ($student_answer == 'option_1') {
                                                        $answer_image = $question_data->option_1_image;
                                                        $student_answer_text = $question_data->option_1;
                                                    } elseif ($student_answer == 'option_2') {
                                                        $answer_image = $question_data->option_2_image;
                                                        $student_answer_text = $question_data->option_2;
                                                    } elseif ($student_answer == 'option_3') {
                                                        $answer_image = $question_data->option_3_image;
                                                        $student_answer_text = $question_data->option_3;
                                                    } elseif ($student_answer == 'option_4') {
                                                        $answer_image = $question_data->option_4_image;
                                                        $student_answer_text = $question_data->option_4;
                                                    }
                                                }

                                                if ($question_data->answer_column == 'option_1') {
                                                    $correct_answer_image = $question_data->option_1_image;
                                                } elseif ($question_data->answer_column == 'option_2') {
                                                    $correct_answer_image = $question_data->option_2_image;
                                                } elseif ($question_data->answer_column == 'option_3') {
                                                    $correct_answer_image = $question_data->option_3_image;
                                                } elseif ($question_data->answer_column == 'option_4') {
                                                    $correct_answer_image = $question_data->option_4_image;
                                                }

                                                $single_received_marks = $single_received_positive_marks - $single_received_negative_marks;

                                                $attempted_group_id = '';
                                                if ($question_data->type == '2') {
                                                    $this->db->where('is_deleted', '0');
                                                    $this->db->where('status', '1');
                                                    $this->db->where('id', $question_data->group_id);
                                                    $single_group = $this->db->get('tbl_test_groups')->row();
                                                    if (!empty($single_group)) {
                                                        $this->db->where('is_deleted', '0');
                                                        $this->db->where('status', '1');
                                                        $this->db->where('test_id', $test_id);
                                                        $this->db->where('group_id', $single_group->id);
                                                        $this->db->where('attempted_test_id', $attempted_id);
                                                        $single_attempted_group = $this->db->get('tbl_attempted_test_groups')->row();
                                                        if (empty($single_attempted_group)) {
                                                            $single_attempted_group_data = array(
                                                                'group_id'          =>  $single_group->id,
                                                                'test_id'           =>  $test_id,
                                                                'attempted_test_id' =>  $attempted_id,
                                                                'group_type'        =>  $single_group->group_type,
                                                                'group_title'       =>  $single_group->group_title,
                                                                'group_description' =>  $single_group->group_description,
                                                                'group_image'       =>  $single_group->group_image,
                                                                'created_on'        =>  date('Y-m-d H:i:s')
                                                            );
                                                            $this->db->insert('tbl_attempted_test_groups', $single_attempted_group_data);
                                                            $attempted_group_id = $this->db->insert_id();
                                                        } else {
                                                            $attempted_group_id = $single_attempted_group->id;
                                                        }
                                                    }
                                                }

                                                $attempted_test_questions_data = array(
                                                    'test_id'          => $test_id,
                                                    'attempted_test_id' => $attempted_id,
                                                    'question_id'      => $question_id,
                                                    'question_status'  => $question_status,
                                                    'correct_answer'   => $correct_answer,
                                                    'correct_answer_col'    => $correct_answer_col,
                                                    'solution'              => $solution,

                                                    'question'         => $question_data->question,
                                                    'option_1'         => $question_data->option_1,
                                                    'option_2'         => $question_data->option_2,
                                                    'option_3'         => $question_data->option_3,
                                                    'option_4'         => $question_data->option_4,
                                                    'answer'           => $student_answer_text,
                                                    'positive_mark'    => $question_data->positive_mark,
                                                    'negative_mark'    => $question_data->negative_mark,

                                                    'received_positive_marks'   =>  $single_received_positive_marks,
                                                    'received_negative_marks'   =>  $single_received_negative_marks,
                                                    'received_marks'            =>  $single_received_marks,

                                                    'type'              =>  $question_data->type,
                                                    'correct_answer_image'     => $correct_answer_image,
                                                    'answer_image'           => $answer_image,
                                                    'group_id'          =>  $question_data->group_id,
                                                    'attempted_group_id' =>  $attempted_group_id,
                                                    'group_type'        =>  $question_data->group_type,
                                                    'question_image'    =>  $question_data->question_image,
                                                    'option_1_image'    =>  $question_data->option_1_image,
                                                    'option_2_image'    =>  $question_data->option_2_image,
                                                    'option_3_image'    =>  $question_data->option_3_image,
                                                    'option_4_image'    =>  $question_data->option_4_image,

                                                    'created_on'       => date('Y-m-d H:i:s'),
                                                );
                                                $this->db->insert('tbl_attempted_test_questions', $attempted_test_questions_data);

                                                $received_positive_marks += $single_received_positive_marks;
                                                $received_negative_marks += $single_received_negative_marks;
                                                $received_total_marks += $single_received_marks;
                                            }
                                        }
                                    }

                                    $calculated_received_total_marks = $received_positive_marks - $received_negative_marks;
                                    $marks_array = array(
                                        'received_positive_marks'   =>  $received_positive_marks,
                                        'received_negative_marks'   =>  $received_negative_marks,
                                        'received_total_marks'      =>  $calculated_received_total_marks,
                                        'result'                    =>  '1',
                                    );
                                    $this->db->where('id', $attempted_id);
                                    $this->db->update('tbl_attempted_test', $marks_array);
                                } else {
                                    $submitted_on = $request['submitted_on'] != "" ? date('Y-m-d H:i:s', strtotime($request['submitted_on'])) : date('Y-m-d H:i:s');
                                    $attempted_test_data = array(
                                        'user_id'       =>  $user_id,
                                        'parent_module' =>  $parent_module,
                                        'test_id'       =>  $test_id,
                                        'submited_on'   =>  $submitted_on,
                                        'topic'         =>  $single_test->topic,
                                        'short_note'            =>  $single_test->short_note,
                                        'short_description'     =>  $single_test->short_description,
                                        'duration'              =>  $single_test->duration,
                                        'description'           =>  $single_test->description,
                                        'total_questions'       =>  $single_test->total_questions,
                                        'total_marks'           =>  $single_test->total_marks,
                                        'created_on'    => date('Y-m-d H:i:s'),
                                    );
                                    $this->db->insert('tbl_attempted_test', $attempted_test_data);
                                    $attempted_id = $this->db->insert_id();

                                    foreach ($answer_list as $answer) {
                                        $single_received_positive_marks = 0;
                                        $single_received_negative_marks = 0;
                                        $single_received_marks = 0;
                                        $question_id = $answer['question_id'];
                                        $student_answer = $answer['student_answer'];
                                        $answer_image = '';
                                        $student_answer_text = '';
                                        $correct_answer_image = '';
                                        $this->db->where('id', $question_id);
                                        $this->db->where('is_deleted', '0');
                                        $question_data = $this->db->get('tbl_test_questions')->row();
                                        if (!empty($question_data)) {
                                            $correct_answer = $question_data->answer;
                                            $correct_answer_col = $question_data->answer_column;
                                            $solution = $question_data->solution;
                                            if ($student_answer == '') {
                                                $question_status = '0';
                                                $single_received_positive_marks = 0;
                                                $single_received_negative_marks = 0;
                                            } else {
                                                if ($student_answer == $correct_answer_col) {
                                                    $question_status = '1';
                                                    $single_received_positive_marks = $question_data->positive_mark != "" ? (int)$question_data->positive_mark : 0;
                                                    $single_received_negative_marks = 0;
                                                } else {
                                                    $question_status = '2';
                                                    $single_received_positive_marks = 0;
                                                    $single_received_negative_marks = $question_data->negative_mark != "" ? (int)$question_data->negative_mark : 0;
                                                }
                                                if ($student_answer == 'option_1') {
                                                    $answer_image = $question_data->option_1_image;
                                                    $student_answer_text = $question_data->option_1;
                                                } elseif ($student_answer == 'option_2') {
                                                    $answer_image = $question_data->option_2_image;
                                                    $student_answer_text = $question_data->option_2;
                                                } elseif ($student_answer == 'option_3') {
                                                    $answer_image = $question_data->option_3_image;
                                                    $student_answer_text = $question_data->option_3;
                                                } elseif ($student_answer == 'option_4') {
                                                    $answer_image = $question_data->option_4_image;
                                                    $student_answer_text = $question_data->option_4;
                                                }
                                            }

                                            if ($question_data->answer_column == 'option_1') {
                                                $correct_answer_image = $question_data->option_1_image;
                                            } elseif ($question_data->answer_column == 'option_2') {
                                                $correct_answer_image = $question_data->option_2_image;
                                            } elseif ($question_data->answer_column == 'option_3') {
                                                $correct_answer_image = $question_data->option_3_image;
                                            } elseif ($question_data->answer_column == 'option_4') {
                                                $correct_answer_image = $question_data->option_4_image;
                                            }

                                            $single_received_marks = $single_received_positive_marks - $single_received_negative_marks;

                                            $attempted_group_id = '';
                                            if ($question_data->type == '2') {
                                                $this->db->where('is_deleted', '0');
                                                $this->db->where('status', '1');
                                                $this->db->where('id', $question_data->group_id);
                                                $single_group = $this->db->get('tbl_test_groups')->row();
                                                if (!empty($single_group)) {
                                                    $this->db->where('is_deleted', '0');
                                                    $this->db->where('status', '1');
                                                    $this->db->where('test_id', $test_id);
                                                    $this->db->where('group_id', $single_group->id);
                                                    $this->db->where('attempted_test_id', $attempted_id);
                                                    $single_attempted_group = $this->db->get('tbl_attempted_test_groups')->row();
                                                    if (empty($single_attempted_group)) {
                                                        $single_attempted_group_data = array(
                                                            'group_id'          =>  $single_group->id,
                                                            'test_id'           =>  $test_id,
                                                            'attempted_test_id' =>  $attempted_id,
                                                            'group_type'        =>  $single_group->group_type,
                                                            'group_title'       =>  $single_group->group_title,
                                                            'group_description' =>  $single_group->group_description,
                                                            'group_image'       =>  $single_group->group_image,
                                                            'created_on'        =>  date('Y-m-d H:i:s')
                                                        );
                                                        $this->db->insert('tbl_attempted_test_groups', $single_attempted_group_data);
                                                        $attempted_group_id = $this->db->insert_id();
                                                    } else {
                                                        $attempted_group_id = $single_attempted_group->id;
                                                    }
                                                }
                                            }

                                            $attempted_test_questions_data = array(
                                                'test_id'          => $test_id,
                                                'attempted_test_id' => $attempted_id,
                                                'question_id'      => $question_id,
                                                'question_status'  => $question_status,
                                                'correct_answer'   => $correct_answer,
                                                'correct_answer_col'    => $correct_answer_col,
                                                'solution'              => $solution,

                                                'question'         => $question_data->question,
                                                'option_1'         => $question_data->option_1,
                                                'option_2'         => $question_data->option_2,
                                                'option_3'         => $question_data->option_3,
                                                'option_4'         => $question_data->option_4,
                                                'answer'           => $student_answer_text,
                                                'correct_answer_image'     => $correct_answer_image,
                                                'answer_image'           => $answer_image,
                                                'positive_mark'    => $question_data->positive_mark,
                                                'negative_mark'    => $question_data->negative_mark,

                                                'received_positive_marks'   =>  $single_received_positive_marks,
                                                'received_negative_marks'   =>  $single_received_negative_marks,
                                                'received_marks'            =>  $single_received_marks,

                                                'type'              =>  $question_data->type,
                                                'group_id'          =>  $question_data->group_id,
                                                'attempted_group_id' =>  $attempted_group_id,
                                                'group_type'        =>  $question_data->group_type,
                                                'question_image'    =>  $question_data->question_image,
                                                'option_1_image'    =>  $question_data->option_1_image,
                                                'option_2_image'    =>  $question_data->option_2_image,
                                                'option_3_image'    =>  $question_data->option_3_image,
                                                'option_4_image'    =>  $question_data->option_4_image,

                                                'created_on'       => date('Y-m-d H:i:s'),
                                            );
                                            $this->db->insert('tbl_attempted_test_questions', $attempted_test_questions_data);

                                            $received_positive_marks += $single_received_positive_marks;
                                            $received_negative_marks += $single_received_negative_marks;
                                            $received_total_marks += $single_received_marks;
                                        }
                                    }

                                    $calculated_received_total_marks = $received_positive_marks - $received_negative_marks;
                                    $marks_array = array(
                                        'received_positive_marks'   =>  $received_positive_marks,
                                        'received_negative_marks'   =>  $received_negative_marks,
                                        'received_total_marks'      =>  $calculated_received_total_marks,
                                        'result'                    => '1',
                                    );
                                    $this->db->where('id', $attempted_id);
                                    $this->db->update('tbl_attempted_test', $marks_array);
                                }
                            }

                            $type = '3';
                            $app_message = "Hello, " . $single->full_name . "!\n\n🎉 Your test submitted successfully!";
                            $title = 'Test Submit Successfull';
                            $notification_data = [
                                "landing_page"  => 'test_result_page',
                                "redirect_id"   => (string)$attempted_id
                            ];

                            $this->Notification_model->send_notification($app_message, $title, $notification_data, $type, $user_id);

                            $json_arr['status'] = 'true';
                            $json_arr['message'] = 'Success';
                            $json_arr['data'] = ['attempted_id' => $attempted_id];
                        } else {
                            $json_arr['status'] = 'false';
                            $json_arr['message'] = 'Test questions count mismatch. Total ' . $total_questions . ' questions expected but received ' . $answer_list . ' questions.';
                            $json_arr['data'] = [];
                        }
                    } else {
                        $json_arr['status'] = 'false';
                        $json_arr['message'] = 'Test not found';
                        $json_arr['data'] = [];
                    }
                } else {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'User not found';
                    $json_arr['data'] = [];
                }
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Login not available.';
                $json_arr['data'] = [];
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Request not found.';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
    }

    public function getTestResult_overview()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        if ($request) {
            if (!empty($request['login_id']) && !empty($request['attempted_test_id'])) {
                $user_id = $request['login_id'];
                $test_id = $request['test_id'];
                $attempted_test_id = $request['attempted_test_id'];
                $parent_module = $request['parent_module'];

                $this->db->where('id', $attempted_test_id);
                $this->db->where('parent_module', $parent_module);
                $this->db->where('user_id', $user_id);
                $this->db->where('test_id', $test_id);
                $this->db->where('is_deleted', '0');
                $attempted_data = $this->db->get('tbl_attempted_test')->row();

                if (empty($attempted_data)) {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'Test details not found';
                    $json_arr['data'] = [];
                    echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
                    return;
                }

                $this->db->where('attempted_test_id', $attempted_test_id);
                $this->db->where('test_id', $test_id);
                $this->db->where('is_deleted', '0');
                $this->db->where('question_status', '1');
                $correct = $this->db->get('tbl_attempted_test_questions')->num_rows();

                $this->db->where('attempted_test_id', $attempted_test_id);
                $this->db->where('test_id', $test_id);
                $this->db->where('is_deleted', '0');
                $this->db->where('question_status', '2');
                $incorrect = $this->db->get('tbl_attempted_test_questions')->num_rows();

                $this->db->where('attempted_test_id', $attempted_test_id);
                $this->db->where('test_id', $test_id);
                $this->db->where('is_deleted', '0');
                $this->db->where('question_status', '0');
                $unattempted = $this->db->get('tbl_attempted_test_questions')->num_rows();

                $total_questions = $attempted_data->total_questions != "" ? $attempted_data->total_questions : '0';
                $accuracy = $total_questions > 0 ? ($correct / $total_questions) * 100 : 0.00;

                $your_score = $attempted_data->received_total_marks != "" ? $attempted_data->received_total_marks : '0.00';
                $score_outfoff = $attempted_data->total_marks != "" ? (int)$attempted_data->total_marks : '0';

                $rank_outfoff = 0;
                $rank = 0;
                $percentile = 0.00;

                $this->db->where('test_id', $test_id);
                $this->db->where('parent_module', $parent_module);
                $this->db->where('is_deleted', '0');
                $total_users = $this->db->get('tbl_attempted_test')->num_rows();

                $this->db->select('received_total_marks');
                $this->db->where('test_id', $test_id);
                $this->db->where('parent_module', $parent_module);
                $this->db->where('is_deleted', '0');
                $scores_query = $this->db->get('tbl_attempted_test');
                $scores = $scores_query->result_array();

                // Sort scores in descending order to calculate rank
                $all_scores = array_column($scores, 'received_total_marks');
                arsort($all_scores);

                // Calculate user's rank
                $user_score = $your_score;
                $rank = array_search($user_score, $all_scores) + 1;

                // Calculate percentile
                $rank_outfoff = $total_users;
                $percentile = ($rank / $rank_outfoff) * 100;

                $percentile = round($percentile, 2);

                $response = array(
                    'your_score'        => $your_score,
                    'score_outfoff'     => $score_outfoff,
                    'rank'              => $rank,
                    'rank_outfoff'      => $rank_outfoff,
                    'percentile'  => $percentile,
                    'correct'     => $correct,
                    'incorrect'   => $incorrect,
                    'unattempted' => $unattempted,
                    'total_questions'   => $total_questions,
                    'accuracy'    => $accuracy,
                );
                $json_arr['status'] = 'true';
                $json_arr['message'] = 'Success';
                $json_arr['data'] = $response;
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Login ID or Attempted Test ID not provided';
                $json_arr['data'] = [];
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Invalid request';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
    }

    public function getTestResult_solutions()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        if ($request) {
            if (!empty($request['login_id']) && !empty($request['attempted_test_id'])) {
                $user_id = $request['login_id'];
                $test_id = $request['test_id'];
                $attempted_test_id = $request['attempted_test_id'];
                $parent_module = $request['parent_module'];

                $this->db->where('id', $attempted_test_id);
                $this->db->where('parent_module', $parent_module);
                $this->db->where('user_id', $user_id);
                $this->db->where('test_id', $test_id);
                $this->db->where('is_deleted', '0');
                $attempted_data = $this->db->get('tbl_attempted_test')->row();

                if (empty($attempted_data)) {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'Test details not found';
                    $json_arr['data'] = [];
                    echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
                    return;
                }

                $this->db->select('tbl_attempted_test_questions.question,tbl_attempted_test_questions.question_image,tbl_attempted_test_questions.answer,tbl_attempted_test_questions.answer_image,tbl_attempted_test_questions.correct_answer_image,tbl_attempted_test_questions.correct_answer,tbl_attempted_test_questions.solution,tbl_attempted_test_questions.type as question_type,tbl_attempted_test_questions.attempted_group_id as group_id,tbl_attempted_test_groups.group_type,tbl_attempted_test_groups.group_title,tbl_attempted_test_groups.group_description,tbl_attempted_test_groups.group_image');
                $this->db->join('tbl_attempted_test_groups', 'tbl_attempted_test_groups.id = tbl_attempted_test_questions.attempted_group_id', 'left');
                $this->db->where('tbl_attempted_test_questions.attempted_test_id', $attempted_test_id);
                $this->db->where('tbl_attempted_test_questions.test_id', $test_id);
                $this->db->where('tbl_attempted_test_questions.is_deleted', '0');
                $all_questions = $this->db->get('tbl_attempted_test_questions')->result();

                $json_arr['status'] = 'true';
                $json_arr['message'] = 'Success';
                $json_arr['data'] = $all_questions;
                $json_arr['group_image_base'] = base_url() . 'assets/uploads/master_gallary/';
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Login ID or Attempted Test ID not provided';
                $json_arr['data'] = [];
                $json_arr['group_image_base'] = '';
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Invalid request';
            $json_arr['data'] = [];
            $json_arr['group_image_base'] = '';
        }
        echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
    }
    public function getTestGroupDetails()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        if ($request) {
            if (!empty($request['login_id']) && !empty($request['test_id'])) {
                $user_id = $request['login_id'];
                $test_id = $request['test_id'];
                $attempted_test_id = isset($request['attempted_test_id']) ? $request['attempted_test_id'] : '';
                $parent_module = isset($request['attempted_test_id']) ? $request['parent_module'] : '';
                $group_id = isset($request['group_id']) ? $request['group_id'] : '';
                $attempted_group_id = isset($request['attempted_group_id']) ? $request['attempted_group_id'] : '';

                if ($attempted_test_id != "") {
                    $this->db->where('id', $attempted_test_id);
                    if ($parent_module != "") {
                        $this->db->where('parent_module', $parent_module);
                    }
                    $this->db->where('user_id', $user_id);
                    $this->db->where('test_id', $test_id);
                    $this->db->where('is_deleted', '0');
                    $attempted_data = $this->db->get('tbl_attempted_test')->row();

                    if (empty($attempted_data)) {
                        $json_arr['status'] = 'false';
                        $json_arr['message'] = 'Test details not found';
                        $json_arr['data'] = [];
                        echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
                        return;
                    }

                    $this->db->select('tbl_attempted_test_groups.group_type,tbl_attempted_test_groups.group_title,tbl_attempted_test_groups.group_description,tbl_attempted_test_groups.group_image');
                    $this->db->where('tbl_attempted_test_groups.attempted_test_id', $attempted_test_id);
                    $this->db->where('tbl_attempted_test_groups.test_id', $test_id);
                    if ($group_id != "") {
                        $this->db->where('tbl_attempted_test_groups.group_id', $group_id);
                    }
                    if ($attempted_group_id != "") {
                        $this->db->where('tbl_attempted_test_groups.id', $attempted_group_id);
                    }
                    $this->db->where('tbl_attempted_test_groups.is_deleted', '0');
                    $all_questions = $this->db->get('tbl_attempted_test_groups')->result();
                } else {
                    $this->db->select('tbl_test_groups.group_type,tbl_test_groups.group_title,tbl_test_groups.group_description,tbl_test_groups.group_image');
                    $this->db->where('tbl_test_groups.test_id', $test_id);
                    if ($group_id != "") {
                        $this->db->where('tbl_test_groups.id', $group_id);
                    }
                    $this->db->where('tbl_test_groups.is_deleted', '0');
                    $all_questions = $this->db->get('tbl_test_groups')->result();
                }

                $json_arr['status'] = 'true';
                $json_arr['message'] = 'Success';
                $json_arr['data'] = $all_questions;
                $json_arr['group_image_base'] = base_url() . 'assets/uploads/master_gallary/';
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Login ID and Test ID required';
                $json_arr['data'] = [];
                $json_arr['group_image_base'] = '';
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Invalid request';
            $json_arr['data'] = [];
            $json_arr['group_image_base'] = '';
        }
        echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
    }

    public function getTestResult_questions_details()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        if ($request) {
            if (!empty($request['login_id']) && !empty($request['attempted_test_id'])) {
                $user_id = $request['login_id'];
                $test_id = $request['test_id'];
                $attempted_test_id = $request['attempted_test_id'];
                $parent_module = $request['parent_module'];
                $question_status = $request['question_status'];

                if ($question_status == "") {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'Question Status not available';
                    $json_arr['data'] = [];
                    echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
                    return;
                }

                $this->db->where('id', $attempted_test_id);
                $this->db->where('parent_module', $parent_module);
                $this->db->where('user_id', $user_id);
                $this->db->where('test_id', $test_id);
                $this->db->where('is_deleted', '0');
                $attempted_data = $this->db->get('tbl_attempted_test')->row();

                if (empty($attempted_data)) {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'Test details not found';
                    $json_arr['data'] = [];
                    echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
                    return;
                }

                $this->db->select('question,option_1,option_2,option_3,option_4,answer as student_answer_option, correct_answer_col as correct_answer_option,correct_answer');
                $this->db->where('attempted_test_id', $attempted_test_id);
                $this->db->where('test_id', $test_id);
                $this->db->where('is_deleted', '0');
                $this->db->where('question_status', $question_status);
                $all_questions = $this->db->get('tbl_attempted_test_questions')->result();

                if (empty($all_questions)) {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'Questions not found';
                    $json_arr['data'] = [];
                    echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
                    return;
                }

                $json_arr['status'] = 'true';
                $json_arr['message'] = 'Success';
                $json_arr['data'] = $all_questions;
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Login ID or Attempted Test ID not provided';
                $json_arr['data'] = [];
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Invalid request';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
    }

    public function get_manage_test_series_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $offset = $request['offset'];
        $limit = $request['limit'];
        $user_id = isset($request['login_id']) ? $request['login_id'] : '';

        $this->db->select('id, title, description, sub_headings, banner_image, mrp, sale_price, discount, status, usage_count, created_at, updated_at');
        $this->db->from('test_series');
        $this->db->limit($limit, $offset);

        $exist = $this->db->get()->result();

        if (!empty($exist)) {
            foreach ($exist as &$row) {
                $is_test_series_bought = '0';
                $test_series_bought_id = '';

                $this->db->where('is_deleted', '0');
                $this->db->where('user_id', $user_id);
                $this->db->where('test_id', $row->id);
                $course_bought = $this->db->get('tbl_bought_test_series')->row();
                if (!empty($course_bought)) {
                    $is_test_series_bought = '1';
                    $test_series_bought_id = $course_bought->id;
                }
                $row->is_test_series_bought = $is_test_series_bought;
                $row->test_series_bought_id = $test_series_bought_id;
            }
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'Test Series retrieved successfully.';
            $json_arr['image_path'] = base_url();
            $json_arr['data'] = $exist;
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'No Test Series available.';
            $json_arr['image_path'] = base_url();
            $json_arr['data'] = [];
        }


        echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
    }

    public function get_single_test_series_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $test_id = $request['test_id'];
        $user_id = $request['login_id'];
        // $offset = $request['offset'];
        // $limit = $request['limit'];

        $this->db->select('id, title, description, sub_headings,tagline,prakaran_lecture,validity, banner_image, mrp, sale_price, discount, status, usage_count, created_at, updated_at');
        $this->db->from('test_series');
        // $this->db->limit($limit, $offset);
        $this->db->where('id', $test_id);

        $exist = $this->db->get()->row();

        if (!empty($exist)) {
            $is_test_series_bought = '0';
            $test_series_bought_id = '';

            $this->db->where('is_deleted', '0');
            $this->db->where('user_id', $user_id);
            $this->db->where('test_id', $exist->id);
            $course_bought = $this->db->get('tbl_bought_test_series')->row();

            if (!empty($course_bought)) {
                $is_test_series_bought = '1';
                $test_series_bought_id = $course_bought->id;
            }

            $exist->is_test_series_bought = $is_test_series_bought;
            $exist->test_series_bought_id = $test_series_bought_id;

            $json_arr['status'] = 'true';
            $json_arr['message'] = 'Test Series details retrieved successfully.';
            $json_arr['image_path'] = base_url();
            $json_arr['data'] = $exist;
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'No test series available.';
            $json_arr['image_path'] = base_url();
            $json_arr['data'] = [];
        }

        echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
    }


    // public function get_single_test_series_api()
    // {
    //     $request = json_decode(file_get_contents('php://input'), true);
    //     $test_id = $request['test_id'];
    //     if ($request) {
    //         if (!empty($request['login_id'])) {
    //             $user_id = $request['login_id'];
    //             $this->db->where('login_id', $user_id);
    //             $single = $this->db->get('user_login')->row();
    //             if (!empty($single)) {
    //                 $this->db->select('id, title, description, sub_headings, banner_image, mrp, sale_price, discount, status, usage_count, created_at, updated_at');
    //                 $this->db->from('test_series');
    //                 $this->db->where('id', $test_id);
    //                 $exist = $this->db->get()->row();
    //                 if (!empty($exist)) {
    //                     foreach ($exist as &$row) {
    //                         $is_course_bought = '0';
    //                         $course_bought_id = '';

    //                         $this->db->where('is_deleted', '0');
    //                         $this->db->where('user_id', $user_id);
    //                         $this->db->where('test_id', $row->id);
    //                         $course_bought = $this->db->get('tbl_bought_test_series')->row();
    //                         if (!empty($course_bought)) {
    //                             $is_course_bought = '1';
    //                             $course_bought_id = $course_bought->id;
    //                         }

    //                         $row->is_course_bought = $is_course_bought;
    //                         $row->course_bought_id = $course_bought_id;
    //                     }
    //                     $json_arr['status'] = 'true';
    //                     $json_arr['message'] = 'Test Series details retrieved successfully.';
    //                     $json_arr['image_path'] = base_url();
    //                     $json_arr['data'] = $exist;
    //                 } else {
    //                     $json_arr['status'] = 'false';
    //                     $json_arr['message'] = 'No Test Series available.';
    //                     $json_arr['image_path'] = base_url();
    //                     $json_arr['data'] = [];
    //                 }
    //             } else {
    //                 $json_arr['status'] = 'false';
    //                 $json_arr['message'] = 'User not found';
    //                 $json_arr['data'] = [];
    //             }
    //         } else {
    //             $json_arr['status'] = 'false';
    //             $json_arr['message'] = 'Login not available.';
    //             $json_arr['data'] = [];
    //         }
    //     } else {
    //         $json_arr['status'] = 'false';
    //         $json_arr['message'] = 'Request not found.';
    //         $json_arr['data'] = [];
    //     }
    //     echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
    // }

    public function buy_test_series()
    {
        $request = json_decode(file_get_contents('php://input'), true);

        if ($request) {
            if (!empty($request['login_id'])) {
                $user_id = $request['login_id'];
                $test_id = isset($request['test_id']) ? $request['test_id'] : '';
                $transaction_id = isset($request['transaction_id']) ? $request['transaction_id'] : '';
                $this->db->where('login_id', $user_id);
                $single = $this->db->get('user_login')->row();
                if (!empty($single)) {
                    if ($test_id != "") {
                        $this->db->select('test_series.*');
                        $this->db->from('test_series');
                        $this->db->where('id', $test_id);
                        $result = $this->db->get();
                        $test_series_data = $result->row();

                        if (!empty($test_series_data)) {
                            $payment_status = $request['payment_status'];
                            $is_coupon_applied = $request['is_coupon_applied'];
                            $applied_coupon_id = $request['applied_coupon_id'];
                            $payment_amount = $request['payment_amount'];
                            if ($payment_status == '1') {
                                $mrp = $test_series_data->mrp != "" ? (float)$test_series_data->mrp : 0;
                                $test_series_course_discount = $test_series_data->discount != "" ? (float)$test_series_data->discount : 0;
                                $sale_price = $test_series_data->sale_price != "" ? (float)$test_series_data->sale_price : 0;
                                $coupon_discount_amount = 0;
                                $coupons_discount_type = null;
                                $discount = 0;
                                if ($is_coupon_applied == '1') {
                                    $this->db->where('id', $applied_coupon_id);
                                    $coupons = $this->db->get('tbl_coupons')->row();
                                    if (!empty($coupons)) {
                                        $applied_coupon_id = $coupons->id;
                                        $discount = $coupons->discount != "" ? $coupons->discount : 0;
                                        if ($coupons->discount_type == '0') {
                                            $coupon_discount_amount = $mrp * $discount;
                                        } elseif ($coupons->discount_type == '1') {
                                            $coupon_discount_amount = $discount;
                                        } else {
                                            $coupon_discount_amount = 0;
                                        }
                                    }
                                }
                                $original_sale_pice = $sale_price - $coupon_discount_amount;
                                $total_discount_amount = $coupon_discount_amount + $test_series_course_discount;
                                if ($payment_amount == $original_sale_pice) {
                                    $buy_data = array(
                                        'user_id'           => $user_id,
                                        'test_id'         => $test_id,
                                        'test_series_course_mrp'        => $mrp,
                                        'test_series_course_discount'   => $test_series_course_discount,
                                        'test_series_course_buy_price'  => $sale_price,
                                        'payment_status'    => $payment_status,
                                        'is_coupon_applied' => $is_coupon_applied,
                                        'applied_coupon_id' => $applied_coupon_id,
                                        'coupon_discount_type'      => $coupons_discount_type,
                                        'coupon_discount'           => $discount,
                                        'coupon_discount_amount'    => $coupon_discount_amount,
                                        'total_discount_amount'     => $total_discount_amount,
                                        'payment_amount'    => $payment_amount,
                                        'transaction_id'    => $transaction_id,
                                        'created_on'        => date('Y-m-d H:i:s'),
                                        'payment_on'        => date('Y-m-d H:i:s'),
                                    );
                                    // print_r($buy_data);
                                    // exit;
                                    $this->db->insert('tbl_bought_test_series', $buy_data);
                                    $insert_id = $this->db->insert_id();

                                    $my_buy_data = array(
                                        'user_id'           => $user_id,
                                        'type'              => '0',
                                        'primary_table_id'  => $insert_id,
                                        'primary_table'     => 'tbl_bought_test_series',
                                        'content_primary_table_id'  => $test_id,
                                        'content_primary_table'     => 'test_series',
                                        'payment_amount'    => $payment_amount,
                                        'transaction_id'    => $transaction_id,
                                        'payment_status'    => $payment_status,
                                        'content_status'    => '1',
                                        'created_on'        => date('Y-m-d H:i:s'),
                                        'payment_on'        => date('Y-m-d H:i:s'),
                                    );
                                    $this->db->insert('tbl_user_contents', $my_buy_data);
                                    $content_id = $this->db->insert_id();

                                    $payment_data = array(
                                        'user_id'           => $user_id,
                                        'payment_for'       => '2',
                                        'payment_on'        => date('Y-m-d H:i:s'),
                                        'transaction_id'    => $transaction_id,
                                        'payment_status'    => $payment_status,
                                        'payment_amount'    => $payment_amount,
                                        'primary_table_id'  => $insert_id,
                                        'primary_table_name' => 'tbl_bought_test_series'
                                    );
                                    $payment_id = $this->set_user_payment($payment_data);

                                    $this->db->where('id', $insert_id);
                                    $this->db->update('tbl_bought_test_series', array('payment_table_id' => $payment_id));

                                    $type = '2';
                                    $app_message = "Hello, " . $single->full_name . "!\n\n🎉 Your test series payment successful!";
                                    $title = 'Test Series payment Successfull';
                                    $notification_data = [
                                        "landing_page"  => 'my_contents',
                                        "redirect_id"   => (string)$content_id
                                    ];

                                    $this->Notification_model->send_notification($app_message, $title, $notification_data, $type, $user_id);

                                    $json_arr['status'] = 'true';
                                    $json_arr['message'] = 'Success';
                                    $json_arr['data'] = [$insert_id];
                                } else {
                                    $json_arr['status'] = 'false';
                                    $json_arr['message'] = 'Payment amount is not correct. It should be Rs. ' . $original_sale_pice;
                                    $json_arr['data'] = [];
                                }
                            } else {
                                $json_arr['status'] = 'false';
                                $json_arr['message'] = 'Payment is not successfull';
                                $json_arr['data'] = [];
                            }
                        } else {
                            $json_arr['status'] = 'false';
                            $json_arr['message'] = 'Test Series Details not found';
                            $json_arr['data'] = [];
                        }
                    } else {
                        $json_arr['status'] = 'false';
                        $json_arr['message'] = 'Course ID Required';
                        $json_arr['data'] = [];
                    }
                } else {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'User not found';
                    $json_arr['data'] = [];
                }
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Login not available.';
                $json_arr['data'] = [];
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Request not found.';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
    }

    public function buy_membership()
    {
        $request = json_decode(file_get_contents('php://input'), true);

        if ($request) {
            if (!empty($request['login_id'])) {
                $user_id = $request['login_id'];
                $memership_id = isset($request['membership_id']) ? $request['membership_id'] : '';
                $transaction_id = isset($request['transaction_id']) ? $request['transaction_id'] : '';
                $this->db->where('login_id', $user_id);
                $single = $this->db->get('user_login')->row();
                if (!empty($single)) {
                    if ($memership_id != "") {
                        $this->db->select('membership_plans.*');
                        $this->db->from('membership_plans');
                        $this->db->where('id', $memership_id);
                        $result = $this->db->get();
                        $test_series_data = $result->row();

                        if (!empty($test_series_data)) {
                            $payment_status = $request['payment_status'];
                            $is_coupon_applied = $request['is_coupon_applied'];
                            $applied_coupon_id = $request['applied_coupon_id'];
                            $payment_amount = $request['payment_amount'];
                            if ($payment_status == '1') {
                                $mrp = $test_series_data->actual_price != "" ? (float)$test_series_data->actual_price : 0;
                                $test_series_course_discount_rate = $test_series_data->discount_per != "" ? (float)$test_series_data->discount_per : 0;
                                $test_series_course_discount = ($test_series_course_discount_rate * $mrp / 100);
                                $sale_price = $test_series_data->price != "" ? (float)$test_series_data->price : 0;
                                $coupon_discount_amount = 0;
                                $coupons_discount_type = null;
                                $discount = 0;
                                if ($is_coupon_applied == '1') {
                                    $this->db->where('id', $applied_coupon_id);
                                    $coupons = $this->db->get('tbl_coupons')->row();
                                    if (!empty($coupons)) {
                                        $applied_coupon_id = $coupons->id;
                                        $discount = $coupons->discount != "" ? $coupons->discount : 0;
                                        if ($coupons->discount_type == '0') {
                                            $coupon_discount_amount = $mrp * $discount;
                                        } elseif ($coupons->discount_type == '1') {
                                            $coupon_discount_amount = $discount;
                                        } else {
                                            $coupon_discount_amount = 0;
                                        }
                                    }
                                }
                                $original_sale_pice = $sale_price - $coupon_discount_amount;
                                $total_discount_amount = $coupon_discount_amount + $test_series_course_discount;
                                if ($payment_amount == $original_sale_pice) {
                                    $start_date = (new DateTime())->format('Y-m-d');
                                    $end_date = (new DateTime())->add(new DateInterval('P' . $test_series_data->no_of_months . 'M'))->format('Y-m-d');

                                    $buy_data = array(
                                        'login_id'              => $user_id,
                                        'membership_id'         => $memership_id,

                                        'start_date'            => $start_date,
                                        'end_date'              => $end_date,
                                        'duration'              => $test_series_data->no_of_months,
                                        'amount'                => $payment_amount,

                                        'original_price'            => $mrp,
                                        'original_discount_rate'    => $test_series_course_discount_rate,
                                        'original_discount_amount'  => $test_series_course_discount,
                                        'original_sale_amount'      => $sale_price,

                                        'payment_status'            => $payment_status,
                                        'is_coupon_applied'         => $is_coupon_applied,
                                        'applied_coupon_id'         => $applied_coupon_id,
                                        'coupon_discount_type'      => $coupons_discount_type,
                                        'coupon_discount'           => $discount,
                                        'coupon_discount_amount'    => $coupon_discount_amount,
                                        'total_discount_amount'     => $total_discount_amount,

                                        'payment_id'                => $transaction_id,
                                        'created_on'        => date('Y-m-d H:i:s'),
                                        'payment_on'        => date('Y-m-d H:i:s'),
                                    );
                                    $this->db->insert('tbl_my_membership', $buy_data);
                                    $insert_id = $this->db->insert_id();

                                    $payment_data = array(
                                        'user_id'           => $user_id,
                                        'payment_for'       => '0',
                                        'payment_on'        => date('Y-m-d H:i:s'),
                                        'transaction_id'    => $transaction_id,
                                        'payment_status'    => $payment_status,
                                        'payment_amount'    => $payment_amount,
                                        'primary_table_id'  => $insert_id,
                                        'primary_table_name' => 'tbl_my_membership'
                                    );
                                    $payment_id = $this->set_user_payment($payment_data);

                                    $this->db->where('id', $insert_id);
                                    $this->db->update('tbl_my_membership', array('payment_table_id' => $payment_id));

                                    $this->db->where('login_id', $user_id);
                                    $this->db->update('user_login', array('my_membership_id' => $insert_id, 'start_date' => $start_date, 'end_date' => $end_date, 'membership_id' => $memership_id, 'is_active_membership' => '1'));

                                    $type = '0';
                                    $app_message = "Hello, " . $single->full_name . "!\n\n🎉 Your membership has been successfully activated!";
                                    $title = 'Membership Payment Successfull';
                                    $notification_data = [
                                        "landing_page"  => 'my_payments',
                                        "redirect_id"   => (string)$payment_id
                                    ];

                                    $this->Notification_model->send_notification($app_message, $title, $notification_data, $type, $user_id);

                                    $json_arr['status'] = 'true';
                                    $json_arr['message'] = 'Success';
                                    $json_arr['data'] = [$insert_id];
                                } else {
                                    $json_arr['status'] = 'false';
                                    $json_arr['message'] = 'Payment amount is not correct. It should be Rs. ' . $original_sale_pice;
                                    $json_arr['data'] = [];
                                }
                            } else {
                                $json_arr['status'] = 'false';
                                $json_arr['message'] = 'Payment is not successfull';
                                $json_arr['data'] = [];
                            }
                        } else {
                            $json_arr['status'] = 'false';
                            $json_arr['message'] = 'Membership Details not found';
                            $json_arr['data'] = [];
                        }
                    } else {
                        $json_arr['status'] = 'false';
                        $json_arr['message'] = 'Membership ID Required';
                        $json_arr['data'] = [];
                    }
                } else {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'User not found';
                    $json_arr['data'] = [];
                }
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Login not available.';
                $json_arr['data'] = [];
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Request not found.';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
    }

    public function user_payments()
    {
        $request = json_decode(file_get_contents('php://input'), true);

        if ($request) {
            if (!empty($request['login_id'])) {
                $user_id = $request['login_id'];
                $type = isset($request['type']) ? $request['type'] : '';
                $offset = isset($request['offset']) ? $request['offset'] : '';
                $limit = isset($request['limit']) ? $request['limit'] : '';
                $this->db->where('login_id', $user_id);
                $single = $this->db->get('user_login')->row();
                if (!empty($single)) {
                    $this->db->select('id,payment_for,payment_on,transaction_id,payment_status,payment_amount');
                    $this->db->where('user_id', $user_id);
                    if ($type != "") {
                        $this->db->where('payment_for', $type);
                    }
                    if ($limit != "" && $offset != "") {
                        $this->db->limit($limit, $offset);
                    }
                    $this->db->where('is_deleted', '0');
                    $this->db->order_by('payment_on', 'desc');
                    $result = $this->db->get('tbl_user_payments');
                    $test_series_data = $result->result();

                    if (!empty($test_series_data)) {
                        $json_arr['status'] = 'true';
                        $json_arr['message'] = 'Success';
                        $json_arr['data'] = $test_series_data;
                    } else {
                        $json_arr['status'] = 'false';
                        $json_arr['message'] = 'Payments not available';
                        $json_arr['data'] = [];
                    }
                } else {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'User not found';
                    $json_arr['data'] = [];
                }
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Login not available.';
                $json_arr['data'] = [];
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Request not found.';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
    }

    public function user_notifications()
    {
        $request = json_decode(file_get_contents('php://input'), true);

        if ($request) {
            if (!empty($request['login_id'])) {
                $user_id = $request['login_id'];
                $type = isset($request['type']) ? $request['type'] : '';
                $offset = isset($request['offset']) ? $request['offset'] : '';
                $limit = isset($request['limit']) ? $request['limit'] : '';
                $this->db->where('login_id', $user_id);
                $single = $this->db->get('user_login')->row();
                if (!empty($single)) {
                    $this->db->select('id,type,content,title,created_on');
                    $this->db->where('send_customer', $user_id);
                    if ($type != "") {
                        $this->db->where('type', $type);
                    }
                    if ($limit != "" && $offset != "") {
                        $this->db->limit($limit, $offset);
                    }
                    $this->db->where('is_deleted', '0');
                    $this->db->order_by('created_on', 'desc');
                    $result = $this->db->get('tbl_customer_notifications');
                    $test_series_data = $result->result();

                    if (!empty($test_series_data)) {
                        $json_arr['status'] = 'true';
                        $json_arr['message'] = 'Success';
                        $json_arr['data'] = $test_series_data;
                    } else {
                        $json_arr['status'] = 'false';
                        $json_arr['message'] = 'Notifications not available';
                        $json_arr['data'] = [];
                    }
                } else {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'User not found';
                    $json_arr['data'] = [];
                }
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Login not available.';
                $json_arr['data'] = [];
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Request not found.';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
    }

    public function user_payment_details()
    {
        $request = json_decode(file_get_contents('php://input'), true);

        if ($request) {
            if (!empty($request['login_id'])) {
                $user_id = $request['login_id'];
                $payment_id = isset($request['payment_id']) ? $request['payment_id'] : '';
                if ($payment_id != "") {
                    $this->db->where('login_id', $user_id);
                    $single = $this->db->get('user_login')->row();
                    if (!empty($single)) {
                        $this->db->select('id,payment_for,payment_on,transaction_id,payment_status,payment_amount');
                        $this->db->where('user_id', $user_id);
                        $this->db->where('id', $payment_id);
                        $this->db->where('is_deleted', '0');
                        $result = $this->db->get('tbl_user_payments');
                        $test_series_data = $result->row();

                        $data = [];
                        if (!empty($test_series_data)) {
                            $json_arr['status'] = 'true';
                            $json_arr['message'] = 'Success';
                            $json_arr['data'] = $data;
                        } else {
                            $json_arr['status'] = 'false';
                            $json_arr['message'] = 'Payment details not available';
                            $json_arr['data'] = [];
                        }
                    } else {
                        $json_arr['status'] = 'false';
                        $json_arr['message'] = 'User not found';
                        $json_arr['data'] = [];
                    }
                } else {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'Payment ID not available.';
                    $json_arr['data'] = [];
                }
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Login not available.';
                $json_arr['data'] = [];
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Request not found.';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
    }
    public function set_user_payment($array)
    {
        $date = array(
            'created_on'        => date('Y-m-d H:i:s')
        );
        $data = array_merge($array, $date);
        $this->db->insert('tbl_user_payments', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function get_test_series_pdf_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $test_id = $request['test_id'];
        $offset = $request['offset'];
        $limit = $request['limit'];

        $this->db->select('id, title, description,image_url, pdf_url, created_on,status');
        $this->db->from('test_series_pdf');
        $this->db->where('test_series_id', $test_id);
        // $this->db->where('source_type', 'test_series');
        // $this->db->where('type', 'Pdf');
        $this->db->limit($limit, $offset);
        $exist = $this->db->get()->result();
        if (!empty($exist)) {
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'Test Series PDF retrieved successfully.';
            $json_arr['image_path'] = base_url() . 'assets/uploads/test_series/pdf/';
            $json_arr['data'] = $exist;
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Test Series Pdf not available.';
            $json_arr['image_path'] = base_url() . 'assets/uploads/test_series/pdf/';
            $json_arr['data'] = [];
        }

        echo json_encode($json_arr);
    }

    public function get_test_series_test_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $test_id = $request['test_id'];
        $user_id = $request['login_id'];
        $offset = $request['offset'];
        $limit = $request['limit'];

        $this->db->from('test_series');
        $this->db->where('id', $test_id);
        $this->db->limit($limit, $offset);
        $exist = $this->db->get()->row();

        if (!empty($exist)) {
            if ($exist->tests != "") {
                $test = explode(',', $exist->tests);
                $tests = array();
                if (!empty($test)) {
                    for ($i = 0; $i < count($test); $i++) {
                        $this->db->where('id', $test[$i]);
                        $this->db->where('is_deleted', '0');
                        $single_test = $this->db->get('tbl_test_setups')->row();
                        if (!empty($single_test)) {
                            $this->db->where('test_id', $single_test->id);
                            $this->db->where('user_id', $user_id);
                            $this->db->where('is_deleted', '0');
                            $this->db->where('parent_module', 'testseries');
                            $attempted_test = $this->db->get('tbl_attempted_test')->row();
                            if (!empty($attempted_test)) {
                                $is_test_attempted = '1';
                                $attempted_test_id = $attempted_test->id;
                            } else {
                                $is_test_attempted = '0';
                                $attempted_test_id = '';
                            }

                            if ($single_test->show_ans == 'Yes') {
                                $show_correct_ans = '1';
                            } else {
                                $show_correct_ans = '0';
                            }

                            if ($single_test->download_test_pdf == 'Yes') {
                                $download_test_pdf = '1';
                                $test_pdf_link = $single_test->test_pdf != '' ? (base_url() . 'assets/uploads/test_pdfs/' . $single_test->test_pdf) : '';
                            } else {
                                $download_test_pdf = '0';
                                $test_pdf_link = '';
                            }

                            $tests[] = array(
                                'test_id'             =>  $exist->id,
                                'is_test_attempted'     =>  $is_test_attempted,
                                'attempted_test_id'     =>  $attempted_test_id,
                                'test_id'               =>  $single_test->id,
                                'topic'                 =>  $single_test->topic,
                                'short_note'            =>  $single_test->short_note,
                                'short_description'     =>  $single_test->short_description,
                                'duration'              =>  $single_test->duration,
                                'total_questions'       =>  $single_test->total_questions,
                                'total_marks'           =>  $single_test->total_marks,

                                'is_show_correct_ans'  => $show_correct_ans,
                                'is_download_test_pdf' => $download_test_pdf,
                                'test_pdf_link'        => $test_pdf_link,
                            );
                        }
                    }
                }

                if (!empty($tests)) {
                    $json_arr['status'] = 'true';
                    $json_arr['message'] = 'Test Series tests retrieved successfully.';
                    $json_arr['data'] = $tests;
                } else {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'Test Series tests not available.';
                    $json_arr['data'] = [];
                }
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Test Series tests not available.';
                $json_arr['data'] = [];
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Test Series not available.';
            $json_arr['data'] = [];
        }

        echo json_encode($json_arr);
    }

    public function current_affairs_category_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $user_id = $request['login_id'];
        $offset = $request['offset'];
        $limit = $request['limit'];

        $this->db->select('id, category_name');
        $this->db->from('current_affairs_category');
        $this->db->where('is_deleted', '0');
        $this->db->limit($limit, $offset);
        $exist = $this->db->get()->result();

        if (!empty($exist)) {
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'Current Affairs category retrieved successfully.';
            $json_arr['data'] = $exist;
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Current Affairs category not available.';
            $json_arr['data'] = [];
        }

        echo json_encode($json_arr);
    }
    public function get_current_affairs_test_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $category_id = isset($request['category_id']) && $request['category_id'] != "" ? $request['category_id'] : '';
        $user_id = $request['login_id'];
        $offset = $request['offset'];
        $limit = $request['limit'];

        if ($category_id != "") {
            $this->db->from('current_affairs_category');
            $this->db->where('tests !=', null);
            $this->db->where('is_deleted', '0');
            $this->db->where('id', $category_id);
            $exist = $this->db->get()->row();

            $all_tests = array();
            if (!empty($exist)) {
                $test = explode(',', $exist->tests);
                if (!empty($test)) {
                    $tests = array_slice($test, $offset, $limit);
                    for ($i = 0; $i < count($test); $i++) {
                        $this->db->where('id', $test[$i]);
                        $this->db->where('is_deleted', '0');
                        $single_test = $this->db->get('tbl_test_setups')->row();
                        if (!empty($single_test)) {
                            $this->db->where('test_id', $single_test->id);
                            $this->db->where('user_id', $user_id);
                            $this->db->where('is_deleted', '0');
                            $this->db->where('parent_module', 'currentaffair');
                            $attempted_test = $this->db->get('tbl_attempted_test')->row();
                            if (!empty($attempted_test)) {
                                $is_test_attempted = '1';
                                $attempted_test_id = $attempted_test->id;
                            } else {
                                $is_test_attempted = '0';
                                $attempted_test_id = '';
                            }

                            if ($single_test->show_ans == 'Yes') {
                                $show_correct_ans = '1';
                            } else {
                                $show_correct_ans = '0';
                            }

                            if ($single_test->download_test_pdf == 'Yes') {
                                $download_test_pdf = '1';
                                $test_pdf_link = $single_test->test_pdf != '' ? (base_url() . 'assets/uploads/test_pdfs/' . $single_test->test_pdf) : '';
                            } else {
                                $download_test_pdf = '0';
                                $test_pdf_link = '';
                            }

                            $all_tests[] = array(
                                'category_id'           =>  $exist->id,
                                'category_name'         =>  $exist->category_name,
                                'is_test_attempted'     =>  $is_test_attempted,
                                'attempted_test_id'     =>  $attempted_test_id,
                                'test_id'               =>  $single_test->id,
                                'topic'                 =>  $single_test->topic,
                                'short_note'            =>  $single_test->short_note,
                                'short_description'     =>  $single_test->short_description,
                                'duration'              =>  $single_test->duration,
                                'total_questions'       =>  $single_test->total_questions,
                                'total_marks'           =>  $single_test->total_marks,

                                'is_show_correct_ans'  => $show_correct_ans,
                                'is_download_test_pdf' => $download_test_pdf,
                                'test_pdf_link'        => $test_pdf_link,
                            );
                        }
                    }
                }

                if (!empty($all_tests)) {
                    $json_arr['status'] = 'true';
                    $json_arr['message'] = 'Test retrieved successfully.';
                    $json_arr['data'] = $all_tests;
                } else {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'Test not available.';
                    $json_arr['data'] = [];
                }
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Test not available.';
                $json_arr['data'] = [];
            }
        } else {
            $this->db->from('current_affairs_category');
            $this->db->where('tests !=', null);
            $this->db->where('is_deleted', '0');
            $all_exist = $this->db->get()->result();

            $tests = array();
            if (!empty($all_exist)) {
                foreach ($all_exist as $exist) {
                    $test = explode(',', $exist->tests);
                    if (!empty($test)) {
                        for ($i = 0; $i < count($test); $i++) {
                            $this->db->where('id', $test[$i]);
                            $this->db->where('is_deleted', '0');
                            $single_test = $this->db->get('tbl_test_setups')->row();
                            if (!empty($single_test)) {
                                $this->db->where('test_id', $single_test->id);
                                $this->db->where('user_id', $user_id);
                                $this->db->where('is_deleted', '0');
                                $this->db->where('parent_module', 'currentaffair');
                                $attempted_test = $this->db->get('tbl_attempted_test')->row();
                                if (!empty($attempted_test)) {
                                    $is_test_attempted = '1';
                                    $attempted_test_id = $attempted_test->id;
                                } else {
                                    $is_test_attempted = '0';
                                    $attempted_test_id = '';
                                }

                                if ($single_test->show_ans == 'Yes') {
                                    $show_correct_ans = '1';
                                } else {
                                    $show_correct_ans = '0';
                                }

                                if ($single_test->questions_shuffle == 'Yes') {
                                    $questions_shuffle = '1';
                                } else {
                                    $questions_shuffle = '0';
                                }

                                if ($single_test->download_test_pdf == 'Yes') {
                                    $download_test_pdf = '1';
                                    $test_pdf_link = $single_test->test_pdf != '' ? (base_url() . 'assets/uploads/test_pdfs/' . $single_test->test_pdf) : '';
                                } else {
                                    $download_test_pdf = '0';
                                    $test_pdf_link = '';
                                }

                                $tests[] = array(
                                    'category_id'           =>  $exist->id,
                                    'category_name'         =>  $exist->category_name,
                                    'is_test_attempted'     =>  $is_test_attempted,
                                    'attempted_test_id'     =>  $attempted_test_id,
                                    'test_id'               =>  $single_test->id,
                                    'topic'                 =>  $single_test->topic,
                                    'short_note'            =>  $single_test->short_note,
                                    'short_description'     =>  $single_test->short_description,
                                    'duration'              =>  $single_test->duration,
                                    'total_questions'       =>  $single_test->total_questions,
                                    'total_marks'           =>  $single_test->total_marks,

                                    'is_show_correct_ans'  => $show_correct_ans,
                                    'is_download_test_pdf' => $download_test_pdf,
                                    'test_pdf_link'        => $test_pdf_link,
                                );
                            }
                        }
                    }
                }

                if (!empty($tests)) {
                    $json_arr['status'] = 'true';
                    $json_arr['message'] = 'Test retrieved successfully.';
                    $json_arr['data'] = $tests;
                } else {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'Test not available.';
                    $json_arr['data'] = [];
                }
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Test not available.';
                $json_arr['data'] = [];
            }
        }

        echo json_encode($json_arr);
    }
    public function exam_materials_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $user_id = $request['login_id'];
        $offset = $request['offset'];
        $limit = $request['limit'];

        $this->db->select('tbl_exam_materials.*');
        $this->db->from('tbl_exam_materials');
        $this->db->where('is_deleted', '0');
        $this->db->limit($limit, $offset);
        $exist = $this->db->get()->result();

        if (!empty($exist)) {
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'Exam Materials retrieved successfully.';
            $json_arr['data'] = $exist;
            $json_arr['image_path'] = base_url() . 'assets/uploads/exam_material/images/';
            // $json_arr['image_path'] = base_url();
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Exam Materials not available.';
            $json_arr['data'] = [];
            $json_arr['image_path'] = base_url() . 'assets/uploads/exam_material/images/';
            // $json_arr['image_path'] = base_url();
        }
        echo json_encode($json_arr);
    }

    public function exam_material_subjects_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $user_id = $request['login_id'];
        $offset = $request['offset'];
        $limit = $request['limit'];

        $this->db->select('tbl_exam_material_subjects.*');
        $this->db->where('tbl_exam_material_subjects.is_deleted', '0');
        $this->db->where('tbl_exam_material_subjects.status', '1');
        $this->db->limit($limit, $offset);
        $exist = $this->db->get('tbl_exam_material_subjects')->result();

        if (!empty($exist)) {
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'Exam Material subjects retrieved successfully.';
            $json_arr['data'] = $exist;
            $json_arr['image_path'] = base_url() . 'assets/uploads/exam_material/images/';
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Exam Material subjects not available.';
            $json_arr['data'] = [];
            $json_arr['image_path'] = base_url() . 'assets/uploads/exam_material/images/';
        }

        echo json_encode($json_arr);
    }

    public function exam_material_exams_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $user_id = $request['login_id'];
        $offset = $request['offset'];
        $limit = $request['limit'];

        $this->db->select('tbl_exam_material_exams.*');
        $this->db->where('tbl_exam_material_exams.is_deleted', '0');
        $this->db->where('tbl_exam_material_exams.status', '1');
        $this->db->limit($limit, $offset);
        $query = $this->db->get('tbl_exam_material_exams');
        // $query = $this->db->query("SELECT * FROM tbl_exam_material_examwise LIMIT 1");
        // Check for query execution errors.
        // if ($query === false) {
        //     error_log('Query Error: ' . json_encode($this->db->error())); // Log detailed error.
        //     error_log('SQL Query: ' . $this->db->last_query());
        //     $json_arr['status'] = 'false';
        //     $json_arr['message'] = 'Database query failed.';
        //     $json_arr['data'] = [];
        //     $json_arr['image_path'] = base_url() . 'assets/uploads/exam_material/images/';
        //     echo json_encode($json_arr);
        //     return;
        // }
        $exist = $query->result();
        // $exist = $this->db->get('tbl_exam_material_examwise')->result();
        if (!empty($exist)) {
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'Exam Material exams retrieved successfully.';
            $json_arr['data'] = $exist;
            $json_arr['image_path'] = base_url() . 'assets/uploads/exam_material/images/';
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Exam Material exams not available.';
            $json_arr['data'] = [];
            $json_arr['image_path'] = base_url() . 'assets/uploads/exam_material/images/';
        }

        echo json_encode($json_arr);
    }


    public function exam_material_subject_tests_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $exam_material_id = $request['exam_material_id'];
        $exam_material_subject_id = $request['subject_id'];
        // $subjectwise_material_id = $request['subjectwise_material_id'];
        $user_id = $request['login_id'];
        $offset = $request['offset'];
        $limit = $request['limit'];
        $this->db->select('tbl_exam_material_subjectwise.*,exam_material_id, subject_id, subject_description, subject_short_description, tbl_exam_material_subjects.title as subject_title, tbl_exam_material_subjects.icon as subject_icon');
        $this->db->join('tbl_exam_material_subjects', 'tbl_exam_material_subjects.id = tbl_exam_material_subjectwise.subject_id');
        $this->db->join('tbl_exam_materials', 'tbl_exam_materials.id = tbl_exam_material_subjectwise.exam_material_id');
        $this->db->where('tbl_exam_material_subjectwise.is_deleted', '0');
        $this->db->where('tbl_exam_material_subjectwise.exam_material_id', $exam_material_id);
        $this->db->where('tbl_exam_material_subjectwise.subject_id', $exam_material_subject_id);
        // $this->db->where('tbl_exam_material_subjectwise.id', $subjectwise_material_id);
        // tbl_exam_material_subjectwise.id as subjectwise_material_id,
        $this->db->where('tbl_exam_materials.is_deleted', '0');
        $this->db->where('tbl_exam_material_subjectwise.tests !=', null);
        $exist = $this->db->get('tbl_exam_material_subjectwise')->row();

        if (!empty($exist)) {
            if ($exist->tests != "") {
                // var_dump($exist->tests);
                $test = array_map('trim', explode(',', $exist->tests));
                // var_dump($test);
                $test = explode(',', $exist->tests);
                $all_tests = array();
                if (!empty($test)) {
                    // echo "into test";
                    // exit;
                    $test = array_slice($test, $offset, $limit);
                    // print_r($test);
                    // exit;
                    for ($i = 0; $i < count($test); $i++) {
                        $this->db->where('id', $test[$i]);
                        $this->db->where('is_deleted', '0');
                        $single_test = $this->db->get('tbl_test_setups')->row();
                        // print_r($single_test);
                        // exit;
                        if (!empty($single_test)) {
                            $this->db->where('test_id', $single_test->id);
                            $this->db->where('user_id', $user_id);
                            $this->db->where('is_deleted', '0');
                            $this->db->where('parent_module', 'exam_material');
                            $attempted_test = $this->db->get('tbl_attempted_test')->row();
                            // print_r($attempted_test);
                            // exit;
                            if (!empty($attempted_test)) {
                                $is_test_attempted = '1';
                                $attempted_test_id = $attempted_test->id;
                            } else {
                                $is_test_attempted = '0';
                                $attempted_test_id = '';
                            }

                            if ($single_test->show_ans == 'Yes') {
                                $show_correct_ans = '1';
                            } else {
                                $show_correct_ans = '0';
                            }

                            if ($single_test->download_test_pdf == 'Yes') {
                                $download_test_pdf = '1';
                                $test_pdf_link = $single_test->test_pdf != '' ? (base_url() . 'assets/uploads/test_pdfs/' . $single_test->test_pdf) : '';
                            } else {
                                $download_test_pdf = '0';
                                $test_pdf_link = '';
                            }

                            $all_tests[] = array(
                                'subjectwise_material_id' =>  $exist->id,
                                'exam_material_id'      =>  $exist->exam_material_id,
                                'exam_material_subject_id'  =>  $exist->subject_id,
                                'is_test_attempted'     =>  $is_test_attempted,
                                'attempted_test_id'     =>  $attempted_test_id,
                                'test_id'               =>  $single_test->id,
                                'topic'                 =>  $single_test->topic,
                                'short_note'            =>  $single_test->short_note,
                                'short_description'     =>  $single_test->short_description,
                                'duration'              =>  $single_test->duration,
                                'total_questions'       =>  $single_test->total_questions,
                                'total_marks'           =>  $single_test->total_marks,

                                'is_show_correct_ans'  => $show_correct_ans,
                                'is_download_test_pdf' => $download_test_pdf,
                                'test_pdf_link'        => $test_pdf_link,
                            );
                            // print_r($all_tests);
                            // exit;
                        }
                    }
                }
                if (!empty($all_tests)) {
                    $json_arr['status'] = 'true';
                    $json_arr['message'] = 'Exam material subjectwise tests retrieved successfully.';
                    $json_arr['data'] = $all_tests;
                } else {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'Exam material subjectwise tests not available.';
                    $json_arr['data'] = [];
                }
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Exam material tests not available.';
                $json_arr['data'] = [];
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Exam material not available.';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr);
    }

    public function exam_material_exam_tests_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $exam_material_id = $request['exam_material_id'];
        $exam_id = $request['exam_id'];
        $exam_year_id = $request['exam_year_id'];
        $exam_type_id = $request['exam_type_id'];
        $user_id = $request['login_id'];
        $offset = $request['offset'];
        $limit = $request['limit'];
        $this->db->select('tbl_exam_material_examwise.*, 
        tbl_exam_material_examwise.exam_material_id, 
        tbl_exam_material_examwise.exam_id, 
        tbl_exam_material_examwise.exam_type_id, 
        tbl_exam_material_examwise.year_id, 
        tbl_exam_material_examwise.subject_description as description, 
        tbl_exam_material_examwise.description, 
        tbl_exam_material_exams.title as exam_title, 
        tbl_exam_material_exams.icon as exam_icon, 
        tbl_exam_material_exam_years.title as exam_year_title, 
        tbl_exam_material_exam_types.title as exam_type_title, 
        tbl_exam_material_exam_types.icon as exam_type_icon');
        $this->db->join('tbl_exam_material_exams', 'tbl_exam_material_exams.id = tbl_exam_material_examwise.exam_id');
        $this->db->join('tbl_exam_material_exam_types', 'tbl_exam_material_exam_types.id = tbl_exam_material_examwise.exam_type_id');
        $this->db->join('tbl_exam_material_exam_years', 'tbl_exam_material_exam_years.id = tbl_exam_material_examwise.year_id');
        $this->db->join('tbl_exam_materials', 'tbl_exam_materials.id = tbl_exam_material_examwise.exam_material_id');
        $this->db->where('tbl_exam_material_examwise.is_deleted', '0');
        $this->db->where('tbl_exam_material_examwise.exam_material_id', $exam_material_id);
        $this->db->where('tbl_exam_material_examwise.exam_id', $exam_id);
        $this->db->where('tbl_exam_material_examwise.exam_type_id', $exam_type_id);
        $this->db->where('tbl_exam_material_examwise.year_id', $exam_year_id);
        $this->db->where('tbl_exam_material_examwise.tests IS NOT NULL', null, false);
        $this->db->where("FIND_IN_SET('1', tbl_exam_material_examwise.tests) >", 0);
        $this->db->where('tbl_exam_materials.is_deleted', '0');
        $query = $this->db->get('tbl_exam_material_examwise');
        if (!$query) {
            echo "Query failed: " . $this->db->last_query();
            print_r($this->db->error());
            exit;
        }
        if ($query->num_rows() > 0) {
            $exist = $query->row();
            if (!empty($exist)) {
                if ($exist->tests != "") {
                    $test = array_map('trim', explode(',', $exist->tests));
                    $test = explode(',', $exist->tests);
                    $all_tests = array();
                    // print_r($test);
                    // exit;
                    if (!empty($test)) {
                        $test = array_slice($test, $offset, $limit);
                        for ($i = 0; $i < count($test); $i++) {
                            $this->db->where('id', $test[$i]);
                            $this->db->where('is_deleted', '0');
                            $single_test = $this->db->get('tbl_test_setups')->row();
                            if (!empty($single_test)) {
                                $this->db->where('test_id', $single_test->id);
                                $this->db->where('user_id', $user_id);
                                $this->db->where('is_deleted', '0');
                                $this->db->where('parent_module', 'exam_material');
                                $attempted_test = $this->db->get('tbl_attempted_test')->row();
                                if (!empty($attempted_test)) {
                                    $is_test_attempted = '1';
                                    $attempted_test_id = $attempted_test->id;
                                } else {
                                    $is_test_attempted = '0';
                                    $attempted_test_id = '';
                                }

                                if ($single_test->show_ans == 'Yes') {
                                    $show_correct_ans = '1';
                                } else {
                                    $show_correct_ans = '0';
                                }

                                if ($single_test->download_test_pdf == 'Yes') {
                                    $download_test_pdf = '1';
                                    $test_pdf_link = $single_test->test_pdf != '' ? (base_url() . 'assets/uploads/test_pdfs/' . $single_test->test_pdf) : '';
                                } else {
                                    $download_test_pdf = '0';
                                    $test_pdf_link = '';
                                }

                                $all_tests[] = array(
                                    'examwise_material_id'  =>  $exist->id,
                                    'exam_material_id'      =>  $exist->exam_material_id,
                                    'exam_material_exam_id' =>  $exist->exam_id,
                                    'exam_material_year_id' =>  $exist->year_id,
                                    'exam_material_exam_type_id' =>  $exist->exam_type_id,
                                    'is_test_attempted'     =>  $is_test_attempted,
                                    'attempted_test_id'     =>  $attempted_test_id,
                                    'test_id'               =>  $single_test->id,
                                    'topic'                 =>  $single_test->topic,
                                    'short_note'            =>  $single_test->short_note,
                                    'short_description'     =>  $single_test->short_description,
                                    'duration'              =>  $single_test->duration,
                                    'total_questions'       =>  $single_test->total_questions,
                                    'total_marks'           =>  $single_test->total_marks,

                                    'is_show_correct_ans'  => $show_correct_ans,
                                    'is_download_test_pdf' => $download_test_pdf,
                                    'test_pdf_link'        => $test_pdf_link,
                                );
                                // print_r($all_tests);
                                // exit;
                            }
                        }
                    }

                    if (!empty($all_tests)) {
                        $json_arr['status'] = 'true';
                        $json_arr['message'] = 'Exam material tests retrieved successfully.';
                        $json_arr['data'] = $all_tests;
                    } else {
                        $json_arr['status'] = 'false';
                        $json_arr['message'] = 'Exam material tests not available.';
                        $json_arr['data'] = [];
                    }
                } else {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'Exam material tests not available.';
                    $json_arr['data'] = [];
                }
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Exam material not available.';
                $json_arr['data'] = [];
            }
        } else {
            // echo "No matching record found.";
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'No matching record found.';
            $json_arr['data'] = [];
        }

        echo json_encode($json_arr);
    }
    public function exam_material_exam_years_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $user_id = $request['login_id'];
        $offset = $request['offset'];
        $limit = $request['limit'];

        $this->db->select('tbl_exam_material_exam_years.*');
        $this->db->where('tbl_exam_material_exam_years.is_deleted', '0');
        $this->db->where('tbl_exam_material_exam_years.status', '1');
        $this->db->limit($limit, $offset);
        // $query = $this->db->query("SELECT * FROM tbl_exam_material_examwise LIMIT 1");
        // $exist = $query->result();
        $this->db->order_by('tbl_exam_material_exam_years.id', 'desc');
        $exist = $this->db->get('tbl_exam_material_exam_years')->result();

        if (!empty($exist)) {
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'Exam Material exam years retrieved successfully.';
            $json_arr['data'] = $exist;
            $json_arr['image_path'] = base_url() . 'assets/uploads/exam_material/images/';
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Exam Material exam years not available.';
            $json_arr['data'] = [];
            $json_arr['image_path'] = base_url() . 'assets/uploads/exam_material/images/';
        }

        echo json_encode($json_arr);
    }

    public function exam_material_exam_years_types_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $user_id = $request['login_id'];
        // $offset = $request['offset'];
        // $limit = $request['limit'];
        $this->db->select('tbl_exam_material_exam_types.*');
        $this->db->where('tbl_exam_material_exam_types.is_deleted', '0');
        $this->db->where('tbl_exam_material_exam_types.status', '1');
        // $this->db->limit($limit, $offset);
        $exist = $this->db->get('tbl_exam_material_exam_types')->result();

        if (!empty($exist)) {
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'Exam Material exam types retrieved successfully.';
            $json_arr['data'] = $exist;
            $json_arr['image_path'] = base_url() . 'assets/uploads/exam_material/images/';
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Exam Material exam types not available.';
            $json_arr['data'] = [];
            $json_arr['image_path'] = base_url() . 'assets/uploads/exam_material/images/';
        }

        echo json_encode($json_arr);
    }

    public function exam_material_recent_tests_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $exam_material_id = $request['exam_material_id'];
        $user_id = $request['login_id'];
        $limit = $request['limit'];

        $this->db->select('tbl_exam_material_examwise.exam_material_id, tbl_exam_material_examwise.tests,tbl_exam_material_examwise.created_on');
        $this->db->join('tbl_exam_material_exams', 'tbl_exam_material_exams.id = tbl_exam_material_examwise.exam_id');
        $this->db->join('tbl_exam_material_exam_types', 'tbl_exam_material_exam_types.id = tbl_exam_material_examwise.exam_type_id');
        $this->db->join('tbl_exam_material_exam_years', 'tbl_exam_material_exam_years.id = tbl_exam_material_examwise.year_id');
        $this->db->join('tbl_exam_materials', 'tbl_exam_materials.id = tbl_exam_material_examwise.exam_material_id');
        $this->db->where('tbl_exam_material_examwise.is_deleted', '0');
        $this->db->where('tbl_exam_material_examwise.exam_material_id', $exam_material_id);
        $this->db->where('tbl_exam_material_examwise.tests !=', null);
        $this->db->where('tbl_exam_materials.is_deleted', '0');
        $this->db->order_by('tbl_exam_material_examwise.created_on', 'desc');
        $examwise_exist = $this->db->get('tbl_exam_material_examwise')->result();

        $this->db->select('tbl_exam_material_subjectwise.exam_material_id, tbl_exam_material_subjectwise.tests,tbl_exam_material_subjectwise.created_on');
        $this->db->join('tbl_exam_material_subjects', 'tbl_exam_material_subjects.id = tbl_exam_material_subjectwise.subject_id');
        $this->db->join('tbl_exam_materials', 'tbl_exam_materials.id = tbl_exam_material_subjectwise.exam_material_id');
        $this->db->where('tbl_exam_material_subjectwise.is_deleted', '0');
        $this->db->where('tbl_exam_material_subjectwise.exam_material_id', $exam_material_id);
        $this->db->where('tbl_exam_materials.is_deleted', '0');
        $this->db->where('tbl_exam_material_subjectwise.tests !=', null);
        $this->db->order_by('tbl_exam_material_subjectwise.created_on', 'desc');
        $subjectwise_exist = $this->db->get('tbl_exam_material_subjectwise')->result();

        $merged_tests = array_merge($examwise_exist, $subjectwise_exist);

        usort($merged_tests, function ($a, $b) {
            return strtotime($b->created_on) - strtotime($a->created_on);
        });

        $latest_tests = array_slice($merged_tests, 0, $limit);
        $tests = [];
        if (!empty($latest_tests)) {
            // print_r($latest_tests);
            // exit;
            $all_tests = array();
            foreach ($latest_tests as $exist) {
                if ($exist->tests != "") {
                    // $test = explode(',', $exist->tests);
                    $test = explode(',', $exist->tests);
                    // print_r($test);  // Check what is inside the $test array after explode
                    // exit;
                    if (!empty($test)) {
                        for ($i = 0; $i < count($test); $i++) {
                            $this->db->where('id', $test[$i]);
                            $this->db->where('is_deleted', '0');
                            $single_test = $this->db->get('tbl_test_setups')->row();
                            // print_r($single_test);
                            // print_r($single_test->id);
                            // exit;
                            if (!empty($single_test)) {
                                $this->db->where('test_id', $single_test->id);
                                $this->db->where('user_id', $user_id);
                                $this->db->where('is_deleted', '0');
                                $this->db->where('parent_module', 'exam_material');
                                $attempted_test = $this->db->get('tbl_attempted_test')->row();
                                // print_r($attempted_test);
                                // exit;
                                if (!empty($attempted_test)) {
                                    $is_test_attempted = '1';
                                    $attempted_test_id = $attempted_test->id;
                                } else {
                                    $is_test_attempted = '0';
                                    $attempted_test_id = '';
                                }

                                if ($single_test->show_ans == 'Yes') {
                                    $show_correct_ans = '1';
                                } else {
                                    $show_correct_ans = '0';
                                }

                                if ($single_test->questions_shuffle == 'Yes') {
                                    $questions_shuffle = '1';
                                } else {
                                    $questions_shuffle = '0';
                                }

                                if ($single_test->download_test_pdf == 'Yes') {
                                    $download_test_pdf = '1';
                                    $test_pdf_link = $single_test->test_pdf != '' ? (base_url() . 'assets/uploads/test_pdfs/' . $single_test->test_pdf) : '';
                                } else {
                                    $download_test_pdf = '0';
                                    $test_pdf_link = '';
                                }

                                $all_tests[] = array(
                                    'exam_material_id'      =>  $exist->exam_material_id,
                                    'is_test_attempted'     =>  $is_test_attempted,
                                    'attempted_test_id'     =>  $attempted_test_id,
                                    'test_id'               =>  $single_test->id,
                                    'topic'                 =>  $single_test->topic,
                                    'short_note'            =>  $single_test->short_note,
                                    'short_description'     =>  $single_test->short_description,
                                    'duration'              =>  $single_test->duration,
                                    'total_questions'       =>  $single_test->total_questions,
                                    'total_marks'           =>  $single_test->total_marks,

                                    'is_show_correct_ans'  => $show_correct_ans,
                                    'is_download_test_pdf' => $download_test_pdf,
                                    'test_pdf_link'        => $test_pdf_link,
                                );
                                // print_r($all_tests);
                                // exit;
                            }
                        }
                    }
                }
            }
            if (!empty($all_tests)) {
                $json_arr['status'] = 'true';
                $json_arr['message'] = 'Exam material tests retrieved successfully.';
                $json_arr['data'] = $all_tests;
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Exam material tests not available.';
                $json_arr['data'] = [];
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Exam material not available.';
            $json_arr['data'] = [];
        }

        echo json_encode($json_arr);
    }

    //pending
    public function exam_material_all_tests_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $exam_material_id = $request['exam_material_id'];
        $user_id = $request['login_id'];
        $limit = $request['limit'];
        $offset = $request['offset'];

        $this->db->select('tbl_exam_material_examwise.exam_material_id, tbl_exam_material_examwise.tests');
        $this->db->join('tbl_exam_material_exams', 'tbl_exam_material_exams.id = tbl_exam_material_examwise.exam_id');
        $this->db->join('tbl_exam_material_exam_types', 'tbl_exam_material_exam_types.id = tbl_exam_material_examwise.exam_type_id');
        $this->db->join('tbl_exam_material_exam_years', 'tbl_exam_material_exam_years.id = tbl_exam_material_examwise.year_id');
        $this->db->join('tbl_exam_materials', 'tbl_exam_materials.id = tbl_exam_material_examwise.exam_material_id');
        $this->db->where('tbl_exam_material_examwise.is_deleted', '0');
        $this->db->where('tbl_exam_material_examwise.exam_material_id', $exam_material_id);
        $this->db->where('tbl_exam_material_examwise.tests !=', null);
        $this->db->where('tbl_exam_materials.is_deleted', '0');
        $this->db->order_by('tbl_exam_material_examwise.created_on', 'desc');
        $examwise_exist = $this->db->get('tbl_exam_material_examwise')->result();

        $this->db->select('tbl_exam_material_subjectwise.exam_material_id, tbl_exam_material_subjectwise.tests');
        $this->db->join('tbl_exam_material_subjects', 'tbl_exam_material_subjects.id = tbl_exam_material_subjectwise.subject_id');
        $this->db->join('tbl_exam_materials', 'tbl_exam_materials.id = tbl_exam_material_subjectwise.exam_material_id');
        $this->db->where('tbl_exam_material_subjectwise.is_deleted', '0');
        $this->db->where('tbl_exam_material_subjectwise.exam_material_id', $exam_material_id);
        $this->db->where('tbl_exam_materials.is_deleted', '0');
        $this->db->where('tbl_exam_material_subjectwise.tests !=', null);
        $this->db->order_by('tbl_exam_material_subjectwise.created_on', 'desc');
        $subjectwise_exist = $this->db->get('tbl_exam_material_subjectwise')->result();

        $merged_tests = array_merge($examwise_exist, $subjectwise_exist);

        usort($merged_tests, function ($a, $b) {
            return strtotime($b->created_on) - strtotime($a->created_on);
        });

        $latest_tests = array_slice($merged_tests, $offset, $limit);

        if (!empty($latest_tests)) {
            $all_tests = array();
            foreach ($latest_tests as $exist) {
                if ($exist->tests != "") {
                    $test = explode(',', $exist->tests);
                    if (!empty($test)) {
                        for ($i = 0; $i < count($test); $i++) {
                            $this->db->where('id', $test[$i]);
                            $this->db->where('is_deleted', '0');
                            $single_test = $this->db->get('tbl_test_setups')->row();
                            if (!empty($single_test)) {
                                $this->db->where('test_id', $single_test->id);
                                $this->db->where('user_id', $user_id);
                                $this->db->where('is_deleted', '0');
                                $this->db->where('parent_module', 'exam_material');
                                $attempted_test = $this->db->get('tbl_attempted_test')->row();
                                if (!empty($attempted_test)) {
                                    $is_test_attempted = '1';
                                    $attempted_test_id = $attempted_test->id;
                                } else {
                                    $is_test_attempted = '0';
                                    $attempted_test_id = '';
                                }

                                if ($single_test->show_ans == 'Yes') {
                                    $show_correct_ans = '1';
                                } else {
                                    $show_correct_ans = '0';
                                }

                                if ($single_test->questions_shuffle == 'Yes') {
                                    $questions_shuffle = '1';
                                } else {
                                    $questions_shuffle = '0';
                                }

                                if ($single_test->download_test_pdf == 'Yes') {
                                    $download_test_pdf = '1';
                                    $test_pdf_link = $single_test->test_pdf != '' ? (base_url() . 'assets/uploads/test_pdfs/' . $single_test->test_pdf) : '';
                                } else {
                                    $download_test_pdf = '0';
                                    $test_pdf_link = '';
                                }

                                $all_tests[] = array(
                                    'exam_material_id'      =>  $exist->exam_material_id,
                                    'is_test_attempted'     =>  $is_test_attempted,
                                    'attempted_test_id'     =>  $attempted_test_id,
                                    'test_id'               =>  $single_test->id,
                                    'topic'                 =>  $single_test->topic,
                                    'short_note'            =>  $single_test->short_note,
                                    'short_description'     =>  $single_test->short_description,
                                    'duration'              =>  $single_test->duration,
                                    'total_questions'       =>  $single_test->total_questions,
                                    'total_marks'           =>  $single_test->total_marks,

                                    'is_show_correct_ans'  => $show_correct_ans,
                                    'is_download_test_pdf' => $download_test_pdf,
                                    'test_pdf_link'        => $test_pdf_link,
                                );
                            }
                        }
                    }
                }
            }

            if (!empty($tests)) {
                $json_arr['status'] = 'true';
                $json_arr['message'] = 'Exam material tests retrieved successfully.';
                $json_arr['data'] = $all_tests;
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Exam material tests not available.';
                $json_arr['data'] = [];
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Exam material not available.';
            $json_arr['data'] = [];
        }

        echo json_encode($json_arr);
    }


    // public function exam_material_syllabus_subjectwise_type()
    // {
    //     $request = json_decode(file_get_contents('php://input'), true);
    //     $user_id = $request['login_id'];
    //     $offset = $request['offset'];
    //     $limit = $request['limit'];

    //     $this->db->select('tbl_syllabus_subjectwise_type.*');
    //     $this->db->where('tbl_syllabus_subjectwise_type.is_deleted', '0');
    //     $this->db->where('tbl_syllabus_subjectwise_type.status', '1');
    //     $this->db->limit($limit, $offset);
    //     $exist = $this->db->get('tbl_syllabus_subjectwise_type')->result();
    //     // print_r($exist);
    //     // exit;
    //     if (!empty($exist)) {
    //         $json_arr['status'] = 'true';
    //         $json_arr['message'] = 'Exam Material syllabus subjectwise type retrieved successfully.';
    //         $json_arr['data'] = $exist;
    //         $json_arr['image_path'] = base_url() . 'assets/uploads/exam_material/images/';
    //     } else {
    //         $json_arr['status'] = 'false';
    //         $json_arr['message'] = 'Exam Material syllabus subjectwise type not available.';
    //         $json_arr['data'] = [];
    //         $json_arr['image_path'] = base_url() . 'assets/uploads/exam_material/images/';
    //     }

    //     echo json_encode($json_arr);
    // }

    public function exam_material_syllabus_subjectwise_pdf()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $user_id = $request['login_id'];
        $offset = $request['offset'];
        $limit = $request['limit'];
        $subject_id = $request['subject_id'];

        $this->db->select('tbl_syllabus_subjectwise_pdf.*');
        $this->db->where('tbl_syllabus_subjectwise_pdf.subject_id', $subject_id);
        $this->db->where('tbl_syllabus_subjectwise_pdf.is_deleted', '0');
        $this->db->where('tbl_syllabus_subjectwise_pdf.status', '1');
        $this->db->limit($limit, $offset);
        $exist = $this->db->get('tbl_syllabus_subjectwise_pdf')->result();
        // print_r($exist);
        // exit;
        if (!empty($exist)) {
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'Exam Material syllabus subjectwise pdf retrieved successfully.';
            $json_arr['data'] = $exist;
            $json_arr['pdf_url'] = base_url() . 'assets/uploads/exam_material/pdf/';
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Exam Material syllabus subjectwise pdf not available.';
            $json_arr['data'] = [];
            $json_arr['pdf_url'] = base_url() . 'assets/uploads/exam_material/pdf/';
        }

        echo json_encode($json_arr);
    }

    public function exam_material_syllabus_subjectwise_content()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $user_id = $request['login_id'];
        $offset = $request['offset'];
        $limit = $request['limit'];
        $subject_id = $request['subject_id'];

        $this->db->select('tbl_syllabus_subjectwise_content.*');
        $this->db->where('tbl_syllabus_subjectwise_content.subject_id', $subject_id);
        $this->db->where('tbl_syllabus_subjectwise_content.is_deleted', '0');
        $this->db->where('tbl_syllabus_subjectwise_content.status', '1');
        $this->db->limit($limit, $offset);
        $exist = $this->db->get('tbl_syllabus_subjectwise_content')->result();
        // print_r($exist);
        // exit;
        if (!empty($exist)) {
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'Exam Material syllabus subjectwise content retrieved successfully.';
            $json_arr['data'] = $exist;
            $json_arr['image_path'] = base_url() . 'assets/uploads/exam_material/images/';
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Exam Material syllabus subjectwise content not available.';
            $json_arr['data'] = [];
            $json_arr['image_path'] = base_url() . 'assets/uploads/exam_material/images/';
        }

        echo json_encode($json_arr);
    }

    public function exam_material_syllabus_examwise_pdf()
    {
        $request = json_decode(file_get_contents('php://input'), true);

        // if ($request) {
        //     if (isset($request['login_id'])) {
        $user_id = $request['login_id'];
        $offset = $request['offset'];
        $limit = $request['limit'];
        $exam_id = $request['exam_id'];
        $exam_year_id = $request['exam_year_id'];
        $exam_type_id = $request['exam_type_id'];

        $this->db->select('tbl_syllabus_examwise_pdf.*');
        $this->db->where('tbl_syllabus_examwise_pdf.exam_id', $exam_id);
        $this->db->where('tbl_syllabus_examwise_pdf.exam_year_id', $exam_year_id);
        $this->db->where('tbl_syllabus_examwise_pdf.exam_type_id', $exam_type_id);
        $this->db->where('tbl_syllabus_examwise_pdf.is_deleted', '0');
        $this->db->where('tbl_syllabus_examwise_pdf.status', '1');
        $this->db->limit($limit, $offset);
        $exist = $this->db->get('tbl_syllabus_examwise_pdf')->result();
        // print_r($exist);
        // exit;
        if (!empty($exist)) {
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'Exam Material syllabus examwise pdf retrieved successfully.';
            $json_arr['data'] = $exist;
            $json_arr['pdf_url'] = base_url() . 'assets/uploads/exam_material/pdf/';
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Exam Material syllabus examwise pdf not available.';
            $json_arr['data'] = [];
            $json_arr['pdf_url'] = base_url() . 'assets/uploads/exam_material/pdf/';
        }
        //     } else {
        //         echo json_encode(['status' => 'false', 'message' => 'User ID is required.']);
        //     }
        // } else {
        //     echo json_encode(['status' => 'false', 'message' => 'Invalid request.']);
        // }

        echo json_encode($json_arr);
    }

    public function exam_material_syllabus_examwise_content()
    {
        $request = json_decode(file_get_contents('php://input'), true);

        // if ($request) {
        //     if (isset($request['login_id'])) {
        $user_id = $request['login_id'];
        $offset = $request['offset'];
        $limit = $request['limit'];
        $exam_id = $request['exam_id'];
        $exam_year_id = $request['exam_year_id'];
        $exam_type_id = $request['exam_type_id'];

        $this->db->select('tbl_syllabus_examwise_content.*');
        $this->db->where('tbl_syllabus_examwise_content.exam_id', $exam_id);
        $this->db->where('tbl_syllabus_examwise_content.exam_year_id', $exam_year_id);
        $this->db->where('tbl_syllabus_examwise_content.exam_type_id', $exam_type_id);
        $this->db->where('tbl_syllabus_examwise_content.is_deleted', '0');
        $this->db->where('tbl_syllabus_examwise_content.status', '1');
        $this->db->limit($limit, $offset);
        $exist = $this->db->get('tbl_syllabus_examwise_content')->result();
        // print_r($exist);
        // exit;
        if (!empty($exist)) {
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'Exam Material syllabus examwise content retrieved successfully.';
            $json_arr['data'] = $exist;
            $json_arr['image_path'] = base_url() . 'assets/uploads/exam_material/images/';
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Exam Material syllabus examwise content not available.';
            $json_arr['data'] = [];
            $json_arr['image_path'] = base_url() . 'assets/uploads/exam_material/images/';
        }
        //     } else {
        //         echo json_encode(['status' => 'false', 'message' => 'User ID is required.']);
        //     }
        // } else {
        //     echo json_encode(['status' => 'false', 'message' => 'Invalid request.']);
        // }

        echo json_encode($json_arr);
    }

    public function exam_material_previous_paper_examwise_pdf()
    {
        $request = json_decode(file_get_contents('php://input'), true);

        // if ($request) {
        //     if (isset($request['login_id'])) {
        $user_id = $request['login_id'];
        $offset = $request['offset'];
        $limit = $request['limit'];
        $exam_id = $request['exam_id'];
        $exam_year_id = $request['exam_year_id'];
        $exam_type_id = $request['exam_type_id'];

        $this->db->select('tbl_previous_paper_examwise_pdf.*');
        $this->db->where('tbl_previous_paper_examwise_pdf.exam_id', $exam_id);
        $this->db->where('tbl_previous_paper_examwise_pdf.exam_year_id', $exam_year_id);
        $this->db->where('tbl_previous_paper_examwise_pdf.exam_type_id', $exam_type_id);
        $this->db->where('tbl_previous_paper_examwise_pdf.is_deleted', '0');
        $this->db->where('tbl_previous_paper_examwise_pdf.status', '1');
        $this->db->limit($limit, $offset);
        $exist = $this->db->get('tbl_previous_paper_examwise_pdf')->result();
        // print_r($exist);
        // exit;
        if (!empty($exist)) {
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'Exam Material pervious paper examwise pdf retrieved successfully.';
            $json_arr['data'] = $exist;
            $json_arr['image_path'] = base_url() . 'assets/uploads/exam_material/images/';
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Exam Material pervious paper examwise pdf not available.';
            $json_arr['data'] = [];
            $json_arr['image_path'] = base_url() . 'assets/uploads/exam_material/images/';
        }
        //     } else {
        //         echo json_encode(['status' => 'false', 'message' => 'User ID is required.']);
        //     }
        // } else {
        //     echo json_encode(['status' => 'false', 'message' => 'Invalid request.']);
        // }

        echo json_encode($json_arr);
    }

    public function exam_material_subjectwise_pdf()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $user_id = $request['login_id'];
        $offset = $request['offset'];
        $limit = $request['limit'];
        $subject_id = $request['subject_id'];
        $exam_material_id = $request['exam_material_id'];

        $this->db->select('tbl_exam_material_subjectwise_pdf.*');
        $this->db->where('tbl_exam_material_subjectwise_pdf.exam_material_id', $exam_material_id);
        $this->db->where('tbl_exam_material_subjectwise_pdf.subject_id', $subject_id);
        $this->db->where('tbl_exam_material_subjectwise_pdf.is_deleted', '0');
        $this->db->where('tbl_exam_material_subjectwise_pdf.status', '1');
        $this->db->limit($limit, $offset);
        $exist = $this->db->get('tbl_exam_material_subjectwise_pdf')->result();
        // print_r($exist);
        // exit;
        if (!empty($exist)) {
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'Exam Material subjectwise pdf retrieved successfully.';
            $json_arr['data'] = $exist;
            $json_arr['image_path'] = base_url() . 'assets/uploads/exam_material/images/';
            $json_arr['pdf_path'] = base_url() . 'assets/uploads/exam_material/pdf/';
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Exam Material subjectwise pdf not available.';
            $json_arr['data'] = [];
            $json_arr['image_path'] = base_url() . 'assets/uploads/exam_material/images/';
            $json_arr['pdf_path'] = base_url() . 'assets/uploads/exam_material/pdf/';
        }

        echo json_encode($json_arr);
    }

    public function exam_material_examwise_pdf()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        // if ($request) {
        //     if (isset($request['login_id'])) {
        $user_id = $request['login_id'];
        $offset = $request['offset'];
        $limit = $request['limit'];
        $exam_material_id = $request['exam_material_id'];
        $exam_id = $request['exam_id'];
        $exam_year_id = $request['exam_year_id'];
        $exam_type_id = $request['exam_type_id'];

        $this->db->select('tbl_exam_material_examwise_pdf.*');
        $this->db->where('tbl_exam_material_examwise_pdf.exam_material_id', $exam_material_id);
        $this->db->where('tbl_exam_material_examwise_pdf.exam_id', $exam_id);
        $this->db->where('tbl_exam_material_examwise_pdf.exam_year_id', $exam_year_id);
        $this->db->where('tbl_exam_material_examwise_pdf.exam_type_id', $exam_type_id);
        $this->db->where('tbl_exam_material_examwise_pdf.is_deleted', '0');
        $this->db->where('tbl_exam_material_examwise_pdf.status', '1');
        $this->db->limit($limit, $offset);
        $exist = $this->db->get('tbl_exam_material_examwise_pdf')->result();
        // print_r($exist);
        // exit;
        if (!empty($exist)) {
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'Exam Material examwise pdf retrieved successfully.';
            $json_arr['data'] = $exist;
            $json_arr['image_path'] = base_url() . 'assets/uploads/exam_material/images/';
            $json_arr['pdf_path'] = base_url() . 'assets/uploads/exam_material/pdf/';
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Exam Material examwise pdf not available.';
            $json_arr['data'] = [];
            $json_arr['image_path'] = base_url() . 'assets/uploads/exam_material/images/';
            $json_arr['pdf_path'] = base_url() . 'assets/uploads/exam_material/pdf/';
        }
        //     } else {
        //         echo json_encode(['status' => 'false', 'message' => 'User ID is required.']);
        //     }
        // } else {
        //     echo json_encode(['status' => 'false', 'message' => 'Invalid request.']);
        // }

        echo json_encode($json_arr);
    }

    public function get_all_category_english_vocabulary_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $this->db->select('*');
        $this->db->where('is_deleted', '0');
        $result = $this->db->get('tbl_vocabulary_category');
        $result = $result->result();
        $json_arr['status'] = 'true';
        $json_arr['message'] = 'success';
        $json_arr['data'] = $result;
        echo json_encode($json_arr);
    }

    public function get_all_category_marathi_sabd_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $this->db->select('*');
        $this->db->where('is_deleted', '0');
        $result = $this->db->get('marathi_sabd_category');
        $result = $result->result();
        $json_arr['status'] = 'true';
        $json_arr['message'] = 'success';
        $json_arr['data'] = $result;
        echo json_encode($json_arr);
    }

    public function get_english_vocabulary_api()
    {
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
        $this->db->select('english_vocabulary.*, tbl_vocabulary_category.vocabulary_category_name');
        if ($request['category'] != "") {
            $this->db->where('english_vocabulary.category', $request['category']);
        }
        $this->db->where('english_vocabulary.status', 'Active');
        $this->db->join('tbl_vocabulary_category', 'tbl_vocabulary_category.id = english_vocabulary.category');
        $this->db->order_by('english_vocabulary.sequence_no', 'ASC');
        $this->db->limit($limit, $offset);
        $result = $this->db->get('english_vocabulary');
        $result = $result->result();
        if (!empty($result)) {
            foreach ($result as $item) {
                //$item->current_affair_image_path = base_url('AppAPI/current-affairs/' . $item->current_affair_image);
                $item->issave = $this->isBookmarked_vocabulary($item->id, $request['login_id']);
            }
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'success';
            $json_arr['image_path'] = base_url() . 'assets/uploads/english_vocabulary/images/';
            $json_arr['data'] = $result;
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'No Data Found.';
            $json_arr['image_path'] = base_url() . 'assets/uploads/english_vocabulary/images/';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr);
    }

    public function isBookmarked_vocabulary($id, $login_id)
    {
        $this->db->where('english_vocabulary_id', $id);
        $this->db->where('login_id', $login_id);
        $query = $this->db->get('english_vocabulary_saved');
        $query = $query->row();

        $isAvailable = '0';
        if (!empty($query)) {
            $isAvailable = '1';
        } else {
            $isAvailable = '0';
        }
        return $isAvailable;
    }

    public function get_saved_english_vocabulary()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $offset = $request['offset'];
        $limit = $request['limit'];
        $this->db->select('english_vocabulary.*, tbl_vocabulary_category.vocabulary_category_name, 1 AS issave');
        $this->db->from('english_vocabulary_saved');

        if ($request['category'] != "") {
            $this->db->where('english_vocabulary.category', $request['category']);
        }

        $this->db->where('english_vocabulary_saved.login_id', $request['login_id']);
        $this->db->join('english_vocabulary', 'english_vocabulary.id  = english_vocabulary_saved.english_vocabulary_id');
        $this->db->join('tbl_vocabulary_category', 'tbl_vocabulary_category.id = english_vocabulary.category', 'left');
        $this->db->where('english_vocabulary.status', 'Active');
        $this->db->order_by('english_vocabulary.sequence_no', 'ASC');
        $this->db->limit($limit, $offset);
        $result = $this->db->get();
        $result = $result->result();
        if (!empty($result)) {
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'success';
            $json_arr['image_path'] = base_url() . 'assets/uploads/english_vocabulary/images/';
            $json_arr['data'] = $result;
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'No Data Found.';
            $json_arr['image_path'] = base_url() . 'assets/uploads/english_vocabulary/images/';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr);
    }


    public function get_marathi_sabd_api()
    {
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
        $this->db->select('marathi_sabd.*, marathi_sabd_category.category_name');
        if ($request['category'] != "") {
            $this->db->where('marathi_sabd.category', $request['category']);
        }
        $this->db->where('marathi_sabd.status', 'Active');
        $this->db->join('marathi_sabd_category', 'marathi_sabd_category.id = marathi_sabd.category');
        $this->db->order_by('marathi_sabd.sequence_no', 'ASC');
        $this->db->limit($limit, $offset);
        $result = $this->db->get('marathi_sabd');
        $result = $result->result();
        if (!empty($result)) {
            foreach ($result as $item) {
                //$item->current_affair_image_path = base_url('AppAPI/current-affairs/' . $item->current_affair_image);
                $item->issave = $this->isBookmarked_marathi_sabd($item->id, $request['login_id']);
            }
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'success';
            $json_arr['image_path'] = base_url() . 'assets/uploads/marathi_sabd/images/';
            $json_arr['data'] = $result;
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'No Data Found.';
            $json_arr['image_path'] = base_url() . 'assets/uploads/marathi_sabd/images/';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr);
    }

    public function isBookmarked_marathi_sabd($id, $login_id)
    {
        $this->db->where('marathi_sabd_id', $id);
        $this->db->where('login_id', $login_id);
        $query = $this->db->get('marathi_sabd_saved');
        $query = $query->row();

        $isAvailable = '0';
        if (!empty($query)) {
            $isAvailable = '1';
        } else {
            $isAvailable = '0';
        }
        return $isAvailable;
    }

    public function get_saved_marathi_sabd()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $offset = $request['offset'];
        $limit = $request['limit'];
        $this->db->select('marathi_sabd.*, marathi_sabd_category.category_name, 1 AS issave');
        $this->db->from('marathi_sabd_saved');

        if ($request['category'] != "") {
            $this->db->where('marathi_sabd.category', $request['category']);
        }

        $this->db->where('marathi_sabd_saved.login_id', $request['login_id']);
        $this->db->join('marathi_sabd', 'marathi_sabd.id  = marathi_sabd_saved.marathi_sabd_id');
        $this->db->join('marathi_sabd_category', 'marathi_sabd_category.id = marathi_sabd.category', 'left');
        $this->db->where('marathi_sabd.status', 'Active');
        $this->db->order_by('marathi_sabd.sequence_no', 'ASC');
        $this->db->limit($limit, $offset);

        $result = $this->db->get();
        $result = $result->result();
        if (!empty($result)) {
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'success';
            $json_arr['image_path'] = base_url() . 'assets/uploads/marathi_sabd/images/';
            $json_arr['data'] = $result;
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'No Data Found.';
            $json_arr['image_path'] = base_url() . 'assets/uploads/marathi_sabd/images/';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr);
    }


    public function get_all_saved_post_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
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
        $this->db->select('tbl_news_saved.*,current_affairs_saved.current_affair_id as saved_current_affairs_id,current_affairs_saved.current_affairs_saved_id ,current_affairs_saved.login_id,current_affairs_saved.status as current_affair_status,tbl_news.news_image,tbl_news.news_title,tbl_news.news_description,tbl_news.sequence_no as news_sequence_no,current_affairs.sequence_no as current_affairs_sequence_no,current_affairs.current_affair_image,current_affairs.current_affair_title,current_affairs.current_affair_description');
        $this->db->join('tbl_news', 'tbl_news.id = tbl_news_saved.news_id');
        $this->db->join('tbl_news_saved', 'tbl_news_saved.login_id = current_affairs_saved.login_id');
        $this->db->join('current_affairs', 'current_affairs.current_affair_id = current_affairs_saved.saved_current_affairs_id');
        $this->db->where('tbl_news_saved.status', 'Active');
        $this->db->where('current_affairs_saved.status', 'Active');
        $this->db->order_by('tbl_news_saved.news_sequence_no', 'ASC');
        $this->db->order_by('current_affairs_saved.current_affairs_sequence_no', 'ASC');
        $this->db->limit($limit, $offset);
        $result = $this->db->get('current_affairs_saved');
        $result = $result->result();
        if (!empty($result)) {
            // foreach ($result as $item) {
            //     //$item->current_affair_image_path = base_url('AppAPI/current-affairs/' . $item->current_affair_image);
            //     $item->issave = $this->isBookmarked_vocabulary($item->id, $request['login_id']);
            // }
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'success';
            $json_arr['image_path'] = base_url() . 'assets/uploads/english_vocabulary/images/';
            $json_arr['data'] = $result;
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'No Data Found.';
            $json_arr['image_path'] = base_url() . 'assets/uploads/english_vocabulary/images/';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr);
    }

    public function get_whatsapp_number_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $this->db->where('is_deleted', '0');
        $this->db->where('status', '1');
        $result = $this->db->get('tbl_whatsapp_details');
        $result = $result->result();

        if (!empty($result)) {
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'success';
            $json_arr['data'] = $result;
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'No Data Found.';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr);
    }

    public function set_user_english_vocabulary_bookmark_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        if ($request) {
            if (!empty($request['login_id']) && !empty($request['english_vocabulary_id'])) {
                $login_id = $request['login_id'];
                $english_vocabulary_id = $request['english_vocabulary_id'];

                $this->db->where('english_vocabulary_id', $english_vocabulary_id);
                $this->db->where('login_id', $login_id);
                $result = $this->db->get('english_vocabulary_saved');
                $result = $result->row();

                if (!empty($result)) {
                    $this->db->where('english_vocabulary_saved_id', $result->english_vocabulary_saved_id);
                    $this->db->delete('english_vocabulary_saved');

                    $json_arr['status'] = 'true';
                    $json_arr['message'] = 'English Vocabulary removed successfully.';
                } else {
                    $data = array(
                        'login_id' => $login_id,
                        'english_vocabulary_id' => $english_vocabulary_id,
                        'status' => 'Active'
                    );
                    $this->db->insert('english_vocabulary_saved', $data);
                    $json_arr['status'] = 'true';
                    $json_arr['message'] = 'English Vocabulary saved successfully.';
                }
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'User ID and English Vocabulary ID are required.';
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Invalid request.';
        }
        echo json_encode($json_arr);
    }

    public function set_user_marathi_sabd_sangrah_bookmark_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        if ($request) {
            if (!empty($request['login_id']) && !empty($request['marathi_sabd_id'])) {
                $login_id = $request['login_id'];
                $marathi_sabd_id = $request['marathi_sabd_id'];

                $this->db->where('marathi_sabd_id', $marathi_sabd_id);
                $this->db->where('login_id', $login_id);
                $result = $this->db->get('marathi_sabd_saved');
                $result = $result->row();

                if (!empty($result)) {
                    $this->db->where('marathi_sabd_saved_id', $result->marathi_sabd_saved_id);
                    $this->db->delete('marathi_sabd_saved');

                    $json_arr['status'] = 'true';
                    $json_arr['message'] = 'Marathi Sabd Sangrah removed successfully.';
                } else {
                    $data = array(
                        'login_id' => $login_id,
                        'marathi_sabd_id' => $marathi_sabd_id,
                        'status' => 'Active'
                    );
                    $this->db->insert('marathi_sabd_saved', $data);
                    $json_arr['status'] = 'true';
                    $json_arr['message'] = 'Marathi Sabd Sangrah saved successfully.';
                }
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'User ID and Marathi Sabd Sangrah ID are required.';
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Invalid request.';
        }
        echo json_encode($json_arr);
    }

    public function delete_active_user()
    {
        $request = json_decode(file_get_contents('php://input'), true);

        if ($request) {
            if (!empty($request['login_id'])) {
                $login_id = $request['login_id'];
                $this->db->where('login_id', $login_id);
                $query = $this->db->get('user_login');
                // print_r($query);
                // exit;
                if ($query->num_rows() > 0) {
                    $result = $query->row();
                    $this->db->where('login_id', $login_id);
                    $this->db->update('user_login', ['status' => 'Inactive']);
                    $json_arr['status'] = 'true';
                    $json_arr['message'] = 'Success.';
                } else {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'Invalid request.';
                }
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'User ID is required.';
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Invalid request.';
        }
        echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
    }

    public function get_mpsc_all_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        if ($request) {
            if (!empty($request['login_id'])) {
                $user_id = $request['login_id'];
                $category_id = $request['category_id'];
                $sub_category_id = $request['sub_category_id'];
                $this->db->where('login_id', $user_id);
                $single = $this->db->get('user_login')->row();
                if (!empty($single)) {

                    if (!empty($category_id) && !empty($sub_category_id)) {

                        $this->db->select('tbl_ebooks.id AS ebook_id, tbl_ebooks.title, tbl_ebooks.image, tbl_ebook_category.id AS category_id, tbl_ebook_sub_category.id AS sub_category_id');
                        $this->db->from('tbl_ebooks');
                        $this->db->join('tbl_ebook_category', 'tbl_ebook_category.id = tbl_ebooks.category_id', 'left');
                        $this->db->join('tbl_ebook_sub_category', 'tbl_ebook_sub_category.id = tbl_ebooks.sub_category_id', 'left');
                        $this->db->where('tbl_ebooks.is_deleted', '0');
                        $this->db->where('tbl_ebooks.status', '1');
                        if (isset($category_id)) {
                            $this->db->where('tbl_ebooks.category_id', $category_id);
                        }
                        if (isset($sub_category_id)) {
                            $this->db->where('tbl_ebooks.sub_category_id', $sub_category_id);
                        }
                        $this->db->order_by('tbl_ebooks.id', 'DESC');
                        $result = $this->db->get();
                        $ebook_list = $result->result();

                        if (!empty($ebook_list)) {
                            $data = [];
                            foreach ($ebook_list as $ebook_list_result) {
                                $data[] = array(
                                    'id'         =>  $ebook_list_result->ebook_id,
                                    'category_id'         =>  $ebook_list_result->category_id,
                                    'sub_category_id'         =>  $ebook_list_result->sub_category_id,
                                    'title'      =>  $ebook_list_result->title,
                                    'image'       =>  $ebook_list_result->image != "" ? base_url('/assets/ebook_images/' . $ebook_list_result->image) : '',
                                );
                            }
                            $json_arr['status'] = 'true';
                            $json_arr['message'] = 'Success';
                            $json_arr['data'] = $data;
                        } else {
                            $json_arr['status'] = 'false';
                            $json_arr['message'] = 'Ebook not found';
                            $json_arr['data'] = [];
                        }
                    } else {
                        $json_arr['status'] = 'false';
                        $json_arr['message'] = 'Category and Sub-Category not found';
                        $json_arr['data'] = [];
                    }
                } else {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'User not found';
                    $json_arr['data'] = [];
                }
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Login not available.';
                $json_arr['data'] = [];
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Request not found.';
            $json_arr['data'] = [];
        }
        echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
    }




    public function mpsc_all_subjectwise_external_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $user_id = $request['login_id'];
        $exam_material_id = $request['exam_material_id'];
        $offset = $request['offset'];
        $limit = $request['limit'];

        $this->db->select('tbl_exam_material_subjectwise_test.*,tbl_exam_material_subjects.id,tbl_exam_material_subjects.title,tbl_exam_material_subjects.icon');

        $this->db->join('tbl_exam_material_subjects', 'tbl_exam_material_subjects.id = tbl_exam_material_subjectwise_test.subject_id');

        $this->db->from('tbl_exam_material_subjectwise_test');
        $this->db->where('tbl_exam_material_subjectwise_test.exam_material_id', $exam_material_id);
        $this->db->where('tbl_exam_material_subjectwise_test.is_deleted', '0');
        $this->db->where('tbl_exam_material_subjectwise_test.status', '1');
        $this->db->limit($limit, $offset);
        $this->db->group_by('tbl_exam_material_subjectwise_test.subject_id');
        $exist = $this->db->get()->result();
        // print_r($exist);
        // exit;
        if (!empty($exist)) {
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'MPSC Subjects retrieved successfully.';
            $json_arr['data'] = $exist;
            $json_arr['image_path'] = base_url() . 'assets/uploads/exam_material/images/';
            // $json_arr['image_path'] = base_url();
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'MPSC Subjects not available.';
            $json_arr['data'] = [];
            $json_arr['image_path'] = base_url() . 'assets/uploads/exam_material/images/';
            // $json_arr['image_path'] = base_url();
        }
        echo json_encode($json_arr);
    }

    public function exam_material_subjectwise_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $user_id = $request['login_id'];
        $exam_material_id = $request['exam_material_id'];
        $offset = $request['offset'];
        $limit = $request['limit'];
        $this->db->select('tbl_exam_material_subjectwise_test.*,tbl_exam_material_subjects.id,tbl_exam_material_subjects.title,tbl_exam_material_subjects.icon');
        $this->db->join('tbl_exam_material_subjects', 'tbl_exam_material_subjects.id = tbl_exam_material_subjectwise_test.subject_id');
        $this->db->from('tbl_exam_material_subjectwise_test');
        if ($exam_material_id != '') {
            $this->db->where('tbl_exam_material_subjectwise_test.exam_material_id', $exam_material_id);
        }
        $this->db->where('tbl_exam_material_subjectwise_test.is_deleted', '0');
        $this->db->where('tbl_exam_material_subjectwise_test.status', '1');
        $this->db->limit($limit, $offset);
        $this->db->group_by('tbl_exam_material_subjectwise_test.subject_id');
        $exist = $this->db->get()->result();
        // print_r($exist);
        // exit;
        if (!empty($exist)) {
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'MPSC Subjects retrieved successfully.';
            $json_arr['data'] = $exist;
            $json_arr['image_path'] = base_url() . 'assets/uploads/exam_material/images/';
            // $json_arr['image_path'] = base_url();
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'MPSC Subjects not available.';
            $json_arr['data'] = [];
            $json_arr['image_path'] = base_url() . 'assets/uploads/exam_material/images/';
            // $json_arr['image_path'] = base_url();
        }
        echo json_encode($json_arr);
    }

    public function exam_material_examwise_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $user_id = $request['login_id'];
        $exam_material_id = $request['exam_material_id'];
        $offset = $request['offset'];
        $limit = $request['limit'];
        $this->db->select('tbl_exam_material_examwise_test.*,tbl_exam_material_exams.id,tbl_exam_material_exams.title,tbl_exam_material_exams.icon');
        $this->db->join('tbl_exam_material_exams', 'tbl_exam_material_exams.id = tbl_exam_material_examwise_test.exam_id');
        $this->db->from('tbl_exam_material_examwise_test');
        if ($exam_material_id != '') {
            $this->db->where('tbl_exam_material_examwise_test.exam_material_id', $exam_material_id);
            // $this->db->where('type', (string)$type);
        }
        $this->db->where('tbl_exam_material_examwise_test.is_deleted', '0');
        $this->db->where('tbl_exam_material_examwise_test.status', '1');
        $this->db->limit($limit, $offset);
        $this->db->group_by('tbl_exam_material_examwise_test.exam_id');
        $exist = $this->db->get()->result();
        // print_r($exist);
        // exit;
        if (!empty($exist)) {
            $json_arr['status'] = 'true';
            $json_arr['message'] = 'MPSC Exams retrieved successfully.';
            $json_arr['data'] = $exist;
            $json_arr['image_path'] = base_url() . 'assets/uploads/exam_material/images/';
            // $json_arr['image_path'] = base_url();
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'MPSC Exams not available.';
            $json_arr['data'] = [];
            $json_arr['image_path'] = base_url() . 'assets/uploads/exam_material/images/';
            // $json_arr['image_path'] = base_url();
        }
        echo json_encode($json_arr);
    }

    public function exam_material_subjectwise_tests_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $user_id = $request['login_id'];
        $exam_material_id = $request['exam_material_id'];
        $subject_id = $request['subject_id'];
        $offset = $request['offset'];
        $limit = $request['limit'];
        $this->db->select('tbl_subjectwise_tests.*,tbl_exam_material_subjects.id,tbl_exam_material_subjects.title,tbl_exam_material_subjects.icon');
        $this->db->join('tbl_exam_material_subjects', 'tbl_exam_material_subjects.id = tbl_subjectwise_tests.subject_id');
        $this->db->from('tbl_subjectwise_tests');
        if ($exam_material_id != '') {
            $this->db->where('tbl_subjectwise_tests.exam_material_id', $exam_material_id);
        }
        if ($subject_id != '') {
            $this->db->where('tbl_subjectwise_tests.subject_id', $subject_id);
        }
        $this->db->where('tbl_subjectwise_tests.is_deleted', '0');
        $this->db->where('tbl_subjectwise_tests.status', '1');
        $this->db->limit($limit, $offset);
        // $this->db->group_by('tbl_exam_material_subjectwise_test.subject_id');
        // $exist = $this->db->get()->result();
        // print_r($exist);
        // exit;
        $exist = $this->db->get()->row();
        if (!empty($exist)) {
            if ($exist->tests != "") {
                $test = explode(',', $exist->tests);
                $tests = array();
                if (!empty($test)) {
                    for ($i = 0; $i < count($test); $i++) {
                        $this->db->where('id', $test[$i]);
                        $this->db->where('is_deleted', '0');
                        $single_test = $this->db->get('tbl_test_setups')->row();
                        if (!empty($single_test)) {
                            $this->db->where('test_id', $single_test->id);
                            $this->db->where('user_id', $user_id);
                            $this->db->where('is_deleted', '0');
                            $this->db->where('parent_module', 'exam_material');
                            $attempted_test = $this->db->get('tbl_attempted_test')->row();
                            if (!empty($attempted_test)) {
                                $is_test_attempted = '1';
                                $attempted_test_id = $attempted_test->id;
                            } else {
                                $is_test_attempted = '0';
                                $attempted_test_id = '';
                            }
                            if ($single_test->show_ans == 'Yes') {
                                $show_correct_ans = '1';
                            } else {
                                $show_correct_ans = '0';
                            }

                            if ($single_test->download_test_pdf == 'Yes') {
                                $download_test_pdf = '1';
                                $test_pdf_link = $single_test->test_pdf != '' ? (base_url() . 'assets/uploads/test_pdfs/' . $single_test->test_pdf) : '';
                            } else {
                                $download_test_pdf = '0';
                                $test_pdf_link = '';
                            }

                            $tests[] = array(
                                'exam_id'             =>  $exist->exam_material_id,
                                'is_test_attempted'     =>  $is_test_attempted,
                                'attempted_test_id'     =>  $attempted_test_id,
                                'test_id'               =>  $single_test->id,
                                'topic'                 =>  $single_test->topic,
                                'short_note'            =>  $single_test->short_note,
                                'short_description'     =>  $single_test->short_description,
                                'duration'              =>  $single_test->duration,
                                'total_questions'       =>  $single_test->total_questions,
                                'total_marks'           =>  $single_test->total_marks,
                                'image'                 =>  $single_test->image,

                                'is_show_correct_ans'  => $show_correct_ans,
                                'is_download_test_pdf' => $download_test_pdf,
                                'test_pdf_link'        => $test_pdf_link,
                            );
                        }
                    }
                }

                if (!empty($tests)) {
                    $json_arr['status'] = 'true';
                    $json_arr['message'] = 'MPSC Subjects Test retrieved successfully.';
                    $json_arr['data'] = $tests;
                    $json_arr['image_path'] = base_url() . 'assets/uploads/test_setup/images/';
                } else {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'MPSC Subjects Test not retrieved successfully.';
                    $json_arr['data'] = [];
                    $json_arr['image_path'] = base_url() . 'assets/uploads/test_setup/images/';
                }
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Subject tests not available.';
                $json_arr['data'] = [];
                $json_arr['image_path'] = base_url() . 'assets/uploads/test_setup/images/';
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Subject not available.';
            $json_arr['data'] = [];
            $json_arr['image_path'] = base_url() . 'assets/uploads/test_setup/images/';
        }

        // if (!empty($exist)) {
        //     $json_arr['status'] = 'true';
        //     $json_arr['message'] = 'MPSC Subjects retrieved successfully.';
        //     $json_arr['data'] = $exist;
        //     $json_arr['image_path'] = base_url() . 'assets/uploads/exam_material/images/';
        //     // $json_arr['image_path'] = base_url();
        // } else {
        //     $json_arr['status'] = 'false';
        //     $json_arr['message'] = 'MPSC Subjects not available.';
        //     $json_arr['data'] = [];
        //     $json_arr['image_path'] = base_url() . 'assets/uploads/exam_material/images/';
        //     // $json_arr['image_path'] = base_url();
        // }
        echo json_encode($json_arr);
    }

    public function exam_material_examwise_tests_api()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $user_id = $request['login_id'];
        $exam_material_id = $request['exam_material_id'];
        $exam_id = $request['exam_id'];
        $offset = $request['offset'];
        $limit = $request['limit'];
        $exam_year_id = $request['exam_year_id'];
        $exam_type_id = $request['exam_type_id'];
        $this->db->select('tbl_examwise_tests.*,tbl_exam_material_exams.id,tbl_exam_material_exams.title,tbl_exam_material_exams.icon');
        $this->db->join('tbl_exam_material_exams', 'tbl_exam_material_exams.id = tbl_examwise_tests.exam_name');
        $this->db->from('tbl_examwise_tests');
        $this->db->where('tbl_examwise_tests.exam_type', $exam_type_id);
        $this->db->where('tbl_examwise_tests.exam_year', $exam_year_id);
        $this->db->where('tbl_examwise_tests.exam_material_id', $exam_material_id);
        $this->db->where('tbl_examwise_tests.exam_name', $exam_id);
        $this->db->where('tbl_examwise_tests.is_deleted', '0');
        $this->db->where('tbl_examwise_tests.status', '1');
        $this->db->limit($limit, $offset);
        $exist = $this->db->get()->row();
        // print_r($exist);
        // exit;
        if (!empty($exist)) {
            if ($exist->tests != "") {
                $test = explode(',', $exist->tests);
                $tests = array();
                if (!empty($test)) {
                    for ($i = 0; $i < count($test); $i++) {
                        $this->db->where('id', $test[$i]);
                        $this->db->where('is_deleted', '0');
                        $single_test = $this->db->get('tbl_test_setups')->row();
                        if (!empty($single_test)) {
                            $this->db->where('test_id', $single_test->id);
                            $this->db->where('user_id', $user_id);
                            $this->db->where('is_deleted', '0');
                            $this->db->where('parent_module', 'exam_material');
                            $attempted_test = $this->db->get('tbl_attempted_test')->row();
                            if (!empty($attempted_test)) {
                                $is_test_attempted = '1';
                                $attempted_test_id = $attempted_test->id;
                            } else {
                                $is_test_attempted = '0';
                                $attempted_test_id = '';
                            }
                            if ($single_test->show_ans == 'Yes') {
                                $show_correct_ans = '1';
                            } else {
                                $show_correct_ans = '0';
                            }

                            if ($single_test->download_test_pdf == 'Yes') {
                                $download_test_pdf = '1';
                                $test_pdf_link = $single_test->test_pdf != '' ? (base_url() . 'assets/uploads/test_pdfs/' . $single_test->test_pdf) : '';
                            } else {
                                $download_test_pdf = '0';
                                $test_pdf_link = '';
                            }

                            $tests[] = array(
                                'exam_id'             =>  $exist->exam_material_id,
                                'is_test_attempted'     =>  $is_test_attempted,
                                'attempted_test_id'     =>  $attempted_test_id,
                                'test_id'               =>  $single_test->id,
                                'topic'                 =>  $single_test->topic,
                                'short_note'            =>  $single_test->short_note,
                                'short_description'     =>  $single_test->short_description,
                                'duration'              =>  $single_test->duration,
                                'total_questions'       =>  $single_test->total_questions,
                                'total_marks'           =>  $single_test->total_marks,
                                'image'                 =>  $single_test->image,

                                'is_show_correct_ans'  => $show_correct_ans,
                                'is_download_test_pdf' => $download_test_pdf,
                                'test_pdf_link'        => $test_pdf_link,
                            );
                        }
                    }
                }

                if (!empty($tests)) {
                    $json_arr['status'] = 'true';
                    $json_arr['message'] = 'Exam tests retrieved successfully.';
                    $json_arr['data'] = $tests;
                    $json_arr['image_path'] = base_url() . 'assets/uploads/test_setup/images/';
                } else {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'Exam tests not available.';
                    $json_arr['data'] = [];
                    $json_arr['image_path'] = base_url() . 'assets/uploads/test_setup/images/';
                }
            } else {
                $json_arr['status'] = 'false';
                $json_arr['message'] = 'Exam tests not available.';
                $json_arr['data'] = [];
                $json_arr['image_path'] = base_url() . 'assets/uploads/test_setup/images/';
            }
        } else {
            $json_arr['status'] = 'false';
            $json_arr['message'] = 'Exam not available.';
            $json_arr['data'] = [];
            $json_arr['image_path'] = base_url() . 'assets/uploads/test_setup/images/';
        }
        echo json_encode($json_arr);
    }
    public function get_recent_post_api_exam_material()
    {
        $request = json_decode(file_get_contents('php://input'), true);

        if ($request) {
            if (isset($request['login_id'])) {
                $user_id = $request['login_id'];
                $exam_material_id = $request['exam_material_id'];
                $offset = $request['offset'];
                $limit = $request['limit'];

                $this->db->select('
                    tbl_examwise_pdf.id AS examwise_id,
                    tbl_examwise_pdf.exam_material_id,
                    tbl_examwise_pdf.title AS exam_title,
                    tbl_examwise_pdf.short_description AS exam_short_description,
                    tbl_examwise_pdf.pdf AS exam_pdf,
                    tbl_examwise_pdf.image AS exam_image,
                    tbl_examwise_pdf.status AS exam_status,
                    tbl_examwise_pdf.is_deleted AS exam_deleted,
                    tbl_examwise_pdf.created_on AS created_on
                ');
                $this->db->where('tbl_examwise_pdf.exam_material_id', $exam_material_id);
                $this->db->where('tbl_examwise_pdf.status', '1');
                $this->db->where('tbl_examwise_pdf.is_deleted', '0');
                // $this->db->limit($limit, $offset);
                $examwise_result = $this->db->get('tbl_examwise_pdf')->result_array();

                $this->db->select('
                    tbl_subjectwise_pdf.id AS subjectwise_id,
                    tbl_subjectwise_pdf.exam_material_id AS exam_material_id,
                    tbl_subjectwise_pdf.title AS exam_title,
                    tbl_subjectwise_pdf.short_description AS exam_short_description,
                    tbl_subjectwise_pdf.pdf AS exam_pdf,
                    tbl_subjectwise_pdf.image AS exam_image,
                    tbl_subjectwise_pdf.status AS exam_status,
                    tbl_subjectwise_pdf.is_deleted AS exam_deleted,
                    tbl_subjectwise_pdf.created_on AS created_on
                ');
                $this->db->where('tbl_subjectwise_pdf.exam_material_id', $exam_material_id);
                $this->db->where('tbl_subjectwise_pdf.status', '1');
                $this->db->where('tbl_subjectwise_pdf.is_deleted', '0');
                // $this->db->limit($limit, $offset);
                $subjectwise_result = $this->db->get('tbl_subjectwise_pdf')->result_array();

                $merged_results = array_merge($examwise_result, $subjectwise_result);
                usort($merged_results, function ($a, $b) {
                    return strtotime($b['created_on']) - strtotime($a['created_on']); // Newest first
                });

                $paginated_results = array_slice($merged_results, $offset, $limit);

                if (!empty($paginated_results)) {
                    $json_arr['status'] = 'true';
                    $json_arr['message'] = 'Success';
                    $json_arr['data'] = $paginated_results;
                    $json_arr['image_path'] = base_url() . 'assets/uploads/exam_material/images/';
                    $json_arr['pdf_path'] = base_url() . 'assets/uploads/exam_material/pdf/';
                } else {
                    $json_arr['status'] = 'false';
                    $json_arr['message'] = 'No post found.';
                    $json_arr['data'] = [];
                    $json_arr['image_path'] = base_url() . 'assets/uploads/exam_material/images/';
                    $json_arr['pdf_path'] = base_url() . 'assets/uploads/exam_material/pdf/';
                }

                echo json_encode($json_arr);
            } else {
                echo json_encode(['status' => 'false', 'message' => 'User ID is required.']);
            }
        } else {
            echo json_encode(['status' => 'false', 'message' => 'Invalid request.']);
        }
    }

    public function update_memberships(){
        $this->db->where("is_active_membership",'1');
        $result = $this->db->get("user_login")->result();
        if(!empty($result)){
            $flag = '0';
            foreach($result as $data){   
                $this->db->select('tbl_my_membership.id, tbl_my_membership.membership_id, tbl_my_membership.login_id, tbl_my_membership.start_date, tbl_my_membership.end_date, tbl_my_membership.amount, tbl_my_membership.payment_id, tbl_my_membership.status, tbl_my_membership.is_deleted, tbl_my_membership.created_at, tbl_my_membership.updated_at, membership_plans.title as membership_title');
                $this->db->join('membership_plans', 'membership_plans.id = tbl_my_membership.membership_id');
                $this->db->join('user_login', 'user_login.login_id = tbl_my_membership.login_id');
                $this->db->where('CURDATE() BETWEEN tbl_my_membership.start_date AND tbl_my_membership.end_date');
                $this->db->where('tbl_my_membership.is_deleted', '0');
                $this->db->where('tbl_my_membership.login_id', $data->login_id);
                $this->db->where('tbl_my_membership.id', $data->my_membership_id);
                $this->db->order_by('tbl_my_membership.id', 'desc');
                $membership_details = $this->db->get('tbl_my_membership')->row();
                if(empty($membership_details)){
                    $flag = '1';
                    $update_data = array(
                        'is_active_membership'  =>  '0',
                        'membership_id'         =>  null,
                        'end_date'              =>  null,
                        'start_date'            =>  null,
                        'my_membership_id'      =>  null
                    );
                    $this->db->where("login_id",$data->login_id);
                    $this->db->update("user_login",$update_data);
                }
            }

            if($flag == '1'){
                echo json_encode(['status' => 'true', 'message' => 'Memberships updated successfully']);
            }else{
                echo json_encode(['status' => 'false', 'message' => 'Expired memberships not available']);
            }
        }else{
            echo json_encode(['status' => 'false', 'message' => 'Active memberships not available']);
        }
    }
}
