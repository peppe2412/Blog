<?php session_start(); ?>
<nav class="navbar fs-4 navbar-expand-lg" id="navbar">
    <div class="container-fluid">
        <a class="navbar-brand fs-1 link-main-nav fst-italic" href="/">Blog</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/posts/index">Posts</a>
                </li>
                <li class="nav-item">
                    <?php if (isset($_SESSION['auth_hash'])): ?>
                        <a class="nav-link" href="/dashboard">Area riservata</a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </div>
</nav>