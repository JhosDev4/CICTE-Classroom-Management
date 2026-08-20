<?php
session_start();
if (isset($_SESSION['student_id']) && $_SESSION['role'] === 'Student' && isset($_GET['room_id'])) {
    include "../req/DB_connection.php";
    include "../admin/data/room.php";
    include "../admin/data/schedule.php";

    $room_id = $_GET['room_id'];
    $room = getRoomById($room_id, $conn);

    if (!$room) {
        echo "<h3>Room not found.</h3>";
        exit;
    }

    $schedules = getSchedulesByRoom($room_id, $conn);

    date_default_timezone_set('Asia/Manila');
    $currentDateTime = new DateTime();
    $currentDay = $currentDateTime->format('l');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Room Schedule - <?= htmlspecialchars($room['room_name']) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" />
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('../img/green-gradient.avif') no-repeat center center fixed;
            background-size: cover;
        }
        .schedule-card {
            border: 1px solid #ccc;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #f8f9fa;
            transition: background-color 0.3s ease;
        }
        .schedule-card.ongoing {
            background-color: #dc3545;
            color: white;
        }
        .btn-back {
            background-color: #024751;
            color: #fff;
            border-radius: 12px;
        }
        .btn-back:hover {
            background-color: #0edc7c;
            color: #000;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <a href="schedule-view.php" class="btn btn-back mb-3">← Back to Room View</a>
    <h3 class="text-light">Schedule for Room: <?= htmlspecialchars($room['room_name']) ?></h3>

    <?php
    if (empty($schedules)) {
        echo '<div class="alert alert-info mt-3">No schedules found for this room.</div>';
    } else {
        foreach ($schedules as $sched) {
            $isOngoing = false;
            $days = array_map('trim', explode(',', $sched['day']));

            foreach ($days as $day) {
                // Build today's full datetime
                $todayDate = $currentDateTime->format('Y-m-d');
                $startTime = DateTime::createFromFormat('Y-m-d H:i:s', $todayDate . ' ' . $sched['start_time']);
                $endTime = DateTime::createFromFormat('Y-m-d H:i:s', $todayDate . ' ' . $sched['end_time']);
                $now = clone $currentDateTime;

                // Overnight class
                if ($endTime < $startTime) {
                    $endTime->modify('+1 day');
                    if ($now < $startTime) $now->modify('+1 day');
                }

                if (
                    strcasecmp($day, $now->format('l')) === 0 &&
                    $now >= $startTime &&
                    $now < $endTime
                ) {
                    $isOngoing = true;
                    break;
                }

                // Past-midnight case
                $yesterday = (clone $now)->modify('-1 day');
                if (
                    strcasecmp($day, $yesterday->format('l')) === 0 &&
                    DateTime::createFromFormat('H:i:s', $sched['end_time']) < DateTime::createFromFormat('H:i:s', $sched['start_time']) &&
                    $now < $endTime
                ) {
                    $isOngoing = true;
                    break;
                }
            }

    ?>
    <div class="schedule-card <?= $isOngoing ? 'ongoing' : '' ?>">
        <h5><?= htmlspecialchars($sched['subject']) ?> - <?= htmlspecialchars($sched['course']) ?> (<?= htmlspecialchars($sched['section']) ?>)</h5>
        <p><strong>Instructor:</strong> <?= htmlspecialchars($sched['instructor']) ?></p>
        <p><strong>Day:</strong> <?= htmlspecialchars($sched['day']) ?></p>
        <p><strong>Time:</strong> <?= htmlspecialchars($sched['start_time']) ?> - <?= htmlspecialchars($sched['end_time']) ?></p>
        <p><strong>Year Level:</strong> <?= htmlspecialchars($sched['year_level']) ?></p>
    </div>
    <?php
        }
    }
    ?>
</div>
</body>
</html>
<?php
} else {
    header("Location: ../login.php");
    exit;
}
?>
