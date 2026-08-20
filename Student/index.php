<?php 
session_start();
if (isset($_SESSION['student_id']) && isset($_SESSION['role'])) {
  if ($_SESSION['role'] == 'Student') {
    include "../req/DB_connection.php";
    include "data/student.php";
    include "data/subject.php";
    include "data/section.php";

    $student_id = $_SESSION['student_id'];
    $student = getStudentById($student_id, $conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Student - Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="icon" href="../logo.png" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
  />
</head>
<style>
  body {
    background-image: url("../img/green-gradient.avif");
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
  }
</style>
<body>
  <?php include "inc/navbar.php"; ?>

  <?php if ($student != 0) : ?>
  <div class="container mt-5">
    <div class="row">
      <!-- Left: Profile Image + Toggle Button -->
      <div class="col-md-4">
        <div class="card">
          <img src="../img/student-<?= $student['gender'] ?>.png" class="card-img-top" alt="Student Image" />
          <div class="card-body text-center">
            <h5 class="card-title">@<?= $student['username'] ?></h5>
            <button id="toggleDetailsBtn" class="btn btn-sm btn-primary mt-2">Show Details</button>
          </div>
        </div>
        <!-- Hidden Details Section (Below Image) -->
        <div id="studentDetails" class="mt-3" style="display:none;">
          <div class="card">
            <div class="card-header bg-success text-white">Student Details</div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">First name: <?= $student['fname'] ?></li>
              <li class="list-group-item">Last name: <?= $student['lname'] ?></li>
              <li class="list-group-item">Username: <?= $student['username'] ?></li>
              <li class="list-group-item">Address: <?= $student['address'] ?></li>
              <li class="list-group-item">Date of birth: <?= $student['date_of_birth'] ?></li>
              <li class="list-group-item">Email address: <?= $student['email_address'] ?></li>
              <li class="list-group-item">Gender: <?= $student['gender'] ?></li>
              <li class="list-group-item">Date of joined: <?= $student['date_of_joined'] ?></li>
              <li class="list-group-item">
                Section:
                <?php 
                  $section = $student['section'];
                  $s = getSectioById($section, $conn);
                  echo $s['section'];
                ?>
              </li>
              <li class="list-group-item">Parent first name: <?= $student['parent_fname'] ?></li>
              <li class="list-group-item">Parent last name: <?= $student['parent_lname'] ?></li>
              <li class="list-group-item">Parent phone number: <?= $student['parent_phone_number'] ?></li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Right: Navigation Buttons -->
      <div class="col-md-8">
      <ul
        class="navbar-nav me-auto mb-2 mb-lg-0 d-flex justify-content-between text-center"
        id="navLinks"
        style="gap: 1rem;"
      >
        <li class="nav-item flex-fill">
          <a
            href="schedule-view.php"
            class="btn w-100 py-4 text-white d-flex justify-content-between align-items-center"
            style="background-color: #3A8C56;"
          >
            Classroom
            <i class="fa fa-columns fs-1 ms-2"></i>
          </a>
        </li>
        <li class="nav-item flex-fill">
          <a
            href="pass.php"
            class="btn w-100 py-4 text-white d-flex justify-content-between align-items-center"
            style="background-color: #3A8C56;"
          >
            Change Password
            <i class="fa fa-lock fs-1 ms-2"></i>
          </a>
        </li>
        <li class="nav-item flex-fill">
          <a
            href="schedule.php"
            class="btn w-100 py-4 text-white d-flex justify-content-between align-items-center"
            style="background-color: #3A8C56;"
          >
            Schedule
            <i class="fa fa-calendar fs-1 ms-2"></i>
          </a>
        </li>
      </ul>
    </div>

    </div>
  </div>

  <?php else: 
    header("Location: student.php");
    exit;
  endif; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    $(document).ready(function () {
      $("#toggleDetailsBtn").click(function () {
        $("#studentDetails").slideToggle();
        $(this).text(function (i, text) {
          return text === "Show Details" ? "Hide Details" : "Show Details";
        });
      });

      $("#navLinks li:nth-child(1) a").addClass("active");
    });
  </script>
</body>
</html>

<?php
  } else {
    header("Location: ../login.php");
    exit;
  }
} else {
  header("Location: ../login.php");
  exit;
}
?>
