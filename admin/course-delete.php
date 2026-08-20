<?php
session_start();
if (isset($_SESSION['admin_id']) && $_SESSION['role'] == 'Admin') {
    include "../req/DB_connection.php";

    if (!isset($_GET['course_id'])) {
        header("Location: course.php?error=Course ID missing");
        exit;
    }

    $sql = "DELETE FROM courses WHERE course_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_GET['course_id']]);

    header("Location: course.php?success=Course deleted successfully");
    exit;
} else {
    header("Location: ../login.php");
    exit;
}
?>
