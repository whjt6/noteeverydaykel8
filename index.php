<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index - Note Everyday</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: url('https://images.unsplash.com/photo-1506748686214-e9df14d4d9d0?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwzNjUyOXwwfDF8c2VhcmNofDF8fG5hdHVyZXxlbnwwfHx8fDE2MjI1NzM1Mjg&ixlib=rb-1.2.1&q=80&w=1080') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 20px;
            color: #fff;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }
        .welcome-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            color: #333; /* Warna teks dalam kontainer */
        }
        nav {
            margin: 20px 0;
            text-align: center;
        }
        nav a {
            margin: 0 15px;
            text-decoration: none;
            color: white; /* Warna teks putih */
            padding: 10px 15px;
            border-radius: 5px;
            transition: transform 0.3s;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.7); /* Bayangan teks */
        }
        nav a:hover {
            transform: scale(1.05);
            color: rgba(255, 255, 255, 0.8); /* Warna putih sedikit transparan saat hover */
        }
        footer {
            text-align: center;
            margin-top: 20px;
            color: #fff; /* Warna teks footer */
            background-color: rgba(0, 0, 0, 0.7); /* Latar belakang footer */
            padding: 10px 0;
            border-radius: 5px;
            position: relative;
            bottom: 0;
            width: 100%;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        ul li {
            margin: 10px 0;
            position: relative;
            padding-left: 20px;
        }
        ul li:before {
            content: '✔';
            position: absolute;
            left: 0;
            color: #4CAF50; /* Warna ikon centang */
        }

        /* Media Query untuk Responsivitas */
        @media (max-width: 600px) {
            .welcome-container {
                padding: 15px; /* Mengurangi padding pada kontainer */
            }
            h1 {
                font-size: 1.5em; /* Mengurangi ukuran font judul */
            }
            nav a {
                padding: 8px 10px; /* Mengurangi padding link navigasi */
                font-size: 0.9em; /* Mengurangi ukuran font link */
            }
            ul li {
                font-size: 0.9em; /* Mengurangi ukuran font daftar */
            }
        }
    </style>
</head>
<body>
    <h1>Selamat Datang di Note Everyday!</h1>
    
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    </nav>

    <div class="welcome-container">
        <p>Kami senang Anda bergabung dengan komunitas kami. Di Note Everyday, kami percaya bahwa setiap catatan adalah langkah menuju produktivitas dan kreativitas.</p>
        <p>Catatan Penting:</p>
        <ul>
            <li>Registrasi: Jika Anda pengguna baru, klik tombol "Daftar" untuk membuat akun.</li>
            <li>Login: Jika Anda sudah memiliki akun, masukkan detail login Anda.</li>
        </ul>
    </div>

    <div style="text-align: center; margin-top: 20px;">
        <?php include 'footer.php'; ?>
    </div>
</body>
</html>