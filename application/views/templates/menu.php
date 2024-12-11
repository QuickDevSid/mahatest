<?php

if (!$this->session->userdata('logged_in')) {
    redirect(base_url());
    // Do your code here
}

?>
<section>
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong><?php echo $this->session->flashdata('success'); ?></strong>
        </div>
    <?php elseif ($this->session->flashdata('error')): ?>
        <div class="alert alert-warning">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong><?php echo $this->session->flashdata('error'); ?></strong>
        </div>
    <?php endif; ?>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <!-- User Info -->
        <div class="user-info">
            <div class="image">
                <img src="<?php echo base_url() . "assets/images/"; ?><?php echo $this->session->userdata('profile_pic'); ?>" width="48" height="48" alt="User" />
            </div>
            <div class="info-container">
                <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $this->session->userdata('name'); ?></div>
                <div class="email"><?php echo $this->session->userdata('email'); ?></div>
                <div class="btn-group user-helper-dropdown">
                    <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                    <ul class="dropdown-menu pull-right">
                        <li>
                            <a href="<?php echo base_url(); ?>users/profile?id=<?php echo $this->session->userdata('user_id'); ?>"><i class="material-icons">person</i>Profile</a>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?php echo base_url(); ?>login/logout"><i class="material-icons">input</i>Sign Out</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- #User Info -->
        <!-- Menu -->
        <div class="menu">
            <ul class="list">
                <li class="header">MAIN NAVIGATION</li>
                <li id="dashboard">
                    <a href="<?php echo base_url(); ?>"> <i class="material-icons">home</i> <span>Home</span> </a>
                </li>
                <li id="master">
                    <a href="javascript:void(0);" class="menu-toggle"> <i class="material-icons">assignment</i>
                        <span>App Setting</span> </a>
                    <ul class="ml-menu">

                        <li id="AppSetting">
                            <a href="#" data-toggle="modal" data-target="#membership_setting" onclick="getAppSettingEdit()">
                                <i class="material-icons">card_travel</i> <span>App Settings</span> </a>
                        </li>
                        <li id="Exam_section">
                            <a href="<?php echo base_url() . "Exam_section"; ?>">
                                <i class="material-icons">people</i> <span>Exam Section</span> </a>
                        </li>
                        <li id="current_affairs_setting">
                            <a href="<?php echo base_url() . "current_affairs_setting"; ?>">
                                <i class="material-icons">people</i> <span>Section Settings</span> </a>
                        </li>
                        <li id="Exam_subject">
                            <a href="<?php echo base_url() . "Exam_subject"; ?>">
                                <i class="material-icons">people</i> <span>Exam Subject</span> </a>
                        </li>

                        <li id="Exam_subsubject">
                            <a href="<?php echo base_url() . "Exam_subsubject"; ?>">
                                <i class="material-icons">people</i> <span>Exam Sub Subject</span> </a>
                        </li>
                        <li id="All_exam_list">
                            <a href="<?php echo base_url() . "All_exam_list"; ?>">
                                <i class="material-icons">people</i> <span>Manage Exams</span> </a>
                        </li>
                        <li id="Classes">
                            <a href="<?php echo base_url() . "classes"; ?>">
                                <i class="material-icons">people</i> <span>Manage Class</span> </a>
                        </li>
                        <li id="Chapters">
                            <a href="<?php echo base_url() . "chapters"; ?>">
                                <i class="material-icons">people</i> <span>Manage Chapter</span> </a>
                        </li>
                        <!-- <li id="All_exam_list">
                            <a href="<?php //echo base_url() . "All_exam_list"; 
                                        ?>"> <i class="material-icons">people</i>
                                <span>Manage Exam</span> </a>
                        </li> -->


                        <li id="Banner">
                            <a href="<?php echo base_url() . "Banner"; ?>"> <i class="material-icons">people</i>
                                <span>Banner Image</span> </a>
                        </li>
                        <li id="introduction_screens">
                            <a href="<?php echo base_url() . "introduction_screens"; ?>"> <i class="material-icons">people</i>
                                <span>Introduction Screen</span> </a>
                        </li>
                        <li id="AppHelp">
                            <a href="<?php echo base_url() . "AppHelp"; ?>"> <i class="material-icons">people</i>
                                <span>App Help Content</span> </a>
                        </li>


                        <li id="faq">
                            <a href="<?php echo base_url() . "faq"; ?>"> <i class="material-icons">people</i>
                                <span>FAQ</span> </a>
                        </li>
                        <li id="admin_users">
                            <a href="<?php echo base_url() . "users"; ?>">
                                <i class="material-icons">people</i> <span>Admin Users</span> </a>
                        </li>
                    </ul>
                </li>
                <li id="app_users">
                    <a href="<?php echo base_url() . "app_users"; ?>"> <i class="material-icons">people</i>
                        <span>Manage App Users</span> </a>
                </li>
                <li id="membership_plan">
                    <a href="javascript:void(0);" class="menu-toggle"> <i class="material-icons">perm_media</i>
                        <span>Membership Plans</span> </a>
                    <ul class="ml-menu">

                        <li id="membership_plan">
                            <a href="<?= base_url('membership_plans/add_membership_plans') ?>">
                                <i class="material-icons">description</i> <span>Add Membership Plans</span> </a>
                        </li>
                        <li id="membership_plan">
                            <a href="<?= base_url('membership_plans/membership_plans_list') ?>">
                                <i class="material-icons">description</i> <span>Membership Plans List</span> </a>
                        </li>

                    </ul>
                </li>
                <!-- <li id="membership_plans">
                    <a href="<?php echo base_url() . "membership_plans"; ?>"> <i class="material-icons">people</i>
                        <span>Membership Plans</span> </a>
                </li> -->

                <li id="test_setup">
                    <a href="javascript:void(0);" class="menu-toggle"> <i class="material-icons">perm_media</i>
                        <span>Test Setup</span> </a>
                    <ul class="ml-menu">
                        <li id="docs">
                            <a href="<?php echo base_url() . "test-setup"; ?>">
                                <i class="material-icons">description</i> <span>Add Test</span> </a>
                        </li>
                        <li id="texts">
                            <a href="<?php echo base_url() . "test-list"; ?>">
                                <i class="material-icons">inventory</i> <span>Test List</span> </a>
                        </li>
                        <li id="gallary">
                            <a href="<?php echo base_url() . "test-gallary"; ?>">
                                <i class="material-icons">image</i> <span>Master Gallary</span> </a>
                        </li>
                    </ul>
                </li>
                <li id="ebook_category">
                    <a href="javascript:void(0);" class="menu-toggle"> <i class="material-icons">perm_media</i>
                        <span>Ebooks</span> </a>
                    <ul class="ml-menu">
                        <li id="docs">
                            <a href="<?php echo base_url() . "ebook_cat/ebooks__cat"; ?>">
                                <i class="material-icons">description</i> <span>Ebook Category</span> </a>
                        </li>
                        <li id="docs">
                            <a href="<?php echo base_url() . "ebook_cat/ebooks__cat_list"; ?>">
                                <i class="material-icons">inventory</i> <span>Ebook Category List</span> </a>
                        </li>
                        <li id="texts">
                            <a href="<?php echo base_url() . "ebook_cat/ebooks_sub_cat"; ?>">
                                <i class="material-icons">description</i> <span>Ebook Sub Category</span> </a>
                        </li>
                        <li id="texts">
                            <a href="<?php echo base_url() . "ebook_cat/ebooks_sub_cat_list"; ?>">
                                <i class="material-icons">inventory</i> <span>Ebook Sub Category List</span> </a>
                        </li>
                        <li id="videos">
                            <a href="<?php echo base_url() . "ebook_cat/ebooks_setup"; ?>">
                                <i class="material-icons">description</i> <span>Ebooks</span> </a>
                        </li>
                        <li id="videos">
                            <a href="<?php echo base_url() . "ebook_cat/ebooks_setup_list"; ?>">
                                <i class="material-icons">inventory</i> <span>Ebooks List</span> </a>
                        </li>
                    </ul>
                </li>
                <li id="courses">
                    <a href="javascript:void(0);" class="menu-toggle"> <i class="material-icons">perm_media</i>
                        <span>Courses</span> </a>
                    <ul class="ml-menu">
                        <li id="manage_courses">
                            <a href="<?= base_url('courses/add_course_data') ?>">
                                <i class="material-icons">description</i> <span>Manage Courses</span> </a>
                        </li>
                        <li id="manage_courses">
                            <a href="<?= base_url('courses/courses_list') ?>">
                                <i class="material-icons">description</i> <span>Manage Courses List</span> </a>
                        </li>
                        <!-- <li id="courses_docs">
                            <a href="<?= base_url('courses/document') ?>">
                                <i class="material-icons">description</i> <span>Docs</span> </a>
                        </li> -->
                        <li id="courses_texts">
                            <a href="<?= base_url('courses/add_texts') ?>">
                                <i class="material-icons">note_alt</i> <span>Texts</span> </a>
                        </li>
                        <li id="courses_texts">
                            <a href="<?= base_url('courses/texts_list') ?>">
                                <i class="material-icons">note_alt</i> <span>Texts List</span> </a>
                        </li>
                        <li id="courses_videos">
                            <a href="<?= base_url('courses/add_course_videos') ?>">
                                <i class="material-icons">description</i> <span>Videos</span> </a>
                        </li>
                        <li id="courses_videos">
                            <a href="<?= base_url('courses/courses_video_list') ?>">
                                <i class="material-icons">description</i> <span>Videos List</span> </a>
                        </li>
                        <li id="courses_quizs">
                            <a href="<?= base_url('courses/tests') ?>">
                                <i class="material-icons">quiz</i> <span>Tests</span> </a>
                        </li>

                        <!-- <li id="courses_test_series">
                            <a href="#">
                                <i class="material-icons">question_mark</i> <span>Test Series</span> </a>
                        </li> -->
                        <li id="courses_pdf">
                            <a href="<?= base_url('courses/add_pdfs'); ?>">
                                <i class="material-icons">picture_as_pdf</i> <span>PDF</span> </a>
                        </li>
                        <li id="courses_pdf">
                            <a href="<?= base_url('courses/pdfs_list'); ?>">
                                <i class="material-icons">picture_as_pdf</i> <span>PDF List</span> </a>
                        </li>
                    </ul>
                </li>
                <li id="test_series_main">
                    <a href="javascript:void(0);" class="menu-toggle"> <i class="material-icons">question_mark</i>
                        <span>Test Series</span> </a>
                    <ul class="ml-menu">
                        <li id="manage_series">
                            <a href="<?= base_url('test_series/add_test_series') ?>">
                                <i class="material-icons">description</i> <span>Manage Test Series</span> </a>
                        </li>
                        <li id="manage_series">
                            <a href="<?= base_url('test_series/test_series_list') ?>">
                                <i class="material-icons">description</i> <span>Manage Test Series List</span> </a>
                        </li>
                        <li id="test_series_quizs">
                            <a href="<?= base_url('test_series/test_series_quizs') ?>">
                                <i class="material-icons">quiz</i> <span>Quiz</span> </a>
                        </li>
                        <li id="test_series_quizs">
                            <a href="<?= base_url('test_series/test_series_quizs_list') ?>">
                                <i class="material-icons">quiz</i> <span>Quiz List</span> </a>
                        </li>
                        <li id="test_series_pdf">
                            <a href="<?= base_url('test_series/test_series_pdf'); ?>">
                                <i class="material-icons">picture_as_pdf</i> <span>PDF</span> </a>
                        </li>
                        <li id="test_series_pdf">
                            <a href="<?= base_url('test_series/test_series_pdf_list'); ?>">
                                <i class="material-icons">picture_as_pdf</i> <span>PDF List</span> </a>
                        </li>
                        <!-- <li id="test_series_videos">
                            <a href="<?= base_url('test_series/videos'); ?>">
                                <i class="material-icons">movie</i> <span>Videos</span> </a>
                        </li> -->
                    </ul>
                </li>
                <li id="ebook_category">
                    <a href="javascript:void(0);" class="menu-toggle"> <i class="material-icons">perm_media</i>
                        <span>Coupon</span> </a>
                    <ul class="ml-menu">
                        <li id="docs">
                            <a href="<?php echo base_url() . "new_coupon/add_coupon"; ?>">
                                <i class="material-icons">description</i> <span>Add Coupon</span> </a>
                        </li>
                        <li id="docs">
                            <a href="<?php echo base_url() . "new_coupon/add_coupon_list"; ?>">
                                <i class="material-icons">description</i> <span>Coupon List</span> </a>
                        </li>
                    </ul>
                </li>
                <li id="docs_and_videos">
                    <a href="javascript:void(0);" class="menu-toggle"> <i class="material-icons">perm_media</i>
                        <span>Docs and Videos</span> </a>
                    <ul class="ml-menu">
                        <li id="docs">
                            <a href="<?php echo base_url() . "doc_videos/add_document"; ?>">
                                <i class="material-icons">description</i> <span>Docs</span> </a>
                        </li>
                        <li id="docs">
                            <a href="<?php echo base_url() . "doc_videos/document_list"; ?>">
                                <i class="material-icons">description</i> <span>Docs List</span> </a>
                        </li>
                        <li id="texts">
                            <a href="<?php echo base_url() . "doc_videos/add_text"; ?>">
                                <i class="material-icons">inventory</i> <span>Texts</span> </a>
                        </li>
                        <li id="texts">
                            <a href="<?php echo base_url() . "doc_videos/text_list"; ?>">
                                <i class="material-icons">inventory</i> <span>Texts List</span> </a>
                        </li>
                        <li id="videos">
                            <a href="<?php echo base_url() . "doc_videos/add_videos"; ?>">
                                <i class="material-icons">movie</i> <span>Videos</span> </a>
                        </li>
                        <li id="videos">
                            <a href="<?php echo base_url() . "doc_videos/videos_list"; ?>">
                                <i class="material-icons">movie</i> <span>Videos List</span> </a>
                        </li>
                        <li id="dv_tests">
                            <a href="<?php echo base_url() . "doc_videos/tests"; ?>">
                                <i class="material-icons">inventory</i> <span>Tests</span> </a>
                        </li>
                    </ul>
                </li>
                <li id="free_mock_test">
                    <a href="<?= base_url() ?>free_test/tests"> <i class="material-icons">question_mark</i>
                        <span>Free Mock Test</span> </a>
                </li>
                <!-- <li id="mpsc_quizes">
                    <a href="#"> <i class="material-icons">quiz</i>
                        <span>MPSC Quizes</span> </a>
                </li> -->
                <li id="exam_material">
                    <a href="javascript:void(0);" class="menu-toggle"> <i class="material-icons">question_mark</i>
                        <span>Exam Material</span> </a>
                    <ul class="ml-menu">
                        <li id="solve_question">
                            <a href="<?php echo base_url() . "exam_material/exam_material_list"; ?>">
                                <i class="material-icons">quiz</i> <span>Exam Material List</span> </a>
                        </li>
                        <!-- <li id="tcs_ibps_exm">
                            <a href="#">
                                <i class="material-icons">picture_as_pdf</i> <span>TCS | IBPS Exams</span> </a>
                        </li>
                        <li id="police_bharti">
                            <a href="#">
                                <i class="material-icons">movie</i> <span>Police Bharti</span> </a>
                        </li>
                        <li id="police_bharti">
                            <a href="#">
                                <i class="material-icons">movie</i> <span>Math Reasoning</span> </a>
                        </li>
                        <li id="police_bharti">
                            <a href="#">
                                <i class="material-icons">movie</i> <span>Grammar Marathi</span> </a>
                        </li>
                        <li id="police_bharti">
                            <a href="#">
                                <i class="material-icons">movie</i> <span>UPSC & SCC</span> </a>
                        </li>
                        <li id="police_bharti">
                            <a href="#">
                                <i class="material-icons">movie</i> <span>State Board / NCERT / YCM</span> </a>
                        </li>
                        <li id="police_bharti">
                            <a href="#">
                                <i class="material-icons">movie</i> <span>Syllabus</span> </a>
                        </li>
                        <li id="police_bharti">
                            <a href="#">
                                <i class="material-icons">movie</i> <span>Previous Paper</span> </a>
                        </li> -->
                    </ul>
                </li>
                <li id="current_affairs">
                    <a href="javascript:void(0);" class="menu-toggle"> <i class="material-icons">question_mark</i>
                        <span>Current Affairs</span> </a>
                    <ul class="ml-menu">
                        <li id="current_affairs">
                            <a href="<?= base_url() ?>current_affairs/manage_current_affairs_form">
                                <i class="material-icons">people</i> <span>Contents</span> </a>
                        </li>
                        <li id="current_affairs">
                            <a href="<?= base_url() ?>current_affairs/manage_current_affairs_form_list">
                                <i class="material-icons">people</i> <span>Contents List</span> </a>
                        </li>
                        <li id="current_affairs">
                            <a href="<?= base_url() ?>current_affairs_quiz">
                                <i class="material-icons">people</i> <span>Tests</span> </a>
                        </li>
                        <li id="current_affairs">
                            <a href="<?= base_url() ?>current_affairs_category">
                                <i class="material-icons">people</i> <span>Category</span> </a>
                        </li>
                    </ul>
                </li>

                <li id="english_vocabulary">
                    <a href="javascript:void(0);" class="menu-toggle"> <i class="material-icons">question_mark</i>
                        <span>English Vocabulary</span> </a>
                    <ul class="ml-menu">
                        <li id="english_vocabulary">
                            <a href="<?= base_url() ?>english_vocabulary/english_vocabulary_form">
                                <i class="material-icons">people</i> <span>Add English Vocabulary</span> </a>
                        </li>
                        <li id="english_vocabulary">
                            <a href="<?= base_url() ?>english_vocabulary/english_vocabulary_form_list">
                                <i class="material-icons">people</i> <span>English Vocabulary List</span> </a>
                        </li>
                        <li id="english_vocabulary">
                            <a href="<?= base_url() ?>english_vocabulary/english_vocabulary_category">
                                <i class="material-icons">people</i> <span>Category</span> </a>
                        </li>
                        <li id="english_vocabulary">
                            <a href="<?= base_url() ?>english_vocabulary/english_vocabulary_category_list">
                                <i class="material-icons">people</i> <span>Category List</span> </a>
                        </li>
                    </ul>
                </li>

                <li id="marathi_sabd">
                    <a href="javascript:void(0);" class="menu-toggle"> <i class="material-icons">question_mark</i>
                        <span>Marathi Sabd Sangrah</span> </a>
                    <ul class="ml-menu">
                        <li id="marathi_sabd">
                            <a href="<?= base_url() ?>marathi_sabd/marathi_sabd_form">
                                <i class="material-icons">people</i> <span>Add Marathi Sabd Sangrah</span> </a>
                        </li>
                        <li id="marathi_sabd">
                            <a href="<?= base_url() ?>marathi_sabd/marathi_sabd_form_list">
                                <i class="material-icons">people</i> <span>Marathi Sabd Sangrah List</span> </a>
                        </li>
                        <li id="marathi_sabd">
                            <a href="<?= base_url() ?>marathi_sabd/marathi_sabd_category">
                                <i class="material-icons">people</i> <span>Category</span> </a>
                        </li>
                        <li id="marathi_sabd">
                            <a href="<?= base_url() ?>marathi_sabd/marathi_sabd_category_list">
                                <i class="material-icons">people</i> <span>Category List</span> </a>
                        </li>
                    </ul>
                </li>

                <!-- <li id="posts">
                    <a href="<?php echo base_url() . "current_affairs"; ?>">
                        <i class="material-icons">people</i> <span>Current Affairs</span> </a>
                </li> -->
                <li id="news">
                    <a href="javascript:void(0);" class="menu-toggle"> <i class="material-icons">question_mark</i>
                        <span>News</span> </a>
                    <ul class="ml-menu">
                        <!-- <li id="news_content">
                            <a href="<?= base_url() ?>current_affairs_category">
                                <i class="material-icons">people</i> <span>News</span> </a>
                        </li> -->
                        <li id="news_content">
                            <a href="<?php echo base_url() . "news/add_news"; ?>">
                                <i class="material-icons">people</i> <span>News</span> </a>
                        </li>
                        <li id="news_content">
                            <a href="<?php echo base_url() . "news/news_list"; ?>">
                                <i class="material-icons">people</i> <span>News List</span> </a>
                        </li>
                        <li id="news_category">
                            <a href="<?= base_url() ?>news/add_news_categorys">
                                <i class="material-icons">people</i> <span>Category</span> </a>
                        </li>
                        <li id="news_category">
                            <a href="<?= base_url() ?>news/news_cat_list">
                                <i class="material-icons">people</i> <span>Category List</span> </a>
                        </li>
                    </ul>
                </li>
                <!-- <li id="current_affairs_quiz">
                    <a href="<?php echo base_url() . "current_affairs_quiz"; ?>">
                        <i class="material-icons">people</i> <span>Current Affairs Quiz</span> </a>
                </li> -->
                <!-- <li id="Pariksha_paddhati_main">
                    <a href="<?php echo base_url() . "Pariksha_paddhati_abhyaskram"; ?>"> <i class="material-icons">people</i>
                        <span>Pariksha Paddhati Abhyaskram</span> </a>
                </li> -->
                <li id="other_option_main">
                    <a href="<?php echo base_url() . "other_option"; ?>"> <i class="material-icons">people</i>
                        <span>Other option</span> </a>
                </li>

                <li id="other_options">
                    <a href="javascript:void(0);" class="menu-toggle"> <i class="material-icons">perm_media</i>
                        <span>Other Options Details</span> </a>
                    <ul class="ml-menu">
                        <li id="manage_other_options">
                            <a href="<?= base_url('other_option_new/add_other_option') ?>">
                                <i class="material-icons">description</i> <span>Manage Other Option</span> </a>
                        </li>
                        <li id="manage_other_options">
                            <a href="<?= base_url('other_option_new/other_option_list') ?>">
                                <i class="material-icons">description</i> <span>Other Option List</span> </a>
                        </li>

                    </ul>
                </li>

                <li id="whatsapp_details">
                    <a href="javascript:void(0);" class="menu-toggle"> <i class="material-icons">perm_media</i>
                        <span>Whatsapp Details</span> </a>
                    <ul class="ml-menu">
                        <!-- <li id="manage_whatsapp_details">
                            <a href="<?= base_url('whatsapp_details/add_whatsapp_details') ?>">
                                <i class="material-icons">description</i> <span>Manage Whatsapp Number</span> </a>
                        </li> -->
                        <li id="manage_whatsapp_details">
                            <a href="<?= base_url('whatsapp_details/whatsapp_details_list') ?>">
                                <i class="material-icons">description</i> <span>Whatsapp Number List</span> </a>
                        </li>

                    </ul>
                </li>
                <li id="other_option_main">
                    <a href="<?php echo base_url() . "add_help_master"; ?>"> <i class="material-icons">people</i>
                        <span>Help Master</span> </a>
                </li>
                <!-- <li id="abhyas_sahitya">
                    <a href="javascript:void(0);" class="menu-toggle"> <i class="material-icons">question_mark</i>
                        <span>Abhyas Sahitya</span> </a>
                    <ul class="ml-menu">
                        <li id="test_series_quizs">
                            <a href="#">
                                <i class="material-icons">quiz</i> <span>Text</span> </a>
                        </li>
                        <li id="test_series_pdf">
                            <a href="<?php echo base_url() . "Abhyas_sahitya"; ?>">
                                <i class="material-icons">picture_as_pdf</i> <span>PDF</span> </a>
                        </li>
                    </ul>
                </li> -->
                <!-- <li id="Masikes">
                    <a href="javascript:void(0);" class="menu-toggle"> <i class="material-icons">contact_mail</i>
                        <span>Masike</span> </a>
                    <ul class="ml-menu">
                        <li id="Masike_category">
                            <a href="<?php echo base_url() . "Masike/category"; ?>">
                                <i class="material-icons">people</i> <span>Masike Category</span> </a>
                        </li>
                        <li id="Masike_masike">
                            <a href="<?php echo base_url() . "Masike"; ?>">
                                <i class="material-icons">people</i> <span>Masike</span> </a>
                        </li>
                    </ul>
                </li> -->
                <li id="doubts">
                    <a href="<?php echo base_url() . "Doubts"; ?>"> <i class="material-icons">contact_mail</i>
                        <span>Doubts</span> </a>
                </li>
                <li id="Yashogatha">
                    <a href="<?php echo base_url() . "Yashogatha"; ?>"> <i class="material-icons">people</i>
                        <span>Yashogatha</span> </a>
                </li>
                <!-- <li id="schedule_cals">
                    <a href="#"> <i class="material-icons">contact_phone</i>
                        <span>Scheduled Calls</span> </a>
                </li> -->
                <li id="Push_notification">
                    <a href="javascript:void(0);" class="menu-toggle"> <i class="material-icons">assignment</i>
                        <span>Push Notification</span> </a>
                    <ul class="ml-menu">
                        <li id="all">
                            <a href="<?php echo base_url() . "Push_notification/all"; ?>">
                                <i class="material-icons">people</i> <span>Sent to all</span> </a>
                        </li>
                        <li id="group">
                            <a href="<?php echo base_url() . "Push_notification/group"; ?>">
                                <i class="material-icons">people</i> <span>Sent to group</span> </a>
                        </li>
                        <li id="single">
                            <a href="<?php echo base_url() . "Push_notification/single"; ?>">
                                <i class="material-icons">people</i> <span>Sent to user</span> </a>
                        </li>
                    </ul>
                </li>
                <li id="feedback">
                    <a href="#"> <i class="material-icons">contact_phone</i>
                        <span>Feedback</span> </a>
                </li>
            </ul>
        </div>
        <!-- #Menu -->
        <!-- Footer -->
        <div class="legal">
            <div class="copyright">
                &copy; <?= date('Y'); ?> <a href="http://codingvisions.com/">Coding Visions Infotetch Pvt. Ltd.</a>.
            </div>
            <div class="version">
                <b>Version: </b> 1.0.6
            </div>
        </div>
        <!-- #Footer -->
    </aside>
    <!-- #END# Left Sidebar -->
</section>
<style type="text/css">
    .modal-body p {
        margin-bottom: 0;
    }
</style>




<div class="modal fade" id="membership_setting" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="editAppSetting" enctype="multipart/form-data" action="<?php echo base_url() ?>Dashboard/editSettingPost" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Membership Page </h4>
                </div>
                <div class="modal-body">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    App Setting
                                    <small>App Footer content setting.</small>
                                </h2>

                            </div>
                            <div class="body">
                                <div class="row clearfix">
                                    <div class="col-md-12">
                                        <b>Footer Content</b>
                                        <div class="input-group">
                                            <div class="form-line">
                                                <input type="text" name="app_footer_info" id="app_footer_info"
                                                    class="form-control text" placeholder="Footer Content" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    Membership Page
                                    <small>Membership page content setting.</small>
                                </h2>

                            </div>
                            <div class="body">
                                <input type="hidden" name="setting_membership_image" id="setting_membership_image" />

                                <div class="row clearfix">
                                    <div class="col-md-12">
                                        <b>Title</b>
                                        <div class="input-group">
                                            <div class="form-line">
                                                <input type="text" name="setting_membership_title" id="setting_membership_title"
                                                    class="form-control text" placeholder="Footer Content" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <b>Key Points</b>
                                        <div class="input-group">
                                            <div class="form-line">
                                                <input type="text" name="setting_membership_subtitle" id="setting_membership_subtitle"
                                                    class="form-control text" placeholder="Key Points Comma Separated" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <b>Banner Image</b>
                                        <div class="input-group">
                                            <div class="form-line">
                                                <input name="setting_membership_image_new" id="setting_membership_image_new" type="file" accept="image/*" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <img class="img-fluid rounded" style="width: 100%;" id="setting_e_img" src="">
                                    </div>

                                    <div class="col-md-12">
                                        <b>Description</b>
                                        <div class="input-group">
                                            <div class="form-line">
                                                <textarea name="setting_membership_description" id="setting_membership_description"
                                                    class="form-control" placeholder="Description" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" name="setting_submit" id="setting_submit" class="btn btn-link waves-effect">SAVE DETAILS
                    </button>
                    <button type="button" class="btn btn-link waves-effect"
                        data-dismiss="modal">CLOSE
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>