<!-- app/Views/admin/client_register.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Daftarkan Client</title>
</head>
<body>
    <?php if (session()->getFlashdata('success')): ?>
        <div style="color: green"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div style="color: red"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('admin/client/register-submit') ?>" method="post">
        <label>Nama:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Daftarkan Client</button>
    </form>
</body>
</html>
