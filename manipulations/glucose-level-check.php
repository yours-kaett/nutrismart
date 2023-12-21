<?php
include "../db_conn.php";
session_start();
if (isset($_POST['created_at']) && isset($_POST['time']) && isset($_POST['glucose_value'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $created_at = validate($_POST['created_at']);
    $time = validate($_POST['time']);
    $glucose_value = validate($_POST['glucose_value']);

    $stmt = $conn->prepare("INSERT INTO tbl_glucose_levels (glucose_value, time, patient_id, created_at) 
    VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssis', $glucose_value, $time, $_SESSION['id'], $created_at);
    $stmt->execute();
    $result = $stmt->get_result();
    header("Location: ../pages/patient/home.php?bs_success");
    exit();
} else {
    header("Location: ../pages/patient/home.php?bs_error");
    exit();
}
