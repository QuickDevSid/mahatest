<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Api_controller extends CI_Controller
{

	public function set_user_doubts_api()
	{
		$this->Api_model->set_user_doubts_api();
	}
	public function get_user_doubts_api()
	{
		$this->Api_model->get_user_doubts_api();
	}

	public function generate_login_otp_api()
	{
		$this->Api_model->generate_login_otp_api();
	}

	public function validate_otp_api()
	{
		$this->Api_model->validate_otp_api();
	}
	public function get_user_profile_api()
	{
		$this->Api_model->get_user_profile_api();
	}

	public function set_logged_in_user()
	{
		$this->Api_model->set_logged_in_user();
	}
	public function set_user_logout()
	{
		$this->Api_model->set_user_logout();
	}
	public function user_notifications()
	{
		$this->Api_model->user_notifications();
	}
	public function get_banner_image_api()
	{
		$this->Api_model->get_banner_image_api();
	}

	public function cerate_account_api()
	{
		$this->Api_model->cerate_account_api();
	}
	public function update_profile_api()
	{
		$this->Api_model->update_profile_api();
	}

	public function get_all_category_current_afair_api()
	{
		$this->Api_model->get_all_category_current_afair_api();
	}
	public function get_current_afair_api()
	{
		$this->Api_model->get_current_afair_api();
	}
	public function get_districts_list_api()
	{
		$this->Api_model->get_districts_list_api();
	}
	public function get_news_api()
	{
		$this->Api_model->get_news_api();
	}
	public function get_yashogatha_data_api()
	{
		$this->Api_model->get_yashogatha_data_api();
	}
	public function get_states_list_api()
	{
		$this->Api_model->get_states_list_api();
	}
	public function get_all_news_categories()
	{
		$this->Api_model->get_all_news_categories();
	}
	public function set_user_current_affairs_bookmark_api()
	{
		$this->Api_model->set_user_current_affairs_bookmark_api();
	}
	public function set_user_news_bookmark_api()
	{
		$this->Api_model->set_user_news_bookmark_api();
	}
	public function get_manage_courses_api()
	{
		$this->Api_model->get_manage_courses_api();
	}
	public function get_single_courses_api()
	{
		$this->Api_model->get_single_courses_api();
	}
	public function get_courses_pdf_api()
	{
		$this->Api_model->get_courses_pdf_api();
	}
	public function get_courses_text_api()
	{
		$this->Api_model->get_courses_text_api();
	}
	public function get_courses_test_api()
	{
		$this->Api_model->get_courses_test_api();
	}
	public function getTestGroupDetails()
	{
		$this->Api_model->getTestGroupDetails();
	}
	public function get_courses_videos_api()
	{
		$this->Api_model->get_courses_videos_api();
	}

	public function get_saved_current_affair()
	{
		$this->Api_model->get_saved_current_affair();
	}

	public function get_saved_news()
	{
		$this->Api_model->get_saved_news();
	}
	public function get_manage_docs_api()
	{
		$this->Api_model->get_manage_docs_api();
	}
	public function get_all_abhyas_sahitya_category_api()
	{
		$this->Api_model->get_all_abhyas_sahitya_category_api();
	}
	public function get_all_other_option_category_api()
	{
		$this->Api_model->get_all_other_option_category_api();
	}
	public function get_other_options_api()
	{
		$this->Api_model->get_other_options_api();
	}
	public function get_syllabus_api()
	{
		$this->Api_model->get_syllabus_api();
	}
	public function get_membership_plans_api()
	{
		$this->Api_model->get_membership_plans_api();
	}
	public function get_help_master_api()
	{
		$this->Api_model->get_help_master_api();
	}
	public function get_my_membership()
	{
		$this->Api_model->get_my_membership();
	}

	public function get_ebooks_api()
	{
		$this->Api_model->get_ebooks_api();
	}

	public function get_ebooks_sub_category_api()
	{
		$this->Api_model->get_ebooks_sub_category_api();
	}

	public function get_ebooks_list_api()
	{
		$this->Api_model->get_ebooks_list_api();
	}

	public function get_ebooks_chapter_api()
	{
		$this->Api_model->get_ebooks_chapter_api();
	}

	public function get_ebooks_solution_api()
	{
		$this->Api_model->get_ebooks_solution_api();
	}
	public function get_ebooks_tests_api()
	{
		$this->Api_model->get_ebooks_tests_api();
	}
	public function get_ebooks_video_separate_api()
	{
		$this->Api_model->get_ebooks_video_separate_api();
	}
	public function get_test_details()
	{
		$this->Api_model->get_test_details();
	}
	public function buy_course()
	{
		$this->Api_model->buy_course();
	}
	public function get_coupon_api()
	{
		$this->Api_model->get_coupon_api();
	}
	public function test_submit()
	{
		$this->Api_model->test_submit();
	}
	public function my_contents()
	{
		$this->Api_model->my_contents();
	}
	public function bought_content_details()
	{
		$this->Api_model->bought_content_details();
	}
	public function get_free_mock_tests()
	{
		$this->Api_model->get_free_mock_tests();
	}
	public function get_doc_videos_tests()
	{
		$this->Api_model->get_doc_videos_tests();
	}

	public function get_manage_test_series_api()
	{
		$this->Api_model->get_manage_test_series_api();
	}

	public function get_single_test_series_api()
	{
		$this->Api_model->get_single_test_series_api();
	}

	public function buy_test_series()
	{
		$this->Api_model->buy_test_series();
	}
	public function buy_membership()
	{
		$this->Api_model->buy_membership();
	}
	public function user_payments()
	{
		$this->Api_model->user_payments();
	}
	public function user_payment_details()
	{
		$this->Api_model->user_payment_details();
	}

	public function get_test_series_pdf_api()
	{
		$this->Api_model->get_test_series_pdf_api();
	}

	public function get_test_series_test_api()
	{
		$this->Api_model->get_test_series_test_api();
	}

	public function getTestResult_overview()
	{
		$this->Api_model->getTestResult_overview();
	}

	public function getTestResult_solutions()
	{
		$this->Api_model->getTestResult_solutions();
	}

	public function getTestResult_questions_details()
	{
		$this->Api_model->getTestResult_questions_details();
	}

	public function current_affairs_category_api()
	{
		$this->Api_model->current_affairs_category_api();
	}

	public function get_current_affairs_test_api()
	{
		$this->Api_model->get_current_affairs_test_api();
	}

	public function exam_materials_api()
	{
		$this->Api_model->exam_materials_api();
	}
	public function exam_material_subjects_api()
	{
		$this->Api_model->exam_material_subjects_api();
	}
	public function exam_material_exams_api()
	{
		$this->Api_model->exam_material_exams_api();
	}
	public function exam_material_subject_tests_api()
	{
		$this->Api_model->exam_material_subject_tests_api();
	}

	public function exam_material_exam_tests_api()
	{
		$this->Api_model->exam_material_exam_tests_api();
	}

	public function exam_material_exam_years_api()
	{
		$this->Api_model->exam_material_exam_years_api();
	}
	public function exam_material_exam_years_types_api()
	{
		$this->Api_model->exam_material_exam_years_types_api();
	}
	public function exam_material_recent_tests_api()
	{
		$this->Api_model->exam_material_recent_tests_api();
	}
	public function exam_material_all_tests_api()
	{
		$this->Api_model->exam_material_all_tests_api();
	}
	public function exam_material_syllabus_subjectwise_type()
	{
		$this->Api_model->exam_material_syllabus_subjectwise_type();
	}
	public function exam_material_syllabus_subjectwise_pdf()
	{
		$this->Api_model->exam_material_syllabus_subjectwise_pdf();
	}

	public function exam_material_syllabus_subjectwise_content()
	{
		$this->Api_model->exam_material_syllabus_subjectwise_content();
	}
	public function exam_material_syllabus_examwise_pdf()
	{
		$this->Api_model->exam_material_syllabus_examwise_pdf();
	}

	public function exam_material_previous_paper_examwise_pdf()
	{
		$this->Api_model->exam_material_previous_paper_examwise_pdf();
	}

	public function exam_material_subjectwise_pdf()
	{
		$this->Api_model->exam_material_subjectwise_pdf();
	}

	public function exam_material_examwise_pdf()
	{
		$this->Api_model->exam_material_examwise_pdf();
	}

	public function get_recent_post_api_exam_material()
	{
		$this->Api_model->get_recent_post_api_exam_material();
	}

	public function exam_material_syllabus_examwise_content()
	{
		$this->Api_model->exam_material_syllabus_examwise_content();
	}

	public function get_all_category_english_vocabulary_api()
	{
		$this->Api_model->get_all_category_english_vocabulary_api();
	}

	public function get_all_category_marathi_sabd_api()
	{
		$this->Api_model->get_all_category_marathi_sabd_api();
	}

	public function get_marathi_sabd_api()
	{
		$this->Api_model->get_marathi_sabd_api();
	}

	public function get_english_vocabulary_api()
	{
		$this->Api_model->get_english_vocabulary_api();
	}

	public function get_saved_english_vocabulary()
	{
		$this->Api_model->get_saved_english_vocabulary();
	}

	public function get_saved_marathi_sabd()
	{
		$this->Api_model->get_saved_marathi_sabd();
	}

	public function get_whatsapp_number_api()
	{
		$this->Api_model->get_whatsapp_number_api();
	}

	public function get_mpsc_all_api()
	{
		$this->Api_model->get_mpsc_all_api();
	}

	public function delete_active_user()
	{
		$this->Api_model->delete_active_user();
	}

	public function set_user_english_vocabulary_bookmark_api()
	{
		$this->Api_model->set_user_english_vocabulary_bookmark_api();
	}
	public function set_user_marathi_sabd_sangrah_bookmark_api()
	{
		$this->Api_model->set_user_marathi_sabd_sangrah_bookmark_api();
	}
	public function exam_material_subjectwise_tests_api()
	{
		$this->Api_model->exam_material_subjectwise_tests_api();
	}

	public function exam_material_examwise_tests_api()
	{
		$this->Api_model->exam_material_examwise_tests_api();
	}
	public function exam_material_examwise_api()
	{
		$this->Api_model->exam_material_examwise_api();
	}

	public function exam_material_subjectwise_api()
	{
		$this->Api_model->exam_material_subjectwise_api();
	}
	public function mpsc_all_subjectwise_external_api()
	{
		$this->Api_model->mpsc_all_subjectwise_external_api();
	}

	public function get_recent_post_api_exam_material()
	{
		$this->Api_model->get_recent_post_api_exam_material();
	}
}
