<?php
include '../config.php';
include '../includes/auth.php';
requireAdmin();

$id = $_GET['id'];
$e = $conn->query("SELECT * FROM events WHERE id=$id")->fetch_assoc();

if(isset($_POST['title'])){

if($_FILES['image']['name']){
    $img = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'],"../assets/uploads/".$img);

    $conn->query("UPDATE events SET 
    title='$_POST[title]',
    venue='$_POST[venue]',
    event_date='$_POST[date]',
    image='$img'
    WHERE id=$id");

} else {
    $conn->query("UPDATE events SET 
    title='$_POST[title]',
    venue='$_POST[venue]',
    event_date='$_POST[date]'
    WHERE id=$id");
}

header("Location: manage_events.php");
exit;
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
<h2>Edit Event</h2>
<form method="post" enctype="multipart/form-data" class="card card-custom p-3">

<input class="form-control mb-2" name="title" value="<?= $e['title'] ?>">
<input class="form-control mb-2" name="venue" value="<?= $e['venue'] ?>">
<input class="form-control mb-2" type="date" name="date" value="<?= $e['event_date'] ?>">
<input class="form-control mb-2" type="file" name="image">

<button class="btn btn-pink">Update</button>

</form>
</div>
</body>
</html>