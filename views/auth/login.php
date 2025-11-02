<?php
session_start();
$error = $_SESSION['login_error'] ?? null;
unset($_SESSION['login_error']);

$logout = $_SESSION['alert_logout'] ?? null;
unset($_SESSION['alert_logout']);

ob_start();
?>

<section class="message-box">
    <?php if ($logout): ?>
        <div class="alert-success alert">
            <div>
                <button class="button-close" id="button-close">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="close-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <?= htmlspecialchars($logout) ?>
        </div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert-danger alert">
            <div>
                <button class="button-close">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="close-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>
</section>

<section class="login-container">
    <div class="login-box">
        <h1 class="title-login">Login</h1>
        <form method="POST" action="/login" class="form-login">
            <label for="email" class="label-login">Email</label>
            <input name="email" type="email" class="input-login" id="email">

            <label for="password" class="label-login">Password</label>
            <input name="password" type="password" class="input-login" id="password">
            <div class="button-login-box">
                <button type="submit" class="button-login">Accedi</button>
            </div>
        </form>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        let errorSpan = document.querySelector('.alert-danger')

        if (errorSpan) {
            const audioError = new Audio('/public/sounds/error-sound.mp3')
            audioError.play()
        }
    })
</script>

<?php
$slotLogin = ob_get_clean();
include_once __DIR__ . '/components/layout.php'
?>