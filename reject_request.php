<?php
session_start();
if (!isset($_SESSION['sturecmsaid']) || strlen($_SESSION['sturecmsaid']) == 0) {
    header('location:logout.php');
}
include('includes/dbconnection.php');

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Delete the user record from the database
    $sql = "UPDATE user SET admin = 2 WHERE id = ?";
    $query = $dbh->prepare($sql);
    $query->bindParam(1, $userId, PDO::PARAM_INT);
    $query->execute();

    // Redirect back to the admin panel or any other appropriate page
    header('Location: admin_panel.php');
    exit();
} else {
    // Invalid request, redirect to an error page or display an error message
    header('Location: error.php');
    exit();
}
?>
