<?php
include '../../db_conn.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
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
                <h3 class="fw-bold mt-5 mb-4">Dietary Reports</h3>
                <select class="form-select mb-3 w-50" id="selectedDate">
                    <option disabled selected>- select date -</option>
                    <?php
                    $stmt = $conn->prepare(' SELECT * FROM tbl_dietary_logging WHERE patient_id = ? GROUP BY date ');
                    $stmt->bind_param('i', $patient_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($rows = $result->fetch_assoc()) {
                        $date = $rows['date'];
                        echo '<option value=' . $date . '>' . $date . '</option>';
                    }
                    ?>
                </select>
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column mt-2 ps-0">
                            <span class="text-white text-center fw-bold meal" data-meal-id="breakfast">BREAKFAST</span>
                            <span class="text-secondary small">Time:
                                <span class="text-white" id="breakfast_time"></span>
                            </span>
                            <span class="text-secondary small">Rice:
                                <span class="text-white" id="breakfast_rice"></span>
                            </span>
                            <span class="text-secondary small">Viand / Other Food:
                                <span class="text-white" id="breakfast_viand"></span>
                            </span>
                            <span class="text-secondary small">Carbohydrates:
                                <span class="text-white" id="breakfast_carbohydrates"></span>
                            </span>
                            <span class="text-secondary small">Protein:
                                <span class="text-white" id="breakfast_protein"></span>
                            </span>
                            <span class="text-secondary small">Fat:
                                <span class="text-white" id="breakfast_fat"></span>
                            </span>
                            <span class="text-secondary small">Fiber:
                                <span class="text-white" id="breakfast_fiber"></span>
                            </span>
                            <span class="text-secondary small">Grams Obtained:
                                <span class="text-white" id="breakfast_total_grams"></span>
                            </span>
                            <span class="text-secondary small">Blood Sugar Level:
                                <span class="text-white" id="breakfast_blood_sugar_level"></span>
                            </span>

                            <hr />

                            <span class="text-white text-center fw-bold meal" data-meal-id="lunch">LUNCH</span>
                            <span class="text-secondary small">Time:
                                <span class="text-white" id="lunch_time"></span>
                            </span>
                            <span class="text-secondary small">Rice:
                                <span class="text-white" id="lunch_rice"></span>
                            </span>
                            <span class="text-secondary small">Viand:
                                <span class="text-white" id="lunch_viand"></span>
                            </span>
                            <span class="text-secondary small">Carbohydrates:
                                <span class="text-white" id="lunch_carbohydrates"></span>
                            </span>
                            <span class="text-secondary small">Protein:
                                <span class="text-white" id="lunch_protein"></span>
                            </span>
                            <span class="text-secondary small">Fat:
                                <span class="text-white" id="lunch_fat"></span>
                            </span>
                            <span class="text-secondary small">Fiber:
                                <span class="text-white" id="lunch_fiber"></span>
                            </span>
                            <span class="text-secondary small">Grams Obtained:
                                <span class="text-white" id="lunch_total_grams"></span>
                            </span>
                            <span class="text-secondary small">Blood Sugar Level:
                                <span class="text-white" id="lunch_blood_sugar_level"></span>
                            </span>

                            <hr />

                            <span class="text-white text-center fw-bold meal" data-meal-id="dinner">DINNER</span>
                            <span class="text-secondary small">Time:
                                <span class="text-white" id="dinner_time"></span>
                            </span>
                            <span class="text-secondary small">Rice:
                                <span class="text-white" id="dinner_rice"></span>
                            </span>
                            <span class="text-secondary small">Viand:
                                <span class="text-white" id="dinner_viand"></span>
                            </span>
                            <span class="text-secondary small">Carbohydrates:
                                <span class="text-white" id="dinner_carbohydrates"></span>
                            </span>
                            <span class="text-secondary small">Protein:
                                <span class="text-white" id="dinner_protein"></span>
                            </span>
                            <span class="text-secondary small">Fat:
                                <span class="text-white" id="dinner_fat"></span>
                            </span>
                            <span class="text-secondary small">Fiber:
                                <span class="text-white" id="dinner_fiber"></span>
                            </span>
                            <span class="text-secondary small">Grams Obtained:
                                <span class="text-white" id="dinner_total_grams"></span>
                            </span>
                            <span class="text-secondary small">Blood Sugar Level:
                                <span class="text-white" id="dinner_blood_sugar_level"></span>
                            </span>

                            <hr />

                            <span class="text-white small">
                                <span class="text-white fw-bold">DATE: </span>
                                <span id="date"></span>
                            </span>
                            <span class="text-white small mb-5">
                                <span class="text-white fw-bold">OVERALL GRAMS OBTAINED: </span>
                                <span id="overall_grams"></span>
                            </span>

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
                <a href="dietary-reports.php" style="color: #c3ffeb !important;">
                    <i class="bi bi-bookmarksfs-fill fs-4"></i>
                </a>
            </div>
        </footer>
    </body>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            function resetValues() {
                // Reset all the values to an initial state
                $('.text-white[id$="_time"]').text('');
                $('.text-white[id$="_rice"]').text('');
                $('.text-white[id$="_viand"]').text('');
                $('.text-white[id$="_carbohydrates"]').text('');
                $('.text-white[id$="_protein"]').text('');
                $('.text-white[id$="_fat"]').text('');
                $('.text-white[id$="_fiber"]').text('');
                $('.text-white[id$="_total_grams"]').text('');
                $('.text-white[id$="_blood_sugar_level"]').text('');
            }

            function updateDietaryInfo(selectedDate) {
                resetValues();
                $.ajax({
                    type: 'POST',
                    url: '../../manipulations/meal_data_reports.php',
                    data: {
                        selectedDate: selectedDate
                    },
                    dataType: 'json',
                    success: function(data) {
                        // Initialize total grams
                        var overallGrams = 0;

                        // Loop through each meal
                        Object.keys(data).forEach(function(mealId) {
                            // Update individual meal details
                            $('#' + mealId.toLowerCase() + '_time').text(data[mealId].time);
                            $('#' + mealId.toLowerCase() + '_rice').text(data[mealId].rice);
                            $('#' + mealId.toLowerCase() + '_viand').text(data[mealId].viand);
                            $('#' + mealId.toLowerCase() + '_carbohydrates').text(data[mealId].carbohydrates + 'g');
                            $('#' + mealId.toLowerCase() + '_protein').text(data[mealId].protein + 'g');
                            $('#' + mealId.toLowerCase() + '_fat').text(data[mealId].fat + 'g');
                            $('#' + mealId.toLowerCase() + '_fiber').text(data[mealId].fiber + 'g');
                            $('#' + mealId.toLowerCase() + '_total_grams').text(data[mealId].total_grams + 'g');
                            $('#' + mealId.toLowerCase() + '_date').text(data[mealId].date);
                            $('#' + mealId.toLowerCase() + '_blood_sugar_level').text(data[mealId].blood_sugar_level + 'g');

                            // Accumulate total grams
                            overallGrams += parseFloat(data[mealId].total_grams);
                        });

                        // Update overall grams
                        $('#overall_grams').text(overallGrams.toFixed() + 'g');
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    }
                });
            }

            $('#selectedDate').on('change', function() {
                var selectedDate = $(this).val();
                document.getElementById("date").textContent = selectedDate;
                updateDietaryInfo(selectedDate);
            });
        });
    </script>

    </html>

<?php
} else {
    header("Location: ../../index.php");
}
