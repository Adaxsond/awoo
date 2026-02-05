<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login User - LITAZ Library</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('logosmk.png') }}" type="image/png">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
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
            margin-bottom: 25px;
            text-align: center;
        }

        .alert-success {
            background-color: #D1FAE5;
            color: #065F46;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 12px;
            text-align: center;
            font-weight: 500;
            border: 1px solid #A7F3D0;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
        }

        .form-group label {
            margin-bottom: 8px;
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

        .btn {
            width: 100%;
            padding: 16px;
            background-color: #059669;
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-size: 1.1rem;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background-color: #047857;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(5, 150, 105, 0.3);
        }

        .form-footer {
            margin-top: 20px;
            text-align: center;
            font-size: 1rem;
            color: #6b7280;
        }

        .form-footer a {
            color: #059669;
            text-decoration: none;
            font-weight: 600;
            margin-left: 5px;
        }

        .form-footer a:hover {
            color: #047857;
            text-decoration: underline;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.85rem;
            margin-top: 5px;
            text-align: center;
        }

        .back-link {
            display: block;
            margin-top: 20px;
            color: #4B5563;
            text-decoration: none;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            
            .left-panel {
                padding: 30px 20px;
            }
            
            .right-panel {
                padding: 30px 20px;
            }
            
            .left-panel h1 {
                font-size: 1.8rem;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }
            
            .right-panel h2 {
                font-size: 1.5rem;
            }
            
            .logo-container {
                width: 120px;
                height: 120px;
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
            <h1>Portal User LITAZ</h1>
            <p>Akses koleksi buku perpustakaan</p>
            <p>Dapatkan pengalaman membaca yang terbaik</p>
        </div>
        
        <div class="right-panel">
            @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
            @endif
            
            <h2>Login User</h2>
            
            <form method="POST" action="{{ route('proseslogin') }}">
                @csrf
                <div class="form-group">
                    <label for="nisn">NISN</label>
                    <input type="text" id="nisn" name="nisn" placeholder="Masukkan NISN Anda" required>
                </div>
                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan kata sandi" required>
                </div>
                @error('nisn')
                    <div class="error-message">{{ $message }}</div>
                @enderror
                <button type="submit" class="btn">Login</button>
            </form>

            <div class="form-footer">
                Belum punya akun? <a href="{{ route('registrasi') }}">Daftar</a>
            </div>
        </div>
    </div>
</body>
</html>