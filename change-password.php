<?php
session_start();
include('includes/header.php');


if (isset($_POST['submit'])) {
    $adminid = $_SESSION['sturecmsaid'];
    $cpassword = md5($_POST['currentpassword']);
    $newpassword = md5($_POST['newpassword']);
    $sql = "SELECT ID FROM user WHERE id=:adminid and password=:cpassword";
    $query = $dbh->prepare($sql);
    $query->bindParam(':adminid', $adminid, PDO::PARAM_STR);
    $query->bindParam(':cpassword', $cpassword, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if ($query->rowCount() > 0) {
        $con = "update user set password=:newpassword where id=:adminid";
        $chngpwd1 = $dbh->prepare($con);
        $chngpwd1->bindParam(':adminid', $adminid, PDO::PARAM_STR);
        $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
        $chngpwd1->execute();

        echo '<script>alert("Your password successully changed")</script>';
    } else {
        echo '<script>alert("Your current password is wrong")</script>';

    }
}
?>
<!-- sm-nav -->
<div class="table-responsive">
    <table class="table text-center" id="dataTable" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th style="color: #7436B4;"> <?= __('Change Password')?></th>
        </tr>
        </thead>
    </table>
</div>
<div class="change-password">
    <form name="changepassword" method="post" onsubmit="return checkpass();">
        <div class="row justify-content-center">
            <div class="col-12">
                <label for="OldPassword" class="form-label"> <?= __('Old Password')?></label>
                <input type="password" class="form-control mb-4" id="OldPassword" name="currentpassword" required>
            </div>
            <div class="col-lg-6 col-12">
                <label for="NewPassword" class="form-label"> <?= __('New Password')?></label>
                <input type="password" class="form-control mb-4" id="NewPassword" name="newpassword" required>
            </div>
            <div class="col-lg-6 col-12">
                <label for="Retypepassword" class="form-label"> <?= __('Confirm password')?></label>
                <input type="password" class="form-control mb-4" id="Retypepassword" name="confirmpassword" required>
            </div>
            <div class="col-md-5 col-7">
                <button class="btn reminder-btn w-100" type="submit" name="submit"> <?= __('Save')?></button>
            </div>
            <div class="col-12">
                <a href="forgot-password.php"> <?= __('Forgot Password?')?></a>
            </div>
        </div>
    </form>

</div>

</div>
<!-- /.container-fluid-->
<!-- /.content-wrapper-->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fa fa-angle-up"></i>
</a>
<!-- Logout Modal-->

</div>
<script>
    function checkpass() {
        if (document.changepassword.newpassword.value != document.changepassword.confirmpassword.value) {
            alert('New Password and Confirm Password field does not match');
            document.changepassword.confirmpassword.focus();
            return false;
        }
        return true;
    }
</script>
<?php include_once('includes/footer.php'); ?>
</body>
</html>
