<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Merchant | CrocoPay</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2ecc71;
            --primary-dark: #27ae60;
            --primary-light: #58d68d;
            --white: #ffffff;
            --light-gray: #f5f5f5;
            --medium-gray: #e0e0e0;
            --dark-gray: #333333;
            --error: #e74c3c;
            --success: #2ecc71;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: var(--light-gray);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            background-image: url('https://www.transparenttextures.com/patterns/subtle-white-feathers.png');
        }

        .registration-container {
            background-color: var(--white);
            border-radius: 12px;
            box-shadow: var(--shadow);
            width: 100%;
            max-width: 600px;
            padding: 40px;
            position: relative;
            overflow: hidden;
            border: 1px solid var(--medium-gray);
        }

        .registration-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
        }

        .logo-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            color: var(--primary);
        }

        .logo i {
            font-size: 28px;
            margin-right: 10px;
        }

        .logo h1 {
            font-size: 24px;
            font-weight: 700;
        }

        h2 {
            color: var(--dark-gray);
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 25px;
            text-align: center;
            position: relative;
        }

        h2::after {
            content: '';
            display: block;
            width: 50px;
            height: 3px;
            background: var(--primary);
            margin: 10px auto 0;
            border-radius: 3px;
        }

        .error-message {
            background-color: #fdecea;
            color: var(--error);
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
            border: 1px solid #fadbd8;
        }

        .error-message i {
            margin-right: 8px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 500;
            color: var(--dark-gray);
        }

        input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--medium-gray);
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s;
            background-color: var(--light-gray);
        }

        input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(46, 204, 113, 0.1);
            background-color: var(--white);
        }

        button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(to right, var(--primary), var(--primary-light));
            color: var(--white);
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }

        button:hover {
            background: linear-gradient(to right, var(--primary-dark), var(--primary));
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(46, 204, 113, 0.3);
        }

        /* Modal Styling */
        .modal {
            display: <?= isset($credentials) ? 'flex' : 'none' ?>;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.6);
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            background-color: var(--white);
            padding: 30px;
            width: 90%;
            max-width: 500px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            position: relative;
            border-top: 5px solid var(--primary);
        }

        .close {
            position: absolute;
            right: 20px;
            top: 15px;
            font-size: 24px;
            cursor: pointer;
            color: var(--dark-gray);
            transition: all 0.3s;
        }

        .close:hover {
            color: var(--primary);
            transform: rotate(90deg);
        }

        .modal-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-header i {
            font-size: 28px;
            color: var(--success);
            margin-right: 15px;
        }

        .modal-header h3 {
            font-size: 22px;
            color: var(--dark-gray);
        }

        .credential-list {
            list-style: none;
            margin-bottom: 20px;
        }

        .credential-list li {
            margin-bottom: 15px;
            font-size: 14px;
        }

        .credential-list strong {
            display: block;
            margin-bottom: 5px;
            color: var(--dark-gray);
        }

        code {
            background-color: #f8f9fa;
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid var(--medium-gray);
            font-family: 'Courier New', monospace;
            font-size: 13px;
            word-break: break-all;
            display: block;
        }

        .copy-btn {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            margin-top: 5px;
            transition: all 0.3s;
        }

        .copy-btn:hover {
            background-color: var(--primary-dark);
        }

        .modal-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: var(--dark-gray);
        }
    </style>
</head>
<body>
    <div class="registration-container">
        <div class="logo-header">
            <div class="logo">
                <i class="fas fa-crocodile"></i>
                <h1>CrocoPay</h1>
            </div>
            <p>Platform Pembayaran untuk Merchant</p>
        </div>

        <h2>Form Pendaftaran Merchant</h2>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= base_url('admin/merchant/register') ?>">
            <div class="form-group">
                <label for="name">Nama Toko</label>
                <input type="text" id="name" name="name" required placeholder="Masukkan nama toko Anda">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required placeholder="Masukkan alamat email">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Buat password">
            </div>

            <button type="submit">
                <i class="fas fa-user-plus"></i> Daftarkan Merchant
            </button>
        </form>
    </div>

    <!-- Modal Sukses -->
    <?php if (isset($credentials)): ?>
    <div class="modal" id="successModal">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('successModal').style.display='none'">&times;</span>
            
            <div class="modal-header">
                <i class="fas fa-check-circle"></i>
                <h3>Merchant Berhasil Didaftarkan!</h3>
            </div>
            
            <ul class="credential-list">
                <li>
                    <strong>API Key:</strong>
                    <code id="apiKey"><?= esc($credentials['api_key']) ?></code>
                    <button class="copy-btn" onclick="copyToClipboard('apiKey')">Salin</button>
                </li>
                <li>
                    <strong>API Key:</strong>
                    <code id="apiToken"><?= esc($credentials['api_token']) ?></code>
                    <button class="copy-btn" onclick="copyToClipboard('apiToken')">Salin</button>
                </li>
                <li>
                    <strong>Secret Key:</strong>
                    <code id="secretKey"><?= esc($credentials['secret_key']) ?></code>
                    <button class="copy-btn" onclick="copyToClipboard('secretKey')">Salin</button>
                </li>
            </ul>
            
            <div class="modal-footer">
                <p>Simpan informasi ini dengan aman dan jangan bagikan kepada siapapun</p>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <script>
        function copyToClipboard(elementId) {
            const element = document.getElementById(elementId);
            const text = element.innerText;
            
            navigator.clipboard.writeText(text).then(() => {
                const buttons = document.querySelectorAll('.copy-btn');
                buttons.forEach(btn => {
                    if (btn.textContent === 'Tersalin!') {
                        btn.textContent = 'Salin';
                        btn.style.backgroundColor = 'var(--primary)';
                    }
                });
                
                const clickedBtn = event.target;
                clickedBtn.textContent = 'Tersalin!';
                clickedBtn.style.backgroundColor = 'var(--primary-dark)';
                
                setTimeout(() => {
                    clickedBtn.textContent = 'Salin';
                    clickedBtn.style.backgroundColor = 'var(--primary)';
                }, 2000);
            });
        }
    </script>
</body>
</html>