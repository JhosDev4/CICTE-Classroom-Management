<?php
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])     &&
    isset($_GET['teacher_id'])) {

    if($_SESSION['role'] == 'Admin'){
        include ("../req/DB_connection.php");
        include "data/subject.php";
        include "data/grade.php";
        include "data/section.php";
        include "data/teacher.php";
        $subjects = getAllSubjects($conn);
        $grades = getAllGrades($conn);
        $sections = getAllSections($conn);

        $teacher_id = $_GET['teacher_id'];
        $teacher = getAllTeachersById($teacher_id, $conn);
        
        if ($teacher == 0){
            header("Location: teacher.php");
            exit;  
        }


    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Edit Teacher</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="icon" href="../CICTElogo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">   
</head>
<style>
    body {
        background: url(../img/cite.png);
        background-size: cover;
        background-attachment: fixed;
    }
     .alert{
        color: black;
     }
    label,
    h3,
    .form-label,
    .btn {
        color: white;
    }

    .form-control {
        background-color: rgba(255, 255, 255, 0.1);
        color: white;
        border: 1px solid #ccc;
    }

    .form-control::placeholder {
        color: #ddd;
    }
    .white-label {
        color: white;
        }
</style>

<body>
    <?php
        include "inc/navbar.php";
    ?>
    <div class="container mt-5">
        <a href="teacher.php" 
        class="btn btn-dark">Go Back</a>

        <form method="post"
            class="shadow-lg p-2 mt-5 form-w"
            action="req/teacher-edit.php">
        <h3>Edit Teacher</h3><hr>
        <?php if (isset($_GET['error'])) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $_GET['error'] ?>
                    </div>
                <?php } ?>
                <?php if (isset($_GET['success'])) { ?>
                    <div class="alert alert-success" role="alert">
                        <?= $_GET['success'] ?>
                    </div>
                <?php } ?>
        <div class="mb-3">
            <label class="form-label">First name</label>
            <input type="text" class="form-control" 
            value="<?=$teacher['fname']?>" 
            name="fname">
        </div>

        <div class="mb-3">
            <label class="form-label">Last name</label>
            <input type="text" class="form-control" 
            value="<?=$teacher['lname']?>" 
            name="lname">
        </div>

        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control"  
            value="<?=$teacher['username']?>"
            name="username">
        </div>
        
        <div class="mb-3">
            <label class="form-label">address</label>
            <input type="text" class="form-control"  
            value="<?=$teacher['address']?>"
            name="address">
        </div>

        <div class="mb-3">
          <label class="form-label">employee Number</label>
          <input type="text" 
                 class="form-control"
                 value="<?=$teacher['employee_number']?>"
                 name="employee_number">
        </div>
        <div class="mb-3">
          <label class="form-label">Phone Number</label>
          <input type="text" 
                 class="form-control"
                 value="<?=$teacher['phone_number']?>"
                 name="phone_number">
        </div>
        <div class="mb-3">
          <label class="form-label">Qualification</label>
          <input type="text" 
                 class="form-control"
                 value="<?=$teacher['qualification']?>"
                 name="qualification">
        </div>
        <div class="mb-3">
          <label class="form-label">Email Address</label>
          <input type="text" 
                 class="form-control"
                 value="<?=$teacher['email_address']?>"
                 name="email_address">
        </div>
       <div class="mb-3">
        <label class="form-label">Gender</label><br>
        <label class="white-label">
            <input type="radio"
                value="Male"
                <?php if($teacher['gender'] == 'Male') echo 'checked'; ?> 
                name="gender"> Male
        </label>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <label class="white-label">
            <input type="radio"
                value="Female"
                <?php if($teacher['gender'] == 'Female') echo 'checked'; ?> 
                name="gender"> Female
        </label>
        </div>
        <div class="mb-3">
          <label class="form-label">Date of Birth</label>
          <input type="date" 
                 class="form-control"
                 value=""
                 name="date_of_birth">
        </div> 

        <input type="text"
               value="<?=$teacher['teacher_id']?>"
               name="teacher_id"
               hidden>

       <div class="mb-3">
            <label class="form-label"><b>Subject</b></label>
            <div class="row row-cols-5">
                <?php foreach($subjects as $subject): ?>
                <div class="col white-label">
                <input type="checkbox" name="subjects[]" value="<?=$subject['subject_id']?>">
                <?=$subject['subjects']?>
                </div>
                <?php endforeach ?>
            </div>
            </div>
        <div class="mb-3">
            <label class="form-label">Year level</label>
            <div class="row row-cols-5">
                <?php foreach($grades as $grade): ?>
                <div class="col white-label">
                <input type="checkbox" name="grades[]" value="<?=$grade['grade_id']?>"> 
                <?=$grade['grade_code']?>-<?=$grade['grades']?>
                </div>
                <?php endforeach ?>
            </div>
            </div>
        <div class="mb-3">
            <label class="form-label">Section</label>
            <div class="row row-cols-5">
                <?php foreach($sections as $section): ?>
                <div class="col white-label">
                <input type="checkbox" name="sections[]" value="<?=$section['section_id']?>">
                <?=$section['section']?>
                </div>
                <?php endforeach ?>
            </div>
            </div>



  <button type="submit" 
          class="col btn btn-dark m-2">
          Update</button>
</form>

    <form method="post"
            class="shadow-lg p-2 my-5 form-w"
            action="req/teacher-change.php"
            id="change_password">
        <h3>Change Password</h3><hr>
         <?php if (isset($_GET['perror'])) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $_GET['perror'] ?>
                        </div>
                    <?php } ?>
                    <?php if (isset($_GET['psuccess'])) { ?>
                        <div class="alert alert-success" role="alert">
                            <?= $_GET['psuccess'] ?>
                        </div>
                    <?php } ?>

            <div class="mb-3">
                <div class="mb-3">
                    <label class="form-label"><b>Admin password</b></label>
                        <input type="password" 
                            class="form-control"
                            name="admin_pass">
                         
                </div>

                <label class="form-label"><b>New password</b></label>
                <div class="input-group mb-3">
                    <input type="text" 
                           class="form-control"
                           name="new_pass" 
                           id="passInput">
                    <button class="btn-btn secondary" id="gBtn"><b>Random</b></button>
                </div>
            </div>
            <input type="text"
               value="<?=$teacher['teacher_id']?>"
               name="teacher_id"
               hidden>

            <div class="mb-3">
                <label class="form-label"><b>Confirm new password</b></label>
                
                    <input type="text" 
                           class="form-control"
                           name="c_new_pass"
                           id="passInput2">
            </div>
            <button type="submit" 
                    class="col btn btn-dark m-2">
                   Change</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    $(document).ready(function(){
       $("#navLinks li:nth-child(2) a").addClass('active');
     });

     function makePass(length) {
        let result = '';
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for (let i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        var passInput = document.getElementById('passInput');
        var passInpu2 = document.getElementById('passInput2');
        passInput.value = result;
        passInput2.value = result;
     }
     var gBtn = document.getElementById('gBtn');
     gBtn.addEventListener('click', function(e){
        e.preventDefault();
        makePass(5);
     })
    
    </script>
</body>
</html>
<?php 
    }else {
        header("Location: teacher.php");
        exit;
    } 
    }else {
        header("Location: teacher.php");
        exit;
    } 

?>