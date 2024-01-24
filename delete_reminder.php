<?php
session_start();
if (!isset($_SESSION['sturecmsaid']) || strlen($_SESSION['sturecmsaid']==0)) {
    header('location:logout.php');
}
include('includes/dbconnection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reminder_id = $_POST['reminder_id'];

    // Delete the reminder from the database
    $sql = "DELETE FROM reminders WHERE id = :reminder_id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':reminder_id', $reminder_id, PDO::PARAM_INT);
    $query->execute();

    $referrer = $_SERVER['HTTP_REFERER'];
    // Redirect back to the reminders page
    header("location: $referrer");
    exit;
}
