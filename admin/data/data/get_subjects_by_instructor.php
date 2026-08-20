<?php
include_once "../../req/DB_connection.php";
include_once "teacher.php";
include_once "subject.php";

if (isset($_GET['instructor'])) {
    $instructor = $_GET['instructor'];
    $teachers = getAllTeachers($conn);

    foreach ($teachers as $teacher) {
        $fullName = $teacher['fname'] . ' ' . $teacher['lname'];
        if ($fullName === $instructor) {
            $subjectString = $teacher['subjects'];
            $subjectList = [];

            foreach (str_split(trim($subjectString)) as $subId) {
                $sub = getAllSubjectById($subId, $conn);
                if ($sub != 0) {
                    $subjectList[] = $sub['subjects']; // or subject_code if preferred
                }
            }

            echo json_encode($subjectList);
            exit;
        }
    }
}
echo json_encode([]);
