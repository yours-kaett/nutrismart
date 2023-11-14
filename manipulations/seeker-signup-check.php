<?php
include "../db_conn.php";

// require 'src/PHPMailer.php';
// require 'src/SMTP.php';
// require 'src/Exception.php';

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;

session_start();

if (isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password'])) {

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $email = validate($_POST['email']);
    $username = validate($_POST['username']);
    $password = validate($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM tbl_seeker WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if (mysqli_num_rows($result) > 0) {
        header("Location: ../pages/seeker-signup.php?error=Username already taken.");
        exit();
    } 
    else {
        // $mail = new PHPMailer(true);
        // try {
        //     // SMTP configuration
        //     $mail->isSMTP();
        //     $mail->Host = 'smtp.gmail.com';
        //     $mail->SMTPAuth = true;
        //     $mail->Username = 'christianschool.main@gmail.com';
        //     $mail->Password = 'lhkvevgaglyugygu';
        //     $mail->SMTPSecure = 'tls';
        //     $mail->Port = 587;

        //     // Email content
        //     date_default_timezone_set('Asia/Manila');
        //     $datetime = date("F j, Y - l")." | ".date("h : i : s a");
        //     $recipient = 'kentanthony2022@gmail.com';
        //     $subject = 'Account Creation';
        //     $message = "New Account has been added to the system on $datetime. \n \n";
        //     $message .= "Email: " . $email . "\n";
        //     $message .= "Username: " . $username . "\n";
        //     $message .= "Password: " . $password . "\n \n";
        //     $message .= "Note: Make sure to save the credentials for future purposes.";
        //     $mail->setFrom('christianschool.main@gmail.com', 'Dreamers');
        //     $mail->addAddress($recipient);
        //     $mail->Subject = $subject;
        //     $mail->Body = $message;

        //     $mail->send();
        // }
        // catch (Exception $e) {
        //     echo 'Email could not be sent. Error: ', $mail->ErrorInfo;
        // }

        $password = md5($password);
        $stmt = $conn->prepare("INSERT INTO tbl_seeker (email, username, password) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $email, $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        header("Location: ../pages/seeker-signup.php?success");
        exit();
    }
} else {
    header("Location: ../pages/seeker-signup.php");
    exit();
}
