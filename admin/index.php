<?php
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if($_SESSION['role'] == 'Admin'){

              
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin - Home</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="style.css" />
  <link rel="icon" href="../CICTElogo.png" />

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <?php
        include "inc/navbar.php";

    ?>
       <div class="container mt-5 text-center">
        <div class="row g-3">
            <div class="col-md-3">
            <a href="teacher.php" class="btn w-100 py-4 text-white" style="background-color: #63A67B;">
                <i class="fa fa-user-md fs-1"></i><br>Teachers
            </a>
            </div>
            <div class="col-md-3">
            <a href="student.php" class="btn w-100 py-4 text-white" style="background-color: #63A67B;">
                <i class="fa fa-graduation-cap fs-1"></i><br>Students
            </a>
            </div>
            <div class="col-md-3">
            <a href="class.php" class="btn w-100 py-4 text-white" style="background-color: #63A67B;">
                <i class="fa fa-columns fs-1"></i><br>Class
            </a>
            </div>
            <div class="col-md-3">
            <a href="grade.php" class="btn w-100 py-4 text-white" style="background-color: #63A67B;">
                <i class="fa fa-level-up fs-1"></i><br>Year Level
            </a>
            </div>

            <div class="col-md-3">
            <a href="section.php" class="btn w-100 py-4 text-white" style="background-color: #3A8C56;">
                <i class="fa fa-cubes fs-1"></i><br>Sections
            </a>
            </div>
            <div class="col-md-3">
            <a href="subject.php" class="btn w-100 py-4 text-white" style="background-color: #3A8C56;">
                <i class="fa fa-book fs-1"></i><br>Subject
            </a>
            </div>
            <div class="col-md-3">
            <a href="room.php" class="btn w-100 py-4 text-white" style="background-color: #3A8C56;">
                <i class="fa fa-columns fs-1"></i><br>Classroom
            </a>
            </div>
            <div class="col-md-3">
            <a href="schedule.php" class="btn w-100 py-4 text-white" style="background-color: #3A8C56;">
                <i class="fa fa-calendar fs-1"></i><br>Schedule
            </a>
            </div>

            <div class="col-md-3">
            <a href="registrar-office.php" class="btn w-100 py-4 text-white" style="background-color: rgb(40, 119, 66);">
                <i class="fa fa-pencil-square fs-1"></i><br>Registrar Office
            </a>
            </div>
            <div class="col-md-3">
            <a href="course.php" class="btn w-100 py-4 text-white" style="background-color: rgb(40, 119, 66);">
                <i class="fa fa-book fs-1"></i><br>Course
            </a>
            </div>
            <div class="col-md-3">
            <a href="message.php" class="btn w-100 py-4 text-white" style="background-color: rgb(40, 119, 66);">
                <i class="fa fa-envelope fs-1"></i><br>Message
            </a>
            </div>
            <div class="col-md-3">
              <a href="../logout.php" class="btn text-white w-100 py-4" style="background-color: rgba(2, 71, 81, 0.47);">
                <i class="fa fa-sign-out fs-1"></i><br>Logout
              </a>
            </div>
        </div>
        </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    $(document).ready(function(){
       $("#navLinks li:nth-child(1) a").addClass('active');
     });
    </script>
</body>
</html>
<?php 
    }else {
        header("Location: ../login.php");
        exit;
    } 
}else {
    header("Location: ../login.php");
    exit;
} 

?>