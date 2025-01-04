<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$entry_id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM entries WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $entry_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$entry = $result->fetch_assoc();

if (!$entry) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    $stmt = $conn->prepare("UPDATE entries SET title = ?, content = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ssii", $title, $content, $entry_id, $_SESSION['user_id']);

    if ($stmt->execute()) {
        header("Location: view.php?id=" . $entry_id);
        exit();
    } else {
        $error = "Gagal memperbarui catatan: " . $stmt->error;
    }
}

include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Catatan - Note Everyday</title>
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
        .form-container {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border: 2px solid white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }
        input[type="text"],
        textarea {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            color: black;
            background-color: white;
            box-sizing: border-box; /* Memastikan padding dihitung dalam lebar */
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #45a049;
        }
        .view-note {
            background-color: rgba(76, 175, 80, 0.3);
            border-radius: 5px;
            padding: 10px;
            margin: 20px auto;
            max-width: 800px;
            text-align: center;
        }
        .view-note a {
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
        }
        .view-note a:hover {
            background-color: rgba(255, 255, 255, 0.2);
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
        @media (max-width: 480px) {
            .form-container {
                padding: 15px; /* Mengurangi padding untuk layar kecil */
                max-width: 90%; /* Memperlebar lebar container di ponsel */
            }
            h2 {
                font-size: 24px; /* Mengurangi ukuran font judul */
            }
            button {
                padding: 12px; /* Mengubah padding tombol untuk layar kecil */
            }
        }
    </style>
</head>
<body>
    <h2>Edit Catatan</h2>
    <div class="form-container">
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="post">
            <label for="title" style="color: black;">Judul:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($entry['title']); ?>" required>
            <label for="content" style="color: black;">Konten:</label>
            <textarea name="content" rows="5" required><?php echo htmlspecialchars($entry['content']); ?></textarea>
            <button type="submit">Perbarui</button>
        </form>
    </div>
    <div class="view-note">
        <a href="view.php?id=<?php echo $entry_id; ?>">Kembali ke Catatan</a>
    </div>

    <div style="text-align: center; margin-top: 20px;">
        <?php include 'footer.php'; ?>
    </div>
</body>
</html>