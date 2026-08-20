<?php  
if (isset($_POST['email']) &&
    isset($_POST['full_name']) &&
    isset($_POST['message'])) {

    include "../req/DB_connection.php";
	
    $email     = htmlspecialchars(trim($_POST['email']));
    $full_name = htmlspecialchars(trim($_POST['full_name']));
    $message   = htmlspecialchars(trim($_POST['message']));

	if (empty($email)) {
		$em  = "Email is required";
		header("Location: ../index.php?error=$em#contact");
		exit;
	} else if (empty($full_name)) {
		$em  = "Full name is required";
		header("Location: ../index.php?error=$em#contact");
		exit;
	} else if (empty($message)) {
		$em  = "Message is required";
		header("Location: ../index.php?error=$em#contact");
		exit;
	} else {
       $sql  = "INSERT INTO message (sender_full_name, sender_email, message) VALUES (?, ?, ?)";
       $stmt = $conn->prepare($sql);
       $stmt->execute([$full_name, $email, $message]);

       $sm = "Message sent successfully";
       header("Location: ../index.php?success=$sm#contact");
       exit;
	}
} else {
	header("Location: ../login.php");
	exit;
}
?>
