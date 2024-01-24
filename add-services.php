<?php
session_start();
include('includes/header.php');


$sql2 = "SELECT * from cities ";
$query2 = $dbh->prepare($sql2);
$query2->execute();
$result2 = $query2->fetchAll(PDO::FETCH_OBJ);

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $city = $_POST['city_id'];
    $address = $_POST['address'];
    $servicelink = $_POST['servicelink'];
    $phone = $_POST['phone'];
    $sql = "insert into services(name,city_id,address,servicelink,phone)values(:name,:city,:address,:servicelink,:phone)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':city', $city, PDO::PARAM_STR);
    $query->bindParam(':address', $address, PDO::PARAM_STR);
    $query->bindParam(':servicelink', $servicelink, PDO::PARAM_STR);
    $query->bindParam(':phone', $phone, PDO::PARAM_STR);

    $query->execute();
    $LastInsertId = $dbh->lastInsertId();
    if ($LastInsertId > 0) {

        echo "<script>window.location.href ='near-services.php'</script>";
    } else {
        echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }
}
?>
<div class="table-responsive">
    <table class="table text-center" id="dataTable" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th style="color: #7436B4;"><?= __('Add Service')?></th>
        </tr>
        </thead>
    </table>
</div>
<div class="add-reminder">
    <form method="post">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-12">
                <label for="CarName" class="form-label"><?= __('name of service')?></label>
                <input type="text" class="form-control mb-4" id="CarName" name="name" required>
            </div>

            <div class="col-lg-6 col-12">
                <label for="DateReminder" class="form-label"><?= __('address')?></label>
                <input type="text" class="form-control mb-4" id="DateReminder" name="address" required>
            </div>
            <div class="col-lg-6 col-12">
                <label for="ServiceReminder" class="form-label"><?= __('Service Link')?></label>
                <input type="text" class="form-control mb-4" id="ServiceReminder" name="servicelink" required>
            </div>
            <div class="col-lg-6 col-12">
                <label for="TimeReminder" class="form-label"><?= __('phone')?></label>
                <input type="text" class="form-control mb-4" id="TimeReminder" name="phone" required>
            </div>
            <div class="col-lg-6 col-12">
                <label for="CarName" class="form-label"><?= __('Select City')?></label>

                <select name="city_id" id="" class="form-select">
                    <option value="near-services.php"><?= __('Select City')?></option>
                    <?php
                    foreach ($result2 as $row1) {
                        ?>
                        <option value="<?php echo htmlentities($row1->id); ?>"
                        ><?= __( $row1->name, 'ar') ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-md-5 col-7">
                <button class="btn reminder-btn w-100" name="submit" type="submit"> <?= __('Add')?></button>
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
 <?php include_once('includes/footer.php'); ?>
</body>
</html>
