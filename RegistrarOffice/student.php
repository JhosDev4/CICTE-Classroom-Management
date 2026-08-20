<?php 
session_start();
if (isset($_SESSION['r_user_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Registrar Office') {
        include "../req/DB_connection.php";
        include "data/student.php";
        include "data/grade.php";
        $students = getAllStudents($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Registrar Office - Students</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="icon" href="../logo.png" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <style>
    body {
      background-image: url("../img/green-gradient.avif");
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      min-height: 100vh;
      padding: 2rem;
    }
    .container {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 12px;
      padding: 2rem;
      box-shadow: 0 6px 18px rgba(0,0,0,0.15);
      max-width: 960px;
    }
    .table thead {
      background-color: #1a3e1a;
      color: #fff;
    }
    .table tbody tr:hover {
      background-color: #d7f3d7;
      cursor: pointer;
    }
    .btn-group {
      margin-bottom: 1rem;
    }
    form input.form-control {
      max-width: 300px;
    }
    .alert {
      margin-top: 1rem;
    }
    a.student-link {
      color: #146214;
      text-decoration: none;
      font-weight: 600;
    }
    a.student-link:hover {
      text-decoration: underline;
      color: #0a380a;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h2 class="mb-0">Students List</h2>
    <div class="btn-group">
      <a href="student-add.php" class="btn btn-success">
        <i class="fa fa-user-plus me-2" aria-hidden="true"></i> Register New Student
      </a>
      <a href="index.php" class="btn btn-secondary">
        <i class="fa fa-arrow-left me-2" aria-hidden="true"></i> Go Back
      </a>
    </div>
  </div>

  <form action="student-search.php" method="get" class="mb-4 d-flex flex-wrap gap-2 align-items-center">
    <input 
      type="text" 
      name="searchKey" 
      class="form-control" 
      placeholder="Search by name, ID, username..." 
      aria-label="Search Students" 
      autocomplete="off"
    />
    <button class="btn btn-primary" type="submit" aria-label="Search">
      <i class="fa fa-search" aria-hidden="true"></i>
    </button>
  </form>

  <?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger" role="alert">
      <?=htmlspecialchars($_GET['error'])?>
    </div>
  <?php endif; ?>

  <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success" role="alert">
      <?=htmlspecialchars($_GET['success'])?>
    </div>
  <?php endif; ?>

  <?php if ($students && count($students) > 0): ?>
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead>
        <tr>
          <th scope="col" style="width: 5%;">#</th>
          <th scope="col" style="width: 15%;">Student ID</th>
          <th scope="col">First Name</th>
          <th scope="col">Last Name</th>
          <th scope="col">Username</th>
          <th scope="col" style="width: 15%;">Grade</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($students as $i => $student): ?>
          <tr>
            <th scope="row"><?= $i + 1 ?></th>
            <td><?= htmlspecialchars($student['student_id']) ?></td>
            <td>
              <a class="student-link" href="student-view.php?student_id=<?= urlencode($student['student_id']) ?>">
                <?= htmlspecialchars($student['fname']) ?>
              </a>
            </td>
            <td><?= htmlspecialchars($student['lname']) ?></td>
            <td><?= htmlspecialchars($student['username']) ?></td>
            <td>
              <?php 
                $grade = $student['grade'];
                $g_temp = getGradeById($grade, $conn);
                if ($g_temp != 0) {
                  echo htmlspecialchars($g_temp['grade_code']) . '-' . htmlspecialchars($g_temp['grades']);
                } else {
                  echo '-';
                }
              ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php else: ?>
    <div class="alert alert-info text-center" role="alert">
      No students found.
    </div>
  <?php endif; ?>
</div>

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
        header("Location: ../login.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>
