<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Classroom Management</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="icon" href="CICTElogo.png" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
 
    <style>
        body {
        background: url('img/wlc.jpg') no-repeat center center fixed;
        background-size: cover;
        }
    </style>

  <form class="p-4 rounded shadow bg-white" method="post" action="/System_Project/req/login.php" style="width: 100%; max-width: 360px;">
    <div class="text-center mb-3">
      <img src="img/CICTElogo.png" width="80" alt="CICTE Logo" />
      <h4 class="mt-3">Login</h4>
    </div>

    <?php if (isset($_GET['error'])): ?>
      <div class="alert alert-danger"><?= $_GET['error'] ?></div>
    <?php endif; ?>

    <div class="mb-3">
      <label class="form-label">Username</label>
      <input type="text" class="form-control" name="uname" required />
    </div>

    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" class="form-control" name="pass" required />
    </div>

    <div class="mb-3">
      <label class="form-label">Login As</label>
      <select class="form-select" name="role" required>
        <option value="1">Admin</option>
        <option value="2">Teacher</option>
        <option value="3">Student</option>
        <option value="4">Registrar Office</option>
      </select>
    </div>

    <div class="d-grid gap-2">
      <button type="submit" class="btn btn-dark">Login</button>
      <a href="index.php" class="btn btn-outline-secondary">Home</a>
    </div>

    <p class="text-center text-muted mt-4 mb-0 small">&copy; 2025 CICTE Classroom Management</p>
  </form>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
