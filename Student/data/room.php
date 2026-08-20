<?php
function getAllRooms($conn){
    $sql = "SELECT * FROM rooms";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->rowCount() >= 1 ? $stmt->fetchAll() : 0;
}
function getRoomById($room_id, $conn) {
    $sql = "SELECT * FROM rooms WHERE room_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$room_id]);

    if ($stmt->rowCount() === 1) {
        return $stmt->fetch();
    } else {
        return false;
    }
}
function getSchedulesByRoom($room_id, $conn) {
    // First, get the room name using the room_id
    $room = getRoomById($room_id, $conn);
    if (!$room) return [];

    $room_name = $room['room_name'];

    // Now fetch the schedules that use this room name
    $sql = "SELECT * FROM schedule WHERE room = ? ORDER BY FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'), start_time";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$room_name]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
