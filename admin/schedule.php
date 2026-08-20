<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        include "../req/DB_connection.php";
        include "data/schedule.php";
        $sections = getAllSchedules($conn); // Update this to actually return schedule data

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - Schedule</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="icon" href="../logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
  /* Make all table text white */
  table, thead, tbody, tr, th, td {
    color: white !important;
  }

  /* Optional: make header background dark */
  thead {
    background-color: #212529; /* Bootstrap dark */
  }

  /* Optional: table body background */
  tbody tr {
    background-color: #343a40;
  }

  /* Optional: striped rows */
  tbody tr:nth-child(odd) {
    background-color: #3e444a;
  }
</style>


<body>
<?php 
    include "inc/navbar.php";
    if ($sections != 0) {
?>
<div class="container mt-5">
    <a href="schedule-add.php" class="btn btn-dark">Add New Schedule</a>
    <a href="schedule-view.php" class="btn btn-dark">Class Room view</a>
    <a href="schedule-bscpe.php" class="btn btn-dark">BSCpE</a>
    <a href="schedule-bsit.php" class="btn btn-dark">BSIT</a>
    <a href="schedule-bscs.php" class="btn btn-dark">BSCS</a>

    <?php if (isset($_GET['error'])) { ?>
        <div class="alert alert-danger mt-3 n-table" role="alert">
            <?= $_GET['error'] ?>
        </div>
    <?php } ?>

    <?php if (isset($_GET['success'])) { ?>
        <div class="alert alert-info mt-3 n-table" role="alert">
            <?= $_GET['success'] ?>
        </div>
    <?php } ?>

    <div class="table-responsive mt-3">
        <table class="table table-bordered table-striped">
            <thead class="table-dark text-center">
                <tr>
                    <th>#</th>
                    <th>Instructor</th>
                    <th>Course</th>
                    <th>Subject</th>
                    <th>Room</th>
                    <th>Section</th>
                    <th>Year Level</th>
                    <th>Day of Class</th>
                    <th>Start of Class</th>
                    <th>End of Class</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 0; foreach ($sections as $section): $i++; ?>
                <tr class="text-center">
                    <th><?= $i ?></th>
                    <td><?= $section['instructor'] ?></td>
                    <td><?= $section['course'] ?></td>
                    <td><?= $section['subject'] ?></td>
                    <td><?= $section['room'] ?></td>
                    <td><?= $section['section'] ?></td>
                    <td><?= $section['year_level'] ?></td>
                    <td><?= $section['day'] ?></td>
                    <td><?= $section['start_time'] ?></td>
                    <td><?= $section['end_time'] ?></td>
                    <td>
                        <a href="schedule-edit.php?schedule_id=<?= $section['schedule_id'] ?>" class="btn btn-warning">Edit</a>
                        <a href="schedule-delete.php?schedule_id=<?= $section['schedule_id'] ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php } else { ?>
    <div class="alert alert-info mt-5" role="alert">No schedules found!</div>
<?php } ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function(){
        $("#navLinks li:nth-child(9) a").addClass('active');
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
