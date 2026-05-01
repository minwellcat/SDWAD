<?php
include '../config.php';
include '../includes/auth.php';
requireAdmin();

$users = $conn->query("SELECT name, username FROM users");
$events = $conn->query("SELECT * FROM events");
$regs = $conn->query("
SELECT registrations.*, events.title 
FROM registrations 
JOIN events ON registrations.event_id = events.id
");
?>

<!DOCTYPE html>
<html>
<head>
<?php include '../includes/bootstrap.php'; ?>
</head>
<body>

<?php include '../includes/navbar.php'; ?>
<div class="container mt-4">
<h2>Admin Dashboard</h2>
<div class="row mt-3">

<div class="col-md-4">
<div class="card card-custom p-3">
<h4>Total Users</h4>
<?php while($u = $users->fetch_assoc()){ ?>
<p><?= $u['name'] ?> (<?= $u['username'] ?>)</p>
<?php } ?>

</div>
</div>
<div class="col-md-4">
<div class="card card-custom p-3">
<h4>Total Events</h4>

<?php while($e = $events->fetch_assoc()){ ?>
<div class="d-flex align-items-center mb-2">

<img src="../assets/uploads/<?= $e['image'] ?>" width="50" height="50" style="object-fit:cover;border-radius:6px;">

<div class="ms-2">
<b><?= $e['title'] ?></b><br>
<small><?= $e['event_date'] ?></small>
</div>

</div>
<?php }?>
</div>
</div>

<div class="col-md-4">
<div class="card card-custom p-3">
<h4>Total Registrations</h4>

<?php while($r = $regs->fetch_assoc()){ ?>

<div class="mb-2">

<b><?= $r['full_name'] ?></b><br>
<small><?= $r['course'] ?></small><br>
<small><?= $r['department'] ?></small><br>
<small>Event: <?= $r['title'] ?></small>

</div>
<hr>
<?php } ?>
</div>
</div>
</div>
</div>
</body>
</html>