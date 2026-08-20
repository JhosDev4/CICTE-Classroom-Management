<?php
include "../req/DB_connection.php";
include "data/message.php";

// Get unread messages count dynamically from your backend
$unreadCount = countUnreadMessages($conn);
?>

<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #21252989;">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
      <img src="../img/CICTElogo.png" width="50" style="border-radius: 50%;">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <style>
      /* Your entire original style block here unchanged */
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }
      body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: url('../img/green-gradient.avif') no-repeat center center fixed;
        background-size: cover;
      }
      .navbar {
        background-color: rgba(15, 38, 23, 0.9);
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 2rem;
        position: sticky;
        top: 0;
        z-index: 1000;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(8px);
      }
      .navbar .navbar-brand img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
      }
      .nav-links {
        display: flex;
        gap: 1.5rem;
      }
      .nav-links a {
        color: #d8f3dc;
        text-decoration: none;
        font-weight: 500;
        position: relative;
        transition: color 0.3s ease;
      }
      .nav-links a::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        left: 0;
        bottom: -5px;
        background: #0edc7c;
        transition: width 0.3s ease;
      }
      .nav-links a:hover::after {
        width: 100%;
      }
      .nav-links a:hover {
        color: #a3bfaf;
      }
      .container a.btn {
        background-color: rgba(2, 71, 81, 0.9);
        color: #d8f3dc;
        border-radius: 15px;
        text-align: center;
        font-size: 1rem;
        font-weight: 500;
        transition: transform 0.2s ease, background 0.3s ease;
      }
      .container a.btn i {
        margin-bottom: 10px;
      }
      .container a.btn:hover {
        background-color: #0edc7c;
        color: #000;
        transform: translateY(-4px);
      }
      .container a.btn:active {
        transform: scale(0.98);
      }
      .container a.btn.text-white {
        background-color: #024751;
        font-weight: bold;
      }
      .badge-notification {
        font-size: 0.65rem;
        padding: 0.25em 0.4em;
        border-radius: 50%;
        color: white;
        min-width: 18px;
        text-align: center;
        line-height: 1;
        pointer-events: none;
        user-select: none;
      }
      .position-relative {
        position: relative !important;
      }
      @media (max-width: 768px) {
        .row.row-cols-5 {
          display: grid;
          grid-template-columns: repeat(2, 1fr);
          gap: 1rem;
        }
        .container a.btn {
          padding: 1rem;
          font-size: 0.95rem;
        }
      }
    </style>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0" id="navLinks">
        <li class="nav-item"><a class="nav-link" href="index.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="teacher.php">TeachersAcc</a></li>
        <li class="nav-item"><a class="nav-link" href="student.php">StudentsAcc</a></li>
        <li class="nav-item"><a class="nav-link" href="class.php">Class</a></li>
        <li class="nav-item"><a class="nav-link" href="grade.php">YearLevel</a></li>
        <li class="nav-item"><a class="nav-link" href="section.php">Section</a></li>
        <li class="nav-item"><a class="nav-link" href="subject.php">Subject</a></li>
        <li class="nav-item"><a class="nav-link" href="room.php">ClassRoom</a></li>
        <li class="nav-item"><a class="nav-link" href="schedule.php">Schedule</a></li>
        <li class="nav-item"><a class="nav-link" href="registrar-office.php">RegistrarOffice</a></li>
        <li class="nav-item"><a class="nav-link" href="course.php">Course</a></li>

        <!-- Message with Notification Badge -->
        <li class="nav-item position-relative">
          <?php if ($unreadCount > 0): ?>
            <span class="badge bg-danger position-absolute top-0 start-100 translate-middle badge-notification">
              <?= $unreadCount ?>
            </span>
          <?php endif; ?>
          <a class="nav-link" href="message.php">Message</a>
        </li>
      </ul>

      <ul class="navbar-nav me-right mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="../logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
