<?php
include '../../db_conn.php';
session_start();
if ($_SESSION['id']) {
    $patient_id = $_SESSION['id'];
    $stmt = $conn->prepare(' SELECT * FROM tbl_glucose_levels WHERE patient_id = ?');
    $stmt->bind_param('i', $patient_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $glucose_created_at = $row['created_at'];

    $stmt = $conn->prepare(' SELECT * FROM tbl_glucose_levels WHERE patient_id = ?');
    $stmt->bind_param('i', $patient_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $bp_created_at = $row['created_at'];
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Nutrismart</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../bootstrap/js/bootstrap.bundle.min.js">
        <link rel="stylesheet" href="../../boxicons/css/boxicons.min.css">
        <link rel="stylesheet" href="../../style.css">
        <link rel="icon" href="../../img/logo.png">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <style>
            .cards {
                display: flex;
                flex-wrap: wrap;
            }

            .card-item {
                flex-grow: 1;
                flex-basis: 200;
            }

            .chart-container {
                width: 100%;
                overflow-x: auto;
                /* Enable horizontal scrolling */
                white-space: nowrap;
                /* Prevent line breaks for the bars */
            }
        </style>
    </head>

    <body>
        <header>
            <div class="d-flex align-items-center justify-content-between top-0 fixed-top px-3 py-2">
                <h3>NutriSmart</h3>
                <a href="account.php" class="mx-2">
                    <i class="bx bx-user-circle fs-2"></i>
                </a>
            </div>
        </header>
        <main>
            <div class="container min-vh-100 mb-5 pb-5 px-4">
                <div class="mt-5">
                    <?php
                    if (isset($_GET['bs_success'])) {
                    ?>
                        <p class="alert d-flex align-items-center justify-content-between rounded-0 text-white text-center bg-success p-2 mb-0" data-bs-toggle="alert">
                            <?php echo $_GET['bs_success'], "Glucose value has been saved." ?>
                            <a href="home.php">
                                <button type="button" class="btn-close" role="button"></button>
                            </a>
                        </p>
                    <?php
                    }
                    if (isset($_GET['bs_error'])) {
                    ?>
                        <p class="alert d-flex align-items-center justify-content-between rounded-0 text-white text-center bg-danger p-2 mb-0" data-bs-toggle="alert">
                            <?php echo $_GET['error'], "Error saving glucose value." ?>
                            <a href="home.php">
                                <button type="button" class="btn-close" role="button"></button>
                            </a>
                        </p>
                    <?php
                    }
                    if (isset($_GET['bp_updated'])) {
                    ?>
                        <p class="alert d-flex align-items-center justify-content-between rounded-0 text-white text-center bg-success p-2 mb-0" data-bs-toggle="alert">
                            <?php echo $_GET['updated'], "Blood pressure value has been updated." ?>
                            <a href="home.php">
                                <button type="button" class="btn-close" role="button"></button>
                            </a>
                        </p>
                    <?php
                    }
                    if (isset($_GET['bp_deleted'])) {
                    ?>
                        <p class="alert d-flex align-items-center justify-content-between rounded-0 text-primary text-center bg-warning p-2 mb-0" data-bs-toggle="alert">
                            <?php echo $_GET['deleted'], "Blood pressure value remove successfully." ?>
                            <a href="home.php">
                                <button type="button" class="btn-close" role="button"></button>
                            </a>
                        </p>
                    <?php
                    }
                    if (isset($_GET['bp_success'])) {
                    ?>
                        <p class="alert d-flex align-items-center justify-content-between rounded-0 text-white text-center bg-success p-2 mb-0" data-bs-toggle="alert">
                            <?php echo $_GET['success'], "Blood pressure value has been saved." ?>
                            <a href="home.php">
                                <button type="button" class="btn-close" role="button"></button>
                            </a>
                        </p>
                    <?php
                    }
                    if (isset($_GET['bp_error'])) {
                    ?>
                        <p class="alert d-flex align-items-center justify-content-between rounded-0 text-white text-center bg-danger p-2 mb-0" data-bs-toggle="alert">
                            <?php echo $_GET['error'], "Error saving blood pressure value." ?>
                            <a href="home.php">
                                <button type="button" class="btn-close" role="button"></button>
                            </a>
                        </p>
                    <?php
                    }
                    ?>
                    <p class="pt-4">Glucose Levels</p>
                    <div class="px-4 chart-container">
                        <div style="width: <?php echo $glucose_created_at * 0.8 ?>px;">
                            <canvas id="glucoseChart"></canvas>
                        </div>
                    </div>
                    <?php
                    $stmt = $conn->prepare(' SELECT * FROM tbl_glucose_levels WHERE patient_id = ? ORDER BY created_at ASC');
                    $stmt->bind_param('i', $patient_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        $glucose_created_at = [];
                        $glucoseValues = [];
                        while ($row = $result->fetch_assoc()) {
                            $glucose_created_at[] = $row['created_at'];
                            $glucoseValues[] = $row['glucose_value'];
                        }
                    } else {
                        echo "No glucose data available";
                    }
                    $stmt->close();

                    $stmt = $conn->prepare(' SELECT glucose_value FROM tbl_glucose_levels WHERE patient_id = ? ORDER BY created_at DESC LIMIT 1 ');
                    $stmt->bind_param('i', $patient_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if (mysqli_num_rows($result) > 0) {
                        $row = $result->fetch_assoc();
                        $currentGlucose = $row["glucose_value"];
                        $normalRange = ['min' => 80, 'max' => 120];
                        $cautionRange = ['min' => 121, 'max' => 180];
                        if ($currentGlucose >= $normalRange['min'] && $currentGlucose <= $normalRange['max']) {
                            $indicatorColor = '#00ff15';
                            $status = 'Normal';
                        } elseif ($currentGlucose >= $cautionRange['min'] && $currentGlucose <= $cautionRange['max']) {
                            $indicatorColor = '#ffae00';
                            $status = 'Caution';
                        } else {
                            $indicatorColor = '#ff0000';
                            $status = 'Critical';
                        }
                        echo "
                        <p class='mt-4 mb-0'>Current Glucose Level: 
                            <span style='font-size: 20px; color: $indicatorColor'>$currentGlucose</span>
                        </p>
                        <p>Status: 
                            <span style='font-size: 20px; color: $indicatorColor'>$status</span>
                        </p>";
                    }
                    ?>

                    <hr>

                    <p class="pt-4">Blood Pressures</p>
                    <div class="px-4 chart-container">
                        <div style="width: <?php echo $bp_created_at * 0.8 ?>px;">
                            <canvas id="bpChart"></canvas>
                        </div>
                    </div>
                    <?php
                    $stmt = $conn->prepare(' SELECT * FROM tbl_blood_pressures WHERE patient_id = ? ORDER BY created_at ASC');
                    $stmt->bind_param('i', $patient_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        $bp_created_at = [];
                        $systolicValues = [];
                        while ($row = $result->fetch_assoc()) {
                            $bp_created_at[] = $row['created_at'];
                            $systolicValues[] = $row['systolic'];
                            // $diastolicValues[] = $row['diastolic'];
                        }
                    } else {
                        echo "No blood pressure data available";
                    }
                    $stmt->close();

                    $stmt = $conn->prepare(' SELECT systolic, diastolic FROM tbl_blood_pressures WHERE patient_id = ? ORDER BY created_at DESC LIMIT 1 ');
                    $stmt->bind_param('i', $patient_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result) {
                        while ($row = $result->fetch_assoc()) {
                            $systolic = $row['systolic'];
                            $diastolic = $row['diastolic'];
                            $bloodPressureCategory = interpretBloodPressure($systolic, $diastolic);
                            echo "Systolic: $systolic, Diastolic: $diastolic, Category: $bloodPressureCategory<br>";
                        }
                        $result->close();
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                    function interpretBloodPressure($systolic, $diastolic)
                    {
                        if ($systolic < 120 && $diastolic < 80) {
                            return 'Normal Blood Pressure';
                        } elseif ($systolic >= 120 && $systolic < 130 && $diastolic < 80) {
                            return 'Elevated Blood Pressure';
                        } elseif (($systolic >= 130 && $systolic < 140) || ($diastolic >= 80 && $diastolic < 90)) {
                            return 'Hypertension Stage 1';
                        } elseif ($systolic >= 140 || $diastolic >= 90) {
                            return 'Hypertension Stage 2';
                        } else {
                            return 'Hypertensive Crisis';
                        }
                    }
                    $conn->close();
                    ?>
                    <hr>
                    <div class="cards d-flex w-100">
                        <div class="container card-item col-6 mb-3">
                            <button class="p-3 btn-outline d-flex align-items-center flex-column" type="button" data-bs-toggle="modal" data-bs-target="#glucoseModal">
                                <i class="bx bx-droplet" style="font-size: 50px; margin-bottom: 10px;"></i>
                                <span>Glucose Level</span>
                            </button>
                        </div>
                        <div class="container card-item col-6 mb-3">
                            <button class="p-3 btn-outline d-flex align-items-center flex-column" type="button" data-bs-toggle="modal" data-bs-target="#bpModal">
                                <i class="bx bx-donate-blood" style="font-size: 50px; margin-bottom: 10px;"></i>
                                <span>Blood Pressure</span>
                            </button>
                        </div>
                        <div class="container card-item col-6 mb-3">
                            <a href="dietary-logging.php" class="p-3 btn-outline d-flex align-items-center flex-column">
                                <i class="bx bx-log-in-circle" style="font-size: 50px; margin-bottom: 10px;"></i>
                                <span>Dietary Log</span>
                            </a>
                        </div>
                        <div class="container card-item col-6 mb-3">
                            <a href="#" class="p-3 btn-outline d-flex align-items-center flex-column">
                                <i class="bx bx-rename" style="font-size: 50px; margin-bottom: 10px;"></i>
                                <span>B M I</span>
                            </a>
                        </div>
                        <div class="container card-item col-6 mb-3">
                            <a href="goals.php" class="p-3 btn-outline d-flex align-items-center flex-column">
                                <i class="bx bx-flag" style="font-size: 50px; margin-bottom: 10px;"></i>
                                <span>Set Goal</span>
                            </a>
                        </div>
                        <div class="container card-item col-6 mb-3">
                            <a href="meal-recommendations.php" class="p-3 btn-outline d-flex align-items-center flex-column">
                                <i class="bx bx-podcast" style="font-size: 50px; margin-bottom: 10px;"></i>
                                <span>Recommendations</span>
                            </a>
                        </div>
                        <div class="container card-item col-6 mb-3">
                            <a href="dietary-reports.php" class="p-3 btn-outline d-flex align-items-center flex-column">
                                <i class="bx bx-notepad" style="font-size: 50px; margin-bottom: 10px;"></i>
                                <span>Dietary Reports</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="glucoseModal" tabindex="-1" aria-labelledby="glucoseModalLabel" aria-hidden="true">
                <div class="modal-dialog ref">
                    <div class="modal-content rounded-0">
                        <div class="modal-header">
                            <h6 style="color: #c3f0ff;" class="modal-title" id="glucoseModalLabel">Add Glucose Level</h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="../../manipulations/glucose-level-check.php" method="POST" class="p-4">
                            <?php
                            date_default_timezone_set('Asia/Manila');
                            $date = date('Y-m-j');
                            $time = date('h:i:s');
                            ?>
                            <div class="w-100">
                                <label class="small" style="color: #c3f0ff;">Date</label>
                                <input name="created_at" type="date" value="<?php echo $date ?>" class="ref-input w-100 mb-2" style="font-size: 12px;" id="selectedDate" required>
                            </div>
                            <div class="w-100">
                                <label class="small" style="color: #c3f0ff;">Time</label>
                                <input name="time" type="time" value="<?php echo $time ?>" class="ref-input w-100 mb-2" style="font-size: 12px;" id="selectedDate" required>
                            </div>
                            <div class="w-100">
                                <label class="small" style="color: #c3f0ff;">Glucose Value</label>
                                <input name="glucose_value" type="number" placeholder="Type here..." class="ref-input small mb-3 w-100" required>
                            </div>
                            <div class="w-100 d-flex align-items-center justify-content-between mt-2">
                                <button type="submit" class="btn-login w-100 d-flex align-items-center justify-content-center">
                                    <span id="save">Save</span>
                                </button>&nbsp;
                                <button class="btn-reset w-100 d-flex align-items-center justify-content-center" type="reset" id="colorButton">
                                    Clear
                                </button>
                            </div>
                            <div class="w-100 mt-2">
                                <a href="#" class="btn-outline rounded-4 mt-5 w-100 d-flex align-items-center justify-content-center">
                                    Track glucose levels
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal" id="bpModal" tabindex="-1" aria-labelledby="bpModalLabel" aria-hidden="true">
                <div class="modal-dialog ref">
                    <div class="modal-content rounded-0">
                        <div class="modal-header">
                            <h6 style="color: #c3f0ff;" class="modal-title" id="bpModalLabel">Add Blood Pressure</h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="../../manipulations/blood-pressure-check.php" method="POST" class="p-4">
                            <?php
                            date_default_timezone_set('Asia/Manila');
                            $date = date('Y-m-j');
                            $time = date('h:i:s');
                            ?>
                            <div class="w-100">
                                <label class="small" style="color: #c3f0ff;">Date</label>
                                <input name="created_at" type="date" value="<?php echo $date ?>" class="ref-input w-100 mb-2" style="font-size: 12px;" id="selectedDate" required>
                            </div>
                            <div class="w-100">
                                <label class="small" style="color: #c3f0ff;">Time</label>
                                <input name="time" type="time" value="<?php echo $time ?>" class="ref-input w-100 mb-2" style="font-size: 12px;" id="selectedDate" required>
                            </div>
                            <div class="w-100">
                                <label class="small" style="color: #c3f0ff;">Blood Pressure</label>
                                <div class="d-flex align-items-center justify-content-between">
                                    <input name="systolic" type="number" placeholder="Systolic" class="ref-input small mb-3 w-100 me-2" required>
                                    <input name="diastolic" type="number" placeholder="Diastolic" class="ref-input small mb-3 w-100" required>
                                </div>
                            </div>
                            <div class="w-100 d-flex align-items-center justify-content-between mt-2">
                                <button type="submit" class="btn-login w-100 d-flex align-items-center justify-content-center">
                                    <span id="save">Save</span>
                                </button>&nbsp;
                                <button class="btn-reset w-100 d-flex align-items-center justify-content-center" type="reset" id="colorButton">
                                    Clear
                                </button>
                            </div>
                            <div class="w-100 mt-2">
                                <a href="#" class="btn-outline rounded-4 mt-5 w-100 d-flex align-items-center justify-content-center">
                                    Track blood pressures
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
        <footer>
            <div class="d-flex align-items-center justify-content-between fixed-bottom px-3">
                <a href="#" style="color: #c3ffeb !important;">
                    <i class="bx bxs-home fs-4" style="color: #c3ffeb;"></i>
                </a>
                <a href="goals.php">
                    <i class="bx bx-flag fs-4"></i>
                </a>
                <a href="dietary-logging.php">
                    <i class="bx bx-log-in-circle" style="font-size: 50px;"></i>
                </a>
                <a href="meal-recommendations.php">
                    <i class="bx bx-podcast fs-4"></i>
                </a>
                <a href="dietary-reports.php">
                    <i class="bx bx-notepad fs-4"></i>
                </a>
            </div>
        </footer>
    </body>

    <script>
        var hexColors = [
            '#3498db', '#2ecc71', '#e74c3c', '#f39c12', '#9b59b6',
            '#1abc9c', '#d35400', '#34495e', '#95a5a6', '#c0392b'
        ];
        var ctx = document.getElementById('glucoseChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($glucose_created_at); ?>,
                datasets: [{
                    label: 'Glucose Level',
                    data: <?php echo json_encode($glucoseValues); ?>,
                    borderColor: hexColors,
                    borderWidth: 2,
                }]
            },
            options: {
                maintainAspectRatio: false, // Allow chart to not maintain aspect ratio
                responsive: true, // Make the chart responsive
                scales: {
                    x: {
                        type: 'category', // Use category scale for x-axis
                        maxBarThickness: 50, // Set a maximum bar thickness
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script>
        var hexColors = [
            '#3498db', '#2ecc71', '#e74c3c', '#f39c12', '#9b59b6',
            '#1abc9c', '#d35400', '#34495e', '#95a5a6', '#c0392b'
        ];
        var ctx = document.getElementById('bpChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($bp_created_at); ?>,
                datasets: [{
                    label: 'Blood Pressure',
                    data: <?php echo json_encode($systolicValues); ?>,
                    borderColor: hexColors,
                    borderWidth: 2,
                }]
            },
            options: {
                maintainAspectRatio: false, // Allow chart to not maintain aspect ratio
                responsive: true, // Make the chart responsive
                scales: {
                    x: {
                        type: 'category', // Use category scale for x-axis
                        maxBarThickness: 50, // Set a maximum bar thickness
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <script src="../../bootstrap/js/bootstrap.bundle.min.js"></script>

    </html>

<?php
} else {
    header("Location: ../../index.php");
}
