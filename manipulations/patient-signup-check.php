<?php
include "../db_conn.php";
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

    $stmt = $conn->prepare("SELECT * FROM tbl_patient WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if (mysqli_num_rows($result) > 0) {
        header("Location: ../pages/patient-signup.php?error=Username already taken.");
        exit();
    } else {
        $password = md5($password);
        $stmt = $conn->prepare("INSERT INTO tbl_patient (email, username, password) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $email, $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        header("Location: ../pages/patient-signup.php?success");
        exit();
    }
} else {
    header("Location: ../pages/patient-signup.php");
    exit();
}
