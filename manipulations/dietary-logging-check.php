<?php
include "../db_conn.php";

session_start();

if (isset($_POST['meal_id']) && isset($_POST['month']) && isset($_POST['day']) && 
    isset($_POST['year']) && isset($_POST['time']) && isset($_POST['food_name']) && 
    isset($_POST['carbohydrates']) && isset($_POST['blood_sugar_level'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $meal_id = validate($_POST['meal_id']);
    $month = validate($_POST['month']);
    $day = validate($_POST['day']);
    $year = validate($_POST['year']);
    $time = validate($_POST['time']);
    $food_name = validate($_POST['food_name']);
    $carbohydrates = validate($_POST['carbohydrates']);
    $blood_sugar_level = validate($_POST['blood_sugar_level']);

    $stmt = $conn->prepare("INSERT INTO tbl_dietary_logging(meal_id, month, day, year, time, food_name, carbohydrates, blood_sugar_level, seeker_id) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('iiiissssi', $meal_id, $month, $day, $year, $time, $food_name, $carbohydrates, $blood_sugar_level, $_SESSION['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    header("Location: ../pages/seeker/dietary-logging.php?success");
    exit();
    
} else {
    header("Location: ../pages/dietary-logging.php?error=Unknown error occured.");
    exit();
}
