<?php
include '../config.php';
include '../includes/auth.php';
requireAdmin();

if(!isset($_GET['id'])){
    header("Location: index.php");
    exit;
}
$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM announcements WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
header("Location: index.php");
exit;
?>