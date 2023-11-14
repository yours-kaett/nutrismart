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
    $date = validate($_POST['date']);
    $title = validate($_POST['title']);
    $description = validate($_POST['description']);

    $stmt = $conn->prepare("INSERT INTO tbl_goals (date, title, description, seeker_id) 
    VALUES (?, ?, ?, ?)");
    $stmt->bind_param('sssi', $date, $title, $description, $_SESSION['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    header("Location: ../pages/goals.php?success");
    exit();
    
} else {
    header("Location: ../pages/goals.php?error=Unknown error occured.");
    exit();
}
