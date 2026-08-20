<?php 
session_start();
if (isset($_SESSION['admin_id']) && $_SESSION['role'] == 'Admin') {
    include "../req/DB_connection.php";
    include "data/room.php";
    $rooms = getAllRooms($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Room</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
    .n-table {
        color: white;
    }
</style>
<body>
    <?php include "inc/navbar.php"; ?>

    <div class="container mt-5">
        <a href="room-add.php" class="btn btn-dark">Add New Room</a>

        <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-danger mt-3 n-table" role="alert">
                <?= $_GET['error'] ?>
            </div>
        <?php } ?>

        <?php if (isset($_GET['success'])) { ?>
            <div class="alert alert-info mt-3 n-table" role="alert">
                <?= $_GET['success'] ?>
            </div>
        <?php } ?>

        <?php if ($rooms != 0) { ?>
            <div class="table-responsive">
                <table class="table table-bordered mt-3 n-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Room Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; foreach ($rooms as $room) { $i++; ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= htmlspecialchars($room['room_name']) ?></td>
                            <td>
                                <a href="room-edit.php?room_id=<?= $room['room_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="room-delete.php?room_id=<?= $room['room_id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } else { ?>
            <div class="alert alert-info mt-3" role="alert">No rooms found.</div>
        <?php } ?>
    </div>

    <script>
        $(document).ready(function() {
            $("#navLinks li:nth-child(8) a").addClass('active');
        });
    </script>
</body>
</html>
<?php 
} else {
    header("Location: ../login.php");
    exit;
}
?>
