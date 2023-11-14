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
                <h3 class="fw-bold mt-5 mb-2">Goals</h3>
                <div class="card">
                    <div class="card-body">
                        <?php
                        if (isset($_GET['success'])) {
                        ?>
                            <p class="text-white text-center bg-success p-2 mb-3 w-100" data-bs-toggle="alert">
                                <?php echo $_GET['success'], 'Goal has been set successfully.' ?>
                            </p>
                        <?php
                        }
                        if (isset($_GET['error'])) {
                        ?>
                            <p class="text-white text-center bg-danger p-2 mb-3 w-100"><?php echo $_GET['error'] ?></p>
                        <?php
                        }
                        ?>
                            <?php
                            $stmt = $conn->prepare(' SELECT * FROM tbl_goals WHERE seeker_id = ? ');
                            $stmt->bind_param('i', $_SESSION['id']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($row = $result->fetch_assoc()) {
                                $date = $row['date'];
                                $title = $row['title'];
                                $description = $row['description'];
                                echo '
                                    <hr />
                                    <h6>Date: ' . $date . '</h6>
                                    <h6>Title: ' . $title . '</h6>
                                    <h6>Description: ' . $description . '</h6>
                                ';
                            }
                            ?>
                    </div>
                </div>

                <div class="modal fade" id="addGoalModal" tabindex="-1" aria-labelledby="addGoalModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 style="color: #c3f0ff;" class="modal-title" id="addGoalModalLabel">Set Goal</h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="../manipulations/set-goal-check.php" method="POST" class="p-4">
                                <div class="w-100">
                                    <label class="small" style="color: #c3f0ff;">Date</label>
                                    <input name="date" type="date" class="ref-input w-100 mb-2" style="font-size: 12px;" id="selectedDate">
                                </div>
                                <div class="w-100">
                                    <label class="small" style="color: #c3f0ff;">Title</label>
                                    <input name="title" type="text" placeholder="Type here..." class="ref-input small mb-3 w-100" required>
                                </div>
                                <div class="w-100 d-flex flex-column mb-3">
                                    <label class="small" style="color: #c3f0ff;" for="description">Description</label>
                                    <textarea name="description" id="description" cols="42" rows="3" class="small ps-2 pt-2" style="background-color: #012054d4; color: #c3ffeb; border: none;"></textarea>
                                </div>
                                <div class="w-100 mt-2">
                                    <button class="btn-login w-100 d-flex align-items-center justify-content-center" type="submit">
                                        <span id="save">Set</span>
                                    </button>
                                </div>
                                <div class="w-100 mt-2">
                                    <button class="btn-reset w-100 d-flex align-items-center justify-content-center" type="reset" id="colorButton">
                                        Clear
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer>
            <div class="d-flex align-items-center justify-content-between fixed-bottom px-3">
                <a href="seeker-home.php">
                    <i class="bi bi-house-door fs-4"></i>
                </a>
                <a href="#" style="color: #c3ffeb !important;">
                    <i class="bi bi-flag-fill fs-4"></i>
                </a>
                <a href="dietary-logging.php">
                    <i class="bi bi-patch-plus" style="font-size: 40px;"></i>
                </a>
                <a href="meal-recommendations.php">
                    <i class="bi bi-basket fs-4"></i>
                </a>
                <a href="dietary-monitoring.php">
                    <i class="bi bi-bar-chart-line fs-4"></i>
                </a>
            </div>
            <button class="add-goal" data-bs-toggle="modal" data-bs-target="#addGoalModal">
                <i class="bi bi-pencil-square"></i>
            </button>
        </footer>

        <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../script.js"></script>
        <script>
        </script>
    </body>

    </html>

<?php
} else {
    header('Location ../index.php');
}
