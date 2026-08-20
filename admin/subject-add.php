<?php 
session_start();
if (isset($_SESSION['admin_id']) && $_SESSION['role'] == 'Admin') {
    include "../req/DB_connection.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $subject = trim($_POST['subject']);
        if (!empty($subject)) {
            $sql = "INSERT INTO subjects(subjects) VALUES(?)";
            $stmt = $conn->prepare($sql);
            $res = $stmt->execute([$subject]);

            if ($res) {
                header("Location: subject.php?success=Subject added successfully");
                exit;
            } else {
                header("Location: subject-add.php?error=Failed to add subject");
                exit;
            }
        } else {
            header("Location: subject-add.php?error=Subject name cannot be empty");
            exit;
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Subject</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h3>Add New Subject</h3>
        <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-danger"><?= $_GET['error'] ?></div>
        <?php } ?>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Subject Name</label>
                <input type="text" class="form-control" name="subject" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Subject</button>
            <a href="subject.php" class="btn btn-secondary">Back</a>
        </form>
    </div>
</body>
</html>
<?php 
} else {
    header("Location: ../login.php");
    exit;
}
?>
