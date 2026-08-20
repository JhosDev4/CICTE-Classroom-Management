<?php
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
    include ("../req/DB_connection.php");
    include "data/teacher.php";
    include "data/subject.php";
    include "data/grade.php";
    $teachers = getAllTeachers($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin - Teachers</title>
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
      color:rgb(33, 105, 214);
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
        <a href="teacher-add.php" class="btn btn-dark">Add New Teacher</a>
     <br><br>
  <form action="teacher-search.php" method="get" class="mb-5">
    <div class="input-group">
      <input type="text" class="form-control" name="searchkey" placeholder="Search teachers...">
      <button class="btn btn-secondary"><i class="fa fa-search"></i></button>
    </div>
  </form>

  <?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger"><?= $_GET['error'] ?></div>
  <?php endif; ?>

  <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-info"><?= $_GET['success'] ?></div>
  <?php endif; ?>

  <?php if ($teachers != 0): ?>
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Username</th>
            <th>Subjects</th>
            <th>Year Level</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php $i = 0; foreach ($teachers as $teacher): $i++; ?>
          <tr>
            <td><?= $i ?></td>
            <td><?= $teacher['teacher_id'] ?></td>
            <td><a href="teacher-view.php?teacher_id=<?= $teacher['teacher_id'] ?>"><?= $teacher['fname'] ?></a></td>
            <td><?= $teacher['lname'] ?></td>
            <td><?= $teacher['username'] ?></td>
            <td>
              <?php
                $s = '';
                foreach (str_split(trim($teacher['subjects'])) as $subject) {
                  $s_temp = getAllSubjectById($subject, $conn);
                  if ($s_temp != 0) $s .= $s_temp['subject_code'] . ', ';
                }
                echo rtrim($s, ', ');
              ?>
            </td>
            <td>
              <?php
                $g = '';
                foreach (str_split(trim($teacher['grades'])) as $grade) {
                  $g_temp = getAllGradeById($grade, $conn);
                  if ($g_temp != 0) $g .= $g_temp['grade_code'] . '-' . $g_temp['grades'] . ', ';
                }
                echo rtrim($g, ', ');
              ?>
            </td>
            <td>
              <div class="d-flex gap-2">
                <a href="teacher-edit.php?teacher_id=<?= $teacher['teacher_id'] ?>" class="btn btn-sm btn-dark">Edit</a>
                <a href="teacher-delete.php?teacher_id=<?= $teacher['teacher_id'] ?>" class="btn btn-sm btn-danger">Delete</a>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-info">No teachers found.</div>
  <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  $(document).ready(function(){
             $("#navLinks li:nth-child(2) a").addClass('active');
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
