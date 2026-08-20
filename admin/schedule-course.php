<?php 
session_start();
if (isset($_SESSION['admin_id']) && $_SESSION['role'] == 'Admin') {
    include "../req/DB_connection.php";
    include "data/schedule.php";

    $course = $_GET['course'] ?? '';
    $schedules = getSchedulesByCourse($conn, $course); // You’ll implement this
?>
<!DOCTYPE html>
<html>
<head>
    <title>Schedule - <?= htmlspecialchars(strtoupper($course)) ?></title>
    <!-- Include Bootstrap + your CSS -->
</head>
<body>
    <?php include "inc/navbar.php"; ?>
    <div class="container mt-5">
        <h3>Schedule for <?= strtoupper($course) ?></h3>
        <a href="schedule.php" class="btn btn-secondary">Back to All</a>
        <!-- Render your schedule table here just like in schedule.php -->
    </div>
</body>
</html>
<?php 
} else {
    header("Location: ../login.php");
    exit;
}
?>
