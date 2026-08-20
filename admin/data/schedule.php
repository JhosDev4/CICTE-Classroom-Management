<?php  
// All Schedule
function getAllSchedules($conn){
   $sql = "SELECT * FROM schedules";
   $stmt = $conn->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() >= 1) {
     $schedules = $stmt->fetchAll();
     return $schedules;
   }else {
    return 0;
   }
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
