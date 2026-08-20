<?php 
session_start();
if (isset($_SESSION['admin_id']) && $_SESSION['role'] == 'Admin') {
    include "../req/DB_connection.php";

    if (isset($_GET['subject_id'])) {
        $subject_id = $_GET['subject_id'];
        $sql = "DELETE FROM subjects WHERE subject_id=?";
        $stmt = $conn->prepare($sql);
        $res = $stmt->execute([$subject_id]);

        if ($res) {
            header("Location: subject.php?success=Subject deleted successfully");
            exit;
        } else {
            header("Location: subject.php?error=Failed to delete subject");
            exit;
        }
    } else {
        header("Location: subject.php?error=Subject ID missing");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>

