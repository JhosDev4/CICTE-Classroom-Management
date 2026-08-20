<?php
session_start();
if (isset($_SESSION['admin_id']) && $_SESSION['role'] == 'Admin') {
    if (!isset($_GET['room_id'])) {
        header("Location: room.php?error=Room ID is required");
        exit;
    }

    include "../req/DB_connection.php";

    $room_id = $_GET['room_id'];
    $stmt = $conn->prepare("DELETE FROM rooms WHERE room_id = ?");
    $stmt->execute([$room_id]);

    header("Location: room.php?success=Room deleted successfully");
    exit;

} else {
    header("Location: ../login.php");
    exit;
}
?>
