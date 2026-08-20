<?php 
session_start();
if (isset($_SESSION['admin_id']) && $_SESSION['role'] == 'Admin') {
    include "../req/DB_connection.php";
    include "data/subject.php";

    if (!isset($_GET['subject_id'])) {
        header("Location: subject.php?error=Subject ID missing");
        exit;
    }

    $subject_id = $_GET['subject_id'];
    $subject = getAllSubjectById($subject_id, $conn);

    if (!$subject) {
        header("Location: subject.php?error=Subject not found");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $new_subject = trim($_POST['subject']);
        if (!empty($new_subject)) {
            $sql = "UPDATE subjects SET subjects=? WHERE subject_id=?";
            $stmt = $conn->prepare($sql);
            $res = $stmt->execute([$new_subject, $subject_id]);

            if ($res) {
                header("Location: subject.php?success=Subject updated successfully");
                exit;
            } else {
                header("Location: subject-edit.php?subject_id=$subject_id&error=Failed to update subject");
                exit;
            }
        } else {
            header("Location: subject-edit.php?subject_id=$subject_id&error=Subject name cannot be empty");
            exit;
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Subject</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h3>Edit Subject</h3>
        <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-danger"><?= $_GET['error'] ?></div>
        <?php } ?>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Subject Name</label>
                <input type="text" class="form-control" name="subject" value="<?= htmlspecialchars($subject['subjects']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
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
