<?php 

if (!function_exists('snake_case_to_string')) {
    function snake_case_to_string($snake_case)
    {
        return ucwords(str_replace('_', ' ', $snake_case));
    }
}
if (!function_exists('upload_file')) {
    function upload_file($filename,$path,$required='',$size=10485760)
    {
        $CI = &get_instance();
        $config['upload_path']          = $path;
        if($required=='pdf')
        {
            $config['allowed_types']        = $required;
        }
        else{
            $config['allowed_types']        = 'gif|jpg|png|jpeg|JPG|JPEG|PNG|webp|webp';
        }

        //$config['file_name'] = is_array($filename)?date('Y-m-d'):date('Y-m-d');
        $config['remove_spaces'] = TRUE;
        $response=null;
        if($required=='pdf')
        {
            $Filesize = $_FILES[$filename]['size'];
            if($Filesize>$size)
            {
                $error ['error'] = 'Invalid file size has exceeded it max limit';
                return $error;
            }
            //if()
            $config['max_width']= 1024;
        }
        if(is_array($filename))
        {
            $response=array();
            $files = $_FILES;
            $cpt = count($_FILES ['images'] ['name']);
            for ($i = 0; $i < $cpt; $i ++) {
                $name = time().$files ['images'] ['name'] [$i];
                $_FILES ['images'] ['name'] = $name;
                $_FILES ['images'] ['type'] = $files ['images'] ['type'] [$i];
                $_FILES ['images'] ['tmp_name'] = $files ['images'] ['tmp_name'] [$i];
                $_FILES ['images'] ['error'] = $files ['images'] ['error'] [$i];
                $_FILES ['images'] ['size'] = $files ['images'] ['size'] [$i];

                $CI->upload->initialize($config);
                if(!($CI->upload->do_upload('images')) || $files ['images'] ['error'] [$i] !=0)
                {
                    $error = array('error' => $CI->upload->display_errors());
                    log_message('error','Message:'.strip_tags($error['error']).' Line No:.'.__LINE__.' File :'.base_url().'/application/libraries/Fileupload.php');
                    $response =  $error;
                }
                else
                {
                    $data = array('upload_data' => $CI->upload->data());
                    $response[] = $data['upload_data']['file_name'];
                }
            }
        }
        else{
            $CI->upload->initialize($config);
            if ( ! $CI->upload->do_upload($filename))
            {
                $error = array('error' => $CI->upload->display_errors());
                log_message('error','Message:'.strip_tags($error['error']).' Line No:.'.__LINE__.' File :'.base_url().'/application/libraries/Fileupload.php');
                $response =  $error;
            }
            else
            {
                $data = array('upload_data' => $CI->upload->data());
                $response =  $data['upload_data']['file_name'];
            }
        }
        return $response;
    }
}
if (!function_exists('courses')) {
    function courses()
    {
        $CI = &get_instance();
        $CI->load->model('Courses_model');
        return $CI->Courses_model->getAllData();
    }
}
if (!function_exists('test_series')) {
    function test_series()
    {
        $CI = &get_instance();
        $CI->load->model('Test_series_model');
        return $CI->Test_series_model->getAllData();
    }
}