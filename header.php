<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header - Note Everyday</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif; /* Menggunakan font yang sama dengan index.php */
        }
        header {
            background-color: rgba(76, 175, 80, 0.3); /* Latar belakang hijau sangat transparan */
            color: white; /* Warna teks putih */
            padding: 20px; /* Menambah padding untuk tampilan yang lebih baik */
            text-align: center; /* Mengatur teks ke tengah */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3); /* Menambahkan bayangan untuk kedalaman */
        }
        h1 {
            margin: 0; /* Menghapus margin untuk judul */
            font-size: 2em; /* Ukuran font lebih besar */
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7); /* Bayangan teks yang lebih tajam */
        }
        nav {
            margin: 10px 0; /* Menambahkan margin atas dan bawah untuk navigasi */
        }
        nav a {
            color: white; /* Warna tautan putih */
            text-decoration: none; /* Menghapus garis bawah pada tautan */
            margin: 0 15px; /* Mengatur jarak antar tautan */
            padding: 10px 15px; /* Menambahkan padding */
            border-radius: 4px; /* Membulatkan sudut */
            transition: background-color 0.3s, text-shadow 0.3s; /* Efek transisi */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5); /* Bayangan teks pada tautan */
        }
        nav a:hover {
            background-color: rgba(255, 255, 255, 0.2); /* Efek hover pada tautan */
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7); /* Bayangan lebih tajam saat hover */
        }
    </style>
</head>
<body>
    <header>
        <h1>Selamat Datang di Note Everyday</h1>
        <nav>
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
</body>
</html>