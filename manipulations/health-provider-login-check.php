<?php
session_start();
include "../db_conn.php";
if (isset($_POST['username']) && isset($_POST['password'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $username = validate($_POST['username']);
    $password = validate($_POST['password']);
    $password = md5($password);
    try {
        $stmt = $conn->prepare("SELECT * FROM tbl_health_provider WHERE username = ? AND password = ?");
        if (!$stmt) {
            throw new Exception("Database query error: " . $conn->error);
        }
        $stmt->bind_param("ss", $username, $password);
        if (!$stmt->execute()) {
            throw new Exception("Database query execution failed.");
        }
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if ($row['username'] === $username && $row['password'] === $password) {

                $_SESSION['username'] = $row['username'];
                $_SESSION['id'] = $row['id'];

                header("Location: ../pages/health-provider/home.php");
                exit();
            } else {
                header("Location: ../pages/health-provider-login.php?error");
                exit();
            }
        } else {
            header("Location: ../pages/health-provider-login.php?error");
            exit();
        }
    } catch (Exception $e) {
        header("Location: ../pages/health-provider-login.php?error=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    header("Location: ../pages/health-provider-login.php");
    exit();
}
