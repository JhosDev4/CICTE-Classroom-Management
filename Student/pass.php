<?php 
session_start();
if (isset($_SESSION['student_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Student') {
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Student - Change Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="icon" href="../logo.png" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
  />
  <style>
    body {
      background: url("../img/green-gradient.avif") center center / cover no-repeat fixed;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    .overlay {
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0, 0, 0, 0.4);
      z-index: -1;
    }
    .form-container {
      flex-grow: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 2rem;
    }
    form.form-w {
      background: #ffffffcc;
      padding: 2.5rem 3rem;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
      max-width: 400px;
      width: 100%;
    }
    form.form-w h3 {
      margin-bottom: 1.5rem;
      font-weight: 600;
      color: #10411e;
      text-align: center;
    }
    .form-label {
      font-weight: 600;
      color: #0b3d0b;
    }
    .input-group .btn {
      min-width: 100px;
    }
    .password-toggle {
      cursor: pointer;
      user-select: none;
      margin-left: -35px;
      margin-top: 8px;
      color: #555;
    }
  </style>
</head>
<body>
  <div class="overlay"></div>
  <?php include "inc/navbar.php"; ?>

  <div class="form-container">
    <form
      method="post"
      action="req/student-change.php"
      id="change_password"
      class="form-w shadow"
      novalidate
    >
      <h3>Change Password</h3>
      <hr />

      <?php if (isset($_GET['perror'])): ?>
      <div class="alert alert-danger" role="alert">
        <?= htmlspecialchars($_GET['perror']) ?>
      </div>
      <?php endif; ?>

      <?php if (isset($_GET['psuccess'])): ?>
      <div class="alert alert-success" role="alert">
        <?= htmlspecialchars($_GET['psuccess']) ?>
      </div>
      <?php endif; ?>

      <div class="mb-3">
        <label for="old_pass" class="form-label">Old Password</label>
        <input
          type="password"
          class="form-control"
          name="old_pass"
          id="old_pass"
          required
          minlength="6"
          autocomplete="current-password"
        />
      </div>

      <div class="mb-3">
        <label for="new_pass" class="form-label">New Password</label>
        <div class="input-group">
          <input
            type="password"
            class="form-control"
            name="new_pass"
            id="new_pass"
            required
            minlength="6"
            autocomplete="new-password"
          />
          <button class="btn btn-secondary" id="gBtn" type="button" title="Generate Random Password">
            Random
          </button>
          <span class="password-toggle" id="toggleNewPass" title="Show/Hide Password">
            <i class="fa fa-eye"></i>
          </span>
        </div>
      </div>

      <div class="mb-3">
        <label for="c_new_pass" class="form-label">Confirm New Password</label>
        <div class="input-group">
          <input
            type="password"
            class="form-control"
            name="c_new_pass"
            id="c_new_pass"
            required
            minlength="6"
            autocomplete="new-password"
          />
          <span class="password-toggle" id="toggleConfirmPass" title="Show/Hide Password">
            <i class="fa fa-eye"></i>
          </span>
        </div>
      </div>

      <button type="submit" class="btn btn-primary w-100">Change Password</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    $(function () {
      // Highlight nav link for Student menu (3rd item)
      $("#navLinks li:nth-child(3) a").addClass("active");

      // Generate random password function
      function makePass(length) {
        const chars =
          "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        let result = "";
        for (let i = 0; i < length; i++) {
          result += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return result;
      }

      // Generate button click event
      $("#gBtn").on("click", function (e) {
        e.preventDefault();
        const randomPass = makePass(8);
        $("#new_pass").val(randomPass);
        $("#c_new_pass").val(randomPass);
      });

      // Toggle password visibility
      function togglePasswordVisibility(toggleId, inputId) {
        $(toggleId).on("click", function () {
          const input = $(inputId);
          const icon = $(this).find("i");
          if (input.attr("type") === "password") {
            input.attr("type", "text");
            icon.removeClass("fa-eye").addClass("fa-eye-slash");
          } else {
            input.attr("type", "password");
            icon.removeClass("fa-eye-slash").addClass("fa-eye");
          }
        });
      }
      togglePasswordVisibility("#toggleNewPass", "#new_pass");
      togglePasswordVisibility("#toggleConfirmPass", "#c_new_pass");

      // Client-side form validation for password confirmation
      $("#change_password").on("submit", function (e) {
        const newPass = $("#new_pass").val();
        const confirmPass = $("#c_new_pass").val();
        if (newPass !== confirmPass) {
          e.preventDefault();
          alert("New password and confirmation do not match.");
        }
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
