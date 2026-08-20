<?php
session_start();

if (!isset($_SESSION['admin_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: ../login.php");
    exit;
}

include "../req/DB_connection.php";

// Move POST logic BEFORE output
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course = trim($_POST['course']);
    if (empty($course)) {
        header("Location: course-add.php?error=Course name is required");
        exit;
    }
    $sql = "INSERT INTO courses (course_name) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$course]);

    header("Location: course.php?success=Course added successfully");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Admin - Add Course</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        body {
            background: url("../img/green-gradient.avif") no-repeat center center fixed;
            background-size: cover;
            color: white;
        }
        .container, .form-label {
            color: white;
        }
        .form-control {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border: 1px solid white;
        }
        .form-control::placeholder {
            color: #ddd;
        }
    </style>
</head>
<body>
    <?php include "inc/navbar.php"; ?>

    <div class="container mt-5">
        <h3>Add New Course</h3>

        <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-danger mt-3"><?= htmlspecialchars($_GET['error']) ?></div>
        <?php } ?>

        <form method="POST" class="mt-3">
            <div class="mb-3">
                <label for="course" class="form-label">Course Name</label>
                <input type="text" class="form-control" id="course" name="course" placeholder="Enter course name" required>
            </div>
            <button type="submit" class="btn btn-success">Add</button>
            <a href="course.php" class="btn btn-secondary">Back</a>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $("#navLinks li:nth-child(11) a").addClass('active');
        });
    </script>
</body>
</html>
