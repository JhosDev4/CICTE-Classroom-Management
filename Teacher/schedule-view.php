<?php 
session_start();
if (isset($_SESSION['teacher_id']) && $_SESSION['role'] == 'Teacher') {
    include "../req/DB_connection.php";
    include "data/room.php";
    include "data/schedule.php";

    $rooms = getAllRooms($conn);
    $schedules = getAllSchedules($conn);

    date_default_timezone_set('Asia/Manila');
    $currentDay = date("l");
    $currentTime = date("H:i:s");
    $currentTimestamp = strtotime($currentTime);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Room Availability</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('../img/green-gradient.avif') no-repeat center center fixed;
            background-size: cover;
        }
        .room-card {
            border-radius: 20px;
            color: #fff;
            padding: 25px;
            text-align: center;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4);
            transition: transform 0.2s ease-in-out;
            min-height: 220px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .room-card:hover { transform: translateY(-5px); }
        .available { background-color: rgba(40, 167, 69, 0.85); }
        .occupied { background-color: rgba(220, 53, 69, 0.85); }
        .btn-light.btn-sm {
            background-color: #ffffffdd;
            color: #024751;
            font-weight: 500;
            border-radius: 12px;
            margin-top: 10px;
        }
        .btn-light.btn-sm:hover {
            background-color: #0edc7c;
            color: #000;
        }
        h3.text-center {
            color: #f0fff4;
            text-shadow: 1px 1px 2px #000;
        }
        .container a.btn {
            background-color: rgba(2, 71, 81, 0.9);
            color: #d8f3dc;
            border-radius: 15px;
            font-size: 1rem;
            font-weight: 500;
            transition: transform 0.2s ease, background 0.3s ease;
        }
        .container a.btn:hover {
            background-color: #0edc7c;
            color: #000;
            transform: translateY(-4px);
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <a href="schedule.php" class="btn btn-secondary mb-3">Back</a>
    <h3 class="text-center mb-4">Room Availability (<?= htmlspecialchars($currentDay) ?> @ <?= htmlspecialchars($currentTime) ?>)</h3>
    
    <div class="row g-4">
        <?php foreach ($rooms as $room): 
            $isOccupied = false;

            foreach ($schedules as $sched) {
                if (trim($sched['room']) === trim($room['room_name'])) {
                    $days = array_map('trim', explode(',', $sched['day']));
                    $start = strtotime($sched['start_time']);
                    $end = strtotime($sched['end_time']);
                    $now = $currentTimestamp;

                    foreach ($days as $day) {
                        if (strcasecmp($day, $currentDay) === 0) {
                            $adjustedNow = $now;
                            $adjustedStart = $start;
                            $adjustedEnd = $end;

                            if ($end < $start) {
                                $adjustedEnd += 86400; // +24h
                                if ($now < $start) $adjustedNow += 86400;
                            }

                            if ($adjustedStart <= $adjustedNow && $adjustedNow < $adjustedEnd) {
                                $isOccupied = true;
                                break 2;
                            }
                        }

                        // Check if class started yesterday and ends today
                        $yesterday = date('l', strtotime('-1 day'));
                        if (strcasecmp($day, $yesterday) === 0 && $end < $start) {
                            $adjustedEnd = $end + 86400;
                            if ($now < $end) {
                                $isOccupied = true;
                                break 2;
                            }
                        }
                    }
                }
            }
        ?>
        <div class="col-md-3 d-flex">
            <div class="room-card <?= $isOccupied ? 'occupied' : 'available' ?> w-100">
                <div>
                    <h4><?= htmlspecialchars($room['room_name']) ?></h4>
                    <p><?= $isOccupied ? 'Occupied' : 'Free' ?></p>
                </div>
                <a href="schedule-view-details.php?room_id=<?= urlencode($room['room_id']) ?>" class="btn btn-light btn-sm">View Schedule</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function(){
        $("#navLinks li:nth-child(8) a").addClass('active');
    });
</script>
</body>
</html>
<?php 
} else {
    header("Location: ../login.php");
    exit;
}
?>
