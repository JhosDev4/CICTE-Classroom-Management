<?php
session_start();
if (isset($_SESSION['admin_id']) && $_SESSION['role'] == 'Admin') {
    include "../req/DB_connection.php";

    $error = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $instructor  = $_POST['instructor'] ?? '';
        $course      = $_POST['course'] ?? '';
        $subject     = $_POST['subject'] ?? '';
        $room        = $_POST['room'] ?? '';
        $section     = $_POST['section'] ?? '';
        $year_level  = $_POST['year_level'] ?? '';
        $dayArray    = $_POST['day'] ?? [];
        $start_time  = $_POST['start_time'] ?? '';
        $end_time    = $_POST['end_time'] ?? '';

        $day = implode(', ', $dayArray);

        if (
            empty($instructor) || empty($course) || empty($subject) || empty($room) ||
            empty($section) || empty($year_level) || empty($dayArray) ||
            empty($start_time) || empty($end_time)
        ) {
            $error = "All fields are required!";
        } else {
            // Check for conflicts in the same room
            foreach ($dayArray as $selectedDay) {
                $query = "SELECT * FROM schedules WHERE room = ? AND FIND_IN_SET(?, day) 
                          AND (
                              (start_time < ? AND end_time > ?) OR
                              (start_time < ? AND end_time > ?) OR
                              (start_time >= ? AND end_time <= ?)
                          )";
                $stmt = $conn->prepare($query);
                $stmt->execute([
                    $room, $selectedDay,
                    $end_time, $end_time,
                    $start_time, $start_time,
                    $start_time, $end_time
                ]);
                if ($stmt->rowCount() > 0) {
                    $error = "Conflict detected: Another class is already scheduled in $room on $selectedDay between $start_time and $end_time.";
                    break;
                }
            }

            // If no error, insert the schedule
            if (!$error) {
                $sql = "INSERT INTO schedules (instructor, course, subject, room, section, year_level, day, start_time, end_time)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    $instructor, $course, $subject, $room, $section, $year_level,
                    $day, $start_time, $end_time
                ]);

                header("Location: schedule.php?success=New schedule added successfully");
                exit;
            }
        }
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add New Schedule</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>
<style>
    body {
        background-image: url('../img/green-gradient.avif');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        color: white; /* Make general text white */
    }

    label, h3, a, .form-label {
        color: white !important; /* Ensure labels and headings are white */
    }

    .form-control {
        background-color: rgba(255, 255, 255, 0.8); /* light background */
        color: #000; /* dark text inside input fields for readability */
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

    .alert {
        color: white;
        background-color: rgba(220, 53, 69, 0.8);
        border: none;
    }
</style>
<a href="schedule.php" class="btn btn-secondary">Back</a>
<body class="container mt-5">
    <h3>Add New Schedule</h3>
    <?php if (isset($error)) { ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php } ?>

    <form method="POST">
        <div class="mb-3"><label class="form-label">Instructor</label>
            <select class="form-control" name="instructor" required>
                <option value="" disabled selected>Select Instructor</option>
                <?php
                    include_once "data/teacher.php";
                    $teachers = getAllTeachers($conn);
                    foreach ($teachers as $teacher) {
                        $fullName = $teacher['fname'] . ' ' . $teacher['lname'];
                        echo "<option value='" . htmlspecialchars($fullName) . "'>$fullName</option>";
                    }
                ?>
            </select>
        </div>
       <div class="mb-3"><label class="form-label">Course</label>
            <select class="form-control" name="course" required>
                <option value="" disabled selected>Select Course</option>
                <?php
                    include_once "data/course.php";
                    $courses = getAllCourses($conn);
                    foreach ($courses as $course) {
                        echo "<option value='" . htmlspecialchars($course['course_name']) . "'>" . htmlspecialchars($course['course_name']) . "</option>";
                    }
                ?>
            </select>
        </div>
        <div class="mb-3"><label class="form-label">Subject</label>
            <select class="form-control" name="subject" required>
                <option value="" disabled selected>Select Subject</option>
                <?php
                    include_once "data/subject.php";
                    $subjects = getAllSubjects($conn);
                    foreach ($subjects as $subject) {
                        echo "<option value='" . htmlspecialchars($subject['subjects']) . "'>" . htmlspecialchars($subject['subjects']) . "</option>";
                    }
                ?>
            </select>
        </div>
        <div class="mb-3"><label class="form-label">Room</label>
            <select class="form-control" name="room" required>
                <option value="" disabled selected>Select Room</option>
                <?php
                    include_once "data/room.php";
                    $rooms = getAllRooms($conn);
                    foreach ($rooms as $room) {
                        echo "<option value='" . htmlspecialchars($room['room_name']) . "'>" . htmlspecialchars($room['room_name']) . "</option>";
                    }
                ?>
            </select>
        </div>
        <div class="mb-3"><label class="form-label">Section</label>
            <select class="form-control" name="section" required>
                <option value="" disabled selected>Select Section</option>
                <?php
                    include_once "data/section.php";
                    $sections = getAllSections($conn);
                    foreach ($sections as $section) {
                        echo "<option value='" . htmlspecialchars($section['section']) . "'>" . htmlspecialchars($section['section']) . "</option>";
                    }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Select Year Level</label>
            <select class="form-select" name="year_level" required>
                <option value="" disabled <?= empty($_POST['year_level']) ? 'selected' : '' ?>>-- Select Year Level --</option>
                <option value="1" <?= isset($_POST['year_level']) && $_POST['year_level'] == '1' ? 'selected' : '' ?>>1</option>
                <option value="2" <?= isset($_POST['year_level']) && $_POST['year_level'] == '2' ? 'selected' : '' ?>>2</option>
                <option value="3" <?= isset($_POST['year_level']) && $_POST['year_level'] == '3' ? 'selected' : '' ?>>3</option>
                <option value="4" <?= isset($_POST['year_level']) && $_POST['year_level'] == '4' ? 'selected' : '' ?>>4</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Select Day(s)</label>
            <select class="form-select" name="day[]" multiple required>
                <option value="Monday">Mon</option>
                <option value="Tuesday">Tues</option>
                <option value="Wednesday">Wed</option>
                <option value="Thursday">Thur</option>
                <option value="Friday">Fri</option>
                <option value="Saturday">Sat</option>
                <option value="Sunday">Sun</option>
            </select>
            <small class="form-text text-white">Hold Ctrl (Windows) or Command (Mac) to select multiple days.</small>
        </div>
        <div class="mb-3"><label class="form-label">Start Time</label>
            <input type="time" class="form-control" name="start_time" required>
        </div>
        <div class="mb-3"><label class="form-label">End Time</label>
            <input type="time" class="form-control" name="end_time" required>
        </div>
        <button type="submit" class="btn btn-success">Add Schedule</button>
        <a href="schedule.php" class="btn btn-secondary">Cancel</a>
    </form>
</body>
</html>

<?php
} else {
    header("Location: ../login.php");
    exit;
}
?>
