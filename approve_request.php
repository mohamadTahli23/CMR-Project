<?php
session_start();
if (!isset($_SESSION['sturecmsaid']) || strlen($_SESSION['sturecmsaid']) == 0) {
    header('location:logout.php');
}
include('includes/dbconnection.php');

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Update the user record to set admin = 1 (approve the request)
    $sql = "UPDATE user SET admin = 1 WHERE id = :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $userId, PDO::PARAM_INT);
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
