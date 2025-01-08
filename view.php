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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
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
            font-family: 'Montserrat', sans-serif;
        }
        .welcome-message {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.5em;
            color: #fff;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.7);
        }
        .search-container, .create-note {
            background-color: rgba(76, 175, 80, 0.6);
            border-radius: 8px;
            padding: 15px;
            margin: 20px auto;
            max-width: 90%;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
            transition: transform 0.3s;
        }
        .search-container:hover, .create-note:hover {
            transform: scale(1.02);
        }
        .search-container input {
            padding: 10px;
            border: none;
            border-radius: 5px;
            width: 70%;
            margin-right: 10px;
            box-sizing: border-box;
            font-size: 1em;
            transition: border 0.3s;
        }
        .search-container input:focus {
            outline: none;
            border: 2px solid #5cb85c;
        }
        .search-container button {
            background-color: #5cb85c;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            width: 25%;
            transition: background-color 0.3s;
        }
        .search-container button:hover {
            background-color: #4cae4c;
        }
        .table-container {
            max-width: 90%;
            margin: 20px auto;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            padding: 20px;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            color: #333;
        }
        th {
            background-color: #f1f1f1;
            color: #333;
            font-weight: 600;
        }
        tr:hover {
            background-color: #f9f9f9;
            transition: background-color 0.3s;
        }
        .action-links a {
            color: #5cb85c;
            margin-right: 10px;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }
        .action-links a:hover {
            color: #4cae4c;
        }
        .full-content {
            display: none;
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: rgba(100, 100, 100, 0.1);
        }
        .toggle-link {
            cursor: pointer;
            text-decoration: underline;
        }
        .toggle-link.more {
            color: #28A745; /* Warna untuk "lihat lebih sedikit" */
        }
        .toggle-link.less {
            color: #007BFF; /* Warna untuk "lihat selengkapnya" */
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
                width: 60%;
                margin-right: 5px;
            }
            .search-container {
                flex-direction: column;
                align-items: center;
            }
            .search-container button {
                width: 90%;
                margin-top: 10px;
            }
        }

        @media (max-width: 480px) {
            h2 {
                font-size: 24px;
            }
            .welcome-message {
                font-size: 1.2em;
            }
            .search-container input {
                width: 100%;
                margin-right: 0;
            }
            .search-container button {
                width: 100%;
                padding: 12px;
            }
            .create-note a {
                padding: 12px 20px;
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
                        <td>
                            <?php
                            $content = htmlspecialchars($entry['content']);
                            if (strlen($content) > 55) {
                                $preview = substr($content, 0, 55) . '... ';
                                echo $preview . '<span class="toggle-link less" onclick="toggleContent(this)">lihat selengkapnya</span>';
                                echo '<div class="full-content">' . $content . '<br><span class="toggle-link more" onclick="toggleContent(this)"></div>';
                            } else {
                                echo $content;
                            }
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($entry['created_at']); ?></td>
                        <td class="action-links">
                            <a href="edit.php?id=<?php echo $entry['id']; ?>"><i class="fas fa-edit"></i> Edit</a>
                            <a href="delete.php?id=<?php echo $entry['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus catatan ini?');"><i class="fas fa-trash"></i> Hapus</a>
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
                row.style.display = (title.includes(input) || content.includes(input)) ? '' : 'none';
            });
        }

        function toggleContent(link) {
            const fullContent = link.parentNode.querySelector('.full-content');
            if (fullContent.style.display === 'none' || fullContent.style.display === '') {
                fullContent.style.display = 'block';
                link.textContent = 'lihat lebih sedikit';
            } else {
                fullContent.style.display = 'none';
                link.textContent = 'lihat selengkapnya';
            }
        }
    </script>
    <div style="text-align: center; margin-top: 20px;">
        <?php include 'footer.php'; ?>
    </div>
</body>
</html>
