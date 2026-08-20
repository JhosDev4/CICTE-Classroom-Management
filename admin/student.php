<?php
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
    include("../req/DB_connection.php");
    include "data/student.php";
    include "data/grade.php";
    $students = getAllStudents($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin - Students</title>
  <link rel="icon" href="../CICTElogo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
  <style>
    body {
      background-color: #f9f9f9;
      font-family: 'Segoe UI', sans-serif;
      color: #333;
    }
    .container {
      max-width: 960px;
    }
    h1 {
      font-size: 24px;
      font-weight: 600;
      margin-bottom: 20px;
    }
    .btn {
      border-radius: 8px;
    }
    .btn-dark {
      background-color: #222;
      border: none;
    }
    .btn-dark:hover {
      background-color: #444;
    }
    .btn-danger {
      border: none;
    }
    .form-control {
      border-radius: 8px;
    }
    .table {
      background: white;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 0 5px rgba(0,0,0,0.05);
    }
    th {
      background-color: #f2f2f2;
      font-weight: 500;
    }
    td, th {
      vertical-align: middle;
    }
    a {
      color: #0d6efd;
      text-decoration: none;
    }
    a:hover {
      text-decoration: underline;
    }
    .input-group .form-control {
      border-right: 0;
    }
    .input-group .btn {
      border-left: 0;
    }
  </style>
</head>
<body>
<?php include "inc/navbar.php"; ?>

<div class="container mt-5">
    <a href="student-add.php" class="btn btn-dark">Add New Student</a>
    <br><br>
    <form action="student-search.php" method="get" class="mb-5">
      <div class="input-group">
        <input type="text" class="form-control" name="searchkey" placeholder="Search students...">
        <button class="btn btn-secondary"><i class="fa fa-search"></i></button>
      </div>
    </form>

    <?php if (isset($_GET['error'])): ?>
      <div class="alert alert-danger"><?= $_GET['error'] ?></div>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
      <div class="alert alert-info"><?= $_GET['success'] ?></div>
    <?php endif; ?>

    <?php if ($students != 0): ?>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>ID</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Username</th>
              <th>Grade</th>
              <th style="white-space: nowrap; width: 120px;">Action</th>
            </tr>
          </thead>
          <tbody>
          <?php $i = 0; foreach ($students as $student): $i++; ?>
            <tr>
              <td><?= $i ?></td>
              <td><?= $student['student_id'] ?></td>
              <td><a href="student-view.php?student_id=<?= $student['student_id'] ?>"><?= $student['fname'] ?></a></td>
              <td><?= $student['lname'] ?></td>
              <td><?= $student['username'] ?></td>
              <td>
                <?php
                  $g_temp = getAllGradeById($student['grade'], $conn);
                  if ($g_temp != 0) echo $g_temp['grade_code'] . '-' . $g_temp['grades'];
                ?>
              </td>
              <td style="white-space: nowrap;">
                <div class="d-flex gap-2">
                  <a href="student-edit.php?student_id=<?= $student['student_id'] ?>" class="btn btn-sm btn-dark">Edit</a>
                  <a href="student-delete.php?student_id=<?= $student['student_id'] ?>" class="btn btn-sm btn-danger">Delete</a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <div class="alert alert-info">No students found.</div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
?>
