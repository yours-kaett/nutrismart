<?php
include "../db_conn.php";
session_start();
if (isset($_POST['created_at']) && isset($_POST['bp_value'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $created_at = validate($_POST['created_at']);
    $bp_value = validate($_POST['bp_value']);

    $stmt = $conn->prepare("INSERT INTO tbl_blood_pressures (bp_value, patient_id, created_at) 
    VALUES (?, ?, ?)");
    $stmt->bind_param('sis', $bp_value, $_SESSION['id'], $created_at);
    $stmt->execute();
    $result = $stmt->get_result();
    header("Location: ../pages/patient/home.php?bp_success");
    exit();
} else {
    header("Location: ../pages/patient/home.php?bp_error");
    exit();
}
