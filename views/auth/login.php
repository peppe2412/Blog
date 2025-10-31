<?php
session_start();
$error = $_SESSION['login_error'] ?? null;
unset($_SESSION['login_error']);

$logout = $_SESSION['alert_logout'] ?? null;
unset($_SESSION['alert_logout']);

ob_start();
?>

<section class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-4">
            <?php if ($logout): ?>
                <div class="alert alert-success"><?= htmlspecialchars($logout) ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <h1 class="text-center">Login</h1>
            <form method="POST" action="/login">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input name="email" type="email" class="form-control" id="email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input name="password" type="password" class="form-control" id="password">
                </div>
                <button type="submit" class="btn btn-primary">Accedi</button>
            </form>
        </div>
    </div>
</section>


<?php
$slotLogin = ob_get_clean();
include_once __DIR__ . '/components/layout.php'
?>