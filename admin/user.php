<?php
include 'config/db.php';
include '_auth_check.php';

// pesan feedback
$msg = '';

// === CREATE USER ===
if (isset($_POST['create_user'])) {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] === 'admin' ? 'admin' : 'user';

    if ($username && $password) {
        $check = $conn->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
        $check->bind_param('s', $username);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $msg = '❌ Username sudah digunakan.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
            $stmt->bind_param('sss', $username, $hash, $role);
            if ($stmt->execute()) {
                $msg = '✅ User berhasil dibuat.';
            } else {
                $msg = '❌ Gagal membuat user.';
            }
        }
    } else {
        $msg = '⚠️ Harap isi username dan password.';
    }
}

// === FETCH DATA USERS ===
$result = $conn->query("SELECT id, username, role, created_at FROM users ORDER BY created_at DESC");
$users = [];
while ($row = $result->fetch_assoc()) $users[] = $row;
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Kelola User</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-50">
  <div class="flex">
    <?php include 'index_sidebar.php'; ?>
    <main class="flex-1 p-8">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-blue-900">Kelola User</h1>
      </div>

      <?php if ($msg): ?>
        <div class="bg-blue-100 text-blue-800 p-3 rounded mb-4"><?=htmlspecialchars($msg)?></div>
      <?php endif; ?>

      <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h2 class="font-semibold mb-3">Tambah User / Admin Baru</h2>
        <form method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-3">
          <input name="username" placeholder="Username" class="border p-2 rounded" required>
          <input name="password" type="password" placeholder="Password" class="border p-2 rounded" required>
          <select name="role" class="border p-2 rounded">
            <option value="admin">Admin</option>
            <option value="user">User</option>
          </select>
          <div class="md:col-span-3">
            <button name="create_user" class="bg-blue-900 text-yellow-400 px-4 py-2 rounded">Buat</button>
          </div>
        </form>
      </div>

      <div class="bg-white p-4 rounded shadow">
        <table class="w-full">
          <thead class="bg-blue-50">
            <tr>
              <th class="p-2 text-left">ID</th>
              <th>Username</th>
              <th>Role</th>
              <th>Dibuat</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($users as $u): ?>
              <tr class="border-b">
                <td class="p-2"><?=htmlspecialchars($u['id'])?></td>
                <td class="p-2"><?=htmlspecialchars($u['username'])?></td>
                <td class="p-2"><?=htmlspecialchars($u['role'])?></td>
                <td class="p-2"><?=htmlspecialchars($u['created_at'])?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</body>
</html>
                