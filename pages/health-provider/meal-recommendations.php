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
                <a href="#" class="mx-2" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle fs-3 fw-bolder"></i>
                </a>
            </div>
        </header>
        <main>
            <div class="container ref mt-5">
                <h3 class="fw-bold mt-5">Meal Recommendations</h3>
                <?php
                if (isset($_GET['success'])) {
                ?>
                    <p class="text-white text-center bg-success p-2 mb-2" data-bs-toggle="alert">
                        <?php echo $_GET['success'], 'Meal recommendation added successfully.' ?>
                    </p>
                <?php
                }
                if (isset($_GET['exist'])) {
                    ?>
                        <p class="text-primary text-center bg-warning p-2 mb-2" data-bs-toggle="alert">
                            <?php echo $_GET['exist'], 'Viand / Food already exist.' ?>
                        </p>
                    <?php
                    }
                if (isset($_GET['error'])) {
                ?>
                    <p class="text-white text-center bg-danger p-2 mb-2" data-bs-toggle="alert">
                        <?php echo $_GET['error'], 'Unknown error occured.' ?>
                    </p>
                <?php
                }
                ?>
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
                            $rows = $result->fetch_assoc();
                            $meal_id = $rows['meal_id'];
                            echo '
                                <button class="btn btn-primary btn-sm my-2" data-bs-toggle="modal" data-bs-target="#addBreakfastModal' . $meal_id . '">
                                    <i class="bi bi-plus-lg"></i>&nbsp; Add
                                </button>';
                            ?>
                            <div class="modal" id="addBreakfastModal<?php echo $meal_id ?>" tabindex="-1" aria-labelledby="addBreakfastModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content rounded-0">
                                        <div class="modal-header">
                                            <h6 style="color: #c3f0ff;" class="modal-title" id="addBreakfastModalLabel">Add Breakfast Recommendation</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="../../manipulations/meal-recommendation-check.php?meal_id=<?php echo $meal_id ?>" method="POST" class="p-4">
                                            <div class="w-100">
                                                <label class="small" style="color: #c3f0ff;">Time</label>
                                                <input name="time" type="text" value="07:00 am" class="ref-input w-100 mb-2" style="font-size: 12px;">
                                            </div>
                                            <div class="w-100">
                                                <label class="small" style="color: #c3f0ff;">Rice</label>
                                                <input name="rice" type="text" value="Plain Rice" class="ref-input w-100 mb-2" style="font-size: 12px;">
                                            </div>
                                            <div class="w-100">
                                                <label class="small" style="color: #c3f0ff;">Viand / Other Food</label>
                                                <input name="viand" type="text" placeholder="Type here..." class="ref-input small mb-3 w-100" required>
                                            </div>
                                            <div class="w-100 d-flex flex-column mb-3">
                                                <label class="small" style="color: #c3f0ff;" for="ingredients">Ingredients</label>
                                                <textarea name="ingredients" id="ingredients" cols="42" rows="3" class="small ps-2 pt-2" style="background-color: #012054d4; color: #c3ffeb; border: none;"></textarea>
                                            </div>
                                            <div class="w-100">
                                                <label class="small" style="color: #c3f0ff;">Carbohydrates</label>
                                                <input name="carbohydrates" type="number" placeholder="Type here..." class="ref-input small mb-3 w-100" required>
                                            </div>
                                            <div class="w-100">
                                                <label class="small" style="color: #c3f0ff;">Protein</label>
                                                <input name="protein" type="number" placeholder="Type here..." class="ref-input small mb-3 w-100" required>
                                            </div>
                                            <div class="w-100">
                                                <label class="small" style="color: #c3f0ff;">Fat</label>
                                                <input name="fat" type="number" placeholder="Type here..." class="ref-input small mb-3 w-100" required>
                                            </div>
                                            <div class="w-100">
                                                <label class="small" style="color: #c3f0ff;">Fiber</label>
                                                <input name="fiber" type="number" placeholder="Type here..." class="ref-input small mb-3 w-100" required>
                                            </div>
                                            <div class="w-100 mt-2">
                                                <button type="submit" class="btn-login w-100 d-flex align-items-center justify-content-center">
                                                    <span id="save">Save</span>
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
                            <?php
                            while ($rows = $result->fetch_assoc()) {
                                $b += 1;
                                echo '
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="accordion mt-2 w-100" id="accordion1">
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
                                    </div>&nbsp;
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
                            $rows = $result->fetch_assoc();
                            $meal_id = $rows['meal_id'];
                            echo '
                                <button class="btn btn-primary btn-sm my-2" data-bs-toggle="modal" data-bs-target="#addLunchModal' . $meal_id . '">
                                    <i class="bi bi-plus-lg"></i>&nbsp; Add
                                </button>';
                            ?>
                            <div class="modal" id="addLunchModal<?php echo $meal_id ?>" tabindex="-1" aria-labelledby="addLunchModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content rounded-0">
                                        <div class="modal-header">
                                            <h6 style="color: #c3f0ff;" class="modal-title" id="addLunchModalLabel">Add Lunch Recommendation</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="../../manipulations/meal-recommendation-check.php?meal_id=<?php echo $meal_id ?>" method="POST" class="p-4">
                                            <div class="w-100">
                                                <label class="small" style="color: #c3f0ff;">Time</label>
                                                <input name="time" type="text" value="12:00 pm" class="ref-input w-100 mb-2" style="font-size: 12px;">
                                            </div>
                                            <div class="w-100">
                                                <label class="small" style="color: #c3f0ff;">Rice</label>
                                                <input name="rice" type="text" value="Plain Rice" class="ref-input w-100 mb-2" style="font-size: 12px;">
                                            </div>
                                            <div class="w-100">
                                                <label class="small" style="color: #c3f0ff;">Viand / Other Food</label>
                                                <input name="viand" type="text" placeholder="Type here..." class="ref-input small mb-3 w-100" required>
                                            </div>
                                            <div class="w-100 d-flex flex-column mb-3">
                                                <label class="small" style="color: #c3f0ff;" for="ingredients">Ingredients</label>
                                                <textarea name="ingredients" id="ingredients" cols="42" rows="3" class="small ps-2 pt-2" style="background-color: #012054d4; color: #c3ffeb; border: none;"></textarea>
                                            </div>
                                            <div class="w-100">
                                                <label class="small" style="color: #c3f0ff;">Carbohydrates</label>
                                                <input name="carbohydrates" type="number" placeholder="Type here..." class="ref-input small mb-3 w-100" required>
                                            </div>
                                            <div class="w-100">
                                                <label class="small" style="color: #c3f0ff;">Protein</label>
                                                <input name="protein" type="number" placeholder="Type here..." class="ref-input small mb-3 w-100" required>
                                            </div>
                                            <div class="w-100">
                                                <label class="small" style="color: #c3f0ff;">Fat</label>
                                                <input name="fat" type="number" placeholder="Type here..." class="ref-input small mb-3 w-100" required>
                                            </div>
                                            <div class="w-100">
                                                <label class="small" style="color: #c3f0ff;">Fiber</label>
                                                <input name="fiber" type="number" placeholder="Type here..." class="ref-input small mb-3 w-100" required>
                                            </div>
                                            <div class="w-100 mt-2">
                                                <button type="submit" class="btn-login w-100 d-flex align-items-center justify-content-center">
                                                    <span id="save">Save</span>
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
                            <?php
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
                            $rows = $result->fetch_assoc();
                            $meal_id = $rows['meal_id'];
                            echo '
                                <button class="btn btn-primary btn-sm my-2" data-bs-toggle="modal" data-bs-target="#addDinnerModal' . $meal_id . '">
                                    <i class="bi bi-plus-lg"></i>&nbsp; Add
                                </button>';
                            ?>
                            <div class="modal" id="addDinnerModal<?php echo $meal_id ?>" tabindex="-1" aria-labelledby="addDinnerModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content rounded-0">
                                        <div class="modal-header">
                                            <h6 style="color: #c3f0ff;" class="modal-title" id="addDinnerModalLabel">Add Dinner Recommendation</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="../../manipulations/meal-recommendation-check.php?meal_id=<?php echo $meal_id ?>" method="POST" class="p-4">
                                            <div class="w-100">
                                                <label class="small" style="color: #c3f0ff;">Time</label>
                                                <input name="time" type="text" value="07:00 pm" class="ref-input w-100 mb-2" style="font-size: 12px;">
                                            </div>
                                            <div class="w-100">
                                                <label class="small" style="color: #c3f0ff;">Rice</label>
                                                <input name="rice" type="text" value="Plain Rice" class="ref-input w-100 mb-2" style="font-size: 12px;">
                                            </div>
                                            <div class="w-100">
                                                <label class="small" style="color: #c3f0ff;">Viand / Other Food</label>
                                                <input name="viand" type="text" placeholder="Type here..." class="ref-input small mb-3 w-100" required>
                                            </div>
                                            <div class="w-100 d-flex flex-column mb-3">
                                                <label class="small" style="color: #c3f0ff;" for="ingredients">Ingredients</label>
                                                <textarea name="ingredients" id="ingredients" cols="42" rows="3" class="small ps-2 pt-2" style="background-color: #012054d4; color: #c3ffeb; border: none;"></textarea>
                                            </div>
                                            <div class="w-100">
                                                <label class="small" style="color: #c3f0ff;">Carbohydrates</label>
                                                <input name="carbohydrates" type="number" placeholder="Type here..." class="ref-input small mb-3 w-100" required>
                                            </div>
                                            <div class="w-100">
                                                <label class="small" style="color: #c3f0ff;">Protein</label>
                                                <input name="protein" type="number" placeholder="Type here..." class="ref-input small mb-3 w-100" required>
                                            </div>
                                            <div class="w-100">
                                                <label class="small" style="color: #c3f0ff;">Fat</label>
                                                <input name="fat" type="number" placeholder="Type here..." class="ref-input small mb-3 w-100" required>
                                            </div>
                                            <div class="w-100">
                                                <label class="small" style="color: #c3f0ff;">Fiber</label>
                                                <input name="fiber" type="number" placeholder="Type here..." class="ref-input small mb-3 w-100" required>
                                            </div>
                                            <div class="w-100 mt-2">
                                                <button type="submit" class="btn-login w-100 d-flex align-items-center justify-content-center">
                                                    <span id="save">Save</span>
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
                            <?php
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
            <div class="d-flex align-items-center justify-content-around bottom-0 fixed-bottom px-3">
                <a href="home.php">
                    <i class="bi bi-house-door fs-4"></i>
                </a>
                <a href="#add-recommendations" style="color: #c3ffeb !important;">
                    <i class="bi bi-basket-fill fs-4"></i>
                </a>
            </div>
        </footer>

        <script src="../../bootstrap/js/bootstrap.bundle.min.js"></script>

    </body>

    </html>

<?php
} else {
    header("Location: ../../index.php");
}
