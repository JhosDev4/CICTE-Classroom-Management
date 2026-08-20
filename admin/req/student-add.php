<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {

    if (
        isset($_POST['fname']) &&
        isset($_POST['lname']) &&
        isset($_POST['username']) &&
        isset($_POST['pass']) &&
        isset($_POST['address']) &&
        isset($_POST['gender']) &&
        isset($_POST['email_address']) &&
        isset($_POST['date_of_birth']) &&
        isset($_POST['parent_fname']) &&
        isset($_POST['parent_lname']) &&
        isset($_POST['parent_phone_number']) &&
        isset($_POST['section']) &&
        isset($_POST['grade'])
    ) {
        include '../../req/DB_connection.php';
        include "../data/student.php";

        // Retrieve and sanitize input
        $fname = trim($_POST['fname']);
        $lname = trim($_POST['lname']);
        $uname = trim($_POST['username']);
        $pass = trim($_POST['pass']);
        $address = trim($_POST['address']);
        $gender = $_POST['gender'];
        $email_address = trim($_POST['email_address']);
        $date_of_birth = $_POST['date_of_birth'];
        $parent_fname = trim($_POST['parent_fname']);
        $parent_lname = trim($_POST['parent_lname']);
        $parent_phone_number = trim($_POST['parent_phone_number']);
        $grade = $_POST['grade'];
        $section = $_POST['section'];

        // Reusable query string for redirecting back with old values
        $data = 'uname=' . $uname . '&fname=' . $fname . '&lname=' . $lname .
                '&address=' . $address . '&email=' . $email_address . '&pfn=' . $parent_fname .
                '&pln=' . $parent_lname . '&ppn=' . $parent_phone_number;

        // Validations
        if (empty($fname)) {
            $em = "First name is required";
        } else if (empty($lname)) {
            $em = "Last name is required";
        } else if (empty($uname)) {
            $em = "Username is required";
        } else if (!unameIsUnique($uname, $conn, 0)) {
            $em = "Username already exists! Try another.";
        } else if (empty($pass)) {
            $em = "Password is required";
        } else if (empty($address)) {
            $em = "Address is required";
        } else if (empty($email_address)) {
            $em = "Email address is required";
        } else if (empty($date_of_birth)) {
            $em = "Date of birth is required";
        } else if (empty($parent_fname)) {
            $em = "Parent's first name is required";
        } else if (empty($parent_lname)) {
            $em = "Parent's last name is required";
        } else if (empty($parent_phone_number)) {
            $em = "Parent phone number is required";
        }

        if (isset($em)) {
            header("Location: ../student-add.php?error=$em&$data");
            exit;
        }

        // Insert into database
        $sql = "INSERT INTO students (username, password, fname, lname, address, gender, email_address, date_of_birth, parent_fname, parent_lname, parent_phone_number, grade, section)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
        $stmt->execute([$uname, $hashed_pass, $fname, $lname, $address, $gender, $email_address, $date_of_birth, $parent_fname, $parent_lname, $parent_phone_number, json_encode($grade), json_encode($section)]);

        $sm = "Student registered successfully!";
        header("Location: ../student-add.php?success=$sm");
        exit;

    } else {
        $em = "All fields are required!";
        header("Location: ../student-add.php?error=$em");
        exit;
    }

} else {
    header("Location: ../../login.php");
    exit;
}
?>
