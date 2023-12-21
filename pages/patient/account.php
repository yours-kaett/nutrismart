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
                <a href="account.php" class="mx-2">
                    <i class="bi bi-person-circle fs-3 fw-bolder"></i>
                </a>
            </div>
        </header>
        <main>
            <div class="container ref min-vh-100">
                <div class="card mt-4">
                    <div class="w-100 d-flex justify-content-center flex-column">
                        <a href="../../logout.php">
                            <button class="btn-outline">
                                <i class="bi bi-power"></i>&nbsp; Logout
                            </button>
                        </a>
                    </div>
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
                <a href="dietary-logging.php">
                    <i class="bi bi-patch-plus" style="font-size: 40px;"></i>
                </a>
                <a href="meal-recommendations.php">
                    <i class="bi bi-basket fs-4"></i>
                </a>
                <a href="dietary-reports.php">
                    <i class="bi bi-bookmarks fs fs-4"></i>
                </a>
            </div>
        </footer>
    </body>

    </html>

<?php
} else {
    header("Location: ../../index.php");
}
