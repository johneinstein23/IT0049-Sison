<?= view('layout/header', ['title' => $title]) ?>
<div class="page-heading">
    <div>
        <p class="eyebrow">MySQL table: customers</p>
        <h1>Customer Accounts</h1>
    </div>
    <div class="heading-actions">
        <a class="button button-light" href="<?= site_url('/') ?>">Dashboard</a>
        <a class="button" href="<?= site_url('customers/new') ?>">Add customer</a>
    </div>
</div>
<div class="table-card">
    <table class="data-table">
        <thead><tr><th>ID</th><th>Full Name</th><th>Email</th><th>Phone</th><th>Created At</th><th>Action</th></tr></thead>
        <tbody>
        <?php foreach ($customers as $customer): ?>
            <tr>
                <td><?= esc($customer['id']) ?></td>
                <td><?= esc($customer['full_name']) ?></td>
                <td><?= esc($customer['email']) ?></td>
                <td><?= esc($customer['phone'] ?? '') ?></td>
                <td><?= esc($customer['created_at']) ?></td>
                <td><a class="table-link" href="<?= site_url('customers/' . $customer['id'] . '/edit') ?>">Edit</a></td>
            </tr>
        <?php endforeach; ?>
        <?php if ($customers === []): ?>
            <tr><td colspan="6" class="empty-state">No customer records yet. Add the first customer to get started.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?= view('layout/footer') ?>
