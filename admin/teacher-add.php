<?php
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if($_SESSION['role'] == 'Admin'){
        include ("../req/DB_connection.php");
        include "data/subject.php";
        include "data/grade.php";
        include "data/section.php";
        $subjects = getAllSubjects($conn); 
        $grades   = getAllGrades($conn);
        $sections = getAllSections($conn); 
        
        $fname = '';
        $lname = '';
        $uname = '';
        $address = '';
        $en = '';
        $pn = '';
        $qf = '';
        $email = '';

        if (isset($_GET['fname'])) $fname = $_GET['fname'];
        if (isset($_GET['lname'])) $lname = $_GET['lname'];
        if (isset($_GET['uname'])) $uname = $_GET['uname'];
        if (isset($_GET['address'])) $address = $_GET['address'];
        if (isset($_GET['en'])) $en = $_GET['en'];
        if (isset($_GET['pn'])) $pn = $_GET['pn'];
        if (isset($_GET['qf'])) $qf = $_GET['qf'];
        if (isset($_GET['email'])) $email = $_GET['email'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Add Teacher</title>
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
        .form-label,
        h3,label,
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
            action="req/teacher-add.php">
        <h3>Add New Teacher</h3><hr>
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
          <input type="text" 
                 class="form-control"
                 value="<?=$fname?>" 
                 name="fname">
        </div>
        <div class="mb-3">
          <label class="form-label">Last name</label>
          <input type="text" 
                 class="form-control"
                 value="<?=$lname?>"
                 name="lname">
        </div>
        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" 
                 class="form-control"
                 value="<?=$uname?>"
                 name="username">
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <div class="input-group mb-3">
              <input type="text" 
                     class="form-control"
                     name="pass"
                     id="passInput">
              <button class="btn btn-secondary"
                      id="gBtn">
                      Random</button>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Address</label>
          <input type="text" 
                 class="form-control"
                 value="<?=$address?>"
                 name="address">
        </div>
        <div class="mb-3">
          <label class="form-label">Employee Number</label>
          <input type="text" 
                 class="form-control"
                 value="<?=$en?>"
                 name="employee_number">
        </div>
        <div class="mb-3">
          <label class="form-label">Phone Number</label>
          <input type="text" 
                 class="form-control"
                 value="<?=$pn?>"
                 name="phone_number">
        </div>
        <div class="mb-3">
          <label class="form-label">Qualification</label>
          <input type="text" 
                 class="form-control"
                 value="<?=$qf?>"
                 name="qualification">
        </div>
        <div class="mb-3">
          <label class="form-label">Email Address</label>
          <input type="text" 
                 class="form-control"
                 value="<?=$email?>"
                 name="email_address">
        </div>
        <div class="mb-3">
        <label class="form-label">Gender</label><br>
        <input type="radio" value="Male" checked name="gender">
        <span class="white-label">Male</span>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" value="Female" name="gender">
        <span class="white-label">Female</span>
        </div>

        <div class="mb-3">
          <label class="form-label">Date of Birth</label>
          <input type="date" 
                 class="form-control"
                 value=""
                 name="date_of_birth">
        </div> 

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
                <input type="checkbox" name="section[]" value="<?=$section['section_id']?>">
                <?=$section['section']?>
                </div>
                <?php endforeach ?>
            </div>
            </div>



  <button type="submit" class="col btn btn-dark">Add</button>
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
        passInput.value = result;
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
        header("Location: ../login.php");
        exit;
    } 
    }else {
        header("Location: ../login.php");
        exit;
    } 

?>