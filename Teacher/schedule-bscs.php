<?php
session_start();
if (isset($_SESSION['teacher_id']) && $_SESSION['role'] == 'Teacher') {
    include "../req/DB_connection.php";
    include "data/schedule.php";
    include "data/teacher.php";

    $teacher_id = $_SESSION['teacher_id'];
    $teacher = getTeacherById($teacher_id, $conn);
    $instructor_name = $teacher['fname'] . ' ' . $teacher['lname'];
    $course = 'BSCS';

    if (isset($_GET['year_level']) && in_array($_GET['year_level'], ['1', '2', '3', '4'])) {
        $year_level = $_GET['year_level'];
        $sections = getSchedulesByInstructorCourseAndYear($conn, $instructor_name, $course, $year_level);
    } else {
        $sections = getSchedulesByInstructorAndCourse($conn, $instructor_name, $course);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BSCS Instructor Schedule</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../logo.png">
</head>
<style>
    body {
        background-image: url('../img/green-gradient.avif');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        color: white;
    }

    h3, label, .form-label, .alert, a, table, th, td {
        color: white !important;
    }

    select.form-select,
    select.form-select option {
        background-color: rgba(255, 255, 255, 0.9);
        color: black;
    }

    select.form-select:focus {
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(255,255,255,0.25);
    }

    .table {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(255, 255, 255, 0.05);
    }

    .table-bordered th, .table-bordered td {
        border-color: #ddd;
    }

    .form-select, .form-control {
        background-color: rgba(255, 255, 255, 0.9);
        color: black;
    }

    .btn-secondary {
        background-color: rgba(255, 255, 255, 0.2);
        color: white;
        border: 1px solid white;
    }

    .btn-secondary:hover {
        background-color: rgba(255, 255, 255, 0.4);
        color: black;
    }

    .alert-info, .alert-danger {
        background-color: rgba(0, 0, 0, 0.4);
        border: none;
        color: white;
    }
</style>

<body>
<?php include "inc/navbar.php"; ?>

<div class="container mt-5">
    <h3>BSCS Schedule (Your Classes)</h3>
    <a href="schedule.php" class="btn btn-secondary">Back</a>
    <div class="mb-3">
        <form method="GET" class="mb-3">
            <label class="form-label">Select Year Level</label>
            <select class="form-select" name="year_level" onchange="this.form.submit()">
                <option value="">-- Select Year Level --</option>
                <option value="1" <?= isset($_GET['year_level']) && $_GET['year_level'] == '1' ? 'selected' : '' ?>>1st-yr</option>
                <option value="2" <?= isset($_GET['year_level']) && $_GET['year_level'] == '2' ? 'selected' : '' ?>>2nd-yr</option>
                <option value="3" <?= isset($_GET['year_level']) && $_GET['year_level'] == '3' ? 'selected' : '' ?>>3rd-yr</option>
                <option value="4" <?= isset($_GET['year_level']) && $_GET['year_level'] == '4' ? 'selected' : '' ?>>4th-yr</option>
            </select>
        </form>
    </div>

    <?php if (isset($_GET['error'])) { ?>
        <div class="alert alert-danger mt-3" role="alert">
            <?= $_GET['error'] ?>
        </div>
    <?php } ?>

    <?php if (isset($_GET['success'])) { ?>
        <div class="alert alert-info mt-3" role="alert">
            <?= $_GET['success'] ?>
        </div>
    <?php } ?>

    <?php if ($sections != 0) { ?>
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
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <div class="alert alert-info mt-5" role="alert">No BSCS schedules found!</div>
    <?php } ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
} else {
    header("Location: ../login.php");
    exit;
}
?>
