<?php 
session_start();
if (isset($_SESSION['r_user_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Registrar Office') {
        include "../req/DB_connection.php";
        include "data/student.php";
        include "data/subject.php";
        include "data/grade.php";
        include "data/section.php";

        if(isset($_GET['student_id'])){
            $student_id = $_GET['student_id'];
            $student = getStudentById($student_id, $conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Registrar Office - View Student</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="icon" href="../logo.png" />
    <style>
      body {
      background-image: url("../img/green-gradient.avif");
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      min-height: 100vh;
      padding: 2rem;
    }
      .student-card {
        max-width: 400px;
        margin: 3rem auto;
        box-shadow: 0 4px 12px rgb(0 0 0 / 0.1);
        border-radius: 12px;
        overflow: hidden;
        background-color: #fff;
      }
      .student-card img {
        width: 100%;
        height: auto;
        object-fit: cover;
        background-color: #e9ecef;
      }
      .student-card .card-title {
        font-weight: 700;
        font-size: 1.5rem;
      }
      .list-group-item {
        font-size: 0.95rem;
      }
      .list-group-item strong {
        width: 130px;
        display: inline-block;
        color: #495057;
      }
      .btn-back {
        display: block;
        max-width: 400px;
        margin: 1.5rem auto 0;
      }
    </style>
</head>
<body>
    <?php if ($student != 0) { ?>
    <div class="student-card card">
        <img src="../img/student-<?=$student['gender']?>.png" alt="Student Photo" />
        <div class="card-body text-center">
            <h5 class="card-title">@<?=$student['username']?></h5>
            <p class="text-muted mb-0"><?=$student['fname']?> <?=$student['lname']?></p>
        </div>
        <ul class="list-group list-group-flush px-3">
            <li class="list-group-item"><strong>First Name:</strong> <?=$student['fname']?></li>
            <li class="list-group-item"><strong>Last Name:</strong> <?=$student['lname']?></li>
            <li class="list-group-item"><strong>Username:</strong> <?=$student['username']?></li>
            <li class="list-group-item"><strong>Address:</strong> <?=$student['address']?></li>
            <li class="list-group-item"><strong>Date of Birth:</strong> <?=$student['date_of_birth']?></li>
            <li class="list-group-item"><strong>Email:</strong> <?=$student['email_address']?></li>
            <li class="list-group-item"><strong>Gender:</strong> <?=$student['gender']?></li>
            <li class="list-group-item"><strong>Date Joined:</strong> <?=$student['date_of_joined']?></li>
            <li class="list-group-item"><strong>Grade:</strong> 
                <?php 
                  $grade = $student['grade'];
                  $g = getGradeById($grade, $conn);
                  echo $g['grade_code'].'-'.$g['grades'];
                ?>
            </li>
            <li class="list-group-item"><strong>Section:</strong> 
                <?php 
                  $section = $student['section'];
                  $s = getSectioById($section, $conn);
                  echo $s['section'];
                ?>
            </li>
            <li class="list-group-item"><strong>Parent First Name:</strong> <?=$student['parent_fname']?></li>
            <li class="list-group-item"><strong>Parent Last Name:</strong> <?=$student['parent_lname']?></li>
            <li class="list-group-item"><strong>Parent Phone:</strong> <?=$student['parent_phone_number']?></li>
        </ul>
    </div>
    <a href="student.php" class="btn btn-outline-primary btn-back">← Back to Students</a>
    <?php } else {
        header("Location: student.php");
        exit;
    } ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php 
        } else {
            header("Location: student.php");
            exit;
        }
    } else {
        header("Location: ../login.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>
