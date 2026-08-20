<?php
if (isset($_POST['id'])) {
    include "../../req/DB_connection.php";
    $id = intval($_POST['id']);
    $sql = "UPDATE message SET is_read = 1 WHERE message_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
}
?>
