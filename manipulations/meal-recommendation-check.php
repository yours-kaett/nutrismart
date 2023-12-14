<?php
include "../db_conn.php";

session_start();

if (isset($_POST['time']) && isset($_POST['rice']) && 
    isset($_POST['viand']) && isset($_POST['ingredients']) && 
    isset($_POST['carbohydrates']) && isset($_POST['protein']) && 
    isset($_POST['fat']) && isset($_POST['fiber'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $hp_id = $_SESSION['id'];
    $meal_id = $_GET['meal_id'];
    $time = validate($_POST['time']);
    $rice = validate($_POST['rice']);
    $viand = validate($_POST['viand']);
    $ingredients = validate($_POST['ingredients']);
    $carbohydrates = validate($_POST['carbohydrates']);
    $protein = validate($_POST['protein']);
    $fat = validate($_POST['fat']);
    $fiber = validate($_POST['fiber']);

    $stmt = $conn->prepare(' SELECT viand FROM tbl_dietary_meal WHERE viand = ? ');
    $stmt->bind_param('s', $viand);
    $stmt->execute();
    $result = $stmt->get_result();
    if (mysqli_num_rows($result) > 0) {
        header("Location: ../pages/health-provider/meal-recommendations.php?exist");
        exit();
    } else {
        $stmt = $conn->prepare("INSERT INTO tbl_dietary_meal (meal_id, time, rice, viand, ingredients, carbohydrates, protein, fat, fiber, hp_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('issssssssi', $meal_id, $time, $rice, $viand, $ingredients, $carbohydrates, $protein, $fat, $fiber, $hp_id);
        $stmt->execute();
        $result = $stmt->get_result();
        header("Location: ../pages/health-provider/meal-recommendations.php?success");
        exit();
    }
    
} else {
    header("Location: ../pages/health-provider/meal-recommendations.php?error");
    exit();
}
