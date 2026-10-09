<?= view('layout/header', ['title' => $title]) ?>
<?php
$userFormErrors = session()->getFlashdata('user_form_errors') ?? [];
$oldUsername = session()->getFlashdata('old_username') ?? '';
$oldFullName = session()->getFlashdata('old_full_name') ?? '';
?>
<div class="page-heading">
    <div>
        <p class="eyebrow">User Accounts</p>
        <h1><?= $isEdit ? 'Edit user' : 'Add user' ?></h1>
        <p class="form-intro">Enter the account details below. Usernames must be unique.</p>
    </div>
    <a class="button button-light" href="<?= site_url('users') ?>">Back to users</a>
</div>

<form class="form-card" action="<?= esc($action) ?>" method="post"<?= $isEdit ? ' enctype="multipart/form-data"' : '' ?>>
    <?= csrf_field() ?>
    <div class="field">
        <label for="username">Username <span class="required">*</span></label>
        <input id="username" name="username" type="text" maxlength="50" value="<?= esc($isEdit ? old('username', $user['username'] ?? '') : $oldUsername) ?>" required autocomplete="username">
        <small class="field-error"><?= esc($userFormErrors['username'] ?? validation_show_error('username')) ?></small>
    </div>
    <div class="field">
        <label for="full_name">Full name <span class="required">*</span></label>
        <input id="full_name" name="full_name" type="text" maxlength="100" value="<?= esc($isEdit ? old('full_name', $user['full_name'] ?? '') : $oldFullName) ?>" required autocomplete="name">
        <small class="field-error"><?= esc($userFormErrors['full_name'] ?? validation_show_error('full_name')) ?></small>
    </div>

    <?php if (! $isEdit): ?>
        <div class="field">
            <label for="password">Password <span class="required">*</span></label>
            <input id="password" name="password" type="password" minlength="8" maxlength="255" required autocomplete="new-password">
            <small class="help-text">Use at least 8 characters. The password is saved as a hash.</small>
            <small class="field-error"><?= esc($userFormErrors['password'] ?? '') ?></small>
        </div>
    <?php endif; ?>

    <?php if ($isEdit): ?>
        <div class="field">
            <label for="avatar">Profile picture <span class="optional">Optional</span></label>
            <?php if (! empty($user['avatar'])): ?>
                <div class="current-avatar">
                    <img class="avatar avatar-large" src="<?= base_url('uploads/avatars/' . rawurlencode($user['avatar'])) ?>" alt="Current profile picture" width="72" height="72">
                    <span>Current picture</span>
                </div>
            <?php endif; ?>
            <input id="avatar" name="avatar" type="file" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
            <small class="help-text">JPG or PNG, up to 2 MB. The image will be resized to a 256 × 256 thumbnail.</small>
            <small class="field-error"><?= validation_show_error('avatar') ?></small>
        </div>
    <?php endif; ?>

    <div class="form-actions">
        <a class="button button-light" href="<?= site_url('users') ?>">Cancel</a>
        <button class="button" type="submit"><?= $isEdit ? 'Save changes' : 'Create user' ?></button>
    </div>
</form>
<?= view('layout/footer') ?>
