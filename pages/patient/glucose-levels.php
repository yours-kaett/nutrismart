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
            .chart-container {
                width: 100%;
                overflow-x: auto;
                white-space: nowrap;
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
                            <span style='font-size: 20px;'>$currentGlucose</span>
                        </p>
                        <p>Status: 
                            <span style='font-size: 20px; color: $indicatorColor'>$status</span>
                        </p>";
                    }
                    ?>

                    <hr>

                    <div class="">
                        <div class="table-responsive">
                            <table class="table text-white">
                                <thead>
                                    <tr>
                                        <th>Glucose Value</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $conn->prepare(' SELECT * FROM tbl_glucose_levels WHERE patient_id = ? ');
                                    $stmt->bind_param('i', $patient_id);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    while($row = $result->fetch_assoc()){
                                        $glucose_value = $row['glucose_value'];
                                        $date = $row['created_at'];
                                        $time = $row['time'];
                                        echo "
                                        <tr>
                                        <td>$glucose_value</td>
                                        <td>$date</td>
                                        <td>$time</td>
                                        </tr>
                                        ";
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
            <div class="d-flex align-items-center justify-content-between fixed-bottom px-3">
                <a href="home.php">
                    <i class="bx bx-home fs-4"></i>
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
    <script src="../../bootstrap/js/bootstrap.bundle.min.js"></script>

    </html>

<?php
} else {
    header("Location: ../../index.php");
}
