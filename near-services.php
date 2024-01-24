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

if (in_array($id, [1, 2, 3])) {
    // Admin user
    $isAdmin = true;
} else {
    // Regular user
    $isAdmin = false;
}

if (isset($_POST['delete'])) {
    $delete_id = $_POST['delete'];

    $sql = "DELETE FROM services WHERE id=:delete";
    $query = $dbh->prepare($sql);

    $query->bindParam(':delete', $delete_id, PDO::PARAM_INT);

    $query->execute();
    echo '<script>window.location.href = window.location.href;</script>';
}
if (isset($_GET["city_id"])) {
    $city = $_GET["city_id"];
    $sql = "SELECT * FROM services WHERE city_id=:city";
    $query = $dbh->prepare($sql);
    $query->bindParam(':city', $city, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
} else {
    $sql = "SELECT * from  services ";
    $query = $dbh->prepare($sql);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
}
?>
<!-- Example DataTables Card-->
<div class="table-responsive">
    <table class="table text-center" id="dataTable" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th style="color: #7436B4;"><?= __('Service Providers')?></th>
        </tr>
        </thead>
    </table>
</div>
<!-- Button trigger modal -->

<!-- search -->
<div class="input-group mb-3">

    <select name="city_id" id="" class="form-select"
            onchange="window.location.href=this.options[this.selectedIndex].value" ;>
        <option value="near-services.php"><?= __('All Service Providers')?></option>
        <?php
        foreach ($result2 as $row1) {
            ?>
            <option value="near-services.php?city_id=<?php echo htmlentities($row1->id); ?>"

                <?php if (isset($_GET["city_id"]) && $_GET["city_id"] == htmlentities($row1->id)) { ?> selected <?php } ?>
            ><?= __( $row1->name, 'ar') ?></option>
        <?php } ?>
    </select>
</div>
<!-- Modal -->
<div class="add-reminder">
    <form action="" method="post">
        <div class="row my-4">
            <?php


            $cnt = 1;
            if ($query->rowCount() > 0) {
                foreach ($results as $row) { ?>
                    <div class="modal fade" id="service-details<?php echo htmlentities($row->id); ?>" tabindex="-1"
                         aria-labelledby="service-detailsLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5"
                                        id="service-detailsLabel"><?php echo htmlentities($row->name); ?></h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <ul>
                                        <li>
                                            <p> <?= __('phone number')?>: <a
                                                        href="tel:<?php echo htmlentities($row->phone); ?>"><?php echo htmlentities($row->phone); ?></a>
                                            </p>
                                        </li>
                                        <li>
                                            <p> <?= __('address')?> : <span><?php echo htmlentities($row->address); ?></span></p>

                                            <iframe src="<?php echo htmlentities($row->servicelink); ?>">
                                            </iframe>

                                        </li>

                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <?php if ($isAdmin) { // Only show the delete button for admin ?>
                                    <button class="btn btn-danger" type="submit" name="delete" value="<?php echo htmlentities($row->id); ?>"><?= __('Delete')?></button>
                                    <?php } ?>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-12">
                        <a role="button" data-bs-toggle="modal"
                           data-bs-target="#service-details<?php echo htmlentities($row->id); ?>">
                            <div class="service">
                                <div class="service-icon">
                                    <i class="fa-solid fa-gear"></i>
                                </div>
                                <div>
                                    <p>
                                        <?php echo htmlentities($row->name); ?>
                                    </p>
                                    <i class="fa-solid fa-location-dot"></i>
                                    <!--                                    <span>1 km</span>-->
                                    <?php echo htmlentities($row->address); ?>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php }

         } else {
            } ?>
        </div>


    </form>

</div>

</div>
<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fa fa-angle-up"></i>
</a>

</div>
<?php include_once('includes/footer.php'); ?>

</body>
</html>
