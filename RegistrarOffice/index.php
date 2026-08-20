<?php 
session_start();
if (isset($_SESSION['r_user_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Registrar Office') {
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Registrar Office - Home</title>
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
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 2rem;
    }
    .dashboard-container {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 12px;
      padding: 2.5rem 3rem;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
      max-width: 600px;
      width: 100%;
    }
    .dashboard-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      gap: 1.5rem;
    }
    .dashboard-btn {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 1.75rem 1rem;
      font-size: 1.25rem;
      border-radius: 10px;
      transition: background-color 0.3s ease, transform 0.2s ease;
      color: #fff;
      text-decoration: none;
      user-select: none;
      box-shadow: 0 4px 12px rgb(0 0 0 / 0.1);
    }
    .dashboard-btn i {
      font-size: 2.8rem;
      margin-bottom: 0.5rem;
    }
    .dashboard-btn:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 20px rgb(0 0 0 / 0.15);
      text-decoration: none;
    }
    .btn-register {
      background-color: #1a3e1a;
    }
    .btn-register:hover {
      background-color: #146214;
    }
    .btn-all-students {
      background-color: #2e2e2e;
    }
    .btn-all-students:hover {
      background-color: #111111;
    }
    .btn-logout {
      background-color: #ffc107;
      color: #212529;
    }
    .btn-logout:hover {
      background-color: #e0a800;
      color: #212529;
    }
  </style>
</head>
<body>

  <div class="dashboard-container text-center" role="main" aria-label="Registrar Office Dashboard">
    <h1 class="mb-4 fw-bold">Registrar Office Dashboard</h1>
    <div class="dashboard-grid">
      <a href="student-add.php" class="dashboard-btn btn-register" role="button" aria-label="Register Student">
        <i class="fa fa-user-plus" aria-hidden="true"></i>
        Register Student
      </a>
      <a href="student.php" class="dashboard-btn btn-all-students" role="button" aria-label="View All Students">
        <i class="fa fa-users" aria-hidden="true"></i>
        All Students
      </a>
      <a href="../logout.php" class="dashboard-btn btn-logout" role="button" aria-label="Logout">
        <i class="fa fa-sign-out" aria-hidden="true"></i>
        Logout
      </a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    $(document).ready(function(){
      $("#navLinks li:nth-child(1) a").addClass('active');
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
