<?php
include '../../db_conn.php';
session_start();
if ($_SESSION['username']) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Nutrismart</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../bootstrap/js/bootstrap.bundle.min.js">
        <link rel="stylesheet" href="../../bootstrap-icons/bootstrap-icons.css">
        <link rel="stylesheet" href="../../style.css">
        <link rel="icon" href="../../img/logo.png">
    </head>

    <body>
        <header>
            <div class="d-flex align-items-center justify-content-between top-0 fixed-top px-3 py-2">
                <h3>NutriSmart</h3>
                <a href="#" class="mx-2" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle fs-3 fw-bolder"></i>
                </a>
            </div>
        </header>
        <main>
            <div class="container ref mt-5">
                <h3 class="fw-bold mt-5 mb-4">Dietary Monitoring</h3>
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <input type="date" class="ref-input me-4" style="font-size: 12px;" id="selectedDate">
                            <div>
                                <button class="btn-outline btn-sm ps-3 pe-3 py-2" style="width: 100px;" type="button" id="day_Records">
                                    <i class="bi bi-search"></i>&nbsp; Find</button>
                            </div>
                        </div>

                        <div class="table-responsive" id="table">
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
                                <tbody>
                                    <?php
                                    $stmt = $conn->prepare(' SELECT 
                                    tbl_meal.meal,
                                    tbl_dietary_logging.food_name,
                                    tbl_dietary_logging.carbohydrates,
                                    tbl_dietary_logging.blood_sugar_level,
                                    tbl_dietary_logging.seeker_id,
                                    tbl_dietary_logging.time
                                    FROM tbl_dietary_logging
                                    INNER JOIN tbl_meal ON tbl_dietary_logging.meal_id = tbl_meal.id
                                    WHERE tbl_dietary_logging.seeker_id = ? ');
                                    $stmt->bind_param('i', $_SESSION['id']);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
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
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer>
            <div class="d-flex align-items-center justify-content-between bottom-0 fixed-bottom px-3">
                <a href="home.php">
                    <i class="bi bi-house-door fs-4"></i>
                </a>
                <a href="goals.php">
                    <i class="bi bi-flag fs-4"></i>
                </a>
                <a href="dietary-logging.php">
                    <i class="bi bi-patch-plus" style="font-size: 40px;"></i>
                </a>
                <a href="meal-recommendations.php">
                    <i class="bi bi-basket fs-4"></i>
                </a>
                <a href="dietary-monitoring.php" style="color: #c3ffeb !important;">
                    <i class="bi bi-bar-chart-line-fill fs-4"></i>
                </a>
            </div>
        </footer>
    </body>

    <script>
        document.getElementById('day_Records').addEventListener('click', function() {
            var selectedDate = document.getElementById('selectedDate').value;
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById('table').innerHTML = xhr.responseText;
                }
            };
            xhr.open('GET', '../../manipulations/filter_records_day.php?selectedDate=' + selectedDate, true);
            xhr.send();
        });
    </script>

    </html>

<?php
} else {
    header("Location: ../../index.php");
}
