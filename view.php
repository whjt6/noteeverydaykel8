<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM entries WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Catatan - Note Everyday</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
        h2 {
            color: #fff;
            text-align: center;
            margin: 20px 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }
        .welcome-message {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.5em;
            color: #fff;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.7);
        }
        .search-container, .create-note {
            background-color: rgba(76, 175, 80, 0.3);
            border-radius: 5px;
            padding: 10px;
            margin: 20px auto;
            max-width: 90%; /* Mengubah lebar maksimum agar lebih responsif */
            text-align: center;
        }
        .create-note a {
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
        }
        .create-note a:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
        .search-container input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 70%; /* Lebar input yang lebih responsif */
            margin-right: 10px;
            box-sizing: border-box; /* Menghitung padding dalam lebar */
        }
        .search-container button {
            background-color: #5cb85c;
            color: white;
            border: none;
            padding: 10px 15px; /* Menyesuaikan padding tombol */
            border-radius: 5px;
            cursor: pointer;
            width: 25%; /* Lebar tombol yang lebih responsif */
        }
        .search-container button:hover {
            background-color: #4cae4c;
        }
        .table-container {
            max-width: 90%; /* Mengubah lebar maksimum agar lebih responsif */
            margin: 20px auto;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            padding: 20px;
            overflow-x: auto; /* Memungkinkan scroll horizontal untuk tabel */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto; /* Agar kolom menyesuaikan lebar */
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ccc;
            color: #333;
        }
        th {
            background-color: #f1f1f1;
            color: #333;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        footer {
            text-align: center;
            margin-top: 20px;
            color: #fff;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 10px 0;
            border-radius: 5px;
        }

        /* Media Queries untuk Responsivitas */
        @media (max-width: 768px) {
            .search-container input {
                width: 60%; /* Mengurangi lebar input pada layar kecil */
                margin-right: 5px; /* Mengurangi margin kanan pada input */
            }
            .search-container {
                flex-direction: column; /* Mengatur elemen dalam kolom */
                align-items: center; /* Menyelaraskan elemen di tengah */
            }
            .search-container button {
                width: 90%; /* Membuat tombol memenuhi lebar */
                margin-top: 10px; /* Ruang antara input dan tombol */
            }
            .table-container {
                padding: 15px; /* Mengurangi padding pada tabel untuk layar kecil */
            }
            th, td {
                padding: 8px; /* Mengurangi padding pada tabel */
            }
        }

        @media (max-width: 480px) {
            h2 {
                font-size: 24px; /* Mengurangi ukuran font judul */
            }
            .welcome-message {
                font-size: 1.2em; /* Mengurangi ukuran font pesan sambutan */
            }
            .search-container input {
                width: 100%; /* Memperlebar input agar memenuhi layar */
                margin-right: 0; /* Menghilangkan margin kanan pada input */
            }
            .search-container button {
                width: 100%; /* Membuat tombol memenuhi lebar */
                padding: 12px; /* Mengubah padding tombol untuk layar kecil */
            }
            .create-note a {
                padding: 12px 20px; /* Mengubah padding tautan untuk layar kecil */
            }
        }
    </style>
</head>
<body>
    <h2>Daftar Catatan</h2>
    <div class="welcome-message">
        Selamat datang di <strong>Note Everyday</strong>, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>!
    </div>
    <div class="search-container">
        <input type="text" placeholder="Cari catatan..." id="searchInput">
        <button type="button" onclick="searchNotes()"><i class="fas fa-search"></i> Cari</button>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Konten</th>
                    <th>Tanggal Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="notesTable">
                <?php while ($entry = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($entry['title']); ?></td>
                        <td><?php echo htmlspecialchars($entry['content']); ?></td>
                        <td><?php echo htmlspecialchars($entry['created_at']); ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $entry['id']; ?>">Edit</a>
                            <a href="delete.php?id=<?php echo $entry['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus catatan ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="create-note">
        <a href="create.php">Buat Catatan Baru</a>
    </div>
    <script>
        function searchNotes() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#notesTable tr');
            rows.forEach(row => {
                const title = row.cells[0].textContent.toLowerCase();
                const content = row.cells[1].textContent.toLowerCase();
                if (title.includes(input) || content.includes(input)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
    <div style="text-align: center; margin-top: 20px;">
        <?php include 'footer.php'; ?>
    </div>
</body>
</html>