<?php
include '../config.php';
include '../includes/auth.php';
requireLogin();

$user_id = $_SESSION['user']['id'];
$id = $_GET['id'];

$e = $conn->query("SELECT * FROM events WHERE id=$id")->fetch_assoc();

$msg = "";
$ticket_code = "";
$registered = false;

$c = $conn->prepare("SELECT * FROM registrations WHERE user_id=? AND event_id=?");
$c->bind_param("ii", $user_id, $id);
$c->execute();
$resCheck = $c->get_result();

if($resCheck->num_rows > 0){
    $registered = true;
    $data = $resCheck->fetch_assoc();
    $ticket_code = $data['ticket_code'];
}

if(isset($_POST['register']) && !$registered){

    $count = $conn->query("SELECT COUNT(*) as total FROM registrations WHERE event_id=$id")
    ->fetch_assoc()['total'] + 1;

    $ticket = "#" . str_pad($count, 3, "0", STR_PAD_LEFT);

    $stmt = $conn->prepare("
        INSERT INTO registrations(user_id,event_id,full_name,course,department,ticket_code)
        VALUES(?,?,?,?,?,?)
    ");

    $stmt->bind_param(
        "iissss",
        $user_id,
        $id,
        $_POST['name'],
        $_POST['course'],
        $_POST['department'],
        $ticket
    );

    $stmt->execute();

    $msg = "Registration successful!";
    $ticket_code = $ticket;
    $registered = true;
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
<div class="card card-custom p-4">

<img src="../assets/uploads/<?= $e['image'] ?>" class="img-fluid mb-3">

<h3><?= $e['title'] ?></h3>
<p><?= $e['venue'] ?></p>
<p><?= $e['event_date'] ?></p>

<?php if(!$registered){ ?>

<form method="post">
<input class="form-control mb-2" name="name" placeholder="Full Name" required>
<input class="form-control mb-2" name="course" placeholder="Year / Course / Section" required>
<input class="form-control mb-2" name="department" placeholder="College Department" required>
<button name="register" class="btn btn-pink w-100">Register</button>
</form>

<?php } else { ?>

<div class="alert alert-success">✔ You are registered</div>

<div class="alert alert-info">
<b>Your Ticket ID:</b> <?= $ticket_code ?>
</div>

<a href="ticket.php?id=<?= $id ?>" class="btn btn-success w-100 mt-2">
View / Print Ticket
</a>

<a href="unregister.php?id=<?= $id ?>"
   class="btn btn-danger w-100 mt-2"
   onclick="return confirm('Are you sure you want to unregister?')">
Unregister
</a>

<?php } ?>

<?php if($msg){ ?>
<div class="alert alert-primary mt-2"><?= $msg ?></div>
<?php } ?>

<a href="index.php" class="btn btn-secondary mt-2 w-100">Back</a>

</div>
</div>

</body>
</html>