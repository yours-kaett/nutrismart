<?php
include "../db_conn.php";
session_start();
if (isset($_POST['created_at']) && isset($_POST['time']) && isset($_POST['systolic']) && isset($_POST['diastolic'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $created_at = validate($_POST['created_at']);
    $time = validate($_POST['time']);
    $systolic = validate($_POST['systolic']);
    $diastolic = validate($_POST['diastolic']);

    $stmt = $conn->prepare("INSERT INTO tbl_blood_pressures (systolic, diastolic, time, patient_id, created_at) 
    VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('sssis', $systolic, $diastolic, $time, $_SESSION['id'], $created_at);
    $stmt->execute();
    $result = $stmt->get_result();
    header("Location: ../pages/patient/home.php?bp_success");
    exit();
} else {
    header("Location: ../pages/patient/home.php?bp_error");
    exit();
}
