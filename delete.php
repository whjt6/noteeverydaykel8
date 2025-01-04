<?php
session_start();
include 'db.php';

// Cek jika pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Arahkan ke login jika pengguna belum login
    exit();
}

// Cek jika ID catatan diberikan
if (!isset($_GET['id'])) {
    header("Location: index.php"); // Arahkan ke index jika tidak ada ID
    exit();
}

$entry_id = intval($_GET['id']);

// Siapkan dan eksekusi pernyataan untuk menghapus catatan
$stmt = $conn->prepare("DELETE FROM entries WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $entry_id, $_SESSION['user_id']);
if ($stmt->execute()) {
    // Redirect ke halaman index setelah berhasil menghapus
    header("Location: view.php?message=Catatan berhasil dihapus.");
    exit();
} else {
    // Jika gagal, tampilkan error
    echo "Gagal menghapus catatan: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>