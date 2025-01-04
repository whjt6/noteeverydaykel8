<?php
session_start();
include 'db.php';
include 'header.php';

// Cek jika pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ambil catatan dari database
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM entries WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Menghitung jumlah catatan
$total_entries = $result->num_rows;

// Menghitung jumlah catatan hari ini
$today = date("Y-m-d"); // Format tanggal hari ini
$stmt_today = $conn->prepare("SELECT COUNT(*) as count FROM entries WHERE user_id = ? AND DATE(created_at) = ?");
$stmt_today->bind_param("is", $user_id, $today);
$stmt_today->execute();
$result_today = $stmt_today->get_result();
$today_entry_count = $result_today->fetch_assoc()['count'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Note Everyday</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('https://images.unsplash.com/photo-1506748686214-e9df14d4d9d0?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwzNjUyOXwwfDF8c2VhcmNofDF8fG5hdHVyZXxlbnwwfHx8fDE2MjI1NzM1Mjg&ixlib=rb-1.2.1&q=80&w=1080') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 20px;
            color: #fff; /* Warna teks putih untuk kontras */
        }
        h2 {
            color: #fff; /* Warna putih untuk judul */
            text-align: center;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8); /* Bayangan untuk judul */
        }
        .greeting {
            color: #fff; /* Warna putih untuk greeting */
            text-align: center;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.7); /* Bayangan untuk greeting */
        }
        .dashboard-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.95); /* Latar belakang putih transparan */
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* Bayangan halus */
        }
        .statistic {
            display: flex;
            flex-direction: row; /* Menjaga kolom dalam satu baris di layar lebar */
            justify-content: space-between;
            flex-wrap: wrap; /* Membolehkan kolom membungkus ke baris berikutnya */
            margin-bottom: 20px;
        }
        .statistic div {
            flex: 1 1 200px; /* Basis lebar minimum 200px */
            padding: 20px;
            margin: 10px; /* Margin di sekeliling setiap kolom */
            background-color: rgba(231, 243, 254, 0.9); /* Latar belakang transparan untuk statistik */
            border-radius: 5px;
            text-align: center;
            color: #333; /* Warna teks gelap untuk statistik */
            box-sizing: border-box; /* Mengatur ukuran kolom termasuk padding dan margin */
        }
        .tip {
            background-color: rgba(255, 204, 128, 0.9);
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 20px;
            color: #333; /* Warna teks gelap untuk tip */
        }
        .create-note {
            text-align: center;
            margin-top: 20px;
        }
        .create-note a {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .create-note a:hover {
            background-color: #45a049; /* Efek hover yang lebih gelap */
        }
        footer {
            text-align: center;
            margin-top: 20px;
            color: #fff; /* Warna teks footer */
            background-color: rgba(0, 0, 0, 0.7); /* Latar belakang footer */
            padding: 10px 0;
            border-radius: 5px;
        }

        /* Media Query untuk Responsivitas */
        @media (max-width: 600px) {
            .statistic {
                flex-direction: column; /* Mengubah arah kolom untuk tampilan sempit */
                align-items: stretch; /* Meratakan kolom agar lebar penuh */
            }
            .statistic div {
                flex: 1 1 100%; /* Mengubah kolom menjadi penuh pada perangkat kecil */
                margin: 10px 0; /* Mengatur margin untuk setiap kolom */
            }
            .dashboard-container {
                padding: 10px; /* Mengurangi padding pada kontainer */
            }
            h2 {
                font-size: 1.5em; /* Mengurangi ukuran font judul */
            }
            .greeting {
                font-size: 1.2em; /* Mengurangi ukuran font greeting */
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2>Dashboard Anda</h2>
        <p class="greeting">Halo, <?= htmlspecialchars($_SESSION['username']); ?>! Berikut adalah ringkasan catatan Anda:</p>
        
        <div class="statistic">
            <div>
                <h3>Total Catatan</h3>
                <p><?= $total_entries; ?></p>
            </div>
            <div>
                <h3>Catatan Terakhir</h3>
                <?php if ($total_entries > 0): ?>
                    <?php
                    $last_entry = $result->fetch_assoc();
                    echo "<p>" . htmlspecialchars($last_entry['title']) . "</p>";
                    ?>
                <?php else: ?>
                    <p>Tidak ada catatan</p>
                <?php endif; ?>
            </div>
            <div>
                <h3>Catatan Hari Ini</h3>
                <p><?= $today_entry_count; ?></p> <!-- Menampilkan jumlah catatan hari ini -->
            </div>
        </div>

        <div class="tip">
            <h3>Tips Harian</h3>
            <p>Selalu catat ide-ide Anda! Inspirasi bisa datang kapan saja.</p>
        </div>

        <div class="create-note">
            <a href="create.php">Buat Catatan Baru</a>
        </div>
    </div>

    <div style="text-align: center; margin-top: 20px;">
        <?php include 'footer.php'; ?>
    </div>
</body>
</html>