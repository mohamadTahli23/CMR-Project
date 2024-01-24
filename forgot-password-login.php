<?php

require 'lang.php';

include('includes/dbconnection.php');

$value = 0;


if (isset($_POST['emailform'])) {
    $email = $_POST['email'];

    $profile = "SELECT * FROM user WHERE email=:email";
    $query = $dbh->prepare($profile);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    $expFormat = mktime(
        date("H"), date("i"), date("s"), date("m"), date("d") + 1, date("Y")
    );
    $random = rand(100000, 999999);
    $expDate = date("Y-m-d H:i:s", $expFormat);

    if ($query->rowCount() > 0) {
      
       $user = $results[0];
        $name = $user->name;
        $con = "UPDATE user SET reset_link_token=:token, exp_date=:exp WHERE email=:email";
        $chngpwd1 = $dbh->prepare($con);
        $chngpwd1->bindParam(':token', $random);
        $chngpwd1->bindParam(':email', $email);
        $chngpwd1->bindParam(':exp', $expDate);
        $chngpwd1->execute();

        if ($chngpwd1->rowCount() > 0) {
            $subject = 'Reset password';
            $message = 'Dear ' . $name . ' Your code to reset password: ' . $random;
            $headers = 'From: support@cmr-ksa.com';
            mail($email, $subject, $message, $headers);
        }
    }
}

if (isset($_POST['codeform'])) {
    $code = implode($_POST['code']);
    $profile = "SELECT * FROM user WHERE reset_link_token=:code";
    $query = $dbh->prepare($profile);
    $query->bindParam(':code', $code, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if ($query->rowCount() > 0) {
        $value = 1;
    } else {
        echo '<script>alert("Your code is wrong")</script>';
    }
}

if (isset($_POST['passwordform'])) {
    $email = $_POST['email'];
    $password = md5($_POST['newpassword']);

    $profile = "UPDATE user SET password=:pass WHERE email=:email";

    $query = $dbh->prepare($profile);
    $query->bindParam(':pass', $password, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount() > 0) {
        echo '<script>alert("Your password has been updated")</script>';

        echo "<script type='text/javascript'> document.location ='index.php'; </script>";

    } else {

        echo '<script>alert("Your password has NOT been updated !!")</script>';
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




<!-- sm-nav -->
<div class="table-responsive text-center">
    <table class="table " id="dataTable" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th>  <?= __('Reset Password')?></th>
        </tr>
        </thead>
    </table>
</div>
<div class="change-password">
    <div id="msform1">
        <form method="post"
              id="emailform" <?php if (isset($_POST['emailform']) || isset($_POST['codeform'])) { ?> hidden <?php } ?> >
            <div class="row mt-5 pt-5 text-center justify-content-center">
                <div class="col-lg-6 col-12">
                    <label for="" class="form-label"> <?= __('E-mail')?></label>
                    <input type="text" class="form-control mb-4" name="email">
                </div>
                <div class="col-12"></div>
            </div>
            <button type="submit" class=" action-button btn reminder-btn" name="emailform" >
                <?= __('Send')?>
            </button>
        </form>
        <form id="codeform"
              method="post" <?php if (isset($_POST['emailform']) || isset($_POST['codeform']) && $value == 0) { }else{  ?> hidden
        <?php } ?> >
            <div class="mt-5 pt-5 mb-3 text-center">
                <label class="d-block"> <?= __('Verification Code')?></label>
                <div class='number-code'>
                    <input name='code[]' class='code-input' required/>
                    <input name='code[]' class='code-input' required/>
                    <input name='code[]' class='code-input' required/>
                    <input name='code[]' class='code-input' required/>
                    <input name='code[]' class='code-input' required/>
                    <input name='code[]' class='code-input' required/>
                </div>
                <input type="hidden" name="email" value="<?php echo $_POST['email'] ?? ''; ?>">
            </div>
            <button type="submit" class=" action-button btn reminder-btn" name="codeform">
                <?= __('Send')?>
            </button>
        </form>
        <form id="passwordform"
              method="post" <?php if (!isset($_POST['codeform']) || $value == 0) { ?> hidden <?php } ?>>
            <div class="row mt-5 pt-5 text-center justify-content-center">
                <div class="col-lg-6 col-12">
                    <label for="" class="form-label"><?= __('Add New Password') ?></label>
                    <input type="password" class="form-control mb-4" id="" name="newpassword">
                    <input type="hidden" name="email" value="<?php echo isset($_POST['codeform']) ? ($_POST['email'] ?? '') : ''; ?>">
                </div>
                <div class="col-12"></div>
            </div>
            <button type="submit" class="submit action-button btn reminder-btn" name="passwordform" >
                <?= __('Save')?>
            </button>
        </form>
    </div>

</div>

</div>
<!-- /.container-fluid-->
<!-- /.content-wrapper-->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fa fa-angle-up"></i>
</a>
</div>

</body>
</html>
