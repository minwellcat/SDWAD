<?php
include '../config.php';
include '../includes/auth.php';
requireLogin();

$user_id = $_SESSION['user']['id'];
$event_id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM registrations WHERE user_id=? AND event_id=?");
$stmt->bind_param("ii",$user_id,$event_id);
$stmt->execute();

header("Location: details.php?id=".$event_id);
exit;
?>