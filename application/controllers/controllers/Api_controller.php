<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Api_controller extends CI_Controller
{
    
    public function set_user_doubts_api(){
        $this->Api_model->set_user_doubts_api();
    }
    public function get_user_doubts_api(){
        $this->Api_model->get_user_doubts_api();
    }

    public function generate_login_otp_api(){
        $this->Api_model->generate_login_otp_api();
    }
    
    public function validate_otp_api(){
        $this->Api_model->validate_otp_api();
    }
    public function get_user_profile_api(){
        $this->Api_model->get_user_profile_api();
    }
    
    public function set_logged_in_user(){
		$this->Api_model->set_logged_in_user();
	}
	public function set_user_logout(){
		$this->Api_model->set_user_logout();
	}
    public function get_banner_image_api(){
		$this->Api_model->get_banner_image_api();
	}
    
    public function cerate_account_api(){
		$this->Api_model->cerate_account_api();
	}
    public function update_profile_api(){
		$this->Api_model->update_profile_api();
	}

    public function get_all_category_current_afair_api(){
		$this->Api_model->get_all_category_current_afair_api();
	}
    public function get_current_afair_api(){
		$this->Api_model->get_current_afair_api();
	}
    public function get_districts_list_api(){
		$this->Api_model->get_districts_list_api();
	}
    public function get_news_api(){
		$this->Api_model->get_news_api();
	}
    public function get_yashogatha_data_api(){
		$this->Api_model->get_yashogatha_data_api();
	}
    public function get_states_list_api(){
		$this->Api_model->get_states_list_api();
	}
  public function get_all_news_categories(){
		$this->Api_model->get_all_news_categories();
	}
  public function set_user_current_affairs_bookmark_api(){
		$this->Api_model->set_user_current_affairs_bookmark_api();
	}
  public function set_user_news_bookmark_api(){
		$this->Api_model->set_user_news_bookmark_api();
	}
  public function get_manage_courses_api(){
		$this->Api_model->get_manage_courses_api();
	}
	
	public function get_saved_current_affair(){
		$this->Api_model->get_saved_current_affair();
	}

	public function get_saved_news(){
		$this->Api_model->get_saved_news();
	}
}
