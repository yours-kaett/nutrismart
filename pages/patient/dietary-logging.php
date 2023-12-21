<?php
include '../../db_conn.php';
session_start();
if ($_SESSION['id']) {

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
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
                <h3 class="fw-bold mt-5 mb-4">Dietary Logging</h3>
                <div class="container w-100">
                    <?php
                    if (isset($_GET['success'])) {
                    ?>
                        <p class="alert d-flex align-items-center justify-content-between rounded-0 text-white text-center bg-success p-2 mb-2" data-bs-toggle="alert">
                            <?php echo $_GET['success'], "Dietary logging created successfully." ?>
                            <a href="dietary-logging.php">
                                <button type="button" class="btn-close" role="button"></button>
                            </a>
                        </p>
                    <?php
                    }
                    if (isset($_GET['exist'])) {
                        ?>
                            <p class="alert d-flex align-items-center justify-content-between rounded-0 text-primary text-center bg-warning p-2 mb-2" data-bs-toggle="alert">
                                <?php echo $_GET['exist'], "You've already log a meal with that date." ?>
                                <a href="dietary-logging.php">
                                    <button type="button" class="btn-close" role="button"></button>
                                </a>
                            </p>
                        <?php
                        }
                    if (isset($_GET['error'])) {
                    ?>
                        <p class="alert d-flex align-items-center justify-content-between rounded-0 text-white text-center bg-danger w-100 p-2 mb-2">
                            <?php echo $_GET['error'], "Unknown error occured." ?>
                            <a href="dietary-logging.php">
                                <button type="button" class="btn-close" role="button"></button>
                            </a>
                        </p>
                    <?php
                    }
                    ?>
                </div>
                <div class="card mt-2">
                    <form action="../../manipulations/dietary-logging-check.php" method="POST" class="dietary-logs p-4">
                        <div class="w-100">
                            <h6 class="small" style="color: #c3f0ff;">Meals:</h6>
                            <select class="form-select mb-3 w-100 me-5" name="meal_id" id="meal_id">
                                <option disabled selected>- select meal -</option>
                                <?php
                                $stmt = $conn->prepare(' SELECT * FROM tbl_meal ');
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while ($rows = $result->fetch_assoc()) {
                                    $id = $rows['id'];
                                    $meal = $rows['meal'];
                                    echo '
                                    <option value=' . $id . '>' . $meal . '</option>
                                    ';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="w-100">
                            <label class="small mb-2" style="color: #c3f0ff;">Time</label>
                            <input type="text" name="time" id="time" class="ref-input small mb-3 w-100" required>
                        </div>
                        <div class="w-100">
                            <label class="small mb-2" style="color: #c3f0ff;">Rice</label>
                            <input type="text" name="rice" id="rice" class="ref-input small mb-3 w-100" required>
                        </div>
                        <div class="w-100">
                            <label class="small mb-2" style="color: #c3f0ff;">Viand / Other Food</label>
                            <input type="text" name="viand" id="viand" class="ref-input small mb-3 w-100" required>
                        </div>
                        <div class="w-100">
                            <label class="small mb-2" style="color: #c3f0ff;">Ingredients</label>
                            <textarea name="ingredients" id="ingredients" class="ref-input small mb-3 w-100 text-start" cols="30" rows="3" required></textarea>
                        </div>
                        <div class="w-100">
                            <label class="small mb-2" style="color: #c3f0ff;">Carbohydrates (grams)</label>
                            <input type="number" name="carbohydrates" id="carbohydrates" class="ref-input small mb-3 w-100" required>
                        </div>
                        <div class="w-100">
                            <label class="small mb-2" style="color: #c3f0ff;">Protein (grams)</label>
                            <input type="number" name="protein" id="protein" class="ref-input small mb-3 w-100" required>
                        </div>
                        <div class="w-100">
                            <label class="small mb-2" style="color: #c3f0ff;">Fat (grams)</label>
                            <input type="number" name="fat" id="fat" class="ref-input small mb-3 w-100" required>
                        </div>
                        <div class="w-100">
                            <label class="small mb-2" style="color: #c3f0ff;">Fiber (grams)</label>
                            <input type="number" name="fiber" id="fiber" class="ref-input small mb-3 w-100" required>
                        </div>
                        <div class="w-100">
                            <label class="small mb-2" style="color: #c3f0ff;">Total Grams</label>
                            <input type="text" name="total_grams" id="total_grams" value="" class="ref-input small mb-3 w-100" readonly required>
                        </div>
                        <div class="w-100">
                            <label class="small mb-2" style="color: #c3f0ff;">Current Blood Sugar Level (grams)</label>
                            <input type="number" name="blood_sugar_level" id="blood_sugar_level" class="ref-input small mb-3 w-100" required>
                        </div>
                        <div class="w-100">
                            <?php
                            date_default_timezone_set('Asia/Manila');
                            $date = date("Y-m-j");
                            ?>
                            <label class="small mb-2" style="color: #c3f0ff;">Date</label>
                            <input type="date" name="date" id="" value="<?php echo $date ?>" class="ref-input small mb-3 w-100" required>
                        </div>
                        <div class="w-100 mt-2">
                            <button type="submit" class="btn-login w-100 d-flex align-items-center justify-content-center">
                                <span id="save">Save</span>
                            </button>
                        </div>
                        <div class="w-100 mt-2 mb-5">
                            <button class="btn-reset w-100 d-flex align-items-center justify-content-center" type="reset" id="colorButton">
                                Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
        <footer>
            <div class="d-flex align-items-center justify-content-between fixed-bottom px-3">
                <a href="home.php">
                    <i class="bi bi-house-door fs-4"></i>
                </a>
                <a href="goals.php">
                    <i class="bi bi-flag fs-4"></i>
                </a>
                <a href="dietary-logging.php" style="color: #c3ffeb !important;">
                    <i class="bi bi-patch-plus-fill" style="font-size: 40px;"></i>
                </a>
                <a href="meal-recommendations.php">
                    <i class="bi bi-basket fs-4"></i>
                </a>
                <a href="dietary-reports.php">
                    <i class="bi bi-calendar2-week fs-4"></i>
                </a>
            </div>
        </footer>

        <script src="../../bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../../script.js"></script>

        <script>
            $(document).ready(function () {
            // Function to calculate total grams
            function calculateTotalGrams() {
                var carbohydrates = parseFloat($('#carbohydrates').val()) || 0;
                var protein = parseFloat($('#protein').val()) || 0;
                var fat = parseFloat($('#fat').val()) || 0;
                var fiber = parseFloat($('#fiber').val()) || 0;

                var totalGrams = carbohydrates + protein + fat + fiber;
                $('#total_grams').val(totalGrams.toFixed());
            }

            // Event listener for meal select dropdown change
            $('#meal_id').change(function () {
                var mealId = $(this).val();
                $.ajax({
                    url: '../../manipulations/meal_data.php',
                    method: 'POST',
                    data: { meal_id: mealId },
                    dataType: 'json',
                    success: function (data) {
                        $('#time').val(data.time);
                        $('#rice').val(data.rice);
                        $('#viand').val(data.viand);
                        $('#ingredients').val(data.ingredients);
                        $('#carbohydrates').val(data.carbohydrates);
                        $('#protein').val(data.protein);
                        $('#fat').val(data.fat);
                        $('#fiber').val(data.fiber);
                        calculateTotalGrams();
                        document.getElementById("blood_sugar_level").focus();
                    },
                    error: function (error) {
                        console.error('Error fetching data: ', error);
                    }
                });
            });

            // Event listeners for input fields change
            $('#carbohydrates, #protein, #fat, #fiber').on('input', function () {
                calculateTotalGrams();
            });
        });

        </script>
    </body>

    </html>

<?php
} else {
    header('Location ../index.php');
    exit;
}
