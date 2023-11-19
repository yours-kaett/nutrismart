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
                <h3 class="fw-bold mt-5 mb-4">Dietary Logging</h3>
                <?php
                if (isset($_GET['success'])) {
                ?>
                    <p class="text-white text-center bg-success p-2 mb-3" data-bs-toggle="alert">
                        <?php echo $_GET['success'], 'Dietary logging created successfully.' ?>
                    </p>
                <?php
                }
                if (isset($_GET['error'])) {
                ?>
                    <p class="text-white text-center bg-danger w-100 p-2 mb-2"><?php echo $_GET['error'] ?></p>
                <?php
                }
                ?>
                <div class="card mt-2">
                    <form action="../../manipulations/dietary-logging-check.php" method="POST" class="dietary-logs p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h6 class="small" style="color: #c3f0ff;">Month:</h6>
                                <select class="form-select small" style="width: 100px;" name="month" id="month"></select>
                            </div>
                            <div>
                                <h6 class="small" style="color: #c3f0ff;">Day:</h6>
                                <select class="form-select small" style="width: 100px;" name="day" id="day"></select>
                            </div>
                            <div>
                                <h6 class="small" style="color: #c3f0ff;">Year:</h6>
                                <select class="form-select small" style="width: 100px;" name="year" id="year"></select>
                            </div>
                        </div>
                        <div class="w-100">
                            <h6 class="small" style="color: #c3f0ff;">Meals:</h6>
                            <select class="form-select mb-3 w-100 me-5" name="meal_id">
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
                            <input type="time" name="time" class="ref-input small mb-3 w-100" required>
                        </div>
                        <div class="w-100">
                            <label class="small mb-2" style="color: #c3f0ff;">Food name</label>
                            <input type="text" name="food_name" placeholder="Type here..." class="ref-input small mb-3 w-100" required>
                        </div>
                        <div class="w-100">
                            <label class="small mb-2" style="color: #c3f0ff;">Carbohydrates (g)</label>
                            <input type="number" name="carbohydrates" placeholder="Type here..." class="ref-input small mb-3 w-100" required>
                        </div>
                        <div class="w-100">
                            <label class="small mb-2" style="color: #c3f0ff;">Blood Sugar Level (mg)</label>
                            <input type="number" name="blood_sugar_level" placeholder="Type here..." class="ref-input small mb-3 w-100" required>
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
                <a href="dietary-monitoring.php">
                    <i class="bi bi-bar-chart-line fs-4"></i>
                </a>
            </div>
        </footer>

        <script src="../../bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../../script.js"></script>

        <script>
            // Populate Month options
            const monthSelect = document.getElementById('month');
            for (let i = 1; i <= 12; i++) {
                const option = document.createElement('option');
                option.value = i;
                option.textContent = new Date(0, i - 1, 1).toLocaleString('en-US', {
                    month: 'long'
                });
                monthSelect.appendChild(option);
            }
            // Populate Day options (for initial Month)
            const daySelect = document.getElementById('day');
            updateDayOptions();
            // Populate Year options (adjust range as needed)
            const yearSelect = document.getElementById('year');
            const currentYear = new Date().getFullYear();
            for (let i = currentYear - 23; i <= currentYear + 23; i++) {
                const option = document.createElement('option');
                option.value = i;
                option.textContent = i;
                yearSelect.appendChild(option);
            }
            // Update Day options based on Month selection
            monthSelect.addEventListener('change', function() {
                updateDayOptions();
            });

            function updateDayOptions() {
                const selectedMonth = monthSelect.value;
                const daysInMonth = new Date(new Date().getFullYear(), selectedMonth, 0).getDate();
                daySelect.innerHTML = '';
                for (let i = 1; i <= daysInMonth; i++) {
                    const option = document.createElement('option');
                    option.value = i;
                    option.textContent = i;
                    daySelect.appendChild(option);
                }
            }
        </script>
    </body>

    </html>

<?php
} else {
    header('Location ../index.php');
}
