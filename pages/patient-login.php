<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../includes/head.php" ?>
</head>

<body>
    <main>
        <div class="container ref min-vh-100">
            <img src="../img/logo.png" width="90" alt="Nutrismart Logo">
            <h3 class="mt-4">Patient</h3>
            <div class="card">
                <?php
                if (isset($_GET['error'])) {
                ?>
                    <p class="text-white m-2 bg-danger p-2"><?php echo $_GET['error'], 'Invalid username or password' ?></p>
                <?php
                }
                ?>
                <form action="../manipulations/patient-login-check.php" method="POST" class="mb-4 needs-validation">
                    <div class="w-100">
                        <input type="text" name="username" placeholder="Username" class="ref-input mb-3 w-100 me-5 mt-3">
                    </div>
                    <div class="w-100">
                        <input type="password" name="password" placeholder="Password" class="ref-input mb-3 w-100 me-5">
                    </div>
                    <div class="w-100 mt-2">
                        <button type="submit" class="btn-login w-100 me-5 d-flex align-items-center justify-content-center" onclick="submitFn()">
                            <span id="login">Login</span>
                        </button>
                    </div>
                </form>
                <div class="container d-flex justify-content-center flex-column">
                    <p>Don't have an account? <strong><a href="patient-signup.php">Create one.</a></strong></p>
                    <a href="../index.php" class="d-flex justify-content-start">
                        <i class="bi bi-arrow-left"></i>&nbsp;Back
                    </a>
                </div>
            </div>
        </div>
    </main>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../script.js"></script>
</body>

</html>