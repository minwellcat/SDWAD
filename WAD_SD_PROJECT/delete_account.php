<?php
include 'config.php';

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user']['id'];
$msg = "";

if(isset($_POST['confirm_delete'])){
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT password FROM users WHERE id=?");
    $stmt->bind_param("i",$user_id);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();

    if(password_verify($password, $res['password'])){
        $conn->query("DELETE FROM registrations WHERE user_id=$user_id");
        $conn->query("DELETE FROM users WHERE id=$user_id");
        session_destroy();
        header("Location: login.php");
        exit;
    } else {
        $msg = "Incorrect password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<?php include 'includes/bootstrap.php'; ?>
</head>

<body>
<div class="container mt-5">
<div class="card card-custom p-4 text-center">
<h3 class="text-danger">Delete Account</h3>

<p>Are you sure you want to delete your account?</p>
<p><b>This action cannot be undone.</b></p>

<?php if($msg){ ?>
<p class="text-danger"><?= $msg ?></p>
<?php } ?>

<form method="post">
<input type="password" name="password" class="form-control mb-3" placeholder="Enter your password" required>
<button name="confirm_delete" class="btn btn-danger">Yes, Delete My Account</button>
<a href="events/index.php" class="btn btn-secondary ms-2">Cancel</a>

</form>
</div>
</div>
</body>
</html>