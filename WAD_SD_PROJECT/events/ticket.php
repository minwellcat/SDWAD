<?php
include '../config.php';
include '../includes/auth.php';
requireLogin();

$user_id = $_SESSION['user']['id'];
$event_id = $_GET['id'];

$stmt = $conn->prepare("
SELECT r.*, e.title, e.venue, e.event_date
FROM registrations r
JOIN events e ON r.event_id = e.id
WHERE r.user_id=? AND r.event_id=?
");
$stmt->bind_param("ii",$user_id,$event_id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if(!$data){
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<?php include '../includes/bootstrap.php'; ?>

<style>
.ticket-box{
    max-width:600px;
    margin:auto;
    border:2px dashed #ff4d88;
    padding:20px;
    border-radius:15px;
    background:#fff;
    text-align:center;
}
.ticket-title{
    color:#ff4d88;
    font-weight:bold;
}
</style>
</head>
<body>

<div class="container mt-5">
<div class="ticket-box">
<h3 class="ticket-title">🎟️ Event Ticket</h3>
<h4><?= $data['title'] ?></h4>

<p><b>Name:</b> <?= $data['full_name'] ?></p>
<p><b>Course:</b> <?= $data['course'] ?></p>
<p><b>Department:</b> <?= $data['department'] ?></p>

<hr>

<p><b>Venue:</b> <?= $data['venue'] ?></p>
<p><b>Date:</b> <?= $data['event_date'] ?></p>

<hr>

<h3>#<?= ltrim($data['ticket_code'], '#') ?></h3>

<button onclick="window.print()" class="btn btn-pink mt-3">
Print Ticket
</button>

<a href="details.php?id=<?= $event_id ?>" class="btn btn-secondary mt-2">
Back
</a>

</div>
</div>
</body>
</html>