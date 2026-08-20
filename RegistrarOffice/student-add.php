<?php 
session_start();
if (isset($_SESSION['r_user_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Registrar Office') {
        include "../req/DB_connection.php";
        include "data/grade.php";
        include "data/section.php";
        $grades = getAllGrades($conn);
        $sections = getAllSections($conn);

        // Get previous input values safely
        function safeGet($key) {
            return isset($_GET[$key]) ? htmlspecialchars($_GET[$key]) : '';
        }
        $fname = safeGet('fname');
        $lname = safeGet('lname');
        $uname = safeGet('uname');
        $address = safeGet('address');
        $email = safeGet('email');
        $pfn = safeGet('pfn');
        $pln = safeGet('pln');
        $ppn = safeGet('ppn');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Registrar Office - Add Student</title>
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
        max-width: 700px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.15);
      }
      h3 {
        color: #1a3e1a;
        margin-bottom: 1rem;
      }
      hr {
        border-color: #1a3e1a;
      }
      .btn-dark {
        margin-bottom: 1.5rem;
      }
      .form-label {
        font-weight: 600;
        color: #146214;
      }
      .radio-group {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
      }
      .radio-group div {
        flex: 1 1 45%;
        font-weight: 500;
      }
      .input-group .btn {
        min-width: 90px;
      }
    </style>
</head>
<body>
  <div class="container">
    <a href="index.php" class="btn btn-dark"><i class="fa fa-arrow-left me-2"></i>Go Back</a>

    <form method="post" action="req/student-add.php" class="shadow p-4 rounded">
      <h3>Add New Student</h3>
      <hr>

      <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger" role="alert">
          <?= htmlspecialchars($_GET['error']) ?>
        </div>
      <?php endif; ?>

      <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success" role="alert">
          <?= htmlspecialchars($_GET['success']) ?>
        </div>
      <?php endif; ?>

      <div class="mb-3">
        <label class="form-label" for="fname">First Name</label>
        <input id="fname" type="text" name="fname" class="form-control" value="<?= $fname ?>" required />
      </div>

      <div class="mb-3">
        <label class="form-label" for="lname">Last Name</label>
        <input id="lname" type="text" name="lname" class="form-control" value="<?= $lname ?>" required />
      </div>

      <div class="mb-3">
        <label class="form-label" for="address">Address</label>
        <input id="address" type="text" name="address" class="form-control" value="<?= $address ?>" />
      </div>

      <div class="mb-3">
        <label class="form-label" for="email_address">Email Address</label>
        <input id="email_address" type="email" name="email_address" class="form-control" value="<?= $email ?>" />
      </div>

      <div class="mb-3">
        <label class="form-label" for="date_of_birth">Date of Birth</label>
        <input id="date_of_birth" type="date" name="date_of_birth" class="form-control" required />
      </div>

      <div class="mb-3">
        <label class="form-label">Gender</label>
        <div class="radio-group">
          <div>
            <input type="radio" id="gender_m" name="gender" value="Male" checked />
            <label for="gender_m">Male</label>
          </div>
          <div>
            <input type="radio" id="gender_f" name="gender" value="Female" />
            <label for="gender_f">Female</label>
          </div>
        </div>
      </div>

      <hr />

      <div class="mb-3">
        <label class="form-label" for="username">Username</label>
        <input id="username" type="text" name="username" class="form-control" value="<?= $uname ?>" required />
      </div>

      <div class="mb-3">
        <label class="form-label" for="passInput">Password</label>
        <div class="input-group">
          <input id="passInput" type="text" name="pass" class="form-control" required />
          <button id="gBtn" class="btn btn-secondary" type="button" title="Generate Random Password">
            Random
          </button>
        </div>
      </div>

      <hr />

      <div class="mb-3">
        <label class="form-label" for="parent_fname">Parent First Name</label>
        <input id="parent_fname" type="text" name="parent_fname" class="form-control" value="<?= $pfn ?>" />
      </div>

      <div class="mb-3">
        <label class="form-label" for="parent_lname">Parent Last Name</label>
        <input id="parent_lname" type="text" name="parent_lname" class="form-control" value="<?= $pln ?>" />
      </div>

      <div class="mb-3">
        <label class="form-label" for="parent_phone_number">Parent Phone Number</label>
        <input id="parent_phone_number" type="text" name="parent_phone_number" class="form-control" value="<?= $ppn ?>" />
      </div>

      <hr />

      <div class="mb-3">
        <label class="form-label">Grade</label>
        <div class="radio-group">
          <?php foreach ($grades as $grade): ?>
            <div>
              <input 
                type="radio" 
                id="grade_<?= $grade['grade_id'] ?>" 
                name="grade" 
                value="<?= $grade['grade_id'] ?>" 
                required 
              />
              <label for="grade_<?= $grade['grade_id'] ?>">
                <?= htmlspecialchars($grade['grade_code']) ?>-<?= htmlspecialchars($grade['grades']) ?>
              </label>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Section</label>
        <div class="radio-group">
          <?php foreach ($sections as $section): ?>
            <div>
              <input 
                type="radio" 
                id="section_<?= $section['section_id'] ?>" 
                name="section" 
                value="<?= $section['section_id'] ?>" 
                required 
              />
              <label for="section_<?= $section['section_id'] ?>">
                <?= htmlspecialchars($section['section']) ?>
              </label>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    $(document).ready(function(){
      $("#navLinks li:nth-child(3) a").addClass('active');

      function makePass(length) {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        let result = '';
        for(let i = 0; i < length; i++) {
          result += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        $('#passInput').val(result);
      }

      $('#gBtn').on('click', function(e) {
        e.preventDefault();
        makePass(8); // 8-character password for better security
      });
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
