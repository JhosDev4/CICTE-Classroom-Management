<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
        include "../req/DB_connection.php";
        include "data/student.php";
        include "data/subject.php";
        include "data/grade.php";
        include "data/section.php";

        if (isset($_GET['student_id'])) {
            $student_id = $_GET['student_id'];
            $student = getAllStudentById($student_id, $conn);    
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Student - View</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="icon" href="../logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php 
        include "inc/navbar.php";
        if ($student && is_array($student)) {
    ?>
    <div class="container mt-5">
        <div class="card" style="width: 22rem;">
            <img src="../img/student-<?= htmlspecialchars($student['gender']) ?>.png" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title text-center">@<?= htmlspecialchars($student['username']) ?></h5>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">First name: <?= htmlspecialchars($student['fname']) ?></li>
                <li class="list-group-item">Last name: <?= htmlspecialchars($student['lname']) ?></li>
                <li class="list-group-item">Username: <?= htmlspecialchars($student['username']) ?></li>
                <li class="list-group-item">Address: <?= htmlspecialchars($student['address']) ?></li>
                <li class="list-group-item">Date of birth: <?= htmlspecialchars($student['date_of_birth']) ?></li>
                <li class="list-group-item">Email address: <?= htmlspecialchars($student['email_address']) ?></li>
                <li class="list-group-item">Gender: <?= htmlspecialchars($student['gender']) ?></li>
                <li class="list-group-item">Date of joined: <?= htmlspecialchars($student['date_of_joined']) ?></li>

                <li class="list-group-item">Grade: 
                    <?php 
                        $grade = $student['grade'];
                        $g = getAllGradeById($grade, $conn);
                        echo (is_array($g)) ? htmlspecialchars($g['grade_code'].'-'.$g['grades']) : 'N/A';
                    ?>
                </li>
                <li class="list-group-item">Section: 
                    <?php 
                        $section = $student['section'];
                        $s = getSectioById($section, $conn);
                        echo (is_array($s)) ? htmlspecialchars($s['section']) : 'N/A';
                    ?>
                </li>
                <br><br>
                <li class="list-group-item">Parent first name: <?= htmlspecialchars($student['parent_fname']) ?></li>
                <li class="list-group-item">Parent last name: <?= htmlspecialchars($student['parent_lname']) ?></li>
                <li class="list-group-item">Parent phone number: <?= htmlspecialchars($student['parent_phone_number']) ?></li>
            </ul>
            <div class="card-body">
                <a href="student.php" class="card-link">Go Back</a>
            </div>
        </div>
    </div>
    <?php 
        } else {
            header("Location: student.php");
            exit;
        }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
    <script>
        $(document).ready(function(){
            $("#navLinks li:nth-child(3) a").addClass('active');
        });
    </script>
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
