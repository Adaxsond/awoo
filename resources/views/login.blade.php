<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LITAZ Library</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            display: flex;
            width: 100%;
            max-width: 1000px;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .left-panel {
            flex: 1;
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .left-panel h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .left-panel p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .logo-container {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
            overflow: hidden;
            border: 3px solid rgba(255, 255, 255, 0.3);
        }

        .logo {
            width: 80%;
            height: 80%;
            object-fit: contain;
        }

        .right-panel {
            flex: 1;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .right-panel h2 {
            color: #111827;
            font-size: 1.8rem;
            margin-bottom: 30px;
            text-align: center;
        }

        .btn-option {
            display: block;
            width: 100%;
            padding: 14px;
            margin-bottom: 15px;
            border: 2px solid #e5e7eb;
            background-color: white;
            color: #111827;
            border-radius: 12px;
            font-weight: 500;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-option:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            border-color: #10b981;
        }

        .btn-user {
            background-color: #f0fdf4;
            color: #059669;
        }

        .btn-user:hover {
            background-color: #d1fae5;
        }

        .btn-registration {
            background-color: #eff6ff;
            color: #1d4ed8;
        }

        .btn-registration:hover {
            background-color: #dbeafe;
        }

        .separator {
            display: flex;
            align-items: center;
            margin: 25px 0;
            color: #6b7280;
        }

        .separator::before,
        .separator::after {
            content: "";
            flex: 1;
            height: 1px;
            background-color: #d1d5db;
        }

        .separator span {
            padding: 0 15px;
            font-size: 0.9rem;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            font-weight: 500;
            color: #374151;
            font-size: 0.95rem;
        }

        .form-group input {
            padding: 14px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .btn-admin {
            background-color: #059669;
            color: white;
            padding: 16px;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-admin:hover {
            background-color: #047857;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(5, 150, 105, 0.3);
        }

        .error-message {
            color: #ef4444;
            font-size: 0.85rem;
            margin-top: 5px;
            text-align: center;
        }

        @media (max-width: 992px) {
            .container {
                max-width: 600px;
            }

            .left-panel {
                padding: 30px 20px;
            }

            .right-panel {
                padding: 30px 20px;
            }

            .left-panel h1 {
                font-size: 2rem;
            }

            .logo-container {
                width: 150px;
                height: 150px;
            }
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .left-panel h1 {
                font-size: 1.8rem;
            }

            .left-panel {
                padding: 25px 15px;
                border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            }

            .right-panel {
                padding: 30px 20px;
            }

            body {
                padding: 15px 10px;
            }

            .right-panel h2 {
                font-size: 1.6rem;
            }

            .logo-container {
                width: 120px;
                height: 120px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }

            .container {
                border-radius: 15px;
            }

            .left-panel, .right-panel {
                padding: 20px 15px;
            }

            .left-panel h1 {
                font-size: 1.5rem;
            }

            .right-panel h2 {
                font-size: 1.4rem;
            }

            .logo-container {
                width: 100px;
                height: 100px;
            }

            .btn-option, .btn-admin {
                padding: 12px;
                font-size: 0.95rem;
            }

            .form-group input {
                padding: 12px;
            }
        }

        /* Animation for the login form */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .right-panel {
            animation: fadeInUp 0.6s ease forwards;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-panel">
            <div class="logo-container">
                <img src="{{ asset('logosmk.png') }}" alt="LITAZ Library Logo" class="logo">
            </div>
            <h1>Selamat Datang di LITAZ</h1>
            <p>Sistem Perpustakaan Digital Tazakka</p>
            <p>Akses koleksi buku terlengkap kami dengan mudah dan cepat</p>
        </div>

        <div class="right-panel">
            <h2>Portal Login</h2>

            <!-- Tombol Registrasi -->
            <a href="{{ route('registrasi') }}" class="btn-option btn-registration">
                <i class="fas fa-user-plus"></i> Registrasi sebagai User Baru
            </a>

            <!-- Tombol Login User -->
            <a href="{{ route('loginuser') }}" class="btn-option btn-user">
                <i class="fas fa-user"></i> Login sebagai User
            </a>

            <div class="separator">
                <span>atau</span>
            </div>

            <!-- Form Admin -->
            <form method="POST" action="{{ route('login.admin') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email Admin</label>
                    <input type="text" id="email" name="email" placeholder="Masukkan email admin" required>
                </div>

                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan kata sandi" required>
                </div>

                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror

                <button type="submit" class="btn-admin">Masuk sebagai Admin</button>
            </form>
        </div>
    </div>

    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>