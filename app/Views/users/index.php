<?= view('layout/header', ['title' => $title]) ?>
<div class="page-heading">
    <div>
        <p class="eyebrow">MySQL table: users</p>
        <h1>User Accounts</h1>
    </div>
    <div class="heading-actions">
        <a class="button button-light" href="<?= site_url('/') ?>">Dashboard</a>
        <a class="button" href="<?= site_url('users/new') ?>">Add user</a>
    </div>
</div>
<div class="table-card">
    <table class="data-table">
        <thead><tr><th>User</th><th>Username</th><th>Created At</th><th>Action</th></tr></thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td class="user-cell">
                    <img class="avatar" src="<?= ! empty($user['avatar']) ? base_url('uploads/avatars/' . rawurlencode($user['avatar'])) : base_url('images/avatar-placeholder.svg') ?>" alt="" width="44" height="44">
                    <span><?= esc($user['full_name']) ?></span>
                </td>
                <td><?= esc($user['username']) ?></td>
                <td><?= esc($user['created_at']) ?></td>
                <td><a class="table-link" href="<?= site_url('users/' . $user['id'] . '/edit') ?>">Edit</a></td>
            </tr>
        <?php endforeach; ?>
        <?php if ($users === []): ?>
            <tr><td colspan="4" class="empty-state">No user records yet. Add the first user to get started.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?= view('layout/footer') ?>
