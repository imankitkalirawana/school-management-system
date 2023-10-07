<?php
$notification_title = "Password Changed!";
$notification_text = "Password was changed successfully";


// User details
$user_id = $_SESSION["id"];
$smtp = $link->prepare("SELECT * FROM users WHERE id = ?");
$smtp->bind_param("i", $user_id);
$smtp->execute();
$result = $smtp->get_result();
$row = $result->fetch_assoc();

//! User Details
$usertype = $row['usertype'];
$username = $row['username'];
$firstName = $row['name'];
$email = $row['email'];
$phone = $row['mobile_number'];
