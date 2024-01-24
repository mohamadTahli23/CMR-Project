<?php
session_start();
include('includes/header.php');

if (isset($_POST['delete'])) {
    $delete_id = $_POST['delete_id'];
    $sql = "DELETE FROM cities WHERE id=:delete_id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':delete_id', $delete_id, PDO::PARAM_INT);
    $query->execute();
    echo '<script>window.location.href = window.location.href;</script>';
}
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $sql = "insert into cities(name)values(:name)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
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
<div class="table-responsive">
    <table class="table text-center" id="dataTable" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th style="color: #7436B4;"><?= __('Cities') ?></th>
        </tr>
        </thead>
    </table>
</div>
<div class="my-cars text-center">
    <table class="table table-bordered" id="dataTable">
        <thead>
        <tr>
            <th><?= __('City')?></th>
            <th><?= __('Action')?></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $id = $_SESSION['sturecmsaid'];
        $sql = "SELECT * FROM cities";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        if ($query->rowCount() > 0) {
            foreach ($results as $row) {
                ?>
                <tr>
                    <td><?= __( $row->name, 'ar') ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="delete_id" value="<?php echo $row->id ?>">
                            <button class="btn btn-danger" type="submit" name="delete"><?php echo __('Delete'); ?></button>
                        </form>
                    </td>
                </tr>
            <?php }
        } else {
        } ?>
        </tbody>
    </table>
    <div class="row justify-content-center">
        <div class="col-md-5 col-7">
            <button class="btn reminder-btn w-100" type="button" data-bs-toggle="collapse" data-bs-target="#addCar"
                    aria-expanded="false" aria-controls="collapseExample"><?= __('Add new City') ?></button>
        </div>
    </div>
    <div class="collapse" id="addCar">
        <div class="py-3">
            <form action="" method="post">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-12">
                        <label for="carName" class="form-label"><?= __('Enter City Name') ?></label>
                        <input type="text" class="form-control mb-4" id="carName" name="name" required>
                    </div>

                    <div class="col-lg-6"></div>
                    <div class="col-md-5 col-7 ">
                        <button class="btn reminder-btn w-100" type="submit"
                                name="submit"> <?= __('Add new City') ?></button>
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
