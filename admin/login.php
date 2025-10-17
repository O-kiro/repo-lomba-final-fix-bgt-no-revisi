<?php
// admin/login.php
// Versi login yang more robust + debug-ready
// Taruh di folder admin/ (karena config/db.php ada di dalam admin/config/)

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

// Include koneksi (pastikan file ini: admin/config/db.php)
include 'config/db.php';

$error = '';

// Jika user sudah login, redirect ke index/dashboard
if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil input dan sanitasi minimal
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Username & password harus diisi.';
    } else {
        // Prepared statement untuk mencegah SQL injection
        if ($stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ? LIMIT 1")) {
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $res = $stmt->get_result();
            $user = $res->fetch_assoc();
            $stmt->close();

            // Cek user & password
            if ($user) {
                // Pastikan password di DB di-hash menggunakan password_hash()
                if (password_verify($password, $user['password'])) {
                    // Login sukses -> set session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];

                    // Redirect ke dashboard (index.php di folder admin)
                    header('Location: index.php');
                    exit;
                } else {
                    $error = 'Username atau password salah.';
                }
            } else {
                $error = 'Username atau password salah.';
            }
        } else {
            // Kalau prepare gagal, tampilkan error DB (debug)
            $error = 'Terjadi masalah pada database: ' . htmlspecialchars($conn->error);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Login Admin - MAN Kota Batu</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-900 to-blue-800 flex items-center justify-center">
  <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
    <div class="flex items-center gap-3 mb-4">
      <!-- Sesuaikan path logo kalau perlu -->
      <img src="../img/logo man.png" alt="logo" class="w-12 h-12">
      <div>
        <h1 class="text-blue-900 text-xl font-bold">Panel Admin</h1>
        <p class="text-sm text-gray-500">MAN Kota Batu</p>
      </div>
    </div>

    <?php if ($error): ?>
      <div class="bg-red-100 text-red-700 p-3 rounded mb-3"><?=htmlspecialchars($error)?></div>
    <?php endif; ?>

    <form method="POST" class="space-y-3" autocomplete="off">
      <input name="username" value="<?=isset($username) ? htmlspecialchars($username) : ''?>" required placeholder="Username" class="w-full border rounded px-3 py-2 outline-none focus:ring-2 focus:ring-yellow-400" />
      <input name="password" type="password" required placeholder="Password" class="w-full border rounded px-3 py-2 outline-none focus:ring-2 focus:ring-yellow-400" />
      <button class="w-full bg-blue-900 text-yellow-400 py-2 rounded font-semibold hover:brightness-90">Login</button>
    </form>

    <p class="text-xs text-gray-500 mt-4">Masuk menggunakan akun admin. Jika belum punya, buat lewat user management setelah login.</p>
  </div>
</body>
</html>
