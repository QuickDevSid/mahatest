<?php

class Common_Model extends CI_Model {

    
    function __construct() {

        parent::__construct();
        $this->accessdata = array();
        $this->accessdata2 = array();
        $this->langauges_set = array();
        $this->web_lang = "1";
    }

    
    public function send_mailnew($toname, $to_email, $from_name, $frommail, $subject, $strMessage)   {
        try {

            require_once('lib/nusoap.php');

            $mail_obj = new nusoap_client(WEB_SERVICE_PATH . '/sendmail.asmx?WSDL', 'wsdl');
            $param_mail = array('strCustomerNumber' => '0406150940',
                'strAuthKey' => 'mnFUai48GdYDcgaD',
                'intAppID' => '1', 'strSubject' => $subject,
                'strFromEmail' => $frommail, 'strFromName' => $from_name,
                'strToEmail' => $to_email, 'strToName' => $toname,
                'strMessage' => $strMessage,
                'intSource' => '1',
                'strComment' => '');
            #print_r($param_mail)."<br/>";

            $result_mail = $mail_obj->call('SendTransactionalMailAPI', $param_mail, "http://tempuri.org/", "http://tempuri.org/");
            $status_mail = $result_mail['SendTransactionalMailAPIResult'];
            #echo '<script>alert("'.$status_mail.'");</script>';
            unset($mail_obj);
            #echo "Return status ".$status_mail;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    
    public function send_custom_mail($name,$email,$message,$subject)
    {
        $this->load->library('email');
            
        $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'edutechcrm@gmail.com',
            'smtp_pass' => 'tech@123edu13',
            'mailtype'  => 'html',
            'charset'   => 'utf-8'
        );
        $this->email->initialize($config);
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        //Email content
        $htmlContent=$message;
        $this->email->to($email);
        $this->email->from('edutechcrm@gmail.com','News Portal');
        $this->email->subject($subject);
        $this->email->message($htmlContent);
        //Send email
        $this->email->send();


    }
    function getRightsSessionArr($login_user_id) {

        $this->load->model("home_model");
        if ($this->session->userdata('access')) {
            //echo " check this out dashbrd cntrl ";
            //$access_session_data = $this->session->userdata('access'); old approach si 9th index missing  
            $access_session_data = $this->session->userdata('access');
            //$access_session_data = $this->home_model->set_module_rights($data['login_user_id']); //new works fine
            $this->accessdata = $access_session_data;
            //print_r($access_session_data);
        } else {
            //echo " else check this out dashbrd cntrl ";
            $access_session_data = $this->home_model->set_module_rights($login_user_id);
            $this->accessdata = $access_session_data;
            //print_r($access_session_data);
        }
        return $this->accessdata;
    }

    function getWebsiteLanguage() {
        //$this->session->set_userdata('web_lang', '1');                
        if ($this->session->userdata('web_lang')) {
            #echo "WEB LANGUAGES set - ".$this->web_lang = $this->session->userdata('web_lang');
            $this->web_lang = $this->session->userdata('web_lang');
        }
        return $this->web_lang;
    }

    function getDynamicMenu($language_id, $usertype) {
        $language_code = ($language_id == 1 ? 'en' : ($language_id == 2 ? 'ar' : 'en'));
        return $this->printMenus(simplexml_load_file('xmldata/' . $language_code . '/menu_xml.xml'), 1, $usertype);
    }

    public function get_languages_set() {
        if ($this->session->userdata('languages_set')) {
            //echo "langauges set";
            $langauges_set = $this->session->userdata('languages_set');
            #print_r($langauges_set);
            $data['langauges_set'] = $langauges_set;
        } else {
            //echo "elseee langauges not set";
            $langauges_set = $this->common_model->executeArray("SELECT id,title,lang_code,is_default,is_set FROM `website_languages` WHERE active=1");
            #print_r($langauges_set);
            $this->session->set_userdata('languages_set', $langauges_set);
        }
        return $langauges_set;
    }

    function printMenus(SimpleXMLElement $parent, $demoVal, $usertype) {
        if ($demoVal == 1) {
            $html = '';
        } else {
            $html = '<ul class="submenu">';
        }
        foreach ($parent->menu as $menuVar) {
            $html .= $this->getMenus($menuVar, $demoVal, $usertype);
        }
        $html .= "</ul>";
        return $html;
    }

    public function get_query($searchArray) {
        $strQuery = '';
        $strWh = '';
        $arrCount = count($searchArray);
        $limit = ($arrCount / 3);
        for ($i = 0; $i < $limit; $i++) {
            if ($searchArray[3 * $i] != "") {
                $col = 3 * $i + 1;
                $ch = 3 * $i + 2;
                switch ($searchArray[$ch]) {
                    case 1:
                        $strWh = $strWh . " AND " . $searchArray[$col] . " LIKE \"%" . $searchArray[3 * $i] . "%\""; /* 1 For Like */
                        break;
                    case 2:
                        $strWh = $strWh . " AND " . $searchArray[$col] . " = " . $searchArray[3 * $i] . ""; /* 2 For = */
                        break;
                    case 3:
                        $strWh = $strWh . " AND " . $searchArray[$col] . " >= '" . $searchArray[3 * $i] . "'"; /* 3 For >= */
                        break;
                    case 4:
                        $strWh = $strWh . " AND " . $searchArray[$col] . " <= '" . $searchArray[3 * $i] . "'"; /* 4 For <= */
                        break;
                    case 5:
                        $strWh = $strWh . " AND " . $searchArray[$col] . " BETWEEN " . $searchArray[3 * $i] . ""; /* 5 For BETWEEN */
                        break;
                    case 6:
                        $strWh = $strWh . " AND " . $searchArray[$col] . " IN (" . $searchArray[3 * $i] . ")"; /* 5 For IN */
                        break;
                    case 7:
                        $strWh = $strWh . " AND " . $searchArray[$col] . " NOT IN (" . $searchArray[3 * $i] . ")"; /* 5 For IN */
                        break;
                    default:
                        $strWh = $strWh . '';
                        break;
                }
            }
        }
        $strQuery = $strWh;
        return $strQuery;
    }

    function getMenus(SimpleXMLElement $menuVar, $demoVal, $usertype) {
        #$html = '<li id="asset'.$menuVar->asset_assetid.'"><ins>&nbsp;</ins><a href="'.$menuVar->asset_url.'">'.$menuVar->asset_name.' ['.$menuVar->asset_assetid.']</a>';
        $html = '<li id="asset' . $menuVar->menu_levelid . '"><a href="' . base_url() . '' . ($menuVar->menu_url != '#' ? $menuVar->menu_url : 'dashboard') . '">
            <i class="' . $menuVar->fa_icon . ' icon-sidebar"></i>
            ' . ($demoVal == 1 && $menuVar->menu_levelid != 1 ? '<i class="fa fa-angle-right chevron-icon-sidebar"></i>' : '') . '
            
                ' . $menuVar->menu_name . '
            </a>';

        if (isset($menuVar->menu)) {
            // has <asset/> children
            $html .= $this->printMenus($menuVar, 2, $usertype);
        }
        $html .= "</li>\n";

        return $html;
    }

    public function get_module_name($controllerName) {

        $return_arr = $this->executeArray("SELECT module_group_name as g_name,module_name as m_name FROM module WHERE module_controller_name='$controllerName'");
        return $return_arr[0];
        /*
          $this->db->select('module_group_name as mainModuleName');
          $this->db->from('module');
          $this->db->where('module_controller_name', $controllerName);
          $count = $this->db->get();
          $return_status = $count->row();
          return $return_status->mainModuleName;
         */
    }

    function is_logged_in($activated = TRUE) {
        return $this->session->userdata('status') === ($activated ? 1 : 0);
    }

    function get_user_id() {
        return $this->session->userdata('user_id');
    }

    function get_username() {
        return $this->session->userdata('username');
    }

    function get_session_type() {
        return $this->session->userdata('sestype');
    }

    public function blocked_ids($id) {
        $blocked_ids = array('kolos29', 'bitcoin', 'stalker', 'electum', 'crypto');
        if (in_array($id, $blocked_ids)) {
            return false;
        } else {
            return TRUE;
        }
    }

    public function getUserExist($username) {

        $this->db->select('count(1) as userexist');
        $this->db->from('users');
        $this->db->where('username', $username);
        $count = $this->db->get();
        $return_status = $count->row();
        return $return_status->userexist;
    }

    public function getEmailExist($email) {

        $this->db->select('count(1) as emailexist');
        $this->db->from('users');
        $this->db->where('email', $email);
        $count = $this->db->get();
        $return_status = $count->row();
        return $return_status->emailexist;
    }

    public function getUserEmail($id) {

        $this->db->select('email');
        $this->db->from('users');
        $this->db->where('id', $id);
        $count = $this->db->get();
        $return_status = $count->row();
        return $return_status->email;
    }

    public function getMailContaint($name) {

        $newfile = 'emailer/index.html';
        $file = 'emailer/index1.html';
        if (!copy($file, $newfile)) {
            echo "failed to copy file...\n";
        } else {
            echo "copy file success \n";
        }
        //$objODBC = new clsODBC();
        $path_to_file = 'emailer/index.html';
        $file_contents = file_get_contents($path_to_file);

        $file_contents = str_replace("&&username&&", $name, $file_contents);
        file_put_contents($path_to_file, $file_contents);
        #$path_to_file = '../admin/project_mailer.php';
        $file_contents = file_get_contents($path_to_file);
        return $file_contents;
    }

    public function executeQuery($strQuery, $value) {
        $query = $this->db->query($strQuery);
        $query->result(); // Dump the extra resultset.
        $result = $query->row();
        return $result->$value;
    }

    public function executeArray($strQuery) {
        $query = $this->db->query($strQuery);
        return $query->result();
    }

    public function executeNonQuery($strQuery) {

        $query = $this->db->query($strQuery);
        return $query;
    }

    public function randomString($length = 5) {
        $str = "";
        $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }
    
    public function randomNumber($length = 6) {
        $str = "";
        $characters = array_merge(range('0', '9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }

    public function randomNumber_4($length = 4) {
        $str = "";
        $characters = array_merge(range('0', '9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }


    function current_full_url() {
        $CI = & get_instance();

        $url = $CI->config->site_url($CI->uri->uri_string());
        return $_SERVER['QUERY_STRING'] ? $url . '?' . $_SERVER['QUERY_STRING'] : $url;
    }

    /* To fetch single row use this - it will skip 0th  object ref. */

    public function executeRow($strQuery) {
        //  echo '<pre>'; print_r($strQuery); exit;
        $query = $this->db->query($strQuery);
        $query->result(); // Dump the extra resultset.
        return $query->row();
    }

    public function encryptor($action, $string) {

        $key = hash('sha256', $this->config->item('SECRET_KEY'));
        $iv = substr(hash('sha256', $this->config->item('SECRET_IV')), 0, 16);

        if ($action == 'encrypt') {

            $output = openssl_encrypt($string, $this->config->item('ENCRYPT_CODE'), $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $this->config->item('ENCRYPT_CODE'), $key, 0, $iv);
        }
        return $output;
    }

    public function encrypt_url($string) {
      $key = ACCESS_KEY; //key to encrypt and decrypts.
      $result = '';
      $test = "";
       for($i=0; $i<strlen($string); $i++) {
         $char = substr($string, $i, 1);
         $keychar = substr($key, ($i % strlen($key))-1, 1);
         $char = chr(ord($char)+ord($keychar));

         $test[$char]= ord($char)+ord($keychar);
         $result.=$char;
       }

       return urlencode(base64_encode($result));
    }


    public function decrypt_url($string) {
      $key = ACCESS_KEY; //key to encrypt and decrypts.
        $result = '';
        $string = base64_decode(urldecode($string));
       for($i=0; $i<strlen($string); $i++) {
         $char = substr($string, $i, 1);
         $keychar = substr($key, ($i % strlen($key))-1, 1);
         $char = chr(ord($char)-ord($keychar));
         $result.=$char;
       }
       return $result;
    }

    public function check_access_token($access_token,$user_id)
    {
        if($access_token=="" || $user_id=="")
        {
            return 0;
        }
        else
        {
            $sql="SELECT * FROM Customermaster WHERE cust_id=".$user_id." AND access_token='".$access_token."' ";
            $data=$this->executeRow($sql);

            if($data)
            {
                return 1;
            }
            else
            {
                return 2;
            }
        }

    }


    public function getUserIP() {
        $client = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote = $_SERVER['REMOTE_ADDR'];

        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }

        return $ip;
    }

    public function search($searchArray, $query, $order) {
        $strQuery = '';
        $strWh = '';
        $arrCount = count($searchArray);
        $limit = ($arrCount / 3);
        for ($i = 0; $i < $limit; $i++) {
            if ($searchArray[3 * $i] != "") {
                $col = 3 * $i + 1;
                $ch = 3 * $i + 2;
                switch ($searchArray[$ch]) {
                    case 1:
                        $strWh = $strWh . " AND " . $searchArray[$col] . " LIKE \"%" . $searchArray[3 * $i] . "%\""; /* 1 For Like */
                        break;
                    case 2:
                        $strWh = $strWh . " AND " . $searchArray[$col] . " = " . $searchArray[3 * $i] . ""; /* 2 For = */
                        break;
                    case 3:
                        $strWh = $strWh . " AND " . $searchArray[$col] . " >= '" . $searchArray[3 * $i] . "'"; /* 3 For >= */
                        break;
                    case 4:
                        $strWh = $strWh . " AND " . $searchArray[$col] . " <= '" . $searchArray[3 * $i] . "'"; /* 4 For <= */
                        break;
                    case 5:
                        $strWh = $strWh . " AND " . $searchArray[$col] . " BETWEEN " . $searchArray[3 * $i] . ""; /* 5 For BETWEEN */
                        break;
                    case 6:
                        $strWh = $strWh . " AND " . $searchArray[$col] . " IN (" . $searchArray[3 * $i] . ")"; /* 5 For IN */
                        break;
                    case 7:
                        $strWh = $strWh . " AND " . $searchArray[$col] . " NOT IN (" . $searchArray[3 * $i] . ")"; /* 5 For IN */
                        break;
                    default:
                        $strWh = $strWh . '';
                        break;
                }
            }
        }


        $strQuery = $query . $strWh . $order;
//        $arrResult = $objODBC->executeArray($strQuery);

        return $strQuery;
    }
    
  public function objectToArray($d) 
  {
        if (is_object($d)) 
        {
            // Gets the properties of the given object
            // with get_object_vars function
            $d = get_object_vars($d);
        }       
        if (is_array($d)) 
        {
            /*
            * Return array converted to object
            * Using __FUNCTION__ (Magic constant)
            * for recursive call
            */
            return array_map(array($this,__FUNCTION__), $d);
        }
        else 
        {
            // Return array
            return $d;
        }
  }
    


}