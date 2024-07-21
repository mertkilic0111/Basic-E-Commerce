<?php
@ob_start();
@session_start();
require_once(__DIR__ . '/../set/func.php');

//usercontrol(); 
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Basic E-commerce</title>
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
    <link rel="stylesheet" href="../assets/vendors/core/core.css">
    <link rel="stylesheet" href="../assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="../assets/fonts/feather-font/css/iconfont.css">
    <link rel="stylesheet" href="../assets/css/demo_1/style.css">
    <link rel="stylesheet" href="../assets/css/custom.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/brands.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .color-red {
            color: red !important;
            font-size: 10px !important
        }

        .f-bold {
            font-weight: bold !important;
        }

        .js-example-basic-single {
            width: 100% !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            min-height: 20px;
            line-height: 20px;
            background-color: #5897fb;
            border: 1px solid #5897fb;
        }

        .sidebar .sidebar-body .nav.sub-menu .nav-item .nav-link::before {
            display: none !important;
        }

        .sidebar .sidebar-body .nav.sub-menu {
            padding: 0 0 10px 15px !important;
        }

        .table td img {
            border-radius: 0px !important;
        }
    </style>
</head>

<body class="sidebar-dark">
    <div id="loading">
        <div class="text-center">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>

    <div class="main-wrapper">
        <?php include_once('sidebar.php'); ?>
        <div class="page-wrapper">
            <nav class="navbar">
                <a href="#" class="sidebar-toggler">
                    <i data-feather="menu"></i>
                </a>
                <div class="navbar-content">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown nav-profile">
                            <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="../assets/img/logo.png" style="width: auto !important;border-radius:0px;" alt="">
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>