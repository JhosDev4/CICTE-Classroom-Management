<?php  
// All Schedule
function getSchedulesBySection($conn, $section, $year_level = null) {
    $sql = "SELECT * FROM schedules WHERE section = ?";
    $params = [$section];

    if ($year_level !== null) {
        $sql .= " AND year_level = ?";
        $params[] = $year_level;
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    if ($stmt->rowCount() > 0) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    return 0;
}

//schedule_id
function getScheduleById($conn, $id) {
  $sql = "SELECT * FROM schedules WHERE schedule_id=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$id]);
  return $stmt->fetch(PDO::FETCH_ASSOC);
}
//schedules by course
function getSchedulesByCourse($conn, $course) {
  $sql = "SELECT * FROM schedules WHERE course = ?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$course]);
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
//select year level
function getSchedulesByCourseAndYear($conn, $course, $year_level) {
  $sql = "SELECT * FROM schedules WHERE course = ? AND year_level = ?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$course, $year_level]);
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $results ? $results : 0;
}
