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
            <div class="container ref min-vh-100">
                <img src="../img/logo.png" width="90" alt="Nutrismart Logo">
                <div class="card mt-4">
                    <div class="w-100 d-flex justify-content-center flex-column">
                        <a href="dietary-logging.php">
                            <button class="btn-outline mb-2">
                                <i class="bi bi-diagram-3">&nbsp; </i>Setup Dietary Logging
                            </button>
                        </a>
                        <a href="goals.php">
                            <button class="btn-a mb-2">
                                <span>
                                    Set Goals
                                </span>
                            </button>
                        </a>
                        <a href="meal-recommendations.php">
                            <button class="btn-a mb-2">
                                <span>
                                    Meal Recommendations
                                </span>
                            </button>
                        </a>
                        <a href="dietary-monitoring.php">
                            <button class="btn-a mb-2">
                                <span>
                                    Dietary Monitoring
                                </span>
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </main>
        <footer>
            <div class="d-flex align-items-center justify-content-center bottom-0 fixed-bottom">
                <i class="bi bi-house-door-fill fs-2 mb-2" style="color: #c3ffeb;"></i>
            </div>
        </footer>
    </body>

    </html>

<?php
} else {
    header("Location: ../index.php");
}