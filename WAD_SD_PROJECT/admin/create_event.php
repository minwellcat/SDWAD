<?php
include '../config.php';
include '../includes/auth.php';
requireAdmin();

$msg = "";
if(isset($_POST['title'])){
$img = $_FILES['image']['name'];
$tmp = $_FILES['image']['tmp_name'];

move_uploaded_file($tmp, "../assets/uploads/".$img);
$stmt = $conn->prepare("INSERT INTO events(title,venue,event_date,image) VALUES(?,?,?,?)");
$stmt->bind_param("ssss", $_POST['title'], $_POST['venue'], $_POST['date'], $img);
$stmt->execute();
$msg = "Event created!";
}
?>

<!DOCTYPE html>
<html>
<head>
<?php include '../includes/bootstrap.php'; ?>
</head>
<body>
<?php include '../includes/navbar.php'; ?>
<div class="container mt-4">
<h2>Create Event</h2>
<p><?= $msg ?></p>

<form method="post" enctype="multipart/form-data" class="card card-custom p-3">

<input class="form-control mb-2" name="title" placeholder="Title">
<input class="form-control mb-2" name="venue" placeholder="Venue">
<input class="form-control mb-2" type="date" name="date">
<input class="form-control mb-2" type="file" name="image">

<button class="btn btn-pink">Create</button>

</form>
</div>
</body>
</html>