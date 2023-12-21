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
                <div class="w-100 p-4" style="margin-bottom: 120px;">
                <?php
                $stmt = $conn->prepare(' SELECT * FROM tbl_goals WHERE id = ? ');
                $stmt->bind_param('i', $_GET['id']);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $goal_id = $row['id'];
                $date = $row['date'];
                $title = $row['title'];
                $description = $row['description'];
                ?>
                    <form action="../../manipulations/edit-goal-check.php?id=<?php echo $goal_id ?>" method="POST" class="p-4">
                        <div class="w-100">
                            <label class="small" style="color: #c3f0ff;">Date</label>
                            <input value="<?php echo $date ?>" name="date" type="date" class="ref-input w-100 mb-2" style="font-size: 12px;" id="selectedDate" required>
                        </div>
                        <div class="w-100">
                            <label class="small" style="color: #c3f0ff;">Title</label>
                            <input value="<?php echo $title ?>" name="title" type="text" placeholder="Type here..." class="ref-input small mb-3 w-100" required>
                        </div>
                        <div class="w-100 d-flex flex-column mb-3">
                            <label class="small" style="color: #c3f0ff;" for="description">Description</label>
                            <textarea name="description" id="description" placeholder="Type here..." cols="42" rows="3" class="ref-input small ps-2 pt-2 w-100" required>
                            <?php echo $description ?>
                            </textarea>
                        </div>
                        <div class="w-100 mt-2">
                            <button type="submit" class="btn-login w-100 d-flex align-items-center justify-content-center">
                                <span id="save">Update</span>
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
                <a href="goals.php" style="color: #c3ffeb !important;">
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
