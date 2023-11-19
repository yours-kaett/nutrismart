<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../includes/head.php" ?>
</head>

<body>
    <main>
        <div class="container ref min-vh-100">
            <img src="../img/logo.png" width="90" alt="Nutrismart Logo">
            <h3 class="mt-4">Health Provider</h3>
            <div class="card">
                <form action="../manipulations/health-provider-login-check.php" method="POST" class="mb-4">
                    <div class="w-100">
                        <input type="text" name="username" placeholder="Username" class="ref-input mb-3 w-100 me-5 mt-2">
                    </div>
                    <div class="w-100">
                        <input type="password" name="password" placeholder="Password" class="ref-input mb-3 w-100 me-5">
                    </div>
                    <div class="w-100 mt-2">
                        <button class="btn-login w-100 me-5" type="submit">
                            <span>
                                Login &nbsp;<i class="bi bi-box-arrow-in-right"></i>
                            </span>
                        </button>
                    </div>
                </form>
                <div class="container d-flex justify-content-center flex-column">
                    <p>Don't have an account? <strong><a href="health-provider-signup.php">Create one.</a></strong></p>
                    <a href="../index.php" class="d-flex justify-content-start">
                        <i class="bi bi-arrow-left"></i>&nbsp;Back
                    </a>
                </div>
            </div>
        </div>
    </main>
</body>

</html>