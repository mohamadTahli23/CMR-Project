<?php
session_start();
include('includes/header.php');


$value = 0;
if (isset($_POST['emailform'])) {
    $email = $_POST['email'];
    $profile = "SELECT * from user where  user.email=:email";
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
        $con = "update user set reset_link_token=:token,exp_date=:exp where email=:email";
        $chngpwd1 = $dbh->prepare($con);
        $chngpwd1->bindParam(':token', $random);
        $chngpwd1->bindParam(':email', $email);
        $chngpwd1->bindParam(':exp', $expDate);
        $chngpwd1->execute();
        $results = $chngpwd1->fetchAll(PDO::FETCH_OBJ);
        if ($chngpwd1->rowCount() > 0) {
            $subject = 'Reset password';
            $message = 'Your code to reset password: ' . $random;
            $headers = 'From: support@cmr-ksa.com';
            mail($email, $subject, $message, $headers);
        }
    }
}
if (isset($_POST['codeform'])) {
    $code = implode($_POST['code']);
    $profile = "SELECT * from user where  user.reset_link_token=:code";
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
    $id = $_SESSION['sturecmsaid'];
    $password = md5($_POST['newpassword']);
    $con = "update user set password=:pass where id=:id";
    $query = $dbh->prepare($con);
    $query->bindParam(':id', $id, PDO::PARAM_STR);
    $query->bindParam(':pass', $password, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount() > 0) {
        echo '<script>alert("Your password has been updated")</script>';
        echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";

    }
}
 ?>
<!-- sm-nav -->
<div class="table-responsive">
    <table class="table " id="dataTable" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th>  <?= __('Change Password')?></th>
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
            <button type="submit" class=" action-button btn reminder-btn" name="emailform">
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
            </div>
            <button type="submit" class=" action-button btn reminder-btn" name="codeform">
                 <?= __('Send')?>
            </button>
        </form>
        <form id="passwordform"
              method="post" <?php if (!isset($_POST['codeform']) || $value == 0) { ?> hidden <?php } ?>>
            <div class="row mt-5 pt-5 text-center justify-content-center">
                <div class="col-lg-6 col-12">
                    <label for="" class="form-label"> <?= __('Add New Password')?></label>
                    <input type="password" class="form-control mb-4" id="" name="newpassword">
                </div>
                <div class="col-12"></div>
            </div>
            <button type="submit" class="submit action-button btn reminder-btn" name="passwordform">
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
<?php include_once('includes/footer.php'); ?>
</body>
</html>
