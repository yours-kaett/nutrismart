<?php
include "../db_conn.php";

session_start();

if (isset($_POST['date']) && isset($_POST['title']) && isset($_POST['description'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $goal_id = $_GET['id'];
    $date = validate($_POST['date']);
    $title = validate($_POST['title']);
    $description = validate($_POST['description']);

    $stmt = $conn->prepare("UPDATE tbl_goals SET date = ?, title = ?, description = ? WHERE id = ?");
    $stmt->bind_param('sssi', $date, $title, $description, $goal_id);
    $stmt->execute();

    header("Location: ../pages/patient/goals.php?updated");
    exit();
} else {
    header("Location: ../pages/patient/goals.php?error");
    exit();
}
