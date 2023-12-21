<?php
include "../db_conn.php";

session_start();

if (isset($_POST['meal_id']) && isset($_POST['time']) && isset($_POST['rice']) && 
    isset($_POST['viand']) && isset($_POST['ingredients']) && isset($_POST['carbohydrates']) && 
    isset($_POST['protein']) && isset($_POST['fat']) && isset($_POST['fiber']) && 
    isset($_POST['total_grams']) && isset($_POST['blood_sugar_level']) && isset($_POST['date'])) {
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
    $ingredients = validate($_POST['ingredients']);
    $carbohydrates = validate($_POST['carbohydrates']);
    $protein = validate($_POST['protein']);
    $fat = validate($_POST['fat']);
    $fiber = validate($_POST['fiber']);
    $total_grams = validate($_POST['total_grams']);
    $blood_sugar_level = validate($_POST['blood_sugar_level']);
    $date = validate($_POST['date']);

    $stmt = $conn->prepare('SELECT meal_id, date FROM tbl_dietary_logging WHERE meal_id = ? AND date = ?');
    $stmt->bind_param('is', $meal_id, $date);
    $stmt->execute();
    $result = $stmt->get_result();
    if (mysqli_num_rows($result) > 0) {
        header("Location: ../pages/patient/dietary-logging.php?exist");
        exit();
    } else {
        $stmt = $conn->prepare("INSERT INTO tbl_dietary_logging(meal_id, time, rice, viand, ingredients, carbohydrates, protein, fat, fiber, total_grams, blood_sugar_level, date, patient_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('isssssssssssi', $meal_id, $time, $rice, $viand, $ingredients, $carbohydrates, $protein, $fat, $fiber, $total_grams, $blood_sugar_level, $date, $patient_id);
        $stmt->execute();
        $result = $stmt->get_result();
        header("Location: ../pages/patient/dietary-logging.php?success");
        exit();
    }
    
} else {
    header("Location: ../pages/dietary-logging.php?error");
    exit();
}
