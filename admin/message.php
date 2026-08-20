<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {

    include "../req/DB_connection.php";
    include "data/message.php";

    // Mark all unread messages as read when this page is loaded
    $updateSql = "UPDATE message SET is_read = 1 WHERE is_read = 0";
    $conn->prepare($updateSql)->execute();

    // Now get all messages (will have is_read=1 after above)
    $messages = getAllMessages($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin - Messages</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="icon" href="../logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .message-container {
      background-color: white;
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      padding: 30px;
      margin-top: 50px;
    }
    .accordion-button::after {
      transition: transform 0.2s ease-in-out;
    }
    .accordion-button.collapsed::after {
      transform: rotate(-90deg);
    }
    .accordion-button {
      background-color: #e9ecef;
      font-weight: bold;
    }
    .accordion-body {
      background-color: #fdfdfd;
    }
    .meta-info {
      font-size: 0.9rem;
      color: #555;
    }
  </style>
</head>
<body>

<?php include "inc/navbar.php"; ?>

<div class="container">
  <div class="message-container mx-auto" style="max-width: 800px;">
    <h3 class="text-center mb-4"><i class="fas fa-envelope-open-text me-2"></i>Inbox Messages</h3>

    <?php if ($messages != 0): ?>
      <div class="accordion accordion-flush" id="accordionMessages">
        <?php foreach ($messages as $index => $message): ?>
          <div class="accordion-item mb-2">
            <h2 class="accordion-header" id="flush-heading<?= $message['message_id'] ?>">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $message['message_id'] ?>" aria-expanded="false" aria-controls="flush-collapse<?= $message['message_id'] ?>">
                <i class="fa fa-user-circle me-2"></i> <?= htmlspecialchars($message['sender_full_name']) ?>
              </button>
            </h2>
            <div id="flush-collapse<?= $message['message_id'] ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?= $message['message_id'] ?>" data-bs-parent="#accordionMessages">
              <div class="accordion-body">
                <p><?= nl2br(htmlspecialchars($message['message'])) ?></p>
                <div class="d-flex justify-content-between mt-3 meta-info">
                  <span><i class="fa fa-envelope me-1"></i><?= htmlspecialchars($message['sender_email']) ?></span>
                  <span><i class="fa fa-calendar me-1"></i><?= $message['date_time'] ?></span>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="alert alert-info text-center">
        <i class="fa fa-info-circle me-2"></i>No messages found.
      </div>
    <?php endif; ?>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  $(document).ready(function(){
    $("#navLinks li:nth-child(12) a").addClass('active');
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
