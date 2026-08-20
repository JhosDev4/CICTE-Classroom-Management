<?php
session_start();
if (isset($_SESSION['admin_id']) && $_SESSION['role'] == 'Admin') {
    include "../req/DB_connection.php";
    include "data/course.php";

    if (!isset($_GET['course_id'])) {
        header("Location: course.php?error=Course ID missing");
        exit;
    }

    $course = getCourseById($_GET['course_id'], $conn);

    if (!$course) {
        header("Location: course.php?error=Course not found");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $newName = trim($_POST['course']);
        if (empty($newName)) {
            header("Location: course-edit.php?course_id=" . $_GET['course_id'] . "&error=Course name is required");
            exit;
        }

        $sql = "UPDATE courses SET course_name = ? WHERE course_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$newName, $_GET['course_id']]);

        header("Location: course.php?success=Course updated successfully");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Admin - Edit Course</title>
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
        <h3>Edit Course</h3>
        <a href="course.php" class="btn btn-dark mb-3">Go Back</a>

        <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
        <?php } ?>

        <form method="POST" class="mt-3">
            <div class="mb-3">
                <label for="course" class="form-label">Course Name</label>
                <input type="text" class="form-control" id="course" name="course"
                       value="<?= htmlspecialchars($course['course_name']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="course.php" class="btn btn-secondary">Back</a>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $("#navLinks li:nth-child(10) a").addClass('active'); // Adjust if needed
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
