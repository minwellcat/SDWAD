<?php
include 'config.php';
include 'includes/auth.php';
requireLogin();

$msg = "";

$user_id = $_SESSION['user']['id'];

$stmt = $conn->prepare("SELECT username, password FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if(isset($_POST['current']) && isset($_POST['new'])){

    if(password_verify($_POST['current'], $user['password'])){

        $new = password_hash($_POST['new'], PASSWORD_DEFAULT);

        $upd = $conn->prepare("UPDATE users SET password=? WHERE id=?");
        $upd->bind_param("si", $new, $user_id);
        $upd->execute();

        $msg = "Password updated successfully!";
    } else {
        $msg = "Current password is incorrect.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<?php include 'includes/bootstrap.php'; ?>
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<div class="container mt-4">

<div class="card card-custom p-4">

<h3>Change Password</h3>

<form method="post">

<input type="password" name="current" class="form-control mb-2" placeholder="Current Password" required>

<input type="password" name="new" class="form-control mb-2" placeholder="New Password" required>

<button class="btn btn-pink w-100">Update Password</button>

</form>

<?php if($msg){ ?>
<div class="alert alert-info mt-3">
<?= $msg ?>
</div>
<?php } ?>

</div>

</div>

</body>
</html>