<?php
session_start();

if(isset($_GET['lang']) && $_GET['lang'] === 'ar') {
    $_SESSION['lang'] = 'ar';
} else {
    $_SESSION['lang'] = 'en';
}

require 'lang.php';

include('includes/dbconnection.php');

ini_set('display_errors', 'On');

function checker_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
 if (isset($_POST['login'])) {
    $phone = $_POST['phone'];
    $password = md5(checker_input($_POST["password"]));
    $sql = "SELECT id ,name FROM user WHERE phone=:phone and password=:password";

    $query = $dbh->prepare($sql);
    $query->bindParam(':phone', $phone, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount() > 0) {
        foreach ($results as $result) {
            $_SESSION['sturecmsaid'] = $result->id;
            $_SESSION['name'] = $result->name;
        }
        if (!empty($_POST["remember"])) {
            //COOKIES for name
            setcookie("user_login", $_POST["phone"], time() + (10 * 365 * 24 * 60 * 60));
            //COOKIES for password
            setcookie("userpassword", $_POST["password"], time() + (10 * 365 * 24 * 60 * 60));
        } else {
            if (isset($_COOKIE["user_login"])) {
                setcookie("user_login", "");
                if (isset($_COOKIE["userpassword"])) {
                    setcookie("userpassword", "");
                }
            }
        }
        echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";

    } else {
        echo "<script>alert('Invalid Details');</script>";
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CMR</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css'>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
          integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>



<body id="login">
<section class="login">
    <div class="text-center pt-5">
        <img src="images/logo.png" alt="" width="400">
    </div>

    <div class="login-wrapper">

        <div class="container-fluid">

                        <ul class="navbar-nav">

                            <li class="nav-item dropdown">
                                <a class="nav-link  mr-lg-2" id="alertsDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-globe"></i>

                                </a>
                                <div class="dropdown-menu" aria-labelledby="alertsDropdown">
                                    <a class="dropdown-item" href="index.php?lang=en">
                                        <strong>English</strong>

                                    </a>
                                    <a class="dropdown-item" href="index.php?lang=ar">
                                        <strong>عربي</strong>

                                    </a>

                                </div>
                            </li>
                        </ul>



            <div class="row justify-content-between align-items-center">

                <div class="col-lg-5 col-12">

                    <div class="login-form">
                        <h5>  <?= __('Welcome  !')?></h5>
                        <h4 class="mt-3 mb-4"> <?= __('Login')?></h4>
                        <form method="post">
                            <label for="Phone" class="form-label"> <?= __('phone')?></label>
                            <input type="tel" class="form-control" id="Phone" name="phone" required
                                   value="<?php if (isset($_COOKIE["user_login"])) {
                                       echo $_COOKIE["user_login"];
                                   } ?>">
                            <label for="Password" class="form-label"> <?= __('Password')?></label>
                            <input type="password" class="form-control" id="Password" name="password" required
                                   value="<?php if (isset($_COOKIE["userpassword"])) {
                                       echo $_COOKIE["userpassword"];
                                   } ?>">
                            <button class="btn btn-block col-md-12" name="login" type="submit" value="Login"><?= __('Login')?>
                            </button>
                        </form>
                        <p><?= __('Don’t have an account?')?><a href="register.php"><?= __('REGISTER')?></a></p>
                    </div>
                  <div class="col-12">
                        <a href="forgot-password-login.php"> <?= __('Forgot Password?')?></a>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <img class="w-100" src="images/car-main-page.svg" alt="">
                </div>
            </div>
        </div>

    </div>

</section>

</body>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.5/umd/popper.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N"
        crossorigin="anonymous"></script>
<script src="./script.js"></script>
</html>