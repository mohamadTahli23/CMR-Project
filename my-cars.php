<?php
session_start();
if (!isset($_SESSION['sturecmsaid']) || strlen($_SESSION['sturecmsaid'] == 0)) {
    header('location:logout.php');
}
include('includes/header.php');

$id = $_SESSION['sturecmsaid'];

$sql = "SELECT admin FROM user WHERE id = ?";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(1, $id);
$stmt->execute();
$isAdmin = $stmt->fetch(PDO::FETCH_COLUMN);
if ($isAdmin == 1)  {
    // Admin user
    $isAdmin = true;
} else {
    // Regular user
    $isAdmin = false;
}

if (isset($_POST['delete'])) {
    $delete_id = $_POST['delete_id'];
    $sql = "DELETE FROM cars WHERE id=:delete_id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':delete_id', $delete_id, PDO::PARAM_INT);
    $query->execute();
    echo '<script>window.location.href = window.location.href;</script>';

}
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $user_id = $_POST['user_id'];
    $sql = "insert into cars(name,model,year,user_id)values(:name,:model,:year,:user_id)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':model', $model, PDO::PARAM_STR);
    $query->bindParam(':year', $year, PDO::PARAM_STR);
    $query->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $query->execute();
    $LastInsertId = $dbh->lastInsertId();
    if ($LastInsertId > 0) {
        echo '<script>window.location.href = window.location.href;</script>';
    } else {
        echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }
}
?>
<!-- Example DataTables Card-->
<div class="table-responsive ">
    <table class="table text-center" id="dataTable" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th style="color: #7436B4;"><?= __('My Cars') ?></th>
        </tr>
        </thead>
    </table>
</div>
<div class="my-cars text-center">
    <?php

   
        $sql = "SELECT * FROM cars WHERE cars.user_id = :id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
    
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    $cnt = 1;
    if ($query->rowCount() > 0) {
        ?>
        <table class="table table-bordered" id="dataTable">
            <thead>
            <tr>
                <th>#</th>

                <th><?= __('Car Name') ?></th>
                <th><?= __('Car model') ?></th>
                <th><?= __('Car Make Year') ?></th>
                <th><?= __('Action')?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($results as $row) {
                $sql2 = "SELECT * FROM user WHERE user.id = :id";
                $query2 = $dbh->prepare($sql2);
                $query2->bindParam(':id', $row->user_id, PDO::PARAM_STR);
                $query2->execute();
                $results4 = $query2->fetchAll(PDO::FETCH_OBJ);
                ?>
                <tr>
                    <td><?php echo $cnt++; ?></td>

                    <td><?php echo htmlentities($row->name); ?></td>
                    <td><?php echo htmlentities($row->model); ?></td>
                    <td><?php echo htmlentities($row->year); ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="delete_id" value="<?php echo $row->id ?>">
                            <button class="btn btn-danger" type="submit" name="delete"><?php echo __('Delete'); ?></button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    <?php } else {
        // No records found
    } ?>

    <div class="row justify-content-center">
        <div class="col-md-5 col-7">
            <button class="btn reminder-btn w-100 cen" type="button" data-bs-toggle="collapse" data-bs-target="#addCar"
                    aria-expanded="false" aria-controls="collapseExample"><?= __('Add new car') ?></button>
        </div>
    </div>
    <div class="collapse " id="addCar">
        <div class="py-3">
            <form action="" method="post">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-12">
                        <label for="carName" class="form-label"><?= __('Enter Car Name') ?></label>
                        <input type="text" class="form-control mb-4" id="carName" name="name" required placeholder="<?= __('My car, Family car') ?>">
                    </div>
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['sturecmsaid'] ?>">
                    <div class="col-lg-6 col-12">
                        <label for="carModel" class="form-label"><?= __('Enter Car model') ?></label>
                        <input type="text" class="form-control mb-4" id="carModel" name="model" required placeholder="<?= __('Camry, Yukon') ?>">
                    </div>
                    <div class="col-lg-6 col-12">
                        <label for="makeYear" class="form-label"><?= __('Enter Car Make Year') ?></label>
                        <input type="number" class="form-control mb-4" id="makeYear" name="year" required value="2023">
                    </div>
                    <div class="col-lg-6"></div>
                    <div class="col-md-5 col-7">
                        <button class="btn reminder-btn w-100" type="submit"
                                name="submit"> <?= __('Add new car') ?></button>
                    </div>
                </div>
            </form>
        </div>
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

<?php include_once('includes/footer.php'); ?>

</body>
</html>
