<?php
include '../config.php';
include '../includes/auth.php';
requireAdmin();

$event_id = $_GET['event_id'];
$event = $conn->query("SELECT * FROM events WHERE id=$event_id")->fetch_assoc();

$stmt = $conn->prepare("
SELECT registrations.*, users.username 
FROM registrations
JOIN users ON registrations.user_id = users.id
WHERE registrations.event_id = ?
");

$stmt->bind_param("i",$event_id);
$stmt->execute();
$res = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<?php include '../includes/bootstrap.php'; ?>
</head>
<body>

<?php include '../includes/navbar.php'; ?>

<div class="container mt-4">

<div class="card card-custom p-3 mb-3">
<div class="d-flex align-items-center">

<img src="../assets/uploads/<?= $event['image'] ?>" width="70" height="70" style="object-fit:cover;border-radius:8px;">

<div class="ms-3">
<h4><?= $event['title'] ?></h4>
<p class="mb-0"><?= $event['venue'] ?></p>
<small><?= $event['event_date'] ?></small>
</div>

</div>
</div>

<div class="card card-custom p-3">

<h5 class="mb-3">Participants</h5>

<?php if($res->num_rows > 0){ ?>

<table class="table table-bordered table-hover">

<thead>
<tr>
<th>#</th>
<th>Ticket ID</th>
<th>Name</th>
<th>Username</th>
<th>Course / Section</th>
<th>Department</th>
</tr>
</thead>

<tbody>

<?php 
$count = 1;
while($row = $res->fetch_assoc()){ 
?>

<tr>
<td><?= $count++ ?></td>
<td><?= $row['ticket_code'] ?></td>
<td><?= $row['full_name'] ?></td>
<td><?= $row['username'] ?></td>
<td><?= $row['course'] ?></td>
<td><?= $row['department'] ?></td>
</tr>

<?php } ?>

</tbody>
</table>

<?php } else { ?>

<p>No participants yet.</p>

<?php } ?>

</div>

<a href="manage_events.php" class="btn btn-secondary mt-3">Back</a>

</div>

</body>
</html>