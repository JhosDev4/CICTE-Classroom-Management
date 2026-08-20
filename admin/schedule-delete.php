<?php
session_start();
if (isset($_SESSION['admin_id']) && $_SESSION['role'] == 'Admin') {
    if (isset($_GET['schedule_id'])) {
        include "../req/DB_connection.php";

        $schedule_id = $_GET['schedule_id'];

        // Check if the schedule exists
        $checkSql = "SELECT * FROM schedules WHERE schedule_id = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->execute([$schedule_id]);

        if ($checkStmt->rowCount() == 0) {
            header("Location: schedule.php?error=Schedule not found");
            exit;
        }

        // Delete the schedule
        $deleteSql = "DELETE FROM schedules WHERE schedule_id = ?";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->execute([$schedule_id]);

        header("Location: schedule.php?success=Schedule deleted successfully");
        exit;
    } else {
        header("Location: schedule.php?error=Missing schedule ID");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>
