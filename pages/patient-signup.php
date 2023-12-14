<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../includes/head.php" ?>
</head>

<body>
    <main>
        <div class="container ref min-vh-100">
            <img src="../img/logo.png" width="150" alt="Nutrsmart Logo">
            <h3 class="fw-bold mt-4">Patient</h3>
            <div class="card">
                <?php
                if (isset($_GET['success'])) {
                ?>
                    <p class="text-white text-center m-2 bg-success w-100 p-2"><?php echo $_GET['success'], 'Account created successfully.' ?></p>
                <?php
                }
                if (isset($_GET['error'])) {
                ?>
                    <p class="text-white text-center m-2 bg-danger w-100 p-2"><?php echo $_GET['error'] ?></p>
                <?php
                }
                ?>
                <form action="../manipulations/patient-signup-check.php" method="POST" class="mb-4">
                    <div class="w-100">
                        <input type="email" name="email" placeholder="Email" class="ref-input w-100 me-5 mt-2" required>
                    </div>
                    <div class="w-100">
                        <input type="text" name="username" placeholder="Username" class="ref-input mb-3 w-100 me-5 mt-2" required>
                    </div>
                    <div class="w-100">
                        <input type="password" name="password" placeholder="Password" class="ref-input mb-3 w-100 me-5" required>
                    </div>
                    <div class="w-100 mt-2">
                        <a href="#">
                            <button class="btn-login w-100 me-5" type="submit">
                                Create
                            </button>
                        </a>
                    </div>
                </form>
                <div class="container d-flex justify-content-center flex-column">
                    <p>Has an existing account? <strong><a href="patient-login.php">Login here.</a></strong></p>
                </div>
            </div>
        </div>
    </main>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>