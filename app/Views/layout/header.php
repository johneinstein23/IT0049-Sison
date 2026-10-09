<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'POS Application') ?></title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
    <header class="site-header">
        <div class="container nav-wrap">
            <a class="brand" href="<?= base_url('/') ?>">POS Accounts</a>
            <?php if (session()->get('user_id')): ?>
                <nav class="nav-actions">
                    <a href="<?= base_url('customers') ?>">Customers</a>
                    <a href="<?= base_url('users') ?>">Users</a>
                    <span class="signed-in-user"><?= esc(session()->get('full_name')) ?></span>
                    <form class="logout-form" action="<?= site_url('logout') ?>" method="post">
                        <?= csrf_field() ?>
                        <button class="button button-light" type="submit">Log out</button>
                    </form>
                </nav>
            <?php endif; ?>
        </div>
    </header>
    <main class="container">
        <?php $successMessage = session()->getFlashdata('success'); ?>
        <?php if ($successMessage): ?>
            <div class="notice success" role="status"><?= esc($successMessage) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('upload_error')): ?>
            <div class="notice error" role="alert"><?= esc(session()->getFlashdata('upload_error')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('login_error')): ?>
            <div class="notice error" role="alert"><?= esc(session()->getFlashdata('login_error')) ?></div>
        <?php endif; ?>
