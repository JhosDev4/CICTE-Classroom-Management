<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>CICTE Classroom Management</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="icon" href="img/CICTElogo.png"/>
</head>
<body>
  
  <nav class="navbar">
    <div class="logo"><img src="img/CICTElogo.png" alt="Logo"></div>
    <div class="menu-toggle" id="menuToggle">&#9776;</div>
    <div class="nav-links" id="navLinks">
      <a href="#">Home</a>
      <a href="#about">About</a>
      <a href="#contact">Contact</a>
      <a href="login.php">Login</a>
    </div>
  </nav>

  <section class="welcome-text">
    <img src="img/CICTElogo.png" alt="CICTE Logo">
    <h4>CICTE Classroom Management</h4>
    <p>The CICTE Classroom Management System is a web-based platform designed<br>
      to simplify and enhance classroom operations within the CICTE department.</p>
  </section>

  <section id="about">
    <div class="card-1">
      <h5 class="card-title">About Us</h5>
      <p>Welcome to the <b>CICTE Classroom Management System</b>, a dedicated platform developed to support the academic needs of the <b>College of Information, Communication Technology and Engineering (CICTE)</b>.<br><br>
      Our goal is to provide a seamless, organized, and technology-driven environment for students, teachers, and administrators. With features like class scheduling, user role management, course tracking, and more — we aim to make daily academic tasks more efficient and accessible.</p>
    </div>
  </section>

  <section id="contact">
  <form action="req/contact.php" method="post">
    <h3>Contact Us</h3>

    <?php if (isset($_GET['error'])): ?>
      <div style="color: white; background-color: #e74c3c; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
        <?=htmlspecialchars($_GET['error'])?>
      </div>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
      <div style="color: white; background-color: #2ecc71; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
        <?=htmlspecialchars($_GET['success'])?>
      </div>
    <?php endif; ?>

    <input type="email" name="email" placeholder="Email address" required />
    <input type="text" name="full_name" placeholder="Name" required />
    <textarea name="message" placeholder="Message" rows="4" required></textarea>
    <button type="submit">Send</button>
  </form>
</section>


  <script>
    const menuToggle = document.getElementById('menuToggle');
    const navLinks = document.getElementById('navLinks');
    menuToggle.addEventListener('click', () => {
      navLinks.classList.toggle('active');
    });
  </script>

  <div class="footer">
    &copy; 2025 CICTE Classroom Management. All rights reserved.
  </div>

</body>
</html>
