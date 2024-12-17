<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class APIController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $JWTSecretKey = 'mahaTestApp';
        date_default_timezone_set('Asia/Kolkata');
        @header('Content_Type: application/json');
    }

    public function get_slider_details()
    {
        $this->load->model("Introduction_screens_model");
        $result = $this->Introduction_screens_model->getAllData();
        $data = [];
        if ($result) {
            $data['status'] = 'Success';
            $data['data'] = $result;
        } else {
            $data['status'] = 'Failure';
        }
        echo json_encode($data);
    }

    public function getStateList()
    {
        $this->load->model("State_model");
        $result = $this->State_model->getStateList();
        $data = [];
        if ($result) {
            $data['status'] = 'Success';
            $data['data'] = $result;
        } else {
            $data['status'] = 'Failure';
        }
        echo json_encode($data);
    }

    public function getDistrictList($id)
    {
        $this->load->model("District_model");
        $result = $this->District_model->getDistrictList($id);
        $data = [];
        if ($result) {
            $data['status'] = 'Success';
            $data['data'] = $result;
        } else {
            $data['status'] = 'Failure';
        }
        echo json_encode($data);
    }


    function now()
    {
        date_default_timezone_set('Asia/Kolkata');
        return date('Y-m-d H:i:s');
    }

    public function userRegistration()
    {
        $jsonArray = json_decode(file_get_contents('php://input'), true);
        // print_r($jsonArray);die;
        $data = [];

        $this->load->model("AppUsers_API_model");
        $checkMobileExist = $this->AppUsers_API_model->getDetailByWhereConditionArr(['mobile_number' => $jsonArray['mobile_no']]);
        if ($checkMobileExist) {
            $data['status'] = 'Failure';
            $data['message'] = "Mobile No. already exist";
        } else {
            $arr = [
                'full_name' => $jsonArray['name'],
                'email' => $jsonArray['email'],
                'gender' => $jsonArray['gender'],
                'mobile_number' => $jsonArray['mobile_no'],
                'state_id' => $jsonArray['state_id'],
                'district_id' => $jsonArray['district_id'],
                'device_id' => $jsonArray['device_id'],
                'created_at' => $this->now()
            ];
            //print_r($arr);die;
            $result = $this->AppUsers_API_model->save_user($arr);
            //print_r($result);die;
            if ($result == 'Inserted') {
                $data['status'] = 'Success';
                $data['message'] = "User registration is done successfully!!";
            } else {
                $data['status'] = 'Failure';
                $data['message'] = "User registration is not done successfully!!";
            }
        }

        echo json_encode($data);

    }

    public function verify_mobile_no()
    {
        $data = [];
        $jsonArray = json_decode(file_get_contents('php://input'), true);
        // print_r($jsonArray);die;


        $this->load->model("AppUsers_API_model");
        $user = $this->AppUsers_API_model->getDetailByWhereConditionArr([
            'mobile_number' => $jsonArray['mobile_no']]);
        if ($user) {
            $jwt = new JWT();
            $now = date("Y-m-d H:i:s", strtotime("+90 days"));
            // $now=date("Y-m-d h:i:s");

            $user['iat'] = date("Y-m-d H:i:s");
            $user['exp'] = $now;
            //print_r($user);die;
            $token = $jwt->encode($user, $this->JWTSecretKey, 'HS256');
            $data['status'] = 'Success';
            $data['token'] = $token;
        } else {
            $data['status'] = 'Failure';
            $data['message'] = "Mobile No. is not registered";
        }

        echo json_encode($data);
    }


    public function getUserDetail()
    {
        $headerToken = $this->input->get_request_header('Authorization');
        //var_dump($headerToken);die;
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];
        //echo $token;die;

        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            //print_r($token1);die;
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');

                //print_r($data->exp);die;
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {

                    echo json_encode($data);
                }

            }
        } catch (Exception $e) {
            $error = [
                'status' => 401,
                'message' => 'Invalid Token Provided',
                'success' => false
            ];
            echo json_encode($error);
        }
    }


    public function userlogout()
    {
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];
        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            //print_r($token);die;
            if ($token1) {
                $jwt = new JWT();

                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                //print_r($data);die;
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '',
                        'message' => "User Logout Successfully!!"]);
                } else {
                    echo json_encode(['data' => $data,
                        'message' => "Token is valid"]);
                }
            }
        } catch (Exception $e) {
            //print_r($e);die;
            $error = ['status' => 401,
                'message' => 'Invalid Token Provided',
                'success' => false];
            echo json_encode($error);
        }

    }

    public function validateToken()
    {
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];

        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);

            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');

                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    $error = [
                        'status' => 401,
                        'message' => 'Token is expired!!',
                        'success' => false
                    ];
                    return json_encode($error);
                } else {
                    $response = ['status' => 200,
                        'data' => $data,
                        'success' => true];
                    return json_encode($response);
                }
            } else {
                $error = [
                    'status' => 401,
                    'message' => 'Token is not found!!',
                    'success' => false
                ];
                return json_encode($error);
            }
        } catch (Exception $e) {
            $error = [
                'status' => 401,
                'message' => 'Invalid Token Provided',
                'success' => false
            ];
            return json_encode($error);
        }
    }

    public function userUpdateDeviceId()
    {
        $jsonArray = json_decode(file_get_contents('php://input'), true);
        $validate = json_decode($this->validateToken());
        if ($validate->success == true) {

            $this->load->model("AppUsers_API_model");
            $user = $this->AppUsers_API_model->update($validate->data->login_id,
                ['device_id' => $jsonArray['device_id']]);

            echo json_encode([
                'status' => 'Success',
                'message' => "Device Id Updated."]);

        } else {
            echo json_encode($validate);
        }

    }

    public function getHomePageDetail()
    {
        try {
            $headerToken = $this->input->get_request_header('Authorization');
            //var_dump($headerToken);die;
            $splitToken = explode(" ", $headerToken);
            $token = $splitToken[1];
            //echo $token;die;

            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            //print_r($token1);die;
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                //print_r($data->exp);die;
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model("Banner_model");
                    $getBannerDetail = $this->Banner_model->getAllData();
                    $this->load->model("Exam_section_model");
                    $sectionDetail = $this->Exam_section_model->getAllData();
                    $this->load->model("Exam_subject_model");
                    $subjectDetail = $this->Exam_subject_model->getAllDataBySection("MPSC", 6);
                    $this->load->model("SuccessReview_model");
                    $successReviews = $this->SuccessReview_model->getAllData(4);
                    $this->load->model("AppSettings_model");
                    $appSettings = $this->AppSettings_model->getRecordById('app_footer_info');
                    echo json_encode(['getBannerDetail' => $getBannerDetail,
                        'sectionDetail' => $sectionDetail,
                        'subjectDetail' => $subjectDetail,
                        'successReviews' => $successReviews,
                        'appSettings' => $appSettings]);

                }

            }
        } catch (Exception $e) {
            $error = [
                'status' => 401,
                'message' => 'Invalid Token Provided',
                'success' => false
            ];
            echo json_encode($error);
        }
    }

    public function userFeedbackPost()
    {
        $jsonArray = json_decode(file_get_contents('php://input'), true);
        $headerToken = $this->input->get_request_header('Authorization');
        //var_dump($headerToken);die;
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];
        //echo $token;die;
        // print_r($jsonArray);die;
        //echo $jsonArray['feedback'];die;
        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            //print_r($token1);die;
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                //print_r($data);die;
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model("Feedback_model");
                    $result = $this->Feedback_model->save($data->login_id, $jsonArray['feedback'], date('Y-m-d H:i:s'));
                    //print_r($result);die;
                    if ($result == 'Inserted') {
                        $status = 'Success';
                        $msg = 'Feedback is saved successfully!!';
                    } else {
                        $status = 'Failed';
                        $msg = 'Feedback is not saved successfully!!';
                    }

                    echo json_encode(['status' => $status, 'message' => $msg]);


                }

            }
        } catch (Exception $e) {
            $error = [
                'status' => 401,
                'message' => 'Invalid Token Provided',
                'success' => false
            ];
            echo json_encode($error);
        }
    }

    public function getCategoryDetails()
    {
        $jsonArray = json_decode(file_get_contents('php://input'), true);
        $headerToken = $this->input->get_request_header('Authorization');
        //var_dump($headerToken);die;
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];
        //echo $token;die;
        // print_r($jsonArray);die;
        //echo $jsonArray['feedback'];die;
        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            //print_r($token1);die;
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                //print_r($data);die;
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model("Category_model");
                    $data = [];
                    $data['status'] = 'Active';
                    if ($jsonArray['section']) {
                        $data['section'] = $jsonArray['section'];
                    }
                    if ($jsonArray['year']) {
                        $data["YEAR(created_at)"] = $jsonArray['year'];
                    }
                    //print_r($data);die;
                    $result = $this->Category_model->getDataByWhereCondition($data);
                    //print_r($result);die;
                    if ($result) {
                        $status = 'Success';
                    } else {
                        $status = 'Failed';
                    }

                    echo json_encode(['status' => $status, 'data' => $result]);


                }

            }
        } catch (Exception $e) {
            $error = [
                'status' => 401,
                'message' => 'Invalid Token Provided',
                'success' => false
            ];
            echo json_encode($error);
        }
    }

    public function getCurrentAffairsCategoryDetail()
    {
        $jsonArray = json_decode(file_get_contents('php://input'), true);
        $headerToken = $this->input->get_request_header('Authorization');
        //var_dump($headerToken);die;
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];
        //echo $token;die;
        // print_r($jsonArray);die;
        //echo $jsonArray['feedback'];die;
        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            //print_r($token1);die;
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                //print_r($data);die;
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model('CurrentAffairs_model');
                    $result = $this->CurrentAffairs_model->getAllDataAccordingToCategory($jsonArray['category'], $data->login_id);

                    //print_r($result);die;
                    if ($result) {
                        $status = 'Success';
                    } else {
                        $status = 'Failed';
                    }

                    echo json_encode(['status' => $status, 'data' => $result]);

                }

            }
        } catch (Exception $e) {
            $error = [
                'status' => 401,
                'message' => 'Invalid Token Provided',
                'success' => false
            ];
            echo json_encode($error);
        }
    }

    public function currentAffairsPageDetail()
    {
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];
        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            //print_r($token);die;
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                //print_r($data);die;
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model('CurrentAffairs_model');
                    $this->load->model('CurrentAffairSetting_model');
                    $result = $this->CurrentAffairSetting_model->getPostById(1);
                    $categoryResult = [];
                    if ($result) {
                        $categoryResult = $this->CurrentAffairs_model->getDataByGroupByCategoryCondition(6);
                        //print_r($categoryResult);die;
                        $YearResult = $this->CurrentAffairs_model->getDataByGroupByYearCondition(6);
                        //print_r($YearResult);die;
                        $recentResult = $this->CurrentAffairs_model->getRecentData($data->login_id);
                        $status = 'Success';
                    } else {
                        $status = 'Failed';
                    }

                    echo json_encode(['status' => $status,
                        'data' => $result,
                        'categoryWiseData' => $categoryResult,
                        'yearWiseData' => $YearResult,
                        'recentData' => $recentResult]);

                }
            }
        } catch (Exception $e) {
            //print_r($e);die;
            $error = ['status' => 401, 'message' => 'Invalid Token Provided', 'success' => false];
            echo json_encode($error);
        }

    }

    public function currentAffairsAllCategoryWiseDetail()
    {
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];
        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            //print_r($token);die;
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                //print_r($data);die;
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model('CurrentAffairs_model');
                    $categoryResult = $this->CurrentAffairs_model->getDataByGroupByCategoryCondition();
                    if ($categoryResult) {
                        $status = 'Success';
                    } else {
                        $status = 'Failed';
                    }
                    echo json_encode(['status' => $status, 'data' => $categoryResult]);
                }
            }
        } catch (Exception $e) {
            //print_r($e);die;
            $error = ['status' => 401, 'message' => 'Invalid Token Provided', 'success' => false];
            echo json_encode($error);
        }

    }

    public function currentAffairsAllYearDetail()
    {
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];
        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            //print_r($token);die;
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                //print_r($data);die;
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model('CurrentAffairs_model');
                    $YearResult = $this->CurrentAffairs_model->getDataByGroupByYearCondition(4);
                    if ($YearResult) {
                        $status = 'Success';
                    } else {
                        $status = 'Failed';
                    }
                    echo json_encode(['status' => $status, 'data' => $YearResult]);
                }
            }
        } catch (Exception $e) {
            //print_r($e);die;
            $error = ['status' => 401, 'message' => 'Invalid Token Provided', 'success' => false];
            echo json_encode($error);
        }

    }

    public function currentAffairsYearDetail()
    {
        $jsonArray = json_decode(file_get_contents('php://input'), true);
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];
        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            //print_r($token);die;
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                //print_r($data);die;
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model('CurrentAffairs_model');
                    $result = $this->CurrentAffairs_model->getAllDataAccordingToYear($jsonArray['year'], $data->login_id);
                    if ($result) {
                        $status = 'Success';
                    } else {
                        $status = 'Failed';
                    }

                    echo json_encode(['status' => $status, 'data' => $result]);
                }
            }
        } catch (Exception $e) {
            //print_r($e);die;
            $error = ['status' => 401, 'message' => 'Invalid Token Provided', 'success' => false];
            echo json_encode($error);
        }

    }


    public function getFAQDetails()
    {
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];
        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            //print_r($token);die;
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                //print_r($data);die;
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model('FAQ_model');
                    $faqResult = $this->FAQ_model->getAllData();
                    if ($faqResult) {
                        $status = 'Success';
                    } else {
                        $status = 'Failed';
                    }
                    echo json_encode(['status' => $status, 'data' => $faqResult]);
                }
            }
        } catch (Exception $e) {
            //print_r($e);die;
            $error = ['status' => 401, 'message' => 'Invalid Token Provided', 'success' => false];
            echo json_encode($error);
        }

    }


    public function getAppHelpDetails()
    {
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];
        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            //print_r($token);die;
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                //print_r($data);die;
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model('AppHelp_model');
                    $appHelpResult = $this->AppHelp_model->getAllData();
                    if ($appHelpResult) {
                        $status = 'Success';
                    } else {
                        $status = 'Failed';
                    }
                    echo json_encode(['status' => $status, 'data' => $appHelpResult]);
                }
            }
        } catch (Exception $e) {
            //print_r($e);die;
            $error = ['status' => 401, 'message' => 'Invalid Token Provided', 'success' => false];
            echo json_encode($error);
        }

    }


    public function saveUsersCurrentAffairPost()
    {
        $jsonArray = json_decode(file_get_contents('php://input'), true);
        $headerToken = $this->input->get_request_header('Authorization');
        //var_dump($headerToken);die;
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];
        //echo $token;die;
        // print_r($jsonArray);die;
        //echo $jsonArray['feedback'];die;
        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            //print_r($token1);die;
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                //print_r($data);die;
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model("CurrentAffairsSaved_model");

                    $checkSaved = $this->CurrentAffairsSaved_model->getDataByWhereCondition(['current_affair_id' => $jsonArray['current_affair_id'], "login_id" => $data->login_id]);
                    if ($checkSaved) {
                        $status = 'Failure';
                        $msg = 'Current Affair already saved.';
                    } else {
                        $dataIns = array("current_affair_id" => $jsonArray['current_affair_id'],
                            "login_id" => $data->login_id,
                            "status" => "Active"
                        );

                        $result = $this->CurrentAffairsSaved_model->add($dataIns);

                        //print_r($result);die;
                        if ($result) {
                            $status = 'Success';
                            $msg = 'Current Affair is saved successfully!!';
                        } else {
                            $status = 'Failed';
                            $msg = 'Current Affair is not saved!!';
                        }
                    }


                    echo json_encode(['status' => $status, 'message' => $msg]);


                }

            }
        } catch (Exception $e) {
            $error = [
                'status' => 401,
                'message' => 'Invalid Token Provided',
                'success' => false
            ];
            echo json_encode($error);
        }
    }


    public function getSavedCurrentAffairsDetail()
    {
        $jsonArray = json_decode(file_get_contents('php://input'), true);
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];
        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            //print_r($token);die;
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                //print_r($data);die;
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model('CurrentAffairs_model');
                    $result = $this->CurrentAffairs_model->getSavedCurrentAffairsDetail($data->login_id);
                    if ($result) {
                        $status = 'Success';
                    } else {
                        $status = 'Failed';
                    }

                    echo json_encode(['status' => $status, 'data' => $result]);
                }
            }
        } catch (Exception $e) {
            //print_r($e);die;
            $error = ['status' => 401, 'message' => 'Invalid Token Provided', 'success' => false];
            echo json_encode($error);
        }

    }


    public function removeUsersCurrentAffairPost()
    {
        $jsonArray = json_decode(file_get_contents('php://input'), true);
        $headerToken = $this->input->get_request_header('Authorization');
        //var_dump($headerToken);die;
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];
        //echo $token;die;
        // print_r($jsonArray);die;
        //echo $jsonArray['feedback'];die;
        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            //print_r($token1);die;
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                //print_r($data);die;
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model("CurrentAffairsSaved_model");

                    $dataRem = array("current_affair_id" => $jsonArray['current_affair_id'],
                        "login_id" => $data->login_id
                    );

                    $result = $this->CurrentAffairsSaved_model->deleteWhere($dataRem);

                    //print_r($result);die;
                    if ($result) {
                        $status = 'Success';
                        $msg = 'Current Affair is removed successfully!!';
                    } else {
                        $status = 'Failed';
                        $msg = 'Current Affair is not removed!!';
                    }

                    echo json_encode(['status' => $status, 'message' => $msg]);


                }

            }
        } catch (Exception $e) {
            $error = [
                'status' => 401,
                'message' => 'Invalid Token Provided',
                'success' => false
            ];
            echo json_encode($error);
        }
    }


    public function updateCurrentAffairViewsPost()
    {
        $jsonArray = json_decode(file_get_contents('php://input'), true);
        $headerToken = $this->input->get_request_header('Authorization');
        //var_dump($headerToken);die;
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];
        //echo $token;die;
        // print_r($jsonArray);die;
        //echo $jsonArray['feedback'];die;
        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            //print_r($token1);die;
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                //print_r($data);die;
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model("CurrentAffairs_model");

                    $result = $this->CurrentAffairs_model->updateViews($jsonArray['current_affair_id']);

                    //print_r($result);die;
                    if ($result) {
                        $status = 'Success';
                        $msg = 'Current Affair views updated!!';
                    } else {
                        $status = 'Failed';
                        $msg = 'Current Affair is not updated!!';
                    }

                    echo json_encode(['status' => $status, 'message' => $msg]);


                }

            }
        } catch (Exception $e) {
            $error = [
                'status' => 401,
                'message' => 'Invalid Token Provided',
                'success' => false
            ];
            echo json_encode($error);
        }
    }


    public function getSuccessReviews()
    {
        @header('Content_Type: application/json');
        $jsonArray = json_decode(file_get_contents('php://input'), true);
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];
        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            //print_r($token);die;
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                //print_r($data);die;
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model('SuccessReview_model');
                    $result = $this->SuccessReview_model->getAllData();
                    if ($result) {
                        $status = 'Success';
                    } else {
                        $status = 'Failed';
                    }

                    echo json_encode(['status' => $status, 'data' => $result]);
                }
            }
        } catch (Exception $e) {
            //print_r($e);die;
            $error = ['status' => 401, 'message' => 'Invalid Token Provided', 'success' => false];
            echo json_encode($error);
        }

    }


    public function userScheduleCallPost()
    {
        $jsonArray = json_decode(file_get_contents('php://input'), true);
        $headerToken = $this->input->get_request_header('Authorization');
        //var_dump($headerToken);die;
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];
        //echo $token;die;
        // print_r($jsonArray);die;
        //echo $jsonArray['feedback'];die;
        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            //print_r($token1);die;
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                //print_r($data);die;
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model("ScheduleCall_model");
                    $result = $this->ScheduleCall_model->save($data->login_id, $jsonArray['message'], $jsonArray['date'], $jsonArray['time']);
                    //print_r($result);die;
                    if ($result == 'Inserted') {
                        $status = 'Success';
                        $msg = 'Call Schedule successfully!!';
                    } else {
                        $status = 'Failed';
                        $msg = 'Call Schedule failed!! ';
                    }

                    echo json_encode(['status' => $status, 'message' => $msg]);


                }

            }
        } catch (Exception $e) {
            $error = [
                'status' => 401,
                'message' => 'Invalid Token Provided',
                'success' => false
            ];
            echo json_encode($error);
        }
    }


    public function getAbhyasSahityaCategory()
    {
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];
        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            //print_r($token);die;
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                //print_r($data);die;
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model('AbhyasSahitya_model');
                    $result = $this->AbhyasSahitya_model->getAbhyasSahityaCategory();
                    if ($result) {
                        $status = 'Success';
                    } else {
                        $status = 'Failed';
                    }
                    echo json_encode(['status' => $status, 'data' => $result]);
                }
            }
        } catch (Exception $e) {
            //print_r($e);die;
            $error = ['status' => 401, 'message' => 'Invalid Token Provided', 'success' => false];
            echo json_encode($error);
        }

    }

    public function getAbhyasSahityaPDFByCategory()
    {
        $jsonArray = json_decode(file_get_contents('php://input'), true);
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];

        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model('AbhyasSahitya_model');
                    $result = $this->AbhyasSahitya_model->getAbhyasSahityaByCategory($jsonArray['category'], "PDF");

                    if ($result) {
                        $status = 'Success';
                    } else {
                        $status = 'Failed';
                    }
                    echo json_encode(['status' => $status, 'data' => $result]);
                }
            }
        } catch (Exception $e) {
            $error = [
                'status' => 401,
                'message' => 'Invalid Token Provided',
                'success' => false
            ];
            echo json_encode($error);
        }
    }

    public function getAbhyasSahityaTextByCategory()
    {
        $jsonArray = json_decode(file_get_contents('php://input'), true);
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];

        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model('AbhyasSahitya_model');
                    $result = $this->AbhyasSahitya_model->getAbhyasSahityaByCategory($jsonArray['category'], "Text");

                    if ($result) {
                        $status = 'Success';
                    } else {
                        $status = 'Failed';
                    }
                    echo json_encode(['status' => $status, 'data' => $result]);
                }
            }
        } catch (Exception $e) {
            $error = [
                'status' => 401,
                'message' => 'Invalid Token Provided',
                'success' => false
            ];
            echo json_encode($error);
        }
    }


    public function getParikshaPadhatiCategory()
    {
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];
        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            //print_r($token);die;
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model('ParikshaPadhati_model');
                    $result = $this->ParikshaPadhati_model->getCategories();
                    if ($result) {
                        $status = 'Success';
                    } else {
                        $status = 'Failed';
                    }
                    echo json_encode(['status' => $status, 'data' => $result]);
                }
            }
        } catch (Exception $e) {
            $error = ['status' => 401, 'message' => 'Invalid Token Provided', 'success' => false];
            echo json_encode($error);
        }
    }


    public function getParikshaPadhatiPDFByCategory()
    {
        $jsonArray = json_decode(file_get_contents('php://input'), true);
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];

        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model('ParikshaPadhati_model');
                    $result = $this->ParikshaPadhati_model->getItemsByCategory($jsonArray['category']);

                    if ($result) {
                        $status = 'Success';
                    } else {
                        $status = 'Failed';
                    }
                    echo json_encode(['status' => $status, 'data' => $result]);
                }
            }
        } catch (Exception $e) {
            $error = [
                'status' => 401,
                'message' => 'Invalid Token Provided',
                'success' => false
            ];
            echo json_encode($error);
        }
    }

    public function getMasikeCategory()
    {
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];
        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            //print_r($token);die;
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model('Masike_model');
                    $result = $this->Masike_model->getCategories();
                    if ($result) {
                        $status = 'Success';
                    } else {
                        $status = 'Failed';
                    }
                    echo json_encode(['status' => $status, 'data' => $result]);
                }
            }
        } catch (Exception $e) {
            $error = ['status' => 401, 'message' => 'Invalid Token Provided', 'success' => false];
            echo json_encode($error);
        }
    }


    public function getMasikePDFByCategory()
    {
        $jsonArray = json_decode(file_get_contents('php://input'), true);
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];

        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model('Masike_model');
                    $result = $this->Masike_model->getItemsByCategory($jsonArray['category']);

                    if ($result) {
                        $status = 'Success';
                    } else {
                        $status = 'Failed';
                    }
                    echo json_encode(['status' => $status, 'data' => $result]);
                }
            }
        } catch (Exception $e) {
            $error = [
                'status' => 401,
                'message' => 'Invalid Token Provided',
                'success' => false
            ];
            echo json_encode($error);
        }
    }


    public function createDoubtPost()
    {
        $jsonArray = json_decode(file_get_contents('php://input'), true);
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];

        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model("Doubts_models");

                    $doubt_image = $jsonArray['doubt_image'];
                    $fileName = 'doubt' . '-' . time() . '.png';
                    $filePath = "N/A";
                    if ($doubt_image == "N/A") {
                        $filePath = "N/A";
                        $fileName = "N/A";
                    } else {
                        $doubt_image = $jsonArray['doubt_image'];

                        $base64Image = trim($doubt_image);
                        $base64Image = str_replace('data:image/png;base64,', '', $base64Image);
                        $base64Image = str_replace('data:image/jpg;base64,', '', $base64Image);
                        $base64Image = str_replace('data:image/jpeg;base64,', '', $base64Image);
                        $base64Image = str_replace('data:image/gif;base64,', '', $base64Image);
                        $imageData = base64_decode($base64Image);
                        $filePath = 'AppAPI/user-doubts/' . $fileName;
                        file_put_contents($filePath, $imageData);

                        $base64Image = str_replace(' ', '+', $base64Image);
                    }

                    $data = array('user_id' => $data->login_id,
                        'doubt_question' => $jsonArray['question'],
                        'doubt_image' => $fileName,
                        'status' => 'Active');

                    $result = $this->Doubts_models->save($data);
                    //print_r($result);die;
                    if ($result == 'Inserted') {
                        $status = 'Success';
                        $msg = 'Doubt added successfully!!';
                    } else {
                        $status = 'Failed';
                        $msg = 'Doubt failed!! ';
                    }
                    echo json_encode(['status' => $status, 'message' => $msg]);
                }
            }
        } catch (Exception $e) {
            $error = [
                'status' => 401,
                'message' => 'Invalid Token Provided',
                'success' => false
            ];
            echo json_encode($error);
        }
    }

    public function getDoubts()
    {
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];
        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model('Doubts_models');
                    $result = $this->Doubts_models->getDoubts($data->login_id);
                    if ($result) {
                        $status = 'Success';
                    } else {
                        $status = 'Failed';
                    }
                    echo json_encode(['status' => $status, 'data' => $result]);
                }
            }
        } catch (Exception $e) {
            $error = ['status' => 401, 'message' => 'Invalid Token Provided', 'success' => false];
            echo json_encode($error);
        }
    }


    public function getDoubtDetails()
    {
        $jsonArray = json_decode(file_get_contents('php://input'), true);
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];
        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model('Doubts_models');
                    $doubtDetail = $this->Doubts_models->getSingleDoubts($data->login_id, $jsonArray['doubtId']);
                    if ($doubtDetail) {
                        $this->load->model("DoubtComments_models");
                        $doubtComments = $this->DoubtComments_models->getRecordById($jsonArray['doubtId']);
                        echo json_encode(['status' => 'Success',
                            'doubtDetail' => $doubtDetail,
                            'doubtComments' => $doubtComments]);
                    } else {
                        $status = 'Failed';
                        echo json_encode(['status' => $status, 'message' => 'No doubts details found.']);
                    }


                }
            }
        } catch (Exception $e) {
            $error = ['status' => 401, 'message' => 'Invalid Token Provided', 'success' => false];
            echo json_encode($error);
        }
    }


    public function createDoubtCommentPost()
    {
        $jsonArray = json_decode(file_get_contents('php://input'), true);
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];

        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model("DoubtComments_models");

                    $data = array('login_id' => $data->login_id,
                        'doubt_id' => $jsonArray['doubtId'],
                        'comment_body' => $jsonArray['commentBody'],
                        'messageSender' => 'User',
                        'status' => 'Active');

                    $result = $this->DoubtComments_models->save($data);
                    //print_r($result);die;
                    if ($result == 'Inserted') {
                        $status = 'Success';
                        $msg = 'Doubt Comment added successfully!!';
                    } else {
                        $status = 'Failed';
                        $msg = 'Doubt failed!! ';
                    }
                    echo json_encode(['status' => $status, 'message' => $msg]);
                }
            }
        } catch (Exception $e) {
            $error = [
                'status' => 401,
                'message' => 'Invalid Token Provided',
                'success' => false
            ];
            echo json_encode($error);
        }
    }


    public function getDocsVideosDocs()
    {
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];

        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model('DocsVideos_model');
                    $result = $this->DocsVideos_model->getDocuments();

                    if ($result) {
                        $status = 'Success';
                    } else {
                        $status = 'Failed';
                    }
                    echo json_encode(['status' => $status, 'data' => $result]);
                }
            }
        } catch (Exception $e) {
            $error = [
                'status' => 401,
                'message' => 'Invalid Token Provided',
                'success' => false
            ];
            echo json_encode($error);
        }
    }

    public function getDocsVideosTexts()
    {
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];

        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['status' => 'Failed','token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model('DocsVideos_model');
                    $result = $this->DocsVideos_model->getTexts();

                    if ($result) {
                        $status = 'Success';
                    } else {
                        $status = 'Failed';
                    }
                    echo json_encode(['status' => $status, 'data' => $result]);
                }
            }
        } catch (Exception $e) {
            $error = [
                'status' => 401,
                'message' => 'Invalid Token Provided',
                'success' => false
            ];
            echo json_encode($error);
        }
    }

    public function getDocsVideosVideos()
    {
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];

        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model('DocsVideos_model');
                    $result = $this->DocsVideos_model->getVideos();

                    if ($result) {
                        $status = 'Success';
                    } else {
                        $status = 'Failed';
                    }
                    echo json_encode(['status' => $status, 'data' => $result]);
                }
            }
        } catch (Exception $e) {
            $error = [
                'status' => 401,
                'message' => 'Invalid Token Provided',
                'success' => false
            ];
            echo json_encode($error);
        }
    }

    public function updateDocsVideosViewsPost()
    {
        $jsonArray = json_decode(file_get_contents('php://input'), true);
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];

        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model("DocsVideos_model");
                    $result = $this->DocsVideos_model->updateViews($jsonArray['id']);

                    if ($result) {
                        $status = 'Success';
                        $msg = 'Docs and Videos view count updated!!';
                    } else {
                        $status = 'Failed';
                        $msg = 'Docs and Videos view count is not updated!!';
                    }
                    echo json_encode(['status' => $status, 'message' => $msg]);
                }

            }
        } catch (Exception $e) {
            $error = [
                'status' => 401,
                'message' => 'Invalid Token Provided',
                'success' => false
            ];
            echo json_encode($error);
        }
    }

    public function getCouponCodes()
    {
        $jsonArray = json_decode(file_get_contents('php://input'), true);
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];

        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model('Coupons_model');
                    $result = $this->Coupons_model->getCoupons($jsonArray['type']);

                    if ($result) {
                        $status = 'Success';
                    } else {
                        $status = 'Failed';
                    }
                    echo json_encode(['status' => $status, 'data' => $result]);
                }
            }
        } catch (Exception $e) {
            $error = [
                'status' => 401,
                'message' => 'Invalid Token Provided',
                'success' => false
            ];
            echo json_encode($error);
        }
    }

    public function validateCouponCodePost()
    {
        $jsonArray = json_decode(file_get_contents('php://input'), true);
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];

        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model("Coupons_model");
                    $result = $this->Coupons_model->checkCouponCode($jsonArray['coupon_code'], $jsonArray['type']);
                    if ($result) {
                        $status = 'Success';
                        $msg = 'Coupon code is valid!';

                        echo json_encode(['status' => $status, 'message' => $msg, 'data' => $result]);
                    } else {
                        $status = 'Failed';
                        $msg = 'Invalid coupon code!';
                        echo json_encode(['status' => $status, 'message' => $msg]);
                    }

                }

            }
        } catch (Exception $e) {
            $error = [
                'status' => 401,
                'message' => 'Invalid Token Provided',
                'success' => false
            ];
            echo json_encode($error);
        }
    }

    public function updateCouponUsageCountPost()
    {
        $jsonArray = json_decode(file_get_contents('php://input'), true);
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];

        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model("Coupons_model");

                    $result = $this->Coupons_model->updateViews($jsonArray['coupon_id']);

                    if ($result) {
                        $status = 'Success';
                        $msg = 'Coupon usage count updated!!';
                    } else {
                        $status = 'Failed';
                        $msg = 'Coupon usage count is not updated!!';
                    }
                    echo json_encode(['status' => $status, 'message' => $msg]);
                }

            }
        } catch (Exception $e) {
            $error = [
                'status' => 401,
                'message' => 'Invalid Token Provided',
                'success' => false
            ];
            echo json_encode($error);
        }
    }

    public function getMembershipPlans()
    {
        $jsonArray = json_decode(file_get_contents('php://input'), true);
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];

        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model('Membership_Plans_model');
                    $result = $this->Membership_Plans_model->getAllData($jsonArray['type']);
                    $this->load->model("AppSettings_model");
                    $banner = $this->AppSettings_model->getRecordById('setting_membership_image')[0]['key_value'];
                    if ($banner){
                        $banner = base_url() . 'AppAPI/banner-images/' . $banner;
                    }else{
                        $banner = base_url() . 'AppAPI/banner-images/logo.png';
                    }
                    $appSettings['setting_membership_title'] = $this->AppSettings_model->getRecordById('setting_membership_title')[0]['key_value'];
                    $appSettings['setting_membership_subtitle'] = $this->AppSettings_model->getRecordById('setting_membership_subtitle')[0]['key_value'];
                    $appSettings['setting_membership_image'] = $banner;
                    $appSettings['setting_membership_description'] = $this->AppSettings_model->getRecordById('setting_membership_description')[0]['key_value'];
                    if ($result) {
                        $status = 'Success';
                    } else {
                        $status = 'Failed';
                    }
                    echo json_encode(['status' => $status,
                        'appSettings' => $appSettings,
                        'data' => $result]);

                }
            }
        } catch (Exception $e) {
            $error = [
                'status' => 401,
                'message' => 'Invalid Token Provided',
                'success' => false
            ];
            echo json_encode($error);
        }
    }

    public function paymentResponsePost()
    {
        $jsonArray = json_decode(file_get_contents('php://input'), true);
        $required_fields = ['payment_for', 'sub_total', 'final_total', 'payment_details', 'transaction_status'];
        $error = [];
        $this->load->helper('common');
        foreach ($required_fields as $key => $row) {
            if (!array_key_exists($row, $jsonArray)) {
                $error[$row] = sprintf("The %s field is required.", snake_case_to_string($row));
            }
        }
        if (!empty($error)) {
            echo json_encode(['message' => 'Validation', 'success' => false, 'error' => $error]);
            return false;
        }
        $payment_for = $jsonArray['payment_for'];
        $membership_id = $payment_for == 'membership' ? $jsonArray['membership_id'] : null;
        $coupon_id = !empty($jsonArray['coupon_id']) ? $jsonArray['coupon_id'] : null;
        $sub_total = $jsonArray['sub_total'];
        $coupon_discount_amount = $jsonArray['coupon_discount_amount'];
        $final_total = $jsonArray['final_total'];
        $payment_details = $jsonArray['payment_details'];
        $razorpay_orderId = $jsonArray['razorpay_orderId'];
        $razorpay_transaction_id = $jsonArray['razorpay_transaction_id'];
        $transaction_status = $jsonArray['transaction_status'];
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];
        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                    return false;
                } else {
                    $user_id = $data->login_id;

                    $this->load->model('Payments_model');
                    $last_id = $this->Payments_model->get_last_id();
                    $data = [
                        'user_id' => $user_id,
                        'payment_id' => "MahaTest" . $last_id + 1,
                        "membership_id" => $membership_id, //150
                        "coupon_id" => $coupon_id, //Rs. 50
                        "sub_total" => $sub_total,
                        "coupon_discount_amount" => $coupon_discount_amount,
                        "final_total" => $final_total,
                        "payment_details" => json_encode($payment_details),
                        "razorpay_orderId" => $razorpay_orderId,
                        "razorpay_transaction_id" => $razorpay_transaction_id,
                        "transaction_status" => $transaction_status, //Success / Failled
                        "payment_for" => $payment_for //courses/test series
                    ];
                    $this->Payments_model->insert($data);
                    $this->load->model('AppUsers_API_model');
                    if ($payment_for == 'membership') {
                        // add membership id to user
                        $add_membership_data = [
                            'plan_id' => $membership_id,
                        ];
                        $res = $this->AppUsers_API_model->update($user_id, $add_membership_data);
                        //end
                        if ($res == 'Updated') {
                            // update membership count 
                            $this->load->model('Membership_Plans_model');
                            $membership_data = $this->Membership_Plans_model->getPostById($membership_id);
                            if (!empty($membership_data)) {
                                $data = ['usage_count' => $membership_data[0]['usage_count'] + 1];
                                $this->Membership_Plans_model->update($membership_id, $data);
                            }
                            //end
                        }

                    }
                    $response = ['status' => "Success", "message" => "Payment detail added successfully"];
                    echo json_encode($response);
                    return true;
                }
            } else {
                $error = [
                    'status' => 401,
                    'message' => 'unauthorized',
                    'success' => false
                ];
                echo json_encode($error);
                return false;
            }
        } catch (\Exception $e) {
            $error = [
                'status' => 401,
                'message' => 'Invalid Token Provided',
                'success' => false
            ];
            echo json_encode($error);
        }
    }

    public function createRazorPayOrderPost()
    {
        $jsonArray = json_decode(file_get_contents('php://input'), true);
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];
        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                    return false;
                } else {
                    $this->load->library('Razorpay');
                    $user_id = $data->login_id;
                    $amount = $jsonArray['amount'];
                    $razorPayRes = $this->razorpay->generateOrderId($user_id, $amount);
                    if ($razorPayRes != false) {
                        echo json_encode(['status' => "Success", 'data' => $razorPayRes, "message" => "OrderId generated successfully"]);
                        return true;
                    } else {
                        echo json_encode(['status' => "Failed", 'data' => [], "message" => "OrderId not generated"]);
                        return false;
                    }
                }
            }
        } catch (Exception $e) {
            $error = [
                'status' => 401,
                'message' => 'Invalid Token Provided',
                'success' => "Failed"
            ];
            echo json_encode($error);
        }
    }

    public function getAllQuizSubjectSectionWise()
    {
        $jsonArray = json_decode(file_get_contents('php://input'), true);
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];
        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model("Exam_subject_model");
                    $subjectDetail = $this->Exam_subject_model->getAllDataBySection($jsonArray['section']);
                    if ($subjectDetail) {
                        $status = 'Success';
                    } else {
                        $status = 'Failed';
                    }
                    echo json_encode(['status' => $status, 'data' => $subjectDetail]);
                }
            }
        } catch (Exception $e) {
            $error = ['status' => 401, 'message' => 'Invalid Token Provided', 'success' => false];
            echo json_encode($error);
        }

    }

    public function getAllQuizYearSubjectSectionWise()
    {
        $jsonArray = json_decode(file_get_contents('php://input'), true);
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];
        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {

                    $this->load->model("Quiz_model");
                    $yearDetail = $this->Quiz_model->getAllDataBySubjectSectionGroupByYear($jsonArray['subject_id'],$jsonArray['section']);

                    if ($yearDetail) {
                        $status = 'Success';
                    } else {
                        $status = 'Failed';
                    }
                    echo json_encode(['status' => $status, 'data' => $yearDetail]);
                }
            }
        } catch (Exception $e) {
            $error = ['status' => 401, 'message' => 'Invalid Token Provided', 'success' => false];
            echo json_encode($error);
        }

    }

    public function getAllQuizChapterSubjectSectionWise()
    {
        $jsonArray = json_decode(file_get_contents('php://input'), true);
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];
        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {

                    $this->load->model("Exam_subsubject_model");
                    $chapterDetail = $this->Exam_subsubject_model->getAllDataChapterBySubjectSection($jsonArray['subject_id'],$jsonArray['section']);

                    if ($chapterDetail) {
                        $status = 'Success';
                    } else {
                        $status = 'Failed';
                    }
                    echo json_encode(['status' => $status, 'data' => $chapterDetail]);
                }
            }
        } catch (Exception $e) {
            $error = ['status' => 401, 'message' => 'Invalid Token Provided', 'success' => false];
            echo json_encode($error);
        }

    }

    public function getAllQuizzesBySubjectSectionChapterYearWise()
    {
        $jsonArray = json_decode(file_get_contents('php://input'), true);
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];
        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model("Quiz_model");
                    $chapterDetail = $this->Quiz_model->getAllQuizzesByChapterYearSubjectSection($jsonArray['subject_id'],$jsonArray['section'], $jsonArray['yearChapter'], $jsonArray['yearChapterValue']);

                    if ($chapterDetail) {
                        $status = 'Success';
                    } else {
                        $status = 'Failed';
                    }
                    echo json_encode(['status' => $status, 'data' => $chapterDetail]);
                }
            }
        } catch (Exception $e) {
            $error = ['status' => 401, 'message' => 'Invalid Token Provided', 'success' => false];
            echo json_encode($error);
        }

    }

    public function getQuizQuestionsByQuizId()
    {
        $jsonArray = json_decode(file_get_contents('php://input'), true);
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];
        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model("Quiz_model");
                    $quizDetail = $this->Quiz_model->getQuizById($jsonArray['quizId']);
                    $this->load->model("Question_model");
                    $questionDetail = $this->Question_model->getQuestionsByQuizId($jsonArray['quizId']);
                    $questionPagination = $this->Question_model->getQuestionsGroupedByQuizId($jsonArray['quizId']);

                    // Initialize an empty array for the final response
                    $questionPaginationResponse = [];

                    // Group the questions by subject
                    foreach ($questionPagination as $row) {
                        $SubjectID = $row['SubjectID'];
                        $SubjectName = $row['SubjectName'];
                        $QuestionId = $row['QuestionId'];
                        $Question = $row['Question'];

                        // Check if the subject already exists in the response
                        if (!isset($questionPaginationResponse[$SubjectID])) {
                            $questionPaginationResponse[$SubjectID] = [
                                'SubjectID' => $SubjectID,
                                'SubjectName' => $SubjectName,
                                'Questions' => []
                            ];
                        }

                        // Add the question to the respective subject
                        $questionPaginationResponse[$SubjectID]['Questions'][] = [
                            'QuestionId' => $QuestionId,
                            'Question' => $Question
                        ];
                    }

                    // Re-index the array to remove subject ID keys
                    $questionPaginationResponse = array_values($questionPaginationResponse);

                    if ($quizDetail) {
                        $status = 'Success';
                    } else {
                        $status = 'Failed';
                    }

                    echo json_encode(['status' => $status,
                        'message' => "Data found.",
                        'quizDetail' => $quizDetail,
                        'questions' => $questionDetail,
                        'questionPagination' => $questionPaginationResponse]);
                }
            }
        } catch (Exception $e) {
            $error = ['status' => 401, 'message' => 'Invalid Token Provided', 'success' => false];
            echo json_encode($error);
        }

    }

    public function postQuizAnswersByQuizId()
    {
        $jsonArray = json_decode(file_get_contents('php://input'), true);
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];
        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                    return false;
                } else {
                    $user_id = $data->login_id;
                    $quizID = $jsonArray['quizID'];
                    $timeTaken = $jsonArray['timeTaken'];
                    $questionDetails = $jsonArray['questionDetails'];
                    $quizStatus = $jsonArray['quizStatus'];
                    $not_attempted_question = 0;
                    $attempted_questions = 0;
                    $correct_answer = 0;
                    $wrong_answer = 0;
                    $obtain_marks = 0;
                    $percentage = 0;
                    $attempted_percentage = 0;

                    $this->load->model("Quiz_model");
                    $this->load->model("QuizResult_model");
                    $this->load->model("QuizResultDetail_model");

                    $result = $this->Quiz_model->updateAttempts($quizID);
                    $quizDetail = $this->Quiz_model->getQuizById($quizID);

                    $no_of_question = $quizDetail['NoOfQuestion'];
                    $marks_per_question = $quizDetail['MarksPerQuestion'];
                    $total_mark = $quizDetail['TotalMark'];
                    $passing_marks = $quizDetail['PassingMarks'];
                    $quizResult = "Fail";
                    $questionIsCorrect = "No";

                    //Save quiz result 1st to generate id
                    $dataResult = [
                        'quiz_id' => $quizID,
                        'user_id' => $user_id,
                        'total_questions' => $no_of_question,
                        "time_taken" => $timeTaken,
                        "status" => $quizStatus,    //Completed / Paused
                    ];
                    $this->QuizResult_model->save($dataResult);

                    $quizResultId = $this->QuizResult_model->get_last_id();

                    //Save all question data
                   // $questionData = json_decode( $questionDetails, true );
                    foreach ( $questionDetails as $question ) {
                        if ($question['QuestionUserAnswered'] == "0" && $question['QuestionUserAnswer' == "N/A"]){
                            $not_attempted_question = $not_attempted_question + 1;
                            $questionIsCorrect = "No";
                        }else{
                            if ($question['QuestionUserAnswer'] != "N/A"){
                                $attempted_questions = $attempted_questions + 1;
                                if ($question['QuestionUserAnswer'] == $question['QuestionAnswer']){
                                    $correct_answer = $correct_answer + 1;
                                    $questionIsCorrect = "Yes";
                                }else{
                                    $wrong_answer = $wrong_answer + 1;
                                    $questionIsCorrect = "No";
                                }
                            }else{
                                $not_attempted_question = $not_attempted_question + 1;
                                $questionIsCorrect = "No";
                            }
                        }

                        $dataQuestion = [
                            'quiz_result_id' => $quizResultId,
                            'question_id' => $question['QuestionId'],
                            'user_answered' => $question['QuestionUserAnswered'],
                            "users_answer" => $question['QuestionUserAnswer'],
                            "is_correct" => $questionIsCorrect,    //Completed / Paused
                        ];
                        $this->QuizResultDetail_model->save($dataQuestion);
                    }

                    $obtain_marks = $marks_per_question * $correct_answer;
                    $percentage = ($obtain_marks / $total_mark) * 100;
                    $attempted_percentage = ($attempted_questions / $no_of_question) * 100;
                    if ($obtain_marks >= $passing_marks){
                        $quizResult = "Pass";
                    }else{
                        $quizResult = "Fail";
                    }

                    //Update remain fields
                    $dataResult = [
                         'correct_answer' => $correct_answer,
                         'wrong_answer' => $wrong_answer,
                         'attempted_questions' => $attempted_questions,
                         'not_attempted_question' => $not_attempted_question,
                         'attempted_percentage' => $attempted_percentage,
                         "obtain_marks" => $obtain_marks,
                         "percentage" => $percentage,
                         "result_status" => $quizResult
                    ];
                    $quizSaved = $this->QuizResult_model->update($quizResultId, $dataResult);

                    $response = ["resultId" => $quizResultId,
                        "resultStatus" => $quizResult];

                    if ($quizSaved != "Failed") {
                        echo json_encode(['status' => "Success",
                            'data' => $response,
                            "message" => "Answers saved successfully, and result has been generated."]);
                        return true;
                    } else {
                        echo json_encode(['status' => "Failed",
                            "message" => "Server side issue while saving result."]);
                        return false;
                    }
                }
            }
        } catch (Exception $e) {
            $error = [
                'status' => 401,
                'message' => 'Invalid Token Provided',
                'success' => "Failed"
            ];
            echo json_encode($error);
        }
    }

    public function getQuizResultById()
    {
        $jsonArray = json_decode(file_get_contents('php://input'), true);
        $headerToken = $this->input->get_request_header('Authorization');
        $splitToken = explode(" ", $headerToken);
        $token = $splitToken[1];
        try {
            $verifyAuth = new verifyAuthToken();
            $token1 = $verifyAuth->verifyAuthTokenFunc($token);
            if ($token1) {
                $jwt = new JWT();
                $data = $jwt->decode($token, $this->JWTSecretKey, 'HS256');
                if (strtotime($data->exp) < strtotime(date('Y-m-d H:i:s'))) {
                    echo json_encode(['token' => '', 'message' => "Token is expired!!"]);
                } else {
                    $this->load->model("QuizResult_model");
                    $this->load->model("Quiz_model");
                    $quizDetail = $this->Quiz_model->getQuizById($jsonArray['quizId']);
                    $this->load->model("Question_model");
                    $questionDetail = $this->Question_model->getQuestionsResultByQuizResultId($jsonArray['quizId'], $jsonArray['resultId']);
                    $questionPagination = $this->Question_model->getQuestionsGroupedByQuizId($jsonArray['quizId']);

                    $resultDetail = $this->QuizResult_model->getResultById($jsonArray['resultId']);
                    // Initialize an empty array for the final response
                    $questionPaginationResponse = [];

                    // Group the questions by subject
                    foreach ($questionPagination as $row) {
                        $SubjectID = $row['SubjectID'];
                        $SubjectName = $row['SubjectName'];
                        $QuestionId = $row['QuestionId'];
                        $Question = $row['Question'];

                        // Check if the subject already exists in the response
                        if (!isset($questionPaginationResponse[$SubjectID])) {
                            $questionPaginationResponse[$SubjectID] = [
                                'SubjectID' => $SubjectID,
                                'SubjectName' => $SubjectName,
                                'Questions' => []
                            ];
                        }

                        // Add the question to the respective subject
                        $questionPaginationResponse[$SubjectID]['Questions'][] = [
                            'QuestionId' => $QuestionId,
                            'Question' => $Question
                        ];
                    }

                    // Re-index the array to remove subject ID keys
                    $questionPaginationResponse = array_values($questionPaginationResponse);

                    if ($quizDetail) {
                        $status = 'Success';
                    } else {
                        $status = 'Failed';
                    }

                    echo json_encode(['status' => $status,
                        'message' => "Data found.",
                        'quizDetail' => $quizDetail,
                        'resultDetail' => $resultDetail,
                        'questions' => $questionDetail,
                        'questionPagination' => $questionPaginationResponse]);
                }
            }
        } catch (Exception $e) {
            $error = ['status' => 401, 'message' => 'Invalid Token Provided', 'success' => false];
            echo json_encode($error);
        }

    }
}