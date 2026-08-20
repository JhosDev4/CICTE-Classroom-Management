<?php
session_start();
if (isset($_SESSION['admin_id']) && $_SESSION['role'] == 'Admin') {
    include "../req/DB_connection.php";

    if (!isset($_GET['schedule_id'])) {
        header("Location: schedule.php");
        exit;
    }

    $schedule_id = $_GET['schedule_id'];

    // Fetch existing schedule
    $stmt = $conn->prepare("SELECT * FROM schedules WHERE schedule_id = ?");
    $stmt->execute([$schedule_id]);
    $schedule = $stmt->fetch();

    if (!$schedule) {
        header("Location: schedule.php?error=Schedule not found");
        exit;
    }

    $error = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $instructor  = $_POST['instructor'] ?? '';
        $course      = $_POST['course'] ?? '';
        $subject     = $_POST['subject'] ?? '';
        $room        = $_POST['room'] ?? '';
        $section     = $_POST['section'] ?? '';
        $year_level  = $_POST['year_level'] ?? '';
        $day         = isset($_POST['day']) ? implode(', ', $_POST['day']) : '';
        $start_time  = $_POST['start_time'] ?? '';
        $end_time    = $_POST['end_time'] ?? '';

        if (
            empty($instructor) || empty($course) || empty($subject) || empty($room) ||
            empty($section) || empty($year_level) || empty($day) ||
            empty($start_time) || empty($end_time)
        ) {
            $error = "All fields are required!";
        } else {
            $sql = "UPDATE schedules 
                    SET instructor=?, course=?, subject=?, room=?, section=?, year_level=?, day=?, start_time=?, end_time=? 
                    WHERE schedule_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                $instructor, $course, $subject, $room, $section, $year_level,
                $day, $start_time, $end_time, $schedule_id
            ]);

            header("Location: schedule.php?success=Schedule updated successfully");
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Schedule</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>
<style>
    body {
        background-image: url('../img/green-gradient.avif');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        color: white;
    }

    label, h3, a, .form-label {
        color: white !important;
    }

    .form-control {
        background-color: rgba(255, 255, 255, 0.8);
        color: #000;
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
<body class="container mt-5">
    <a href="schedule.php" class="btn btn-secondary mb-3">Back</a>
    <h3>Edit Schedule</h3>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3"><label class="form-label">Instructor</label>
            <select class="form-control" name="instructor" required>
                <option value="" disabled>Select Instructor</option>
                <?php
                    include_once "data/teacher.php";
                    $teachers = getAllTeachers($conn);
                    foreach ($teachers as $teacher) {
                        $fullName = $teacher['fname'] . ' ' . $teacher['lname'];
                        $selected = ($fullName == $schedule['instructor']) ? 'selected' : '';
                        echo "<option value='" . htmlspecialchars($fullName) . "' $selected>$fullName</option>";
                    }
                ?>
            </select>
        </div>

        <div class="mb-3"><label class="form-label">Course</label>
            <select class="form-control" name="course" required>
                <option value="" disabled>Select Course</option>
                <?php
                    include_once "data/course.php";
                    $courses = getAllCourses($conn);
                    foreach ($courses as $course) {
                        $selected = ($course['course_name'] == $schedule['course']) ? 'selected' : '';
                        echo "<option value='" . htmlspecialchars($course['course_name']) . "' $selected>" . htmlspecialchars($course['course_name']) . "</option>";
                    }
                ?>
            </select>
        </div>

        <div class="mb-3"><label class="form-label">Subject</label>
            <select class="form-control" name="subject" required>
                <option value="" disabled>Select Subject</option>
                <?php
                    include_once "data/subject.php";
                    $subjects = getAllSubjects($conn);
                    foreach ($subjects as $subject) {
                        $selected = ($subject['subjects'] == $schedule['subject']) ? 'selected' : '';
                        echo "<option value='" . htmlspecialchars($subject['subjects']) . "' $selected>" . htmlspecialchars($subject['subjects']) . "</option>";
                    }
                ?>
            </select>
        </div>

        <div class="mb-3"><label class="form-label">Room</label>
            <select class="form-control" name="room" required>
                <option value="" disabled>Select Room</option>
                <?php
                    include_once "data/room.php";
                    $rooms = getAllRooms($conn);
                    foreach ($rooms as $room) {
                        $selected = ($room['room_name'] == $schedule['room']) ? 'selected' : '';
                        echo "<option value='" . htmlspecialchars($room['room_name']) . "' $selected>" . htmlspecialchars($room['room_name']) . "</option>";
                    }
                ?>
            </select>
        </div>

        <div class="mb-3"><label class="form-label">Section</label>
            <select class="form-control" name="section" required>
                <option value="" disabled>Select Section</option>
                <?php
                    include_once "data/section.php";
                    $sections = getAllSections($conn);
                    foreach ($sections as $section) {
                        $selected = ($section['section'] == $schedule['section']) ? 'selected' : '';
                        echo "<option value='" . htmlspecialchars($section['section']) . "' $selected>" . htmlspecialchars($section['section']) . "</option>";
                    }
                ?>
            </select>
        </div>

        <div class="mb-3"><label class="form-label">Year Level</label>
            <select class="form-select" name="year_level" required>
                <option value="" disabled>-- Select Year Level --</option>
                <?php for ($i = 1; $i <= 4; $i++): ?>
                    <option value="<?= $i ?>" <?= $schedule['year_level'] == $i ? 'selected' : '' ?>><?= $i ?></option>
                <?php endfor; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Select Day(s)</label>
            <select class="form-select" name="day[]" multiple required>
                <?php
                    $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
                    $selectedDays = explode(', ', $schedule['day']);
                    foreach ($days as $day) {
                        $isSelected = in_array($day, $selectedDays) ? 'selected' : '';
                        echo "<option value=\"$day\" $isSelected>$day</option>";
                    }
                ?>
            </select>
            <small class="form-text text-white">Hold Ctrl (Windows) or Command (Mac) to select multiple days.</small>
        </div>

        <div class="mb-3"><label class="form-label">Start Time</label>
            <input type="time" class="form-control" name="start_time" value="<?= $schedule['start_time'] ?>" required>
        </div>

        <div class="mb-3"><label class="form-label">End Time</label>
            <input type="time" class="form-control" name="end_time" value="<?= $schedule['end_time'] ?>" required>
        </div>

        <button type="submit" class="btn btn-success">Update Schedule</button>
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
