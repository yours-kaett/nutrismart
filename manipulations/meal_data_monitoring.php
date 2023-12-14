<?php
include "../db_conn.php";
session_start();

if ($_SESSION['id']) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $patient_id = $_SESSION['id'];
        $selectedDate = $_POST['selectedDate'];
        $stmt = $conn->prepare('SELECT
        tbl_meal.meal,
        tbl_dietary_logging.time,
        tbl_dietary_logging.rice,
        tbl_dietary_logging.viand,
        tbl_dietary_logging.carbohydrates,
        tbl_dietary_logging.protein,
        tbl_dietary_logging.fat,
        tbl_dietary_logging.fiber,
        tbl_dietary_logging.total_grams,
        tbl_dietary_logging.blood_sugar_level
        FROM tbl_dietary_logging 
        INNER JOIN tbl_meal ON tbl_dietary_logging.meal_id = tbl_meal.id
        WHERE tbl_dietary_logging.patient_id = ? AND tbl_dietary_logging.date = ?');
        $stmt->bind_param('is', $patient_id, $selectedDate);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[strtolower($row['meal'])] = $row;
        }

        if (!empty($data)) {
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            echo json_encode(['error' => 'No data found for the selected date']);
        }
        $stmt->close();
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid request']);
    }
} else {
    header('Location: ../index.php');
    exit;
}
?>
