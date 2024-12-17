<?php

/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */

defined('BASEPATH') or exit('No direct script access allowed');


// | -------------------------------------------------------------------------
// | URI ROUTING
// | -------------------------------------------------------------------------
// | This file lets you re-map URI requests to specific controller functions.
// |
// | Typically there is a one-to-one relationship between a URL string
// | and its corresponding controller class/method. The segments in a
// | URL normally follow this pattern:
// |
// |	example.com/class/method/id/
// |
// | In some instances, however, you may want to remap this relationship
// | so that a different class/function is called than the one
// | corresponding to the URL.
// |
// | Please see the user guide for complete details:
// |
// |	https://codeigniter.com/user_guide/general/routing.html
// |
// | -------------------------------------------------------------------------
// | RESERVED ROUTES
// | -------------------------------------------------------------------------
// |
// | There are three reserved routes:
// |
// |	$route['default_controller'] = 'welcome';
// |
// | This route indicates which controller class should be loaded if the
// | URI contains no data. In the above example, the "welcome" class
// | would be loaded.
// |
// |	$route['404_override'] = 'errors/page_missing';
// |
// | This route will tell the Router which controller/method to use if those
// | provided in the URL cannot be matched to a valid route.
// |
// |	$route['translate_uri_dashes'] = FALSE;
// |
// | This is not exactly a route, but allows you to automatically route
// | controller and method names that contain dashes. '-' isn't a valid
// | class or method name character, so it requires translation.
// | When you set this option to TRUE, it will replace ALL dashes in the
// | controller and method URI segments.
// |
// | Examples:	my-controller/index	-> my_controller/index
// |		my-controller/my-method	-> my_controller/my_method


$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['users'] = 'Users';
$route['app_users'] = 'App_Users';
$route['mobile_app_users'] = "admin/Admin_controller/app_Users";
$route['app_users'] = 'App_Users';
$route['delete_user/(:any)'] = 'Users/delete_user/$1';
$route['User/updateUser'] = 'Users/updateUser';
$route['current_affairs'] = 'CurrentAffairs';
$route['current_affairs_category'] = 'CurrentAffairs/current_affairs_category';
$route['news_category'] = 'News/news_category';
$route['add_news_category_form'] = 'News/add_news_category_form';
$route['add_news_category_form/(:any)'] = 'News/add_news_category_form/$1';
$route['add_news_category'] = 'News/add_news_category';
$route['add_current_affairs_category_form'] = 'CurrentAffairs/add_current_affairs_category_form';
$route['add_current_affairs_category'] = 'CurrentAffairs/add_current_affairs_category';
$route['add_current_affairs_category_form/(:any)'] = 'CurrentAffairs/add_current_affairs_category_form/$1';
$route['delete_current_affairs_category/(:any)'] = 'CurrentAffairs/delete_current_affairs_category/$1';
$route['delete_news_category/(:any)'] = 'News/delete_news_category/$1';
$route['current_affairs_quiz'] = 'CurrentAffairs/tests';
$route['current_affairs/add-test'] = 'CurrentAffairs/add_test';
$route['current_affairs/add_tests'] = 'CurrentAffairs/add_course_tests';
$route['current_affairs/add-test/(:any)'] = 'CurrentAffairs/add_test/$1';
$route['current_affairs/delete-test/(:any)'] = 'CurrentAffairs/delete_test/$1';
$route['current_affairs_category_api'] = 'Api_controller/current_affairs_category_api';
$route['get_current_affairs_test_api'] = 'Api_controller/get_current_affairs_test_api';
$route['other_option'] = 'Other_option';
$route['news'] = 'News';
$route['current_affairs_setting'] = 'CurrentAffairs/current_affairs_setting';

// new routes 21-02-2024 created by abdul

$route['membership_plans'] = 'Membership_Plans';

$route['membership_plans/add_membership_plans'] = 'Membership_Plans/add_membership_plans';
$route['membership_plans/add_membership_plans/(:any)'] = 'Membership_Plans/add_membership_plans/$1';
$route['membership_plans/membership_plans_list'] = 'Membership_Plans/membership_plans_list';
$route['membership_plans/delete_membership_plans_list/(:any)'] = 'Membership_Plans/delete_membership_plans_list/$1';
$route['membership_plans/status_membership_plans_list_active/(:any)'] = 'Membership_Plans/status_membership_plans_list_active/$1';
$route['membership_plans/status_membership_plans_list_in_active/(:any)'] = 'Membership_Plans/status_membership_plans_list_in_active/$1';


$route['other_option_new/add_other_option'] = 'Other_options_controller/add_other_option';
$route['other_option_new/add_other_option/(:any)'] = 'Other_options_controller/add_other_option/$1';
$route['other_option_new/other_option_list'] = 'Other_options_controller/other_option_list';
$route['other_option_new/delete_other_option_list/(:any)'] = 'Other_options_controller/delete_other_option_list/$1';
$route['other_option_new/status_other_option_list_active/(:any)'] = 'Other_options_controller/status_other_option_list_active/$1';
$route['other_option_new/status_other_option_list_in_active/(:any)'] = 'Other_options_controller/status_other_option_list_in_active/$1';


$route['other_option_new/add_other_option_category/(:any)'] = 'Other_options_controller/add_other_option_category/$1';
$route['other_option_new/other_option_category_list'] = 'Other_options_controller/other_option_category_list';
$route['other_option_new/delete_other_option_category_list/(:any)'] = 'Other_options_controller/delete_other_option_category_list/$1';

$route['whatsapp_details/add_whatsapp_details'] = 'Whatsapp_details/add_whatsapp_details';
$route['whatsapp_details/add_whatsapp_details/(:any)'] = 'Whatsapp_details/add_whatsapp_details/$1';
$route['whatsapp_details/whatsapp_details_list'] = 'Whatsapp_details/whatsapp_details_list';
$route['whatsapp_details/delete_whatsapp_details_list/(:any)'] = 'Whatsapp_details/delete_whatsapp_details_list/$1';
$route['whatsapp_details/status_whatsapp_details_list_active/(:any)'] = 'Whatsapp_details/status_whatsapp_details_list_active/$1';
$route['whatsapp_details/status_whatsapp_details_list_in_active/(:any)'] = 'Whatsapp_details/status_whatsapp_details_list_in_active/$1';

$route['exam_material/add_subject'] = 'Exam_Material/add_subject';
$route['exam_material/add_subject/(:any)'] = 'Exam_Material/add_subject/$1';
$route['exam_material/subject_list'] = 'Exam_Material/subject_list';
$route['exam_material/delete_subject_list/(:any)'] = 'Exam_Material/delete_subject_list/$1';

$route['exam_material/add_exam'] = 'Exam_Material/add_exam';
$route['exam_material/add_exam/(:any)'] = 'Exam_Material/add_exam/$1';
$route['exam_material/exam_list'] = 'Exam_Material/exam_list';
$route['exam_material/delete_exam_list/(:any)'] = 'Exam_Material/delete_exam_list/$1';

$route['exam_material/add_exam_year'] = 'Exam_Material/add_exam_year';
$route['exam_material/add_exam_year/(:any)'] = 'Exam_Material/add_exam_year/$1';
$route['exam_material/exam_year_list'] = 'Exam_Material/exam_year_list';
$route['exam_material/delete_exam_year_list/(:any)'] = 'Exam_Material/delete_exam_year_list/$1';
 
$route['exam_material/add_exam_sub'] = 'Exam_Material/add_exam_sub';
$route['exam_material/add_exam_sub/(:any)'] = 'Exam_Material/add_exam_sub/$1';
$route['exam_material/exam_sub_list'] = 'Exam_Material/exam_sub_list';
$route['exam_material/delete_exam_sub_list/(:any)'] = 'Exam_Material/delete_exam_sub_list/$1';

$route['exam_material/exam_material_list'] = 'Exam_material/exam_material_list';

$route['exam_material/add_examwise_pdf/(:any)'] = 'Exam_material/add_examwise_pdf/$1';
$route['exam_material/add_examwise_pdf/(:any)/(:any)'] = 'Exam_material/add_examwise_pdf/$1/$1';
$route['exam_material/examwise_pdf_list'] = 'Exam_material/examwise_pdf_list';
$route['exam_material/delete_examwise_pdf/(:any)'] = 'Exam_material/delete_examwise_pdf/$1';

$route['exam_material/add_document/(:any)'] = 'Exam_material/add_document/$1';
$route['exam_material/document_list'] = 'Exam_material/document_list';


$route['get_membership_section_details'] = 'Membership_Plans/get_membership_section_details';
$route['get_single_membership/(:any)'] = 'Membership_Plans/get_single_membership/$1';

$route['doc_videos/document'] = 'Doc_Videos/documents';
$route['get_doc_video_details'] = 'Doc_Videos/get_doc_video_details';
$route['get_single_video_doc/(:any)'] = 'Doc_Videos/get_single_video_doc/$1';

$route['doc_videos/texts'] = 'Doc_Videos/texts';
$route['doc_videos/videos'] = 'Doc_Videos/videos';
$route['doc_videos/add_docs_videos_tests'] = 'Doc_Videos/add_docs_videos_tests';
$route['doc_videos/tests'] = 'Doc_Videos/tests';
$route['doc_videos/add-test'] = 'Doc_Videos/add_test';
$route['doc_videos/add-test/(:any)'] = 'Doc_Videos/add_test/$1';
$route['doc_videos/delete-test/(:any)'] = 'Doc_Videos/delete_test/$1';


$route['test_notification'] = 'Common_controller/test_notification';
$route['free_test/add-test'] = 'Free_test/add_test';
$route['free_test/add-test/(:any)'] = 'Free_test/add_test/$1';
$route['free_test/delete-test/(:any)'] = 'Free_test/delete_test/$1';
$route['get_free_mock_tests'] = 'Api_controller/get_free_mock_tests';
$route['get_doc_videos_tests'] = 'Api_controller/get_doc_videos_tests';
$route['get_ebooks_tests_api'] = 'Api_controller/get_ebooks_tests_api';
$route['free_test/tests'] = 'Free_test/tests';
$route['course/add-test'] = 'Courses/add_test';
$route['course/add-test/(:any)'] = 'Courses/add_test/$1';
$route['course/delete-test/(:any)'] = 'Courses/delete_test/$1';
$route['get_ebooks_api'] = 'Api_controller/get_ebooks_api';
$route['get_ebooks_sub_category_api'] = 'Api_controller/get_ebooks_sub_category_api';
$route['get_ebooks_list_api'] = 'Api_controller/get_ebooks_list_api';
$route['get_ebooks_chapter_api'] = 'Api_controller/get_ebooks_chapter_api';
$route['get_ebooks_solution_api'] = 'Api_controller/get_ebooks_solution_api';
$route['get_ebooks_video_separate_api'] = 'Api_controller/get_ebooks_video_separate_api';
$route['buy-course'] = 'Api_controller/buy_course';
$route['my-contents'] = 'Api_controller/my_contents';
$route['bought-content-details'] = 'Api_controller/bought_content_details';

$route['buy_test_series'] = 'Api_controller/buy_test_series';
$route['buy_membership'] = 'Api_controller/buy_membership';
$route['user_payments'] = 'Api_controller/user_payments';
$route['user_payment_details'] = 'Api_controller/user_payment_details';

$route['get_coupon_api'] = 'Api_controller/get_coupon_api';
$route['test_submit'] = 'Api_controller/test_submit';
$route['test-setup'] = 'TestSetup/test_setup';
$route['test-list'] = 'TestSetup/test_list';
$route['all_payments'] = 'Payments_controller/all_payments';
$route['test-questions'] = 'TestSetup/questions_list';
$route['test-gallary'] = 'TestSetup/test_gallary';
$route['delete_image'] = 'TestSetup/delete_image';
$route['test-setup/(:any)'] = 'TestSetup/test_setup/$1';
$route['delete-question/(:any)/(:any)'] = 'TestSetup/delete_question/$1';
// $route['doc_videos/add-test/(:any)'] = 'Doc_Videos/add_test/$1';
$route['delete-test/(:any)'] = 'TestSetup/delete_test';
$route['add-test-passages/(:any)'] = 'TestSetup/add_test_passages';


$route['ebook_cat/ebooks_cat'] = 'Ebook_Category/ebooks_cat';
$route['get_ebooks_video_details'] = 'Ebook_Category/get_ebooks_video_details';
$route['get_single_video_doc/(:any)'] = 'Ebook_Category/get_single_video_doc/$1';

$route['ebook_cat/ebooks__cat'] = 'Ebook_Category/ebooks__cat';
$route['ebook_cat/ebooks__cat_list'] = 'Ebook_Category/ebooks__cat_list';
$route['ebook_cat/ebooks__cat/(:any)'] = 'Ebook_Category/add_ebook__cat_data';
$route['ebook_cat/delete_ebooks__cat/(:any)'] = 'Ebook_Category/delete_ebooks__cat/$1';
$route['ebook_cat/ebooks_sub_cat'] = 'Ebook_Category/ebooks_sub_cat';
$route['ebook_cat/ebooks_sub_cat_list'] = 'Ebook_Category/ebooks_sub_cat_list';
$route['ebook_cat/ebooks_sub_cat/(:any)'] = 'Ebook_Category/add_ebook_sub_cat_data';
$route['ebook_cat/delete_ebooks_sub_cat/(:any)'] = 'Ebook_Category/delete_ebooks_sub_cat/$1';
$route['ebook_cat/ebooks_setup'] = 'Ebook_Category/ebooks_setup';
$route['ebook_cat/ebooks_setup_list'] = 'Ebook_Category/ebooks_setup_list';
$route['ebook_cat/ebooks_setup/(:any)'] = 'Ebook_Category/add_ebook_setup_data';
$route['ebook_cat/delete_ebooks_setup/(:any)'] = 'Ebook_Category/delete_ebooks_setup/$1';

$route['ebook_cat/ebooks_chapter_setup'] = 'Ebook_Category/add_ebooks_chapter_setup';
$route['ebook_cat/ebooks_chapter_setup/(:any)'] = 'Ebook_Category/add_ebooks_chapter_setup/$1';
$route['ebook_cat/ebooks_chapter_setup/(:any)/(:any)'] = 'Ebook_Category/add_ebooks_chapter_setup/$1/$1';
$route['ebook_cat/ebooks_chapter_setup_list'] = 'Ebook_Category/ebooks_chapter_setup_list';
$route['ebook_cat/delete_ebooks_chapter_setup/(:any)'] = 'Ebook_Category/delete_ebooks_chapter_setup/$1';

$route['ebook_cat/ebooks_video_setup'] = 'Ebook_Category/add_ebooks_video_setup';
$route['ebook_cat/ebooks_video_setup/(:any)'] = 'Ebook_Category/add_ebooks_video_setup/$1';
$route['ebook_cat/ebooks_video_setup/(:any)/(:any)'] = 'Ebook_Category/add_ebooks_video_setup/$1/$1';
$route['ebook_cat/ebooks_video_setup_list'] = 'Ebook_Category/ebooks_video_setup_list';
$route['ebook_cat/delete_ebooks_video_setup/(:any)'] = 'Ebook_Category/delete_ebooks_video_setup/$1';

$route['new_coupon/add_coupon'] = 'Mahatest_Coupon/add_coupon';
$route['new_coupon/add_coupon_list'] = 'Mahatest_Coupon/add_coupon_list';
$route['new_coupon/add_coupon/(:any)'] = 'Mahatest_Coupon/add_coupon';
$route['new_coupon/delete_coupon/(:any)'] = 'Mahatest_Coupon/delete_coupon/$1';
// NEW API Routes START
$route['test-details'] = 'Api_controller/get_test_details';
$route['get_current_afair_api'] = 'Api_controller/get_current_afair_api';
$route['get_manage_docs_api'] = 'Api_controller/get_manage_docs_api';
$route['get_single_courses_api'] = 'Api_controller/get_single_courses_api';
$route['get_manage_courses_api'] = 'Api_controller/get_manage_courses_api';
$route['get_courses_pdf_api'] = 'Api_controller/get_courses_pdf_api';
$route['get_test_groups'] = 'Api_controller/getTestGroupDetails';
$route['get_courses_text_api'] = 'Api_controller/get_courses_text_api';
$route['get_courses_test_api'] = 'Api_controller/get_courses_test_api';
$route['get_courses_videos_api'] = 'Api_controller/get_courses_videos_api';
$route['get_saved_news'] = 'Api_controller/get_saved_news';


$route['get_saved_english_vocabulary'] = 'Api_controller/get_saved_english_vocabulary';
$route['get_saved_marathi_sabd'] = 'Api_controller/get_saved_marathi_sabd';

$route['set_user_marathi_sabd_sangrah_bookmark_api'] = 'Api_controller/set_user_marathi_sabd_sangrah_bookmark_api';
$route['set_user_english_vocabulary_bookmark_api'] = 'Api_controller/set_user_english_vocabulary_bookmark_api';



$route['get_manage_test_series_api'] = 'Api_controller/get_manage_test_series_api';
$route['get_single_test_series_api'] = 'Api_controller/get_single_test_series_api';
$route['get_test_series_pdf_api'] = 'Api_controller/get_test_series_pdf_api';
$route['get_test_series_test_api'] = 'Api_controller/get_test_series_test_api';
$route['attempted_test_overview'] = 'Api_controller/getTestResult_overview';
$route['attempted_test_solution'] = 'Api_controller/getTestResult_solutions';
$route['attempted_test_question_details'] = 'Api_controller/getTestResult_questions_details';

$route['get_my_membership'] = 'Api_controller/get_my_membership';

$route['get_help_master_api'] = 'Api_controller/get_help_master_api';

$route['get_syllabus_api'] = 'Api_controller/get_syllabus_api';
$route['get_other_options_api'] = 'Api_controller/get_other_options_api';
$route['get_membership_plans_api'] = 'Api_controller/get_membership_plans_api';

$route['get_saved_current_affair'] = 'Api_controller/get_saved_current_affair';
$route['get_all_abhyas_sahitya_category_api'] = 'Api_controller/get_all_abhyas_sahitya_category_api';

$route['get_all_other_option_category_api'] = 'Api_controller/get_all_other_option_category_api';

$route['get_all_category_current_afair_api'] = 'Api_controller/get_all_category_current_afair_api';
$route['get_yashogatha_data_api'] = 'Api_controller/get_yashogatha_data_api';
$route['get_states_list_api'] = 'Api_controller/get_states_list_api';
$route['get_all_news_categories'] = 'Api_controller/get_all_news_categories';
$route['set_user_current_affairs_bookmark_api'] = 'Api_controller/set_user_current_affairs_bookmark_api';
$route['set_user_news_bookmark_api'] = 'Api_controller/set_user_news_bookmark_api';

$route['get_news_api'] = 'Api_controller/get_news_api';
$route['get_districts_list_api'] = 'Api_controller/get_districts_list_api';
$route['set_user_doubts_api'] = 'Api_controller/set_user_doubts_api';

$route['update_profile_api'] = 'Api_controller/update_profile_api';
$route['get_user_doubts_api'] = 'Api_controller/get_user_doubts_api';
$route['cerate_account_api'] = 'Api_controller/cerate_account_api';
$route['get_banner_image_api'] = 'Api_controller/get_banner_image_api';
$route['validate_otp_api'] = 'Api_controller/validate_otp_api';
$route['generate_login_otp_api'] = 'Api_controller/generate_login_otp_api';
$route['get_user_profile_api'] = 'Api_controller/get_user_profile_api';

$route['set_logged_in_user'] = 'Api_controller/set_logged_in_user';
$route['set_user_logout'] = 'Api_controller/set_user_logout';
$route['user_notifications'] = 'Api_controller/user_notifications';

$route['exam_materials_api'] = 'Api_controller/exam_materials_api';
$route['exam_material_subjects_api'] = 'Api_controller/exam_material_subjects_api';
$route['exam_material_exams_api'] = 'Api_controller/exam_material_exams_api';
$route['exam_material_exam_years_api'] = 'Api_controller/exam_material_exam_years_api';
$route['exam_material_exam_years_types_api'] = 'Api_controller/exam_material_exam_years_types_api';
$route['exam_material_recent_tests_api'] = 'Api_controller/exam_material_recent_tests_api';


$route['exam_material_syllabus_subjectwise_type'] = 'Api_controller/exam_material_syllabus_subjectwise_type';
$route['exam_material_syllabus_subjectwise_pdf'] = 'Api_controller/exam_material_syllabus_subjectwise_pdf';
$route['exam_material_syllabus_subjectwise_content'] = 'Api_controller/exam_material_syllabus_subjectwise_content';

$route['exam_material_syllabus_examwise_pdf'] = 'Api_controller/exam_material_syllabus_examwise_pdf';
$route['exam_material_previous_paper_examwise_pdf'] = 'Api_controller/exam_material_previous_paper_examwise_pdf';
$route['exam_material_syllabus_examwise_content'] = 'Api_controller/exam_material_syllabus_examwise_content';
$route['exam_material_subjectwise_pdf'] = 'Api_controller/exam_material_subjectwise_pdf';
$route['exam_material_examwise_pdf'] = 'Api_controller/exam_material_examwise_pdf';
$route['exam_material_subject_tests_api'] = 'Api_controller/exam_material_subject_tests_api';
$route['exam_material_exam_tests_api'] = 'Api_controller/exam_material_exam_tests_api';

$route['get_all_category_english_vocabulary_api'] = 'Api_controller/get_all_category_english_vocabulary_api';
$route['get_all_category_marathi_sabd_api'] = 'Api_controller/get_all_category_marathi_sabd_api';
$route['get_marathi_sabd_api'] = 'Api_controller/get_marathi_sabd_api';
$route['get_english_vocabulary_api'] = 'Api_controller/get_english_vocabulary_api';

$route['get_whatsapp_number_api'] = 'Api_controller/get_whatsapp_number_api';


// $route['exam_material_previous_paper_examwise_pdf'] = 'Api_controller/exam_material_previous_paper_examwise_pdf ';


$route['current_affairs/manage_current_affairs_form'] = 'CurrentAffairs/manage_current_affairs_form';
$route['current_affairs/manage_current_affairs_form/(:any)'] = 'CurrentAffairs/manage_current_affairs_form/$1';
$route['current_affairs/manage_current_affairs_form_list'] = 'CurrentAffairs/manage_current_affairs_form_list';
$route['current_affairs/delete_manage_current_affairs_form/(:any)'] = 'CurrentAffairs/delete_manage_current_affairs_form/$1';
$route['current_affairs/manage_current_affairs_form_active/(:any)'] = 'CurrentAffairs/manage_current_affairs_form_active/$1';
$route['current_affairs/manage_current_affairs_form_inactive/(:any)'] = 'CurrentAffairs/manage_current_affairs_form_inactive/$1';


$route['english_vocabulary/english_vocabulary_form'] = 'EnglishVocabulary/english_vocabulary_form';
$route['english_vocabulary/english_vocabulary_form/(:any)'] = 'EnglishVocabulary/english_vocabulary_form/$1';
$route['english_vocabulary/english_vocabulary_form_list'] = 'EnglishVocabulary/english_vocabulary_form_list';
$route['english_vocabulary/delete_english_vocabulary_form/(:any)'] = 'EnglishVocabulary/delete_english_vocabulary_form/$1';
$route['english_vocabulary/english_vocabulary_form_active/(:any)'] = 'EnglishVocabulary/english_vocabulary_form_active/$1';
$route['english_vocabulary/english_vocabulary_form_inactive/(:any)'] = 'EnglishVocabulary/english_vocabulary_form_inactive/$1';


$route['english_vocabulary/english_vocabulary_category'] = 'EnglishVocabulary/english_vocabulary_category';
$route['english_vocabulary/english_vocabulary_category/(:any)'] = 'EnglishVocabulary/english_vocabulary_category/$1';
$route['english_vocabulary/english_vocabulary_category_list'] = 'EnglishVocabulary/english_vocabulary_category_list';
$route['english_vocabulary/delete_english_vocabulary_category/(:any)'] = 'EnglishVocabulary/delete_english_vocabulary_category/$1';


$route['marathi_sabd/marathi_sabd_form'] = 'MarathiSabd/marathi_sabd_form';
$route['marathi_sabd/marathi_sabd_form/(:any)'] = 'MarathiSabd/marathi_sabd_form/$1';
$route['marathi_sabd/marathi_sabd_form_list'] = 'MarathiSabd/marathi_sabd_form_list';
$route['marathi_sabd/delete_marathi_sabd_form/(:any)'] = 'MarathiSabd/delete_marathi_sabd_form/$1';
$route['marathi_sabd/marathi_sabd_form_active/(:any)'] = 'MarathiSabd/marathi_sabd_form_active/$1';
$route['marathi_sabd/marathi_sabd_form_inactive/(:any)'] = 'MarathiSabd/marathi_sabd_form_inactive/$1';

$route['marathi_sabd/marathi_sabd_category'] = 'MarathiSabd/marathi_sabd_category';
$route['marathi_sabd/marathi_sabd_category/(:any)'] = 'MarathiSabd/marathi_sabd_category/$1';
$route['marathi_sabd/marathi_sabd_category_list'] = 'MarathiSabd/marathi_sabd_category_list';
$route['marathi_sabd/delete_marathi_sabd_category/(:any)'] = 'MarathiSabd/delete_marathi_sabd_category/$1';


// $route['user_login_new']='Api_controller/user_login_new';


// NEW API Routes END
//admin routes staret   
$route['add_help_master'] = "admin/Admin_controller/add_help_master";
// $route['app_users'] = "admin/Admin_controller/app_users";
$route['mobile_app_users'] = "admin/Admin_controller/app_Users";
$route['add_other_option_category'] = "admin/Admin_controller/add_other_option_category";

/*27-02-2024*/
$route['courses/add_course_data'] = 'Courses/add_course_data';
$route['courses/courses_list'] = 'Courses/courses_list';
$route['courses/delete_courses_list/(:any)'] = 'Courses/delete_courses_list/$1';
$route['courses/status_courses_list_active/(:any)'] = 'Courses/status_courses_list_active/$1';
$route['courses/status_courses_list_in_active/(:any)'] = 'Courses/status_courses_list_in_active/$1';

$route['courses/add_course_videos'] = 'Courses/add_course_videos';
$route['courses/add_course_videos/(:any)'] = 'Courses/add_course_videos/$1';
$route['courses/courses_video_list'] = 'Courses/courses_video_list';


$route['courses/add_texts'] = 'Courses/add_texts';
$route['courses/add_texts/(:any)'] = 'Courses/add_texts/$1';
$route['courses/texts_list'] = 'Courses/texts_list';
// $route['courses/delete_texts_list/(:any)'] = 'Courses/delete_texts_list/$1';

$route['courses/add_pdfs'] = 'Courses/add_pdfs';
$route['courses/add_pdfs/(:any)'] = 'Courses/add_pdfs/$1';
$route['courses/pdfs_list'] = 'Courses/pdfs_list';

// $route['exam_material/exam_material_list'] = 'Exam_material/exam_material_list';

// $route['exam_material/previous_examwise_pdf/(:any)'] = 'Exam_material/previous_examwise_pdf/$1';

// $route['exam_material/add_document/(:any)'] = 'Exam_material/add_document/$1';
// $route['exam_material/document_list'] = 'Exam_material/document_list';


$route['doc_videos/add_document'] = 'Doc_Videos/add_document';
$route['doc_videos/add_document/(:any)'] = 'Doc_Videos/add_document/$1';
$route['doc_videos/document_list'] = 'Doc_Videos/document_list';


$route['doc_videos/add_text'] = 'Doc_Videos/add_text';
$route['doc_videos/add_text/(:any)'] = 'Doc_Videos/add_text/$1';
$route['doc_videos/text_list'] = 'Doc_Videos/text_list';

$route['doc_videos/add_videos'] = 'Doc_Videos/add_videos';
$route['doc_videos/add_videos/(:any)'] = 'Doc_Videos/add_videos/$1';
$route['doc_videos/videos_list'] = 'Doc_Videos/videos_list';


$route['doc_videos/document'] = 'Doc_Videos/documents';
$route['get_doc_video_details'] = 'Doc_Videos/get_doc_video_details';
$route['get_single_video_doc/(:any)'] = 'Doc_Videos/get_single_video_doc/$1';

$route['news/add_news'] = 'News/add_news';
$route['news/add_news/(:any)'] = 'News/add_news/$1';
$route['news/news_list'] = 'News/news_list';


$route['news/add_news_categorys'] = 'News/add_news_categorys';
$route['news/add_news_categorys/(:any)'] = 'News/add_news_categorys/$1';
$route['news/news_category_list'] = 'News/news_category_list';



$route['courses/document'] = 'Courses/documents';
$route['courses/texts'] = 'Courses/texts';
$route['courses/course-videos'] = 'Courses/videos';
$route['get_courses'] = 'Courses/get_courses';
$route['get_courses_details'] = 'Courses/get_courses_details';
//$route['get_single_course_detail/{id}']='Courses/get_single_course_detail/$1';
/*28-02-2024*/
// new changes
$route['courses/pdf'] = 'Courses/pdf';
//$route['get_single_course_detail/{id}']='Courses/get_single_course_detail/$1';
/*28-02-2024*/
$route['courses/quizs'] = 'Courses/quizs';
$route['courses/tests'] = 'Courses/tests';
$route['get_quizs_details'] = 'Quizs/get_quiz_details';
$route['get_test_series_details'] = 'TestSeries/get_test_series_details';


//Test series routes
$route['test_series/add_test_series'] = 'TestSeries/add_test_series';
$route['test_series/add_test_series/(:any)'] = 'TestSeries/add_test_series/$1';
$route['test_series/test_series_list'] = 'TestSeries/test_series_list';
$route['test_series/delete_test_series_list/(:any)'] = 'TestSeries/delete_test_series_list/$1';
$route['test_series/status_test_series_list_active/(:any)'] = 'TestSeries/status_test_series_list_active/$1';
$route['test_series/status_test_series_list_in_active/(:any)'] = 'TestSeries/status_test_series_list_in_active/$1';

$route['test_series/test_series_quizs'] = 'TestSeries/test_series_quizs';
$route['test_series/test_series_quizs/(:any)'] = 'TestSeries/test_series_quizs/$1';
$route['test_series/test_series_quizs_list'] = 'TestSeries/test_series_quizs_list';
$route['test_series/delete_test_series_quizs_test/(:any)'] = 'TestSeries/delete_test_series_quizs_test/$1';

$route['test_series/test_series_quizs_view_details/(:any)'] = 'TestSeries/test_series_quizs_view_details/$1';


$route['TestSeries/add_test_series_quizs_tests'] = 'TestSeries/add_test_series_quizs_tests';
// test_series / delete_test_series_quizs_test /

$route['test_series/test_series_pdf'] = 'TestSeries/test_series_pdf';
$route['test_series/test_series_pdf/(:any)'] = 'TestSeries/test_series_pdf/$1';
$route['test_series/test_series_pdf_list'] = 'TestSeries/test_series_pdf_list';
$route['test_series/delete_test_series_pdf_list/(:any)'] = 'TestSeries/delete_test_series_pdf_list/$1';


$route['test_series/manage_series'] = 'TestSeries/index';
$route['get_series'] = 'TestSeries/get_series';
$route['test_series/quizs'] = 'TestSeries/quizs';
$route['get_quizs_details'] = 'Quizs/get_quiz_details';

$route['test_series/pdf'] = 'TestSeries/pdf';
$route['test_series/videos'] = 'TestSeries/videos';



/*end new routes*/


$route['All_exam_list'] = 'All_exam_list';
$route['Study_Material'] = 'Study_Material';
$route['User'] = 'User';
$route['JobAlert'] = 'JobAlert';
$route['Banner'] = 'Banner';
$route['Daily_quiz'] = 'Daily_quiz';
$route['Doubts'] = 'Doubts';
$route['login'] = 'Login';
$route['Gatavarshi_prashna_patrika'] = 'Gatavarshi_prashna_patrika';
$route['Masike'] = 'Masike';
$route['Masike/category'] = 'Masike/category';
$route['Masike/fetch_masike'] = 'Masike/fetch_masike';
$route['Abhyas_sahitya_category'] = 'Abhyas_sahitya_category';
$route['Abhyas_sahitya_category/fetch_abhyas_sahitya_category'] = 'Abhyas_sahitya_category/fetch_abhyas_sahitya_category';

$route['Abhyas_sahitya_category_subject'] = 'Abhyas_sahitya_category_subject';
$route['Abhyas_sahitya'] = 'Abhyas_sahitya';


$route['Pariksha_paddhati_abhyaskram'] = 'Pariksha_paddhati_abhyaskram';
$route['Pariksha_paddhati_abhyaskram/fetch_data'] = 'Pariksha_paddhati_abhyaskram/fetch_datas';
//  $route['Pariksha_paddhati_abhyaskram/pariksha_paddhati_abhyaskram_add'] = 'Pariksha_paddhati_abhyaskram/pariksha_paddhati_abhyaskram_add';
$route['Pariksha_paddhati_abhyaskram_last_yearcut'] = 'Pariksha_paddhati_abhyaskram_last_yearcut';
$route['Pariksha_paddhati_abhyaskram_syllabus'] = 'Pariksha_paddhati_abhyaskram_syllabus';
$route['Pariksha_paddhati_abhyaskram_wattage'] = 'Pariksha_paddhati_abhyaskram_wattage';
$route['Test_series'] = 'Test_series';
$route['Test_series_exam'] = 'Test_series_exam';
$route['Test_series_pdfs'] = 'Test_series_pdfs';
$route['Test_series_videos'] = 'Test_series_videos';
$route['Sarav_prashnasanch_subjects'] = 'Sarav_prashnasanch_subjects';
$route['Sarav_prasnasanch'] = 'Sarav_prasnasanch';


$route['Gatavarshi_prashna_patrika'] = 'Gatavarshi_prashna_patrika';
$route['Yashogatha'] = 'Yashogatha';
$route['Notes'] = 'Notes';
$route['Notes_Subjects'] = 'Notes_Subjects';
$route['Videos'] = 'Videos';
$route['Gatavarshichya_prashna_patrika_year'] = 'Gatavarshichya_prashna_patrika_year';
$route['Gatavarshichya_prashna_patrika_year_title'] = 'Gatavarshichya_prashna_patrika_year_title';
$route['Gatavarshichya_prashna_patrika_live_test'] = 'Gatavarshichya_prashna_patrika_live_test';

$route['Gatavarshiche_prashna_patrika_subjects'] = 'Gatavarshiche_prashna_patrika_subjects';
$route['Gatavarshichya_prashna_patrika_year_practice'] = 'Gatavarshichya_prashna_patrika_year_practice';
$route['Gatavarshichya_prashna_patrika_practice_test'] = 'Gatavarshichya_prashna_patrika_practice_test';

$route['Exam_subject'] = 'Exam_subject';
$route['Push_notification'] = 'Push_notification';
// $route['Push_notification/group'] = 'Push_notification/group';

$route['AppHelp'] = 'AppHelp';
$route['Feedback'] = 'Feedback';
$route['UserPayments'] = 'UserPayments';

$route['introduction_screens'] = 'Introduction_screens';
$route['get_introduction_screen_details'] = 'Introduction_screens/get_introduction_screen_details';
//$route['addIntroductionScreen'] = 'Introduction_screens/addIntroductionScreen';

$route['Exam_section'] = 'Exam_section/index';
$route['get_exam_section_details'] = 'Exam_section/get_exam_section_details';

$route['Exam_subsubject'] = 'Exam_subsubject';
$route['Category'] = 'Category';
$route['get_category_details'] = 'Category/get_category_details';

$route['faq'] = 'FAQ';
$route['get_faq_details'] = 'FAQ/get_faq_details';

$route['classes'] = 'Exam_subject/classes';
$route['chapters'] = 'Exam_subject/chapters';


$route['crud_view'] = 'crud_view';
$route['(:any)'] = 'dashboard/view/$1';
$route['default_controller'] = 'Login';

//API Routes
$route['get_slider_details'] = 'APIController/get_slider_details';
$route['Doubts_Api'] = "api/Doubts_Api/doughtById_get";

//New Work


$route['get_districts_list_api'] = 'Api_controller/get_districts_list_api';
$route['set_user_doubts_api'] = 'Api_controller/set_user_doubts_api';
