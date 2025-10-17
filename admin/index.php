<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'config/db.php';
require_once '_auth_check.php';

// Hitung total user & berita
$resUsers = $conn->query("SELECT COUNT(*) as total FROM users") or die($conn->error);
$totalUsers = $resUsers->fetch_assoc()['total'] ?? 0;

$resNews = $conn->query("SELECT COUNT(*) as total FROM berita") or die($conn->error);
$totalNews = $resNews->fetch_assoc()['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Dashboard - Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-50">
  <div class="flex">
    <?php include 'index_sidebar.php'; ?>
    <main class="flex-1 p-8">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-blue-900">Halo, <?=htmlspecialchars($_SESSION['username'])?></h1>
      </div>

      <div class="grid grid-cols-2 gap-6 mb-6">
        <div class="p-6 bg-white rounded-lg shadow">
          <p class="text-sm text-gray-500">Total Admin/User</p>
          <h3 class="text-3xl font-bold text-blue-900"><?=$totalUsers?></h3>
        </div>
        <div class="p-6 bg-white rounded-lg shadow">
          <p class="text-sm text-gray-500">Total Berita</p>
          <h3 class="text-3xl font-bold text-blue-900"><?=$totalNews?></h3>
        </div>
      </div>

      <section class="bg-white p-6 rounded-lg shadow">
        <h2 class="font-bold text-lg mb-3">Berita Terbaru</h2>
        <ul class="divide-y">
          <?php
          $r = $conn->query("SELECT id, judul, tanggal FROM berita ORDER BY tanggal DESC LIMIT 5") or die($conn->error);
          while ($row = $r->fetch_assoc()):
          ?>
            <li class="py-3">
              <a href="berita.php" class="text-blue-800 font-semibold"><?=htmlspecialchars($row['judul'])?></a>
              <div class="text-xs text-gray-500"><?=htmlspecialchars($row['tanggal'])?></div>
            </li>
          <?php endwhile; ?>
        </ul>
      </section>
    </main>
  </div>
</body>
</html>
