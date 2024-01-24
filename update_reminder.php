<?php
session_start();
if (!isset($_SESSION['sturecmsaid']) || strlen($_SESSION['sturecmsaid']==0)) {
    header('location:logout.php');
}
include('includes/dbconnection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['reminder_id'])) {
        $reminderId = $_POST['reminder_id'];

        // Update the reminder in the database
        $sql = "UPDATE reminders SET active = 1 WHERE id = :reminder_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':reminder_id', $reminderId, PDO::PARAM_INT);
        $stmt->execute();

        // Redirect back to the page
        header('Location: dashboard.php');
        exit;
    }
}
?>

