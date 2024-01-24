<?php
session_start();
include('includes/header.php');

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $Description = $_POST['Description'];
    $odo = $_POST['odo'];
    $date = $_POST['date'];
    $active = 0;
    $car = $_POST['car_id'];
    $user_id = $_POST['user_id'];
    $sql = "insert into reminders(name,odo,date,Description,user_id,car_id,active)values(:name,:odo,:date,:Description,:user_id,:car,:active)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':date', $date, PDO::PARAM_STR);
    $query->bindParam(':odo', $odo, PDO::PARAM_STR);
    $query->bindParam(':car', $car, PDO::PARAM_STR);
    $query->bindParam(':Description', $Description, PDO::PARAM_STR);

    $query->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $query->bindParam(':active', $active);
    $query->execute();
    $LastInsertId = $dbh->lastInsertId();
    if ($LastInsertId > 0) {


        echo "<script>window.location.href ='dashboard.php'</script>";
    } else {
        echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }
}
$id = $_SESSION['sturecmsaid'];
$sql2 = "SELECT * from  cars where cars.user_id=:id";
$query2 = $dbh->prepare($sql2);
$query2->bindParam(':id', $id, PDO::PARAM_STR);
$query2->execute();
$result2 = $query2->fetchAll(PDO::FETCH_OBJ);
?>
<div class="table-responsive">
    <table class="table text-center" id="dataTable" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th style="color: #7436B4;"><?= __('Add Reminder')?></th>
        </tr>
        </thead>
    </table>
</div>
<div class="add-reminder">
    <form method="post">
        <div class="row justify-content-center">
             <div class="col-lg-6 col-12">
                <label for="CarName" class="form-label"><?= __('name of reminder')?></label>
                <input type="text" class="form-control mb-4" id="CarName" name="name" required placeholder="<?= __('Engine Oil, Battery, Brakes') ?>">
            </div>
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['sturecmsaid'] ?>">
            <div class="col-lg-6 col-12">
                <label for="DescriptionReminder" class="form-label"><?= __('Description of reminder')?></label>
                <input type="text" class="form-control mb-4" id="DescriptionReminder" name="Description" required placeholder="<?= __('Change Oil, Check Battery, Replace Brakes') ?>">
            </div>
            <div class="col-lg-6 col-12">
                <label for="odo" class="form-label"><?= __('ODO Read')?></label>
                <input type="text" class="form-control mb-4" id="odo" name="odo" required placeholder="<?= __('30,000 Km, 50,000 Mi') ?>">
            </div>
            <div class="col-lg-6 col-12">
                <label for="DateReminder" class="form-label"><?= __('Date of reminder')?></label>
                <input type="date" class="form-control mb-4" id="DateReminder" name="date" required>
            </div>

            <div class="col-lg-6 col-12">
                <label for="TimeReminder" class="form-label"><?= __('Select Car')?></label>
                <select name="car_id" id="" class="form-select mt-1" required>
                    <option value=""><?= __('Select Car') ?></option>
                    <?php
                    foreach ($result2 as $row1) {
                        ?>
                        <option value="<?php echo htmlentities($row1->id); ?>"><?php echo htmlentities($row1->name); ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-lg-6 col-12 mt-4">
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
