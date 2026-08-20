<?php
session_start();
if (isset($_SESSION['admin_id']) && $_SESSION['role'] == 'Admin') {
    include "../req/DB_connection.php";

    if (!isset($_GET['room_id'])) {
        header("Location: room.php?error=Room ID is required");
        exit;
    }

    $room_id = $_GET['room_id'];

    // Fetch existing room
    $stmt = $conn->prepare("SELECT * FROM rooms WHERE room_id = ?");
    $stmt->execute([$room_id]);
    $room = $stmt->fetch();

    if (!$room) {
        header("Location: room.php?error=Room not found");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $room_name = trim($_POST['room_name']);

        if (empty($room_name)) {
            $error = "Room name is required!";
        } else {
            $stmt = $conn->prepare("UPDATE rooms SET room_name = ? WHERE room_id = ?");
            $stmt->execute([$room_name, $room_id]);

            header("Location: room.php?success=Room updated successfully");
            exit;
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Room</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h3>Edit Room</h3>
    <?php if (isset($error)) { ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php } ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Room Name</label>
            <input type="text" name="room_name" class="form-control" value="<?= htmlspecialchars($room['room_name']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="room.php" class="btn btn-secondary">Cancel</a>
    </form>
</body>
</html>
<?php } else {
    header("Location: ../login.php");
    exit;
} ?>
