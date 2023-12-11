<?php
include '../../db_conn.php';
session_start();
if ($_SESSION['id']) {
    $patient_id = $_SESSION['id'];
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
            <div class="ref mt-5 mb-5 min-vh-100">
                <h3 class="fw-bold mt-5 mb-4">Dietary Monitoring</h3>
                <select class="form-select mb-3 w-50" id="selectedDate">
                    <option disabled selected>- select date -</option>
                    <?php
                    $stmt = $conn->prepare(' SELECT date FROM tbl_dietary_logging WHERE patient_id = ? ');
                    $stmt->bind_param('i', $patient_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($rows = $result->fetch_assoc()) {
                        $date = $rows['date'];
                        echo '<option value=' . $date . '>' . $date . '</option>';
                    }
                    ?>
                </select>
                <div class="d-flex flex-column mt-2 ps-0">
                    <span class="text-white fw-bold meal" data-meal-id="Breakfast">Breakfast</span>
                    <span class="text-secondary small">Time: 
                        <span class="text-white" id="time"></span>
                    </span>
                    <span class="text-secondary small">Rice: 
                        <span class="text-white" id="rice"></span>
                    </span>
                    <span class="text-secondary small">Viand: 
                        <span class="text-white" id="viand"></span>
                    </span>
                    <span class="text-secondary small">Carbohydrates: 
                        <span class="text-white" id="carbohydrates"></span>
                    </span>
                    <span class="text-secondary small">Protein: 
                        <span class="text-white" id="protein"></span>
                    </span>
                    <span class="text-secondary small">Fat: 
                        <span class="text-white" id="fat"></span>
                    </span>
                    <span class="text-secondary small">Fiber: 
                        <span class="text-white" id="fiber"></span>
                    </span>
                    <span class="text-secondary small">Blood Sugar Level: 
                        <span class="text-white" id="blood_sugar_level"></span>
                    </span>
                </div>

                <div class="d-flex flex-column mt-2 ps-0">
                    <span class="text-white fw-bold meal" data-meal-id="Lunch">Lunch</span>
                    <span class="text-secondary small">Time: 
                        <span class="text-white" id="time"></span>
                    </span>
                    <span class="text-secondary small">Rice: 
                        <span class="text-white" id="rice"></span>
                    </span>
                    <span class="text-secondary small">Viand: 
                        <span class="text-white" id="viand"></span>
                    </span>
                    <span class="text-secondary small">Carbohydrates: 
                        <span class="text-white" id="carbohydrates"></span>
                    </span>
                    <span class="text-secondary small">Protein: 
                        <span class="text-white" id="protein"></span>
                    </span>
                    <span class="text-secondary small">Fat: 
                        <span class="text-white" id="fat"></span>
                    </span>
                    <span class="text-secondary small">Fiber: 
                        <span class="text-white" id="fiber"></span>
                    </span>
                    <span class="text-secondary small">Blood Sugar Level: 
                        <span class="text-white" id="blood_sugar_level"></span>
                    </span>
                </div>

                <div class="d-flex flex-column mt-2 ps-0">
                    <span class="text-white fw-bold meal" data-meal-id="Dinner">Dinner</span>
                    <span class="text-secondary small">Time: 
                        <span class="text-white" id="time"></span>
                    </span>
                    <span class="text-secondary small">Rice: 
                        <span class="text-white" id="rice"></span>
                    </span>
                    <span class="text-secondary small">Viand: 
                        <span class="text-white" id="viand"></span>
                    </span>
                    <span class="text-secondary small">Carbohydrates: 
                        <span class="text-white" id="carbohydrates"></span>
                    </span>
                    <span class="text-secondary small">Protein: 
                        <span class="text-white" id="protein"></span>
                    </span>
                    <span class="text-secondary small">Fat: 
                        <span class="text-white" id="fat"></span>
                    </span>
                    <span class="text-secondary small">Fiber: 
                        <span class="text-white" id="fiber"></span>
                    </span>
                    <span class="text-secondary small">Blood Sugar Level: 
                        <span class="text-white" id="blood_sugar_level"></span>
                    </span>
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

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            function updateDietaryInfo(selectedDate) {
                $.ajax({
                    type: 'POST',
                    url: '../../manipulations/meal_data_monitoring.php',
                    data: { selectedDate: selectedDate },
                    dataType: 'json',
                    success: function (data) {
                        $('.meal').each(function () {
                            var mealId = $(this).data('meal-id');
                            $(this).find('.time').text(data[mealId.toLowerCase()].time);
                            $(this).find('.rice').text(data[mealId.toLowerCase()].rice);
                            $(this).find('.viand').text(data[mealId.toLowerCase()].viand);
                            $(this).find('.carbohydrates').text(data[mealId.toLowerCase()].carbohydrates);
                            $(this).find('.protein').text(data[mealId.toLowerCase()].protein);
                            $(this).find('.fat').text(data[mealId.toLowerCase()].fat);
                            $(this).find('.fiber').text(data[mealId.toLowerCase()].fiber);
                            $(this).find('.blood_sugar_level').text(data[mealId.toLowerCase()].blood_sugar_level);
                        });
                    },
                    error: function (error) {
                        console.error('Error fetching data:', error);
                    }
                });
            }
            $('#selectedDate').on('change', function () {
                var selectedDate = $(this).val();
                updateDietaryInfo(selectedDate);
            });
        });
    </script>

    <!-- <script>
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
    </script> -->

    </html>

<?php
} else {
    header("Location: ../../index.php");
}
