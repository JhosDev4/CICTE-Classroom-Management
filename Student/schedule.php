<?php  
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['student_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Student') {
        include "../req/DB_connection.php";
        include "data/student.php";
        include "data/schedule.php";
        include "data/section.php";

        $student_id = $_SESSION['student_id'];
        $student = getStudentById($student_id, $conn);
        $section_id = $student['section'];

        $section_row = getSectioById($section_id, $conn); // correct if needed
        $section = $section_row['section_id']; // e.g., "BSCPE-2101"

        $year_level = isset($_GET['year_level']) ? $_GET['year_level'] : null;
        $sections = getSchedulesBySection($conn, $section, $year_level);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Student - Schedule</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="icon" href="../logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
  body {
    background-image: url("../img/green-gradient.avif");
    background-size: cover;
    background-repeat: repeat;
    background-position: center;
  }
  table, thead, tbody, tr, th, td {
    color: white !important;
  }
  thead {
    background-color: #212529;
  }
  tbody tr {
    background-color: #343a40;
  }
  tbody tr:nth-child(odd) {
    background-color: #3e444a;
  }
  .highlight-red {
    background-color: #dc3545 !important;
    color: white !important;
    font-weight: bold;
  }
</style>

<body>
<?php 
    include "inc/navbar.php";
    if ($sections != 0) {
?>
<div class="container mt-5">

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
                </tr>
            </thead>
            <tbody>
                <?php 
                    date_default_timezone_set('Asia/Manila');
                    $currentDay = date('l'); // e.g. "Saturday"
                    $currentTime = date('H:i:s'); // Current time
                    $i = 0;
                    foreach ($sections as $section):
                        $i++;
                        $isOngoing = (
                            $section['day'] === $currentDay &&
                            $currentTime >= $section['start_time'] &&
                            $currentTime <= $section['end_time']
                        );
                        $rowClass = $isOngoing ? 'highlight-red text-center' : 'text-center';
                ?>
                <tr class="<?= $rowClass ?>">
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
        $("#navLinks li:nth-child(4) a").addClass('active');
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
