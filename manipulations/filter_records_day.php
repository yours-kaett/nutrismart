<?php
include '../db_conn.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['selectedDate'])) {
    $selectedDate = $_GET['selectedDate'];
    list($selectedYear, $selectedMonth, $selectedDay) = explode('-', $selectedDate);

    echo '
        <table class="table">
            <thead class="bg-dark">
                <tr>
                    <th class="small">Meal</th>
                    <th class="small">Food</th>
                    <th class="small">Carbs</th>
                    <th class="small">BS lvl</th>
                    <th class="small">Time</th>
                </tr>
            </thead>
            <tbody>';

    $stmt = $conn->prepare(' SELECT 
        tbl_meal.meal,
        tbl_dietary_logging.food_name,
        tbl_dietary_logging.carbohydrates,
        tbl_dietary_logging.blood_sugar_level,
        tbl_dietary_logging.seeker_id,
        tbl_dietary_logging.time
        FROM tbl_dietary_logging
        INNER JOIN tbl_meal ON tbl_dietary_logging.meal_id = tbl_meal.id
        WHERE tbl_dietary_logging.seeker_id = ?
        AND tbl_dietary_logging.year = ?
        AND tbl_dietary_logging.month = ?
        AND tbl_dietary_logging.day = ? ');

    $stmt->bind_param('iiii', $_SESSION['id'], $selectedYear, $selectedMonth, $selectedDay);
    $stmt->execute();
    $result = $stmt->get_result();

    ob_start();
    while ($rows = $result->fetch_assoc()) {
        $meal = $rows['meal'];
        $food_name = $rows['food_name'];
        $carbohydrates = $rows['carbohydrates'];
        $blood_sugar_level = $rows['blood_sugar_level'];
        $time = $rows['time'];

        echo '
            <tr>
                <td class="small">' . $meal . '</td>
                <td class="small">' . $food_name . '</td>
                <td class="small">' . $carbohydrates . 'g</td>
                <td class="small">' . $blood_sugar_level . 'mg</td>
                <td class="small">' . $time . '</td>
            </tr>
        ';
    }
    
    echo '</tbody> </table>';

    $stmt = $conn->prepare(' SELECT SUM(carbohydrates) AS total_carbs, SUM(blood_sugar_level) AS total_bs, seeker_id
    FROM tbl_dietary_logging WHERE seeker_id = ? AND year = ? AND month = ? AND day = ?');
    $stmt->bind_param('iiii', $_SESSION['id'], $selectedYear, $selectedMonth, $selectedDay);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->fetch_assoc();
    $total_carbs = $rows['total_carbs'];
    $total_bs = $rows['total_bs'];

    if (($total_carbs === null) && ($total_bs === null)) {
        echo '<h6 style="color: #c3f0ff;" class="small text-center">
                <i class="bi bi-cloud-slash"></i>
                &nbsp; No records found.
            </h6>';
    } else {
        echo '
        <h6 style="color: #c3f0ff;" class="small">Consumed Carbohydrates: ' . $total_carbs . 'g </h6>
        <h6 style="color: #c3f0ff;" class="small">Consumed Blood Sugars: ' . $total_bs . 'mg </h6>
        ';
    }

    $filteredRecordsHTML = ob_get_clean();
    echo $filteredRecordsHTML;

}

?>