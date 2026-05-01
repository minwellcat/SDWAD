<?php
include '../config.php';
include '../includes/auth.php';
requireLogin();

$user_role = $_SESSION['user']['role'];

if($user_role == 'admin' && isset($_POST['title'])){
    $stmt = $conn->prepare("INSERT INTO announcements(title,message) VALUES(?,?)");
    $stmt->bind_param("ss", $_POST['title'], $_POST['message']);
    $stmt->execute();
}

$ann = $conn->query("SELECT * FROM announcements ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<?php include '../includes/bootstrap.php'; ?>
</head>
<body>
<?php include '../includes/navbar.php'; ?>

<div class="container mt-4">
<h2>Announcements</h2>
<?php if($user_role=='admin'){ ?>

<form method="post" class="card card-custom p-3 mb-3">
<input class="form-control mb-2" name="title" placeholder="Title">
<textarea class="form-control mb-2" name="message" placeholder="Message"></textarea>
<button class="btn btn-pink">Post</button>

</form>
<?php } ?>
<?php while($a = $ann->fetch_assoc()){ ?>
<div class="card card-custom p-3 mb-2">

<h5><?= $a['title'] ?></h5>
<p><?= $a['message'] ?></p>

<?php if($user_role == 'admin'){ ?>
<a href="delete.php?id=<?= $a['id'] ?>"
   class="btn btn-sm btn-danger"
   onclick="return confirm('Delete this announcement?')">
Delete
</a>
<?php } ?>

</div>
<?php } ?>
</div>
</body>
</html>