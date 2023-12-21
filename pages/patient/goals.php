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
                <div  class="w-100 p-4" style="margin-bottom: 120px;">
                    
                        <?php
                        if (isset($_GET['success'])) {
                        ?>
                            <p class="alert d-flex align-items-center justify-content-between rounded-0 text-white text-center bg-success p-2 mb-4" data-bs-toggle="alert">
                                <?php echo $_GET['success'], "Goal has been set successfully." ?>
                                <a href="goals.php">
                                    <button type="button" class="btn-close" role="button"></button>
                                </a>
                            </p>
                        <?php
                        }
                        if (isset($_GET['updated'])) {
                            ?>
                                <p class="alert d-flex align-items-center justify-content-between rounded-0 text-white text-center bg-success p-2 mb-4" data-bs-toggle="alert">
                                    <?php echo $_GET['updated'], "Goal has been updated successfully." ?>
                                    <a href="goals.php">
                                        <button type="button" class="btn-close" role="button"></button>
                                    </a>
                                </p>
                            <?php
                            }
                            if (isset($_GET['deleted'])) {
                                ?>
                                    <p class="alert d-flex align-items-center justify-content-between rounded-0 text-primary text-center bg-warning p-2 mb-4" data-bs-toggle="alert">
                                        <?php echo $_GET['deleted'], "Goal remove successfully." ?>
                                        <a href="goals.php">
                                            <button type="button" class="btn-close" role="button"></button>
                                        </a>
                                    </p>
                                <?php
                                }
                        if (isset($_GET['error'])) {
                        ?>
                            <p class="alert d-flex align-items-center justify-content-between rounded-0 text-white text-center bg-danger p-2 mb-4" data-bs-toggle="alert">
                                <?php echo $_GET['error'], "Error setting up goal." ?>
                                <a href="goals.php">
                                    <button type="button" class="btn-close" role="button"></button>
                                </a>
                            </p>
                        <?php
                        }
                        ?>
                        <?php
                        $stmt = $conn->prepare(' SELECT * FROM tbl_goals WHERE patient_id = ? ');
                        $stmt->bind_param('i', $_SESSION['id']);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()) {
                            $id = $row['id'];
                            $date = $row['date'];
                            $title = $row['title'];
                            $description = $row['description'];
                            echo '
                                    <h6>Date: ' . $date . '</h6>
                                    <h6>Title: ' . $title . '</h6>
                                    <h6>Description: ' . $description . '</h6>
                                    <a href="edit-goal.php?id='. $id .'">
                                        <button class="btn btn-sm btn-primary pb-0 pt-0" type="button">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </a>
                                    <a href="../../manipulations/delete-goal-check.php?id='. $id .'">
                                        <button class="btn btn-sm btn-danger pb-0 pt-0" type="button">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </a>
                                    <hr />
                                ';
                        }
                        ?>
                    
                </div>

                <div class="modal" id="addGoalModal" tabindex="-1" aria-labelledby="addGoalModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content rounded-0">
                            <div class="modal-header">
                                <h6 style="color: #c3f0ff;" class="modal-title" id="addGoalModalLabel">Set Goal</h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="../../manipulations/goal-check.php" method="POST" class="p-4">
                                <div class="w-100">
                                    <label class="small" style="color: #c3f0ff;">Date</label>
                                    <input name="date" type="date" class="ref-input w-100 mb-2" style="font-size: 12px;" id="selectedDate" required>
                                </div>
                                <div class="w-100">
                                    <label class="small" style="color: #c3f0ff;">Title</label>
                                    <input name="title" type="text" placeholder="Type here..." class="ref-input small mb-3 w-100" required>
                                </div>
                                <div class="w-100 d-flex flex-column mb-3">
                                    <label class="small" style="color: #c3f0ff;" for="description">Description</label>
                                    <textarea name="description" id="description" placeholder="Type here..." cols="42" rows="3" class="ref-input small ps-2 pt-2 w-100" required></textarea>
                                </div>
                                <div class="w-100 mt-2">
                                    <button type="submit" class="btn-login w-100 d-flex align-items-center justify-content-center">
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
                <a href="home.php">
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
                <a href="dietary-reports.php">
                    <i class="bi bi-calendar2-week fs-4"></i>
                </a>
            </div>
            <button class="add-goal pb-0 rounded-0" data-bs-toggle="modal" data-bs-target="#addGoalModal">
                <i class="bi bi-pencil-square"></i>
            </button>
        </footer>

        <script src="../../bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../../script.js"></script>
        <script>
        </script>
    </body>

    </html>

<?php
} else {
    header('Location ../../index.php');
}
