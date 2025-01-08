<?php
$error = ''; // Inisialisasi variabel error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "u857619896_testdiary";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        header("Location: login.php?message=Registrasi berhasil, silakan login.");
        exit();
    } else {
        $error = "Gagal mendaftar: " . $stmt->error;
    }

    $stmt->close(); // Tutup statement
    $conn->close(); // Tutup koneksi
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Note Everyday</title>
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
            color: #fff;
            font-size: 2.5em;
            text-align: center;
            margin: 20px 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
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
            text-shadow: 1px 1px 2px rgba(12, 12, 12, 0.7); /* Bayangan teks */
        }
        nav a:hover {
            color: rgba(7, 7, 7, 0.8); /* Warna putih sedikit transparan saat hover */
        }
        .form-container {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(245, 241, 241, 0.95);
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(7, 7, 7, 0.3);
        }
        .form-container input[type="text"],
        .form-container input[type="password"],
        .form-container input[type="email"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-container label {
            color: #000; /* Mengubah warna label menjadi hitam */
        }
        .register-button {
            display: flex;
            justify-content: center;
        }
        .register-button input[type="submit"] {
            background-color: #4CAF50; /* Warna tombol hijau */
            color: white; /* Warna teks tombol */
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }
        .register-button input[type="submit"]:hover {
            background-color: #45a049; /* Warna tombol saat hover */
            transform: scale(1.05);
        }
        .login-link {
            text-align: center;
            margin-top: 15px;
            color: white; /* Warna teks login tetap putih */
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.9); /* Bayangan lebih jelas pada teks link login */
        }
        .login-link a {
            color: white; /* Warna teks link login tetap putih */
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline; /* Efek underline saat hover */
        }
        footer {
            text-align: center;
            margin-top: 20px;
            color: #fff; /* Warna teks footer */
            background-color: rgba(0, 0, 0, 0.7); /* Latar belakang footer */
            padding: 10px 0;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Register - Note Everyday</h1>
    <nav>
        <a href="index.php">Home</a>
        <a href="login.php">Login</a>
    </nav>
    
    <div class="form-container">
        <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form action="" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <div class="register-button">
                <input type="submit" value="Register">
            </div>
            <div class="login-link">
                <p>Sudah punya akun? <a href="login.php">Login</a></p>
            </div>
        </form>
    </div>

    <div style="text-align: center; margin-top: 20px;">
        <?php include 'footer.php'; ?>
    </div>
</body>
</html>
