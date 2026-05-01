<?php
include '../config.php';
include '../includes/auth.php';
requireAdmin();

$events = $conn->query("SELECT * FROM events");
?>

<!DOCTYPE html>
<html>
<head>
<?php include '../includes/bootstrap.php'; ?>
</head>
<body>

<?php include '../includes/navbar.php'; ?>
<div class="container mt-4">
<h2>Manage Events</h2>
<?php while($e=$events->fetch_assoc()){ ?>
<div class="card card-custom p-3 mb-2">

<h4><?= $e['title'] ?></h4>
<p><?= $e['venue'] ?></p>
<p><?= $e['event_date'] ?></p>

<div class="d-flex gap-2 mt-2">
<a class="btn btn-warning btn-sm flex-fill" href="edit_event.php?id=<?= $e['id'] ?>">Edit</a>
<a class="btn btn-danger btn-sm flex-fill" href="delete_event.php?id=<?= $e['id'] ?>">Delete</a>
<a class="btn btn-primary btn-sm flex-fill" href="view_users.php?event_id=<?= $e['id'] ?>">Users</a>

</div>
</div>
<?php } ?>
</div>
</body>
</html>