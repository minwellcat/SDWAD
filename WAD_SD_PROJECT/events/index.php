<?php
include '../config.php';
include '../includes/auth.php';
requireLogin();

$user_id = $_SESSION['user']['id'];
?>

<!DOCTYPE html>
<html>
<head>
<?php include '../includes/bootstrap.php'; ?>
</head>

<body>

<?php include '../includes/navbar.php'; ?>

<div class="container mt-4">

<div class="row">

<?php
$r = $conn->query("SELECT * FROM events");

while($e = $r->fetch_assoc()){

$id = $e['id'];

$count = $conn->query("SELECT COUNT(*) as t FROM registrations WHERE event_id=$id")
->fetch_assoc()['t'];

$today = date("Y-m-d");

if($e['event_date'] > $today){
    $status = "Upcoming";
} elseif($e['event_date'] == $today){
    $status = "Ongoing";
} else {
    $status = "Ended";
}
?>

<div class="col-md-3 mb-3">

<div class="card card-custom">

<img src="../assets/uploads/<?= $e['image'] ?>" class="event-img">

<div class="p-2">

<h5><?= $e['title'] ?></h5>
<p><?= $e['venue'] ?></p>
<p><?= $e['event_date'] ?> - <b><?= $status ?></b></p>
<p><b><?= $count ?> participants</b></p>

<a href="details.php?id=<?= $id ?>" class="btn btn-pink w-100">
View
</a>

</div>

</div>

</div>

<?php } ?>

</div>

</div>

</body>
</html>