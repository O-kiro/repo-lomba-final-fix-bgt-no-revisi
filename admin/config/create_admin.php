<?php
// Buat akun admin pertama kali
include 'db.php';

$username = 'admin';
$password_plain = 'admin123';
$hash = password_hash($password_plain, PASSWORD_DEFAULT);

$check = $conn->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
$check->bind_param('s', $username);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo "✅ User '$username' sudah ada.";
    exit;
}

$stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'admin')");
$stmt->bind_param('ss', $username, $hash);
if ($stmt->execute()) {
    echo "🎉 Admin berhasil dibuat!<br>Username: <b>$username</b><br>Password: <b>$password_plain</b>";
} else {
    echo "❌ Gagal: " . $stmt->error;
}
$stmt->close();
?>
