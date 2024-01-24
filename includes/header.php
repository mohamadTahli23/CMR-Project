<!DOCTYPE html>
<html lang="en">
<?php


require 'lang.php';

include('includes/dbconnection.php');
$aid = $_SESSION['name'];



?>
<head>
    <meta charset="UTF-8">
    <title>Car Reminder</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./style.css">
</head>
<!-- partial:index.partial.html -->
<body class="fixed-nav sticky-footer" id="page-top">
<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="dashboard.php">
        <img src="images/logo.png" alt="" width="200px">
    </a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
            data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">

        <?php include_once('includes/sidebar.php');?>

    </div>
</nav>
<div class="content-wrapper">
    <div class="container-fluid">
        <ul class="sm-topNav topNav navbar-nav align-items-center justify-content-between w-100 mb-3">
            <li class="nav-item dropdown">
                <a class="nav-link d-flex align-items-center">
                    <div class="person">
                        <i class="fa-solid fa-user"></i>
                    </div>

                    <span><?php echo $aid ?></span>
                    <ul class="navbar-nav">

                        <li class="nav-item dropdown">
                            <a class="nav-link  mr-lg-2" id="alertsDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-globe"></i>
                                <span class="d-lg-none">
                <span class="badge badge-pill badge-warning"></span>
              </span>
                                <span class="indicator text-warning d-none d-lg-block">

              </span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="alertsDropdown">
                                <a class="dropdown-item" href="<?php echo $_SERVER['PHP_SELF']; ?>?lang=en">
                                    <strong><?= __('English', 'en') ?></strong>

                                </a>
                                <a class="dropdown-item" href="<?php echo $_SERVER['PHP_SELF']; ?>?lang=ar">
                                    <strong><?= __('عربي', 'ar') ?></strong>

                                </a>

                            </div>
                        </li>
                    </ul>
                </a>
            </li>

        </ul>
