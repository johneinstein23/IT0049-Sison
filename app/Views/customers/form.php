<?= view('layout/header', ['title' => $title]) ?>
<div class="page-heading">
    <div>
        <p class="eyebrow">Customer Accounts</p>
        <h1><?= $isEdit ? 'Edit customer' : 'Add customer' ?></h1>
        <p class="form-intro">Enter the customer details below. Fields marked required must be completed.</p>
    </div>
    <a class="button button-light" href="<?= site_url('customers') ?>">Back to customers</a>
</div>

<form class="form-card" action="<?= esc($action) ?>" method="post">
    <?= csrf_field() ?>
    <div class="field">
        <label for="full_name">Full name <span class="required">*</span></label>
        <input id="full_name" name="full_name" type="text" maxlength="100" value="<?= esc(old('full_name', $customer['full_name'] ?? '')) ?>" required autocomplete="name">
        <small class="field-error"><?= validation_show_error('full_name') ?></small>
    </div>
    <div class="field">
        <label for="email">Email <span class="required">*</span></label>
        <input id="email" name="email" type="email" maxlength="100" value="<?= esc(old('email', $customer['email'] ?? '')) ?>" required autocomplete="email">
        <small class="field-error"><?= validation_show_error('email') ?></small>
    </div>
    <div class="field">
        <label for="phone">Phone <span class="optional">Optional</span></label>
        <input id="phone" name="phone" type="tel" maxlength="20" value="<?= esc(old('phone', $customer['phone'] ?? '')) ?>" autocomplete="tel">
        <small class="field-error"><?= validation_show_error('phone') ?></small>
    </div>
    <div class="form-actions">
        <a class="button button-light" href="<?= site_url('customers') ?>">Cancel</a>
        <button class="button" type="submit"><?= $isEdit ? 'Save changes' : 'Create customer' ?></button>
    </div>
</form>
<?= view('layout/footer') ?>
