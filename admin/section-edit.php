<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])     &&
    isset($_GET['section_id'])) {

    if ($_SESSION['role'] == 'Admin') {
      
       include "../req/DB_connection.php";
       include "data/section.php";
       $section_id = $_GET['section_id'];
       $section = getSectioById($section_id, $conn);

       if ($section == 0) {
         header("Location: section.php");
         exit;
       }
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - Edit Section</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="icon" href="../logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body {
            background: url("../img/green-gradient.avif") no-repeat center center fixed;
            background-size: cover;
            color: white;
        }

        .form-label,
        .form-control,
        .form-control::placeholder,
        .alert {
            color: white;
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid white;
        }

        .alert-danger {
            background-color: rgba(255, 0, 0, 0.3);
            border-color: red;
        }

        .alert-success {
            background-color: rgba(0, 128, 0, 0.3);
            border-color: green;
        }

        .container h3, .container a, .container hr {
            color: white;
        }
    </style>
</head>
<body>
    <?php include "inc/navbar.php"; ?>
    <div class="container mt-5">
        <a href="section.php" class="btn btn-dark">Go Back</a>

        <form method="post" class="shadow p-3 mt-5 form-w" action="req/section-edit.php">
            <h3>Edit Section</h3><hr>

            <?php if (isset($_GET['error'])) { ?>
              <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($_GET['error']) ?>
              </div>
            <?php } ?>

            <?php if (isset($_GET['success'])) { ?>
              <div class="alert alert-success" role="alert">
                <?= htmlspecialchars($_GET['success']) ?>
              </div>
            <?php } ?>

            <div class="mb-3">
                <label class="form-label">Section</label>
                <input type="text" class="form-control" name="section" 
                       value="<?= htmlspecialchars($section['section']) ?>">
            </div>

            <input type="hidden" class="form-control" name="section_id" 
                   value="<?= htmlspecialchars($section['section_id']) ?>">

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
    <script>
        $(document).ready(function(){
            $("#navLinks li:nth-child(4) a").addClass('active');
        });
    </script>
</body>
</html>
<?php 

  } else {
    header("Location: grade.php");
    exit;
  } 
} else {
	header("Location: grade.php");
	exit;
} 
?>
