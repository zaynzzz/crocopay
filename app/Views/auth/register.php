<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merchant Registration | CrocoPay</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --emerald: #2ecc71;
            --emerald-dark: #27ae60;
            --emerald-light: #58d68d;
            --soft-white: #f9f9f9;
            --light-gray: #ecf0f1;
            --text-dark: #2c3e50;
            --text-medium: #34495e;
            --text-light: #7f8c8d;
            --success: #2ecc71;
            --error: #e74c3c;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
        }
        
        body {
            background-color: var(--soft-white);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: var(--text-dark);
            background-image: url('https://www.transparenttextures.com/patterns/crisp-paper-ruffles.png');
        }
        
        .register-container {
            background-color: white;
            border-radius: 16px;
            box-shadow: var(--shadow);
            width: 100%;
            max-width: 480px;
            padding: 40px;
            margin: 20px;
            position: relative;
            overflow: hidden;
            border: 1px solid var(--light-gray);
        }
        
        .register-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(90deg, var(--emerald), var(--emerald-light));
        }
        
        .logo-header {
            text-align: center;
            margin-bottom: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .logo {
            width: 60px;
            height: 60px;
            background-color: var(--emerald);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            box-shadow: 0 4px 8px rgba(46, 204, 113, 0.2);
        }
        
        .logo i {
            color: white;
            font-size: 28px;
        }
        
        .logo-header h1 {
            color: var(--text-dark);
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .logo-header p {
            color: var(--text-light);
            font-size: 14px;
        }
        
        h2 {
            text-align: center;
            margin-bottom: 25px;
            font-weight: 600;
            color: var(--text-medium);
            font-size: 20px;
            position: relative;
        }
        
        h2::after {
            content: '';
            display: block;
            width: 50px;
            height: 3px;
            background: var(--emerald);
            margin: 10px auto 0;
            border-radius: 3px;
        }
        
        .alert {
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-size: 14px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .alert-success {
            background-color: #e8f8ef;
            color: var(--success);
            border: 1px solid #d1f2e5;
        }
        
        .alert-error {
            background-color: #fdecea;
            color: var(--error);
            border: 1px solid #fadbd8;
        }
        
        .alert i {
            margin-right: 8px;
        }
        
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-medium);
        }
        
        input {
            width: 100%;
            padding: 14px 16px;
            background-color: var(--soft-white);
            border: 1px solid var(--light-gray);
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s;
            color: var(--text-dark);
        }
        
        input:focus {
            outline: none;
            border-color: var(--emerald-light);
            box-shadow: 0 0 0 3px rgba(46, 204, 113, 0.1);
        }
        
        button {
            width: 100%;
            padding: 16px;
            background: linear-gradient(to right, var(--emerald), var(--emerald-light));
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
            box-shadow: 0 4px 8px rgba(46, 204, 113, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        button i {
            margin-right: 8px;
        }
        
        button:hover {
            background: linear-gradient(to right, var(--emerald-dark), var(--emerald));
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(46, 204, 113, 0.3);
        }
        
        .login-link {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
            color: var(--text-light);
        }
        
        .login-link a {
            color: var(--emerald);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
        
        .crocodile-icon {
            position: absolute;
            opacity: 0.03;
            z-index: 0;
        }
        
        .crocodile-icon.top-right {
            top: 20px;
            right: 20px;
            font-size: 80px;
            transform: rotate(15deg);
        }
        
        .crocodile-icon.bottom-left {
            bottom: 20px;
            left: 20px;
            font-size: 60px;
            transform: rotate(-15deg);
        }
        
        .form-container {
            position: relative;
            z-index: 1;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <i class="fas fa-crocodile crocodile-icon top-right"></i>
        <i class="fas fa-crocodile crocodile-icon bottom-left"></i>
        
        <div class="logo-header">
            <div class="logo">
                <i class="fas fa-crocodile"></i>
            </div>
            <h1>CrocoPay</h1>
            <p>Merchant Registration</p>
        </div>
        
        <div class="form-container">
            <h2>Create Your Account</h2>
            
            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
            
            <?php if(session()->get('errors')): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> Please correct the following errors
                </div>
                <ul style="color: var(--error); margin-bottom: 20px; padding-left: 20px; font-size: 14px;">
                    <?php foreach(session()->get('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            
            <form method="post" action="<?= base_url('auth/doRegister') ?>">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" value="<?= old('name') ?>" placeholder="Enter your full name">
                </div>
                
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="<?= old('email') ?>" placeholder="Enter your email">
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Create a password">
                </div>
                
                <button type="submit">
                    <i class="fas fa-user-plus"></i> Register Account
                </button>
            </form>
            
            <div class="login-link">
                <p>Already have an account? <a href="<?= base_url('login') ?>">Login here</a></p>
            </div>
        </div>
    </div>
</body>
</html>