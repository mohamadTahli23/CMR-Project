<?php
session_start();
if (!isset($_SESSION['sturecmsaid']) || strlen($_SESSION['sturecmsaid']) == 0) {
    header('location:logout.php');
}
include('includes/header.php');

$id = $_SESSION['sturecmsaid'];

$sql = "SELECT admin FROM user WHERE id = ?";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(1, $id);
$stmt->execute();
$isAdmin = $stmt->fetch(PDO::FETCH_COLUMN);
if ($isAdmin == 1) {
    // Admin user
    $isAdmin = true;
} else {
    // Regular user
    $isAdmin = false;
}
?>

<div class="table-responsive ">
    <table class="table text-center" id="dataTable" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th style="color: #7436B4;"><?= __('Reminders History')?></th>
        </tr>
        </thead>
    </table>
</div>
<div class="table-responsive text-center">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th><?= __('Car Name')?></th>
            <th><?= __('name of reminder')?></th>
            <th><?= __('Description of reminder')?></th>
            <th><?= __('ODO Read')?></th>
            <th><?= __('Date of reminder')?></th>

            <th><?= __('Action')?></th>
        </tr>
        </thead>
        <tbody>
        <?php


            $sql = "SELECT * from  reminders where reminders.user_id=:id and reminders.active=1";
            $query = $dbh->prepare($sql);
            $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);



        if ($query->rowCount() > 0) {
            foreach ($results as $row) {
                $sql2 = "SELECT * from  user where user.id=:id";
                $query2 = $dbh->prepare($sql2);
                $query2->bindParam(':id', $row->user_id, PDO::PARAM_STR);
                $query2->execute();
                $results4 = $query2->fetchAll(PDO::FETCH_OBJ);
                $carName = '';
                if ($row->car_id) {
                    $sql3 = "SELECT * from cars where id=:car_id";
                    $query3 = $dbh->prepare($sql3);
                    $query3->bindParam(':car_id', $row->car_id, PDO::PARAM_STR);
                    $query3->execute();
                    $results3 = $query3->fetchAll(PDO::FETCH_OBJ);
                    foreach ($results3 as $row3) {
                        $carName = $row3->name;
                    }
                }
                ?>
                <tr>

                    <td><?php echo htmlentities($carName); ?></td>
                    <td><?php echo htmlentities($row->name); ?></td>
                    <td><?php echo htmlentities($row->Description); ?></td>
                    <td><?php echo htmlentities($row->odo); ?></td>
                    <td><?php echo htmlentities($row->date ); ?></td>

                    <td>
                        <form method="post" action="delete_reminder.php">
                            <input type="hidden" name="reminder_id" value="<?php echo $row->id; ?>">
                            <input type="hidden" name="referrer" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                            <button type="submit" class="btn btn-danger"><?php echo __('Delete'); ?></button>
                        </form>

                    </td>
                </tr>
            <?php }
        } else{?>

        </tbody>


    </table>
    <div class="text-center"> <?= __('not found reminders')?></div>

    <?php }?>
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
