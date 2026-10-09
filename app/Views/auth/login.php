<?= view('layout/header', ['title' => $title]) ?>
<?php $loginUsername = session()->getFlashdata('login_username') ?? ''; ?>
<section class="form-card login-card">
    <p class="eyebrow">POS Staff Access</p>
    <h1>Sign in</h1>
    <p class="form-intro">Use your staff username and password to continue.</p>

    <form action="<?= site_url('login') ?>" method="post">
        <?= csrf_field() ?>
        <div class="field">
            <label for="username">Username</label>
            <input id="username" name="username" type="text" maxlength="50" value="<?= esc($loginUsername) ?>" required autocomplete="username" autofocus>
        </div>
        <div class="field">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" required autocomplete="current-password">
        </div>
        <div class="form-actions">
            <button class="button" type="submit">Sign in</button>
        </div>
    </form>
</section>
<?= view('layout/footer') ?>
