<?php
require 'lang.php';

include('includes/dbconnection.php');

// Make sure the submitted registration values are not empty.
if (isset($_POST['Register'])) {
    if (empty($_POST['name']) || empty($_POST['password']) || empty($_POST['email'])) {
        // One or more values are empty.
        exit('Please complete the registration form');
    }

    // Initialize flag variable
    $proceedRegistration = true;

    // Check if the email is already registered
    $email = $_POST['email'];
    $stmt = $dbh->prepare('SELECT id FROM user WHERE email = ?');
    $stmt->bindParam(1, $email);
    $stmt->execute();
    $existingEmail = $stmt->fetch(PDO::FETCH_COLUMN);

    if ($existingEmail) {
        $proceedRegistration = false;
        echo '<script>alert("Email is already registered")</script>';
        echo "<script>window.location.href ='register.php'</script>";
    }

    // Check if the mobile number is already registered
    $phone = $_POST['phone'];
    $stmt = $dbh->prepare('SELECT id FROM user WHERE phone = ?');
    $stmt->bindParam(1, $phone);
    $stmt->execute();
    $existingPhone = $stmt->fetch(PDO::FETCH_COLUMN);

    if ($existingPhone) {
        $proceedRegistration = false;
        echo '<script>alert("Mobile number is already registered")</script>';
        echo "<script>window.location.href ='register.php'</script>";
    }

    if ($stmt = $dbh->prepare('SELECT id, password FROM user WHERE phone = ?')) {
        // Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
        $stmt->bindParam('i', $_POST['phone']);
    } else {
        // Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all 3 fields.
        echo 'Could not prepare statement!';
    }


// Proceed with registration only if flag variable is true
    if ($proceedRegistration) {
        if ($stmt = $dbh->prepare('INSERT INTO user (name, password, email,city_id,phone, admin) VALUES (?, ?, ?,?, ?,? )')) {
            // We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
            $password = md5($_POST['password']);
            $admin = ($_POST['adminRole']) ? 0 : 2;
            $stmt->bindParam(1, $_POST['name']);
            $stmt->bindParam(2, $password);
            $stmt->bindParam(3, $_POST['email']);
            $stmt->bindParam(4, $_POST['city_id']);
            $stmt->bindParam(5, $_POST['phone']);
            $stmt->bindParam(6, $admin);
            $stmt->execute();

            echo '<script>alert("You have successfully registered! You can now login!")</script>';
            echo "<script>window.location.href ='index.php'</script>";
        } else {
            echo 'Could not prepare statement!';
        }
    }
}
$sql2 = "SELECT * from cities ";
$query2 = $dbh->prepare($sql2);
$query2->execute();
$result2 = $query2->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= __('Car Reminder') ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css'>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
          integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>
<body id="login">
<section class="login">
    <div class="text-center pt-5">
        <img src="images/logo.png" alt="" width="300px">
    </div>
    <div class="login-wrapper">
        <div class="container-fluid">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-5 col-12">
                    <div class="login-form">
                        <h5><?= __('Welcome !') ?></h5>
                        <h4 class="mt-3 mb-4"><?= __('Register') ?></h4>
                        <form method="post">
                            <label for="Name" class="form-label"><?= __('Name') ?></label>
                            <input type="text" class="form-control" id="Name" name="name" required>
                            <label for="Phone" class="form-label"><?= __('Phone') ?></label>
                            <input type="text" class="form-control" id="Phone" name="phone" required>
                            <label for="Phone" class="form-label"><?= __('city') ?></label>
                            <select name="city_id" id="" class="form-select" required>
                                <option value=""><?= __('Select City') ?></option>
                                <?php
                                foreach ($result2 as $row1) {
                                    ?>
                                    <option value="<?php echo htmlentities($row1->id); ?>"><?php echo htmlentities($row1->name); ?></option>
                                <?php } ?>
                            </select>
                            <label for="E-mail" class="form-label"><?= __('E-mail') ?></label>
                            <input type="email" class="form-control" id="E-mail" name="email" required>
                            <label for="Password" class="form-label"><?= __('Password') ?></label>
                            <input type="password" class="form-control" id="Password" name="password" required>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="adminRole" id="adminRole">
                                <label class="form-check-label" for="adminRole">
                                    <?= __('Apply as Admin') ?>
                                </label>
                            </div>

                            <button class="btn btn-block col-md-12" name="Register" type="submit"><?= __('Register') ?>
                            </button>
                        </form>
                        <p> <?= __('have an account?') ?><a href="index.php"><?= __('Login') ?></a></p>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <img class="w-100" src="images/car-main-page.svg" alt="">
                </div>
            </div>
        </div>
    </div>
</section>

</body>

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.5/umd/popper.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N"
        crossorigin="anonymous"></script>
<script src="./script.js"></script>

</body>
</html>
