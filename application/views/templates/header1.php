<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Welcome To | Spardha Vahini</title>
    <!-- Favicon-->
    <link rel="icon" href="<?php echo base_url() . "assets/"; ?>favicon.ico" type="image/x-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <!-- Bootstrap Core Css -->
    <link href="<?php echo base_url() . "assets/"; ?>plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- Waves Effect Css -->
    <link href="<?php echo base_url() . "assets/"; ?>plugins/node-waves/waves.css" rel="stylesheet"/>
    <!-- Animation Css -->
    <link href="<?php echo base_url() . "assets/"; ?>plugins/animate-css/animate.css" rel="stylesheet"/>
    <!-- Multi Select Css -->
    <link href="<?php echo base_url() . "assets/"; ?>plugins/multi-select/css/multi-select.css" rel="stylesheet">
    <!-- Sweetalert Css -->
    <link href="<?php echo base_url() . "assets/"; ?>plugins/sweetalert/sweetalert.css" rel="stylesheet"/>
    <!-- JQuery DataTable Css -->
    <link href="<?php echo base_url() . "assets/"; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    <!-- Dropzone Css -->
    <link href="<?php echo base_url() . "assets/"; ?>plugins/dropzone/dropzone.css" rel="stylesheet">
    <!-- Bootstrap Select Css -->
    <link href="<?php echo base_url() . "assets/"; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet"/>
    <!-- Custom Css -->
    <link href="<?php echo base_url() . "assets/"; ?>css/style.css" rel="stylesheet">
    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?php echo base_url() . "assets/"; ?>css/themes/all-themes.css" rel="stylesheet"/>
</head>
<body class="theme-red">
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="preloader">
            <div class="spinner-layer pl-red">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
        <p>Please wait...</p>
    </div>
</div>
<!-- #END# Page Loader -->
<!-- Overlay For Sidebars -->
<div class="overlay"></div>
<!-- #END# Overlay For Sidebars -->
<!-- Search Bar -->
<div class="search-bar">
    <div class="search-icon">
        <i class="material-icons">search</i>
    </div>
    <input type="text" placeholder="START TYPING...">
    <div class="close-search">
        <i class="material-icons">close</i>
    </div>
</div>
<!-- #END# Search Bar -->
<!-- Top Bar -->
<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href="<?php echo base_url(); ?>">MahaTest Admin</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <!-- Call Search -->
                <li>
                    <a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a>
                </li>
                <!-- #END# Call Search -->
            </ul>
        </div>
    </div>
</nav>
<!-- #Top Bar -->
<div id="error_message"></div>
<div id="success_message"></div>
