<?php
include "../db_conn.php";

session_start();

if (isset($_POST['meal_id']) && isset($_POST['time']) && isset($_POST['rice']) && 
    isset($_POST['viand']) && isset($_POST['carbohydrates']) && isset($_POST['protein']) && 
    isset($_POST['fat']) && isset($_POST['fiber']) && isset($_POST['blood_sugar_level']) &&
    isset($_POST['date'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $patient_id = $_SESSION['id'];
    $meal_id = validate($_POST['meal_id']);
    $time = validate($_POST['time']);
    $rice = validate($_POST['rice']);
    $viand = validate($_POST['viand']);
    $carbohydrates = validate($_POST['carbohydrates']);
    $protein = validate($_POST['protein']);
    $fat = validate($_POST['fat']);
    $fiber = validate($_POST['fiber']);
    $blood_sugar_level = validate($_POST['blood_sugar_level']);
    $date = validate($_POST['date']);

    $stmt = $conn->prepare("INSERT INTO tbl_dietary_logging(meal_id, time, rice, viand, carbohydrates, protein, fat, fiber, blood_sugar_level, date, patient_id) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('isssssssssi', $meal_id, $time, $rice, $viand, $carbohydrates, $protein, $fat, $fiber, $blood_sugar_level, $date, $patient_id);
    $stmt->execute();
    $result = $stmt->get_result();
    header("Location: ../pages/seeker/dietary-logging.php?success");
    exit();
    
} else {
    header("Location: ../pages/dietary-logging.php?error=Unknown error occured.");
    exit();
}
