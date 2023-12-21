<?php
include "../db_conn.php";
session_start();
$goal_id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM tbl_goals WHERE id = ?");
$stmt->bind_param('i', $goal_id);
$stmt->execute();
header("Location: ../pages/patient/goals.php?deleted");
exit();
