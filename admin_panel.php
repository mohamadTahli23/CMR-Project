<?php
session_start();
if (!isset($_SESSION['sturecmsaid']) || strlen($_SESSION['sturecmsaid']) == 0) {
    header('location:logout.php');
}
include('includes/header.php');


// Fetch pending admin registration requests
$sql = "SELECT * FROM user WHERE admin = 0"; // Query to fetch pending requests
$query = $dbh->prepare($sql);
$query->execute();
$requests = $query->fetchAll(PDO::FETCH_OBJ);

// Users by City Report
$sqlUsersByCity = "SELECT c.name AS city_name, COUNT(u.id) AS user_count
                   FROM cities c
                   LEFT JOIN user u ON c.id = u.city_id
                   GROUP BY c.id";
$queryUsersByCity = $dbh->prepare($sqlUsersByCity);
$queryUsersByCity->execute();
$usersByCity = $queryUsersByCity->fetchAll(PDO::FETCH_ASSOC);

// Users with the Same Car Name Report
$sqlUsersByCarName = "SELECT LOWER(c.model) AS car_model, COUNT(u.id) AS user_count
                      FROM cars c
                      LEFT JOIN user u ON c.user_id = u.id
                      GROUP BY LOWER(c.model)
                     ";
$queryUsersByCarName = $dbh->prepare($sqlUsersByCarName);
$queryUsersByCarName->execute();
$usersByCarName = $queryUsersByCarName->fetchAll(PDO::FETCH_ASSOC);

$sqlUsersCount = "SELECT COUNT(id) AS total_users FROM user";
$queryUsersCount = $dbh->prepare($sqlUsersCount);
$queryUsersCount->execute();
$totalUsers = $queryUsersCount->fetch(PDO::FETCH_COLUMN);

$sqlServiceProvidersCount = "SELECT COUNT(id) AS total_service_providers FROM services";
$queryServiceProvidersCount = $dbh->prepare($sqlServiceProvidersCount);
$queryServiceProvidersCount->execute();
$totalServiceProviders = $queryServiceProvidersCount->fetch(PDO::FETCH_COLUMN);

$sqlCarsCount = "SELECT COUNT(id) AS total_cars FROM cars";
$queryCarsCount = $dbh->prepare($sqlCarsCount);
$queryCarsCount->execute();
$totalCars = $queryCarsCount->fetch(PDO::FETCH_COLUMN);
?>

    <!-- Display the pending requests in a table -->
    <div class="table-responsive text-center">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th style="color: #7436B4;"><?= __('Admin Registration Requests')?></th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="table-responsive text-center">

    <table class="table table-bordered" id="dataTable">
        <thead>
        <tr>
            <th><?= __('User ID') ?></th>
            <th><?= __('user name')?></th>
            <th><?= __('E-mail') ?></th>
            <th><?= __('Action')?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($requests as $request) { ?>
            <tr>
                <td><?php echo $request->id; ?></td>
                <td><?php echo $request->name; ?></td>
                <td><?php echo $request->email; ?></td>
                <td>
                    <button class="btn btn-success" onclick="window.location.href='approve_request.php?id=<?php echo $request->id; ?>'"><?= __('Approve')?></button>
                    <button class="btn btn-danger" onclick="window.location.href='reject_request.php?id=<?php echo $request->id; ?>'"><?= __('Reject')?></button>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    </div>
    <div class="table-responsive text-center">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th style="color: #7436B4;"><?= __('Website Statics')?></th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="table-responsive text-center">
        <table class="table table-bordered" id="dataTable">
            <thead>
            <tr>
                <th><?= __('Total Users') ?></th>
                <th><?= __('Total Service Providers') ?></th>
                <th><?= __('Total Cars') ?></th>
            </tr>
            </thead>
            <tbody>

            <tr>
                <td><?= $totalUsers ?></td>
                <td><?= $totalServiceProviders ?></td>
                <td><?= $totalCars ?></td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="table-responsive text-center">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th style="color: #7436B4;"><?= __('Users by City Report')?></th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="table-responsive text-center">

    <table  class="table table-bordered" id="dataTable">
        <thead>
        <tr>
            <th><?= __('City')?></th>
            <th><?= __('User Count')?></th>
        </tr>
        </thead>
        <?php foreach ($usersByCity as $row) { ?>
            <tr>
                <td><?= __($row['city_name'], 'ar') ?></td>
                <td><?php echo $row['user_count']; ?></td>
            </tr>
        <?php } ?>
    </table>
    </div>
    <div class="table-responsive text-center">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th style="color: #7436B4;"><?= __('Users with the Same Car Model Report')?></th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="table-responsive text-center">
    <!-- Users with the Same Car Model Report -->

    <table  class="table table-bordered" id="dataTable">
        <thead>
        <tr>
            <th><?= __('Car model') ?></th>
            <th><?= __('User Count')?></th>
        </tr>
        </thead>
        <?php foreach ($usersByCarName as $row) { ?>
            <tr>
                <td><?php echo $row['car_model']; ?></td>
                <td><?php echo $row['user_count']; ?></td>
            </tr>
        <?php } ?>
    </table>
    </div>
<?php include_once('includes/footer.php'); ?>