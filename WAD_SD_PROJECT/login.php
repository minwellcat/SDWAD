<?php
include 'config.php';
$msg="";

if($_SERVER['REQUEST_METHOD']=='POST'){
    $u=$_POST['username'];
    $p=$_POST['password'];

    $stmt=$conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s",$u);
    $stmt->execute();
    $r=$stmt->get_result();

    if($r->num_rows>0){
        $d=$r->fetch_assoc();
        if(password_verify($p,$d['password'])){
            $_SESSION['user']=[
                'id'=>$d['id'],
                'name'=>$d['name'],
                'role'=>strtolower($d['role'])
            ];
            header("Location: events/index.php");
            exit;
        }
    }
    $msg="Invalid login";
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
<h3 class="text-center">Login</h3>
<form method="post">
<input class="form-control mb-2" name="username" placeholder="Username" required>
<input class="form-control mb-2" type="password" name="password" placeholder="Password" required>

<button class="btn btn-pink w-100">Login</button>
</form>
<p class="text-danger text-center mt-2"><?= $msg ?></p>
<a href='register.php'>Register</a><br>
</div>
</body>
</html>