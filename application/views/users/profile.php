<?php
/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */
?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD -> USER PROFILE</h2>
        </div>

        <div class="row clearfix">
            <form method="post" enctype="multipart/form-data" action="<?php echo base_url().'users/add_edit' ?>" class="form-label-left">

                <!-- Profile Picture -->
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <div class="card">
                        <div class="header">
                            <h2>Profile Picture </h2>
                        </div>
                        <div class="body align-center">
                            <center>
                                <div class="pic_size" id="image-holder">
                                    <?php

                                    if (file_exists('assets/images/' . $user_data[0]->profile_pic) && isset($user_data[0]->profile_pic) && $user_data[0]->profile_pic !== '') {
                                        $profile_pic = $user_data[0]->profile_pic ;
                                    } else {
                                        $profile_pic = 'user.png';
                                    } ?>
                                    <center><img class="thumb-image setpropileam"
                                                 src="<?php echo base_url(); ?>assets/images/<?php echo $profile_pic; ?>"
                                                 alt="User profile picture"></center>
                                </div>
                            </center>
                            <br>
                            <div class="fileUpload btn btn-primary btn-lg m-t-15 waves-effect">
                                <span>Change Picture</span>
                                <input id="fileUpload" class="upload dz-clickable" name="profile_pic"
                                       type="file" accept="image/*"/><br/>
                                <input type="hidden" name="fileOld"
                                       value="<?php echo isset($user_data[0]->profile_pic) ? $user_data[0]->profile_pic : ''; ?>"/>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- #END# Profile Picture -->

                <!-- Profile Info -->
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <div class="card">
                        <div class="header">
                            <h2 >
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">My Account</div>
                             </h2>
                        </div>
                        <div class="body">
                            <h5 class="m-b-20">Personal Information</h5>
                            <div class="col-xs-6 col-sm-12 col-md-6 col-lg-6">
                                <p><b>Status : </b><?php echo $user_data[0]->status; ?> </p>
                            </div>
                            <div class="col-xs-6 col-sm-12 col-md-6 col-lg-6">
                                <p><b>User Role : </b><?php echo $user_data[0]->type; ?> </p>
                            </div>
                            <h5 class="m-b-20">&nbsp;</h5>

                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" id="name" name="name"
                                           value="<?php echo(isset($user_data[0]->name) ? $user_data[0]->name : ''); ?>"
                                           required class="form-control">
                                    <label for="name" class="form-label">Name:</label>
                                </div>
                            </div>

                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" id="mobile" name="mobile"
                                           value="<?php echo(isset($user_data[0]->mobile) ? $user_data[0]->mobile : ''); ?>"
                                           required class="form-control">
                                    <label for="exampleInputname" class="form-label">Mobile No:</label>
                                </div>
                            </div>

                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" id="email" name="email"
                                           value="<?php echo(isset($user_data[0]->email) ? $user_data[0]->email : ''); ?>"
                                           required class="form-control" disabled>
                                    <label for="exampleInputemail" class="form-label">Email
                                        :</label>
                                </div>
                            </div>

                            <h5 class="m-b-30">Change Password</h5>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="password" class="form-control" name="currentpassword" id="pass11">
                                    <label class="form-label">Current Password</label>
                                </div>
                            </div>

                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="password" class="form-control validate-equalTo-blur" name="password"
                                           id="password">
                                    <label class="form-label">New Password</label>
                                </div>
                            </div>

                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="password" class="form-control" id="confirm_password"
                                           name="confirmPassword" onkeyup="return Validate()">
                                    <label class="form-label">Confirm Password</label>
                                    <span id="divCheckPasswordMatch"></span>
                                </div>
                            </div>

                            <br>

                            <div class="form-group form-float form-group-lg sub-btn-wdt">
                                <input type="hidden" name="users_id"
                                       value="<?php echo isset($user_data[0]->id) ? $user_data[0]->id : ''; ?>">
                                <input type="hidden" name="users_type"
                                       value="<?php echo isset($user_data[0]->type) ? $user_data[0]->type : ''; ?>">
                                <button class="btn btn-primary btn-lg m-t-15 waves-effect" id="saveformbutton"
                                        type="submit">Save</button>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- #END# Profile Info -->
            </form>
        </div>
    </div>
</section>
