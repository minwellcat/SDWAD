<?php
include '../config.php';
include '../includes/auth.php';
requireAdmin();

if(!isset($_GET['id'])){
    header("Location: manage_events.php");
    exit;
}
$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM registrations WHERE event_id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

$stmt = $conn->prepare("DELETE FROM events WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: manage_events.php");
exit;
?>