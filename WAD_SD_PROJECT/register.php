<?php
include 'config.php';

if($_SERVER['REQUEST_METHOD']=='POST'){
    $n=$_POST['name'];
    $u=$_POST['username'];
    $p=password_hash($_POST['password'],PASSWORD_DEFAULT);

    $stmt=$conn->prepare("INSERT INTO users(name,username,password,role) VALUES(?,?,?,'user')");
    $stmt->bind_param("sss",$n,$u,$p);
    $stmt->execute();

    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="d-flex justify-content-center align-items-center" style="height:100vh;">
<div class="card card-custom p-4" style="width:350px;">
<h3 class="text-center">Register</h3>

<form method="post">
<input class="form-control mb-2" name="name" placeholder="Full Name" required>
<input class="form-control mb-2" name="username" placeholder="Username" required>
<input class="form-control mb-2" type="password" name="password" placeholder="Password" required>
<button class="btn btn-pink w-100">Create</button>

</form>
</div>
</body>
</html>