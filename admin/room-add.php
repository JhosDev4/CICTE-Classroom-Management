<?php
session_start();
if (isset($_SESSION['admin_id']) && $_SESSION['role'] == 'Admin') {
    include "../req/DB_connection.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $room_name = trim($_POST['room_name']);

        if (empty($room_name)) {
            $error = "Room name is required!";
        } else {
            $sql = "INSERT INTO rooms (room_name) VALUES (?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$room_name]);

            header("Location: room.php?success=Room added successfully");
            exit;
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Room</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h3>Add New Room</h3>
    <?php if (isset($error)) { ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php } ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Room Name</label>
            <input type="text" name="room_name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Add Room</button>
        <a href="room.php" class="btn btn-secondary">Back</a>
    </form>
</body>
</html>
<?php } else {
    header("Location: ../login.php");
    exit;
} ?>
