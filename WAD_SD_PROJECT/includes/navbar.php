<?php
if(!isset($_SESSION)) session_start();
$isAdmin = isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
?>
<nav class="navbar navbar-pink navbar-dark px-4 d-flex justify-content-between">
    <div>
        <b>Campus Events</b>
    </div>
    <div>
        <a href="/WAD_SD_PROJECT/events/index.php" class="btn btn-light btn-sm">Events</a>
        <a href="/WAD_SD_PROJECT/announcements/index.php" class="btn btn-light btn-sm">Announcements</a>
	<a href="/WAD_SD_PROJECT/delete_account.php" class="btn btn-danger btn-sm">Delete Account</a>
	<a href="/WAD_SD_PROJECT/change_password.php" class="btn btn-danger btn-sm ms-2">Change Password</a>
        <?php if($isAdmin){ ?>
            <a href="/WAD_SD_PROJECT/admin/dashboard.php" class="btn btn-warning btn-sm">Admin</a>
            <a href="/WAD_SD_PROJECT/admin/manage_events.php" class="btn btn-dark btn-sm">Manage</a>
            <a href="/WAD_SD_PROJECT/admin/create_event.php" class="btn btn-success btn-sm">Create</a>
        <?php } ?>
        <a href="/WAD_SD_PROJECT/logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>
</nav>