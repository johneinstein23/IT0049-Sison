<?= view('layout/header', ['title' => $title]) ?>
<section class="hero">
    <p class="eyebrow">IT0049 Technical Formative Assessment 4</p>
    <h1>Staff access, protected</h1>
    <p>Signed-in staff can manage customer and user records. CodeIgniter sessions and a route filter protect these POS pages.</p>
</section>
<section class="card-grid">
    <a class="card" href="<?= base_url('customers') ?>">
        <span class="card-label">Database table</span>
        <h2>Customer Accounts</h2>
        <p>View records retrieved with <code>CustomerModel::findAll()</code>.</p>
    </a>
    <a class="card" href="<?= base_url('users') ?>">
        <span class="card-label">Database table</span>
        <h2>User Accounts</h2>
        <p>View records retrieved with <code>UserModel::findAll()</code>.</p>
    </a>
</section>
<?= view('layout/footer') ?>
