<?php
include "../db_conn.php";
session_start();
if ($_SESSION['id']) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['meal_id'])) {
        $meal_id = mysqli_real_escape_string($conn, $_POST['meal_id']);
        $stmt = $conn->prepare('SELECT * FROM tbl_dietary_meal WHERE meal_id = ?');
        $stmt->bind_param('i', $meal_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            echo json_encode([]);
        }
        $stmt->close();
    } else {
        echo json_encode([]);
    }
    $conn->close();
} else {
    header('Location ../index.php');
    exit;
}
