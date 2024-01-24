<?php
session_start();
if (!isset($_SESSION['sturecmsaid']) || strlen($_SESSION['sturecmsaid'] == 0)) {
    header('location:logout.php');
}
include('includes/header.php');

$sql2 = "SELECT * from cities ";
$query2 = $dbh->prepare($sql2);
$query2->execute();
$result2 = $query2->fetchAll(PDO::FETCH_OBJ);

$id = $_SESSION['sturecmsaid'];

$profile = "SELECT * from user where  user.id=:id";
$query = $dbh->prepare($profile);
$query->bindParam(':id', $id, PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);


if (isset($_POST['submit'])) {
    $adminid = $_SESSION['sturecmsaid'];
    $AName = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $city = $_POST['city_id'];
    $sql = "update user set name=:name,phone=:phone,email=:email,city_id=:city where id=:aid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':name', $AName, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':phone', $phone, PDO::PARAM_STR);
    $query->bindParam(':aid', $adminid, PDO::PARAM_STR);
    $query->bindParam(':city', $city, PDO::PARAM_STR);
    $query->execute();
    echo '<script>alert("Your profile has been updated")</script>';
    echo "<script>window.location.href ='profile.php'</script>";
}
?>


<div class="table-responsive">
    <table class="table text-center " id="dataTable" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th style="color: #7436B4;"><?= __('Profile') ?></th>
        </tr>
        </thead>
    </table>
</div>
<div class="add-reminder">
    <form method="post">
        <div class="row justify-content-center">
            <?php if ($query->rowCount() > 0) {
                foreach ($results as $row) { ?>
                    <div class="col-lg-6 col-12">
                        <label for="Name" class="form-label"><?= __('Name') ?></label>
                        <input type="text" class="form-control mb-4" id="Name"
                               value="<?php echo htmlentities($row->name); ?>" name="name" required>
                    </div>
                    <div class="col-lg-6 col-12">
                        <label for="E-mail" class="form-label"><?= __('E-mail') ?></label>
                        <input type="email" class="form-control mb-4" id="E-mail"
                               value="<?php echo htmlentities($row->email); ?>" name="email" required>
                    </div>
                    <div class="col-lg-6 col-12">
                        <label for="DateReminder" class="form-label"><?= __('Phone') ?></label>
                        <input type="text" class="form-control mb-4" id="DateReminder"
                               value="<?php echo htmlentities($row->phone); ?>" name="phone">
                    </div>
                    <div class="col-lg-6 col-12">
                        <label for="Phone" class="form-label"><?= __('city') ?></label>
                        <select name="city_id" class="form-select form-control mb-4" required>
                            <option value=""><?= __('Select City') ?></option>
                            <?php
                            foreach ($result2 as $row1) {
                                $cityName = __($row1->name);
                                ?>
                                <option value="<?php echo htmlentities($row1->id); ?>" <?php if ($row->city_id == htmlentities($row1->id)) { ?> selected <?php } ?> ><?php echo htmlentities($cityName); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                <?php }
            } ?>
            <div class="col-md-5 col-7">
                <button class="btn reminder-btn w-100" type="submit" name="submit"><?= __('Save') ?></button>
            </div>
        </div>
    </form>

</div>

</div>
<?php include_once('includes/footer.php'); ?>


</body>
</html>
