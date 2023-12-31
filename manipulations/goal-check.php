<?php
include "../db_conn.php";

session_start();

if (isset($_POST['date']) && isset($_POST['time']) && isset($_POST['title']) && isset($_POST['description'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $date = validate($_POST['date']);
    $time = validate($_POST['time']);
    $title = validate($_POST['title']);
    $description = validate($_POST['description']);

    $stmt = $conn->prepare("INSERT INTO tbl_goals (date, time, title, description, patient_id) 
    VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('ssssi', $date, $time, $title, $description, $_SESSION['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    header("Location: ../pages/patient/goals.php?success");
    exit();
} else {
    header("Location: ../pages/patient/goals.php?error");
    exit();
}
