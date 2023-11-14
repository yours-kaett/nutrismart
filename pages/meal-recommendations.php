<?php
include '../db_conn.php';
session_start();
if ($_SESSION['username']) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include "../includes/head.php" ?>
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
                            $stmt = $conn->prepare(' SELECT * FROM tbl_meal_recom WHERE meal_id = ?');
                            $stmt->bind_param('i', $meal_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($rows = $result->fetch_assoc()) {
                                $b += 1;
                                echo '
                                <div class="accordion mt-2" id="accordionExample">
                                    <div class="accordion-item" style="background-color: transparent !important; color: #c3ffeb !important;">
                                        <h2 class="accordion-header" id="' . $rows['item_name'] . '" >
                                            <button style="background-color: transparent !important; color: #c3ffeb !important; padding: 8px;" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#item' . $rows['id'] . '" aria-expanded="false" aria-controls="' . $rows['description'] . '">
                                                ' . $b . ".  " . $rows['item_name'] . '
                                            </button>
                                        </h2>
                                        <div id="item' . $rows['id'] . '" class="accordion-collapse collapse" aria-labelledby="' . $rows['item_name'] . '" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                ' . $rows['description'] . '
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
                            $stmt = $conn->prepare(' SELECT * FROM tbl_meal_recom WHERE meal_id = ?');
                            $stmt->bind_param('i', $meal_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($rows = $result->fetch_assoc()) {
                                $l += 1;
                                echo '
                                <div class="accordion mt-2" id="accordionExample">
                                    <div class="accordion-item" style="background-color: transparent !important; color: #c3ffeb !important;">
                                        <h2 class="accordion-header" id="' . $rows['item_name'] . '" >
                                            <button style="background-color: transparent !important; color: #c3ffeb !important; padding: 8px;" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#item' . $rows['id'] . '" aria-expanded="false" aria-controls="' . $rows['description'] . '">
                                                ' . $l . ".  " . $rows['item_name'] . '
                                            </button>
                                        </h2>
                                        <div id="item' . $rows['id'] . '" class="accordion-collapse collapse" aria-labelledby="' . $rows['item_name'] . '" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                ' . $rows['description'] . '
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
                            $stmt = $conn->prepare(' SELECT * FROM tbl_meal_recom WHERE meal_id = ?');
                            $stmt->bind_param('i', $meal_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($rows = $result->fetch_assoc()) {
                                $d += 1;
                                echo '
                                <div class="accordion mt-2" id="accordionExample">
                                    <div class="accordion-item" style="background-color: transparent !important; color: #c3ffeb !important;">
                                        <h2 class="accordion-header" id="' . $rows['item_name'] . '" >
                                            <button style="background-color: transparent !important; color: #c3ffeb !important; padding: 8px;" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#item' . $rows['id'] . '" aria-expanded="false" aria-controls="' . $rows['description'] . '">
                                                ' . $d . ".  " . $rows['item_name'] . '
                                            </button>
                                        </h2>
                                        <div id="item' . $rows['id'] . '" class="accordion-collapse collapse" aria-labelledby="' . $rows['item_name'] . '" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                ' . $rows['description'] . '
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
        </main>
        <footer>
            <div class="d-flex align-items-center justify-content-between bottom-0 fixed-bottom px-3">
                <a href="seeker-home.php">
                    <i class="bi bi-house-door fs-4"></i>
                </a>
                <a href="goals.php">
                    <i class="bi bi-flag fs-4"></i>
                </a>
                <a href="dietary-logging.php">
                    <i class="bi bi-patch-plus" style="font-size: 40px;"></i>
                </a>
                <a href="#" style="color: #c3ffeb !important;">
                    <i class="bi bi-basket-fill fs-4"></i>
                </a>
                <a href="dietary-monitoring.php">
                    <i class="bi bi-bar-chart-line fs-4"></i>
                </a>
            </div>
        </footer>

        <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../script.js"></script>

    </body>

    </html>

<?php
} else {
    header("Location: ../index.php");
}
