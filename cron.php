<?php

include('includes/dbconnection.php');




$date = date("Y/m/d");
$nextDay = date('Y-m-d', strtotime('+1 day'));

$sqll = "SELECT * from  reminders WHERE date=:date";
$query1= $dbh->prepare($sqll);
$query1->bindParam(':date', $nextDay);
$query1->execute();
var_dump($query1->queryString);
$results = $query1->fetchAll(PDO::FETCH_OBJ);
if ($query1->rowCount() > 0) {
    foreach ($results as $result) {
        $sqll = "SELECT user.email, user.name, cars.name AS cars_name, cars.model AS car_model FROM user JOIN cars ON user.id = cars.user_id WHERE user.id=:user_id AND cars.id=:car_id";
        $user_id = $result->user_id;
        $car_id = $result->car_id;
        $query = $dbh->prepare($sqll);
        $query->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $query->bindParam(':car_id', $car_id, PDO::PARAM_STR);
        $query->execute();
        $resultss = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            foreach ($resultss as $result2) {
                $subject = 'Reminder for Your Vehicle !';
                $message = 'Hi ' . $result2->name . ', you have a new reminder for Car: ' . $result2->cars_name . ' (' . $result2->car_model . '), Reminder Name: ' . $result->name . ', Description: ' . $result->Description .' On '. $nextDay ;
                $message .= ' <br><br> <a href="http://cmr-ksa.com">Click here to open your Dashboard at CMR, to locate the nearest service provider.</a>  ';
                $headers = "From: support@cmr-ksa.com\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                var_dump($result2->email, $subject, $message, $headers);
                mail($result2->email, $subject, $message, $headers);
            }
        }
    }

}