<?php
include '../../db_conn.php';
session_start();
if ($_SESSION['id']) {
    $patient_id = $_SESSION['id'];
    $stmt = $conn->prepare(' SELECT * FROM tbl_blood_pressures WHERE patient_id = ?');
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
                        $diastolicValues = [];
                        while ($row = $result->fetch_assoc()) {
                            $bp_created_at[] = $row['created_at'];
                            $systolicValues[] = $row['systolic'];
                            $diastolicValues[] = $row['diastolic'];
                        }
                    } else {
                        echo "No blood pressure data available";
                    }
                    $stmt->close();
                    function interpretBloodPressure($systolic, $diastolic)
                    {
                        $result = [];

                        if ($systolic < 120 && $diastolic < 80) {
                            $result['category'] = 'Normal';
                            $result['color'] = '#00ff15'; // Green
                        } elseif ($systolic >= 120 && $systolic < 130 && $diastolic < 80) {
                            $result['category'] = 'Elevated';
                            $result['color'] = '#ffae00'; // Yellow
                        } elseif (($systolic >= 130 && $systolic < 140) || ($diastolic >= 80 && $diastolic < 90)) {
                            $result['category'] = 'Hypertension Stage 1';
                            $result['color'] = '#ffae00'; // Yellow
                        } elseif ($systolic >= 140 || $diastolic >= 90) {
                            $result['category'] = 'Hypertension Stage 2';
                            $result['color'] = '#ff0000'; // Red
                        } else {
                            $result['category'] = 'Hypertensive Crisis';
                            $result['color'] = '#ff0000'; // Red
                        }

                        return $result;
                    }

                    $stmt = $conn->prepare(' SELECT * FROM tbl_blood_pressures WHERE patient_id = ? ORDER BY created_at DESC LIMIT 1 ');
                    $stmt->bind_param('i', $patient_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $systolic = $row['systolic'];
                        $diastolic = $row['diastolic'];
                    
                        $result = interpretBloodPressure($systolic, $diastolic);
                        $bloodPressureCategory = $result['category'];
                        $indicatorColor = $result['color'];
                    
                        echo "
                            <p class='mt-4 mb-0'>Current Blood Pressure: 
                                <span style='font-size: 20px;'>$systolic/$diastolic</span>
                            </p>
                            <p>Status: <span style='font-size: 20px; color: $indicatorColor'>
                                $bloodPressureCategory</span>
                            </p>";
                    } else {
                        echo $conn->error;
                    }

                    ?>
                    <hr>
                    
                    <div class="table-responsive">
                            <table class="table text-white">
                                <thead>
                                    <tr>
                                        <th>Systolic</th>
                                        <th>Diastolic</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $conn->prepare(' SELECT * FROM tbl_blood_pressures WHERE patient_id = ? ');
                                    $stmt->bind_param('i', $patient_id);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    while($row = $result->fetch_assoc()){
                                        $systolic = $row['systolic'];
                                        $diastolic = $row['diastolic'];
                                        $date = $row['created_at'];
                                        $time = $row['time'];
                                        echo "
                                        <tr>
                                        <td>$systolic</td>
                                        <td>$diastolic</td>
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
            '#f39c12', '#c0392b', '#e74c3c', '#3498db', '#9b59b6',
            '#1abc9c', '#2ecc71', '#34495e', '#95a5a6', '#d35400'
        ];
        var ctx = document.getElementById('bpChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($bp_created_at); ?>,
                datasets: [
                {
                    label: 'Systolic',
                    data: <?php echo json_encode($systolicValues); ?>,
                    borderColor: hexColors[0], // You can choose a color from hexColors array
                    backgroundColor: hexColors[0] + '80', // Set background color with some transparency
                    borderWidth: 2,
                },
                {
                    label: 'Diastolic',
                    data: <?php echo json_encode($diastolicValues); ?>,
                    borderColor: hexColors[1], // You can choose another color from hexColors array
                    backgroundColor: hexColors[1] + '80', // Set background color with some transparency
                    borderWidth: 2,
                }
            ]
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
