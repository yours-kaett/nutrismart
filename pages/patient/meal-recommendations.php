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
        <link rel="stylesheet" href="../../boxicons/css/boxicons.min.css">
        <link rel="stylesheet" href="../../style.css">
        <link rel="icon" href="../../img/logo.png">
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
            <div class="container ref mt-5">
                <h3 class="fw-bold mt-5">Meal Recommendations</h3>
                <div class="w-100 p-3" style="margin-bottom: 120px;">
                    <ul class="nav nav-tabs d-flex" role="tablist">
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100 active" role="tab" data-bs-toggle="tab" data-bs-target="#breakfast-tab">Breakfast</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100" role="tab" data-bs-toggle="tab" data-bs-target="#lunch-tab">Lunch</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100" role="tab" data-bs-toggle="tab" data-bs-target="#dinner-tab">Dinner</button>
                        </li>
                    </ul>
                    <div class="tab-content pt-2">
                        <div class="tab-pane fade show active" role="tabpanel" id="breakfast-tab">
                            <?php
                            $meal_id = 1;
                            $stmt = $conn->prepare(' SELECT * FROM tbl_dietary_meal WHERE meal_id = ?');
                            $stmt->bind_param('i', $meal_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($rows = $result->fetch_assoc()) {
                                $b += 1;
                                echo '
                                <div class="accordion mt-2" id="accordion1">
                                    <div class="accordion-item" style="background-color: transparent !important; color: #c3ffeb !important;">
                                        <h2 class="accordion-header" id="' . $rows['viand'] . '" >
                                            <button style="background-color: transparent !important; color: #c3ffeb !important; padding: 8px;" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#item' . $rows['id'] . '" aria-expanded="false" aria-controls="' . $rows['ingredients'] . '">
                                                ' . $b . ".  " . $rows['viand'] . '
                                            </button>
                                        </h2>
                                        <div id="item' . $rows['id'] . '" class="accordion-collapse collapse" aria-labelledby="' . $rows['viand'] . '" data-bs-parent="#accordion1">
                                            <div class="accordion-body">
                                                Ingredients: <br />' . $rows['ingredients'] . ' <br />
                                                <hr />
                                                Carbohydrates: ' . $rows['carbohydrates'] . 'g<br />
                                                Protein: ' . $rows['protein'] . 'g<br />
                                                Fat: ' . $rows['fat'] . 'g<br />
                                                Fiber: ' . $rows['fiber'] . 'g<br />
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                            }
                            $stmt->close();
                            ?>
                        </div>

                        <div class="tab-pane fade" role="tabpanel" id="lunch-tab">
                            <?php
                            $meal_id = 2;
                            $stmt = $conn->prepare(' SELECT * FROM tbl_dietary_meal WHERE meal_id = ?');
                            $stmt->bind_param('i', $meal_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($rows = $result->fetch_assoc()) {
                                $l += 1;
                                echo '
                                <div class="accordion mt-2" id="accordion2">
                                    <div class="accordion-item" style="background-color: transparent !important; color: #c3ffeb !important;">
                                        <h2 class="accordion-header" id="' . $rows['viand'] . '" >
                                            <button style="background-color: transparent !important; color: #c3ffeb !important; padding: 8px;" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#item' . $rows['id'] . '" aria-expanded="false" aria-controls="' . $rows['ingredients'] . '">
                                                ' . $l . ".  " . $rows['viand'] . '
                                            </button>
                                        </h2>
                                        <div id="item' . $rows['id'] . '" class="accordion-collapse collapse" aria-labelledby="' . $rows['viand'] . '" data-bs-parent="#accordion2">
                                            <div class="accordion-body">
                                                Ingredients: <br />' . $rows['ingredients'] . ' <br />
                                                <hr />
                                                Carbohydrates: ' . $rows['carbohydrates'] . 'g<br />
                                                Protein: ' . $rows['protein'] . 'g<br />
                                                Fat: ' . $rows['fat'] . 'g<br />
                                                Fiber: ' . $rows['fiber'] . 'g<br />
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                            }
                            $stmt->close();
                            ?>
                        </div>

                        <div class="tab-pane fade" role="tabpanel" id="dinner-tab">
                            <?php
                            $meal_id = 3;
                            $stmt = $conn->prepare(' SELECT * FROM tbl_dietary_meal WHERE meal_id = ?');
                            $stmt->bind_param('i', $meal_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($rows = $result->fetch_assoc()) {
                                $d += 1;
                                echo '
                                <div class="accordion mt-2" id="accordion3">
                                    <div class="accordion-item" style="background-color: transparent !important; color: #c3ffeb !important;">
                                        <h2 class="accordion-header" id="' . $rows['viand'] . '" >
                                            <button style="background-color: transparent !important; color: #c3ffeb !important; padding: 8px;" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#item' . $rows['id'] . '" aria-expanded="false" aria-controls="' . $rows['ingredients'] . '">
                                                ' . $d . ".  " . $rows['viand'] . '
                                            </button>
                                        </h2>
                                        <div id="item' . $rows['id'] . '" class="accordion-collapse collapse" aria-labelledby="' . $rows['viand'] . '" data-bs-parent="#accordion3">
                                            <div class="accordion-body">
                                                Ingredients: <br />' . $rows['ingredients'] . ' <br />
                                                <hr />
                                                Carbohydrates: ' . $rows['carbohydrates'] . 'g<br />
                                                Protein: ' . $rows['protein'] . 'g<br />
                                                Fat: ' . $rows['fat'] . 'g<br />
                                                Fiber: ' . $rows['fiber'] . 'g<br />
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                            }
                            $stmt->close();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer>
            <div class="d-flex align-items-center justify-content-between fixed-bottom px-3">
                <a href="home">
                    <i class="bx bx-home fs-4"></i>
                </a>
                <a href="goals.php">
                    <i class="bx bx-flag fs-4"></i>
                </a>
                <a href="dietary-logging.php">
                    <i class="bx bx-log-in-circle" style="font-size: 50px;"></i>
                </a>
                <a href="meal-recommendations.php" style="color: #c3ffeb !important;">
                    <i class="bx bx-podcast fs-4"></i>
                </a>
                <a href="dietary-reports.php">
                    <i class="bx bx-notepad fs-4"></i>
                </a>
            </div>
        </footer>

        <script src="../../bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../../script.js"></script>

    </body>

    </html>

<?php
} else {
    header("Location: ../../index.php");
}
