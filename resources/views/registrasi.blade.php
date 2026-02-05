<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Registrasi</title>
    <link rel="icon" href="{{ asset('logosmk.png') }}" type="image/png">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color:rgb(8, 153, 92);
            display: flex;
            justify-content: center;
            align-items: flex-start; 
            min-height: 100vh; /* Supaya bisa lebih panjang dari layar */
            margin: 0;
            padding: 40px 20px;
        }

        @media (min-height: 600px) {
            body {
                align-items: center;
            }
        }

        .card {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .card h2 {
            margin-bottom: 20px;
        }

        .form-group {
            text-align: left;
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .form-group select {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            background-color: #059669;
            color: white;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 10px;
        }

        .btn:hover {
            background-color: #047857;
        }

        .back-link {
            display: block;
            margin-top: 15px;
            color: #4B5563;
            text-decoration: none;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>Registrasi User</h2>
        <form method="POST" action="{{ route('registrasisimpan') }}">
            @csrf
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="nisn">Nomor Induk Mahasiswa Nasional</label>
                <input type="text" id="nisn" name="nisn" required>
            </div>
            @error('nisn')
            <div style="color:red;">{{ $message }}</div>
            @enderror
            <div class="form-group">
                <label for="kelas">Kelas</label>
                <select id="kelas" name="kelas" required>
                    <option value="">Pilih Kelas</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </select>
            </div>
            <div class="form-group">
                <label for="jurusan">Jurusan</label>
                <select id="jurusan" name="jurusan" required>
                    <option value="">Pilih Jurusan</option>
                    <option value="AK">AK - Akutansi dan Keuangan</option>
                    <option value="MK">MK - Manajemen Keuangan</option>
                    <option value="TKJ">TKJ - Teknik Jaringan Komputer</option>
                    <option value="TM">TM - Teknik Mesin</option>
                    <option value="TO">TO - Teknik Otomotif Motor</option>
                    <option value="TKG">TKG - Teknik Konstruksi Gedung</option>
                </select>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" required>
            </div>
            @error('email')
            <div style="color:red;">{{ $message }}</div>
            @enderror
            <div class="form-group">
                <label for="nohp">Nomor HP</label>
                <input type="text" id="nohp" name="nohp" required>
            </div>
            <div class="form-group">
                <label for="password">Kata Sandi</label>
                <input type="password" id="password" name="password" required>
            </div>
            @error('password')
            <div style="color:red;">{{ $message }}</div>
            @enderror
            <br>
            <div class="form-group">
                <label for="password_konfirmasi">Konfirmasi Kata Sandi</label>
                <input type="password" id="password_konfirmasi" name="password_konfirmasi" required>
            </div>
            <button type="submit" class="btn">Daftar</button>
        </form>
        <br>
        Sudah punya akun? <a href="{{ route('loginuser') }}" style="color: #059669; font-weight: bold;">Login</a>
    </div>
</body>
</html>