<?php
include 'config/db.php';
include '_auth_check.php';

// folder upload
$upload_dir = __DIR__ . '/../img/berita/';
$allowed = ['jpg','jpeg','png','webp'];

if (!is_dir($upload_dir)) {
    $upload_dir = __DIR__ . '/../img/';
}

// === CREATE ===
if (isset($_POST['create'])) {
    $judul = trim($_POST['judul'] ?? '');
    $isi = trim($_POST['isi'] ?? '');
    $penulis = $_SESSION['username'];
    $gambar_file = '';

    if (!empty($_FILES['gambar']['name'])) {
        $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            $fn = uniqid('img_') . '.' . $ext;
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_dir . $fn)) {
                $gambar_file = 'img/berita/' . $fn;
            }
        }
    }

    if (!$gambar_file) $gambar_file = 'img/noimage.jpg';

    if ($judul && $isi) {
        $stmt = $conn->prepare("INSERT INTO berita (judul, isi, gambar, penulis) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $judul, $isi, $gambar_file, $penulis);
        $stmt->execute();
        header('Location: berita.php');
        exit;
    }
}

// === UPDATE ===
if (isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $judul = trim($_POST['judul'] ?? '');
    $isi = trim($_POST['isi'] ?? '');
    $gambar_file = $_POST['existing_gambar'] ?? 'img/noimage.jpg';

    if (!empty($_FILES['gambar']['name'])) {
        $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            $fn = uniqid('img_') . '.' . $ext;
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_dir . $fn)) {
                $gambar_file = 'img/berita/' . $fn;
            }
        }
    }

    if ($judul && $isi) {
        $u = $conn->prepare("UPDATE berita SET judul=?, isi=?, gambar=? WHERE id=?");
        $u->bind_param('sssi', $judul, $isi, $gambar_file, $id);
        $u->execute();
        header('Location: berita.php');
        exit;
    }
}

// === DELETE ===
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $s = $conn->prepare("SELECT gambar FROM berita WHERE id=? LIMIT 1");
    $s->bind_param('i', $id);
    $s->execute();
    $res = $s->get_result();
    if ($row = $res->fetch_assoc()) {
        $path = __DIR__ . '/../' . $row['gambar'];
        if (file_exists($path) && strpos($row['gambar'], 'noimage.jpg') === false) {
            @unlink($path);
        }
    }
    $d = $conn->prepare("DELETE FROM berita WHERE id=?");
    $d->bind_param('i', $id);
    $d->execute();
    header('Location: berita.php');
    exit;
}

// === FETCH DATA ===
$res = $conn->query("SELECT * FROM berita ORDER BY tanggal DESC");
$news = [];
while ($r = $res->fetch_assoc()) $news[] = $r;
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Kelola Berita</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-50">
  <div class="flex">
    <?php include 'index_sidebar.php'; ?>
    <main class="flex-1 p-8">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-blue-900">Kelola Berita</h1>
        <a href="#tambah" class="bg-yellow-400 text-blue-900 px-4 py-2 rounded font-semibold">+ Tambah Berita</a>
      </div>

      <!-- FORM TAMBAH -->
      <div id="tambah" class="bg-white p-6 rounded-lg shadow mb-6">
        <form method="POST" enctype="multipart/form-data" class="space-y-3">
          <input name="judul" placeholder="Judul" class="w-full border rounded px-3 py-2" required />
          <textarea name="isi" rows="6" placeholder="Isi berita" class="w-full border rounded px-3 py-2" required></textarea>
          <input type="file" name="gambar" accept=".jpg,.jpeg,.png,.webp" class="border p-2 rounded" />
          <button name="create" class="bg-blue-900 text-yellow-400 px-4 py-2 rounded">Simpan</button>
        </form>
      </div>

      <!-- TABEL BERITA -->
      <div class="bg-white p-4 rounded-lg shadow">
        <table class="w-full table-auto">
          <thead class="bg-blue-50">
            <tr>
              <th class="p-2 text-left">ID</th>
              <th>Judul</th>
              <th>Penulis</th>
              <th>Tanggal</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($news as $n): ?>
            <tr class="border-b">
              <td class="p-2"><?=htmlspecialchars($n['id'])?></td>
              <td class="p-2"><?=htmlspecialchars($n['judul'])?></td>
              <td class="p-2"><?=htmlspecialchars($n['penulis'])?></td>
              <td class="p-2"><?=htmlspecialchars($n['tanggal'])?></td>
              <td class="p-2">
                <a href="?edit=<?=$n['id']?>" class="text-blue-700 mr-2">Edit</a>
                <a href="?delete=<?=$n['id']?>" onclick="return confirm('Hapus berita?')" class="text-red-600">Hapus</a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- FORM EDIT -->
      <?php if (isset($_GET['edit'])):
        $id = (int)$_GET['edit'];
        $s = $conn->prepare("SELECT * FROM berita WHERE id=? LIMIT 1");
        $s->bind_param('i', $id);
        $s->execute();
        $res = $s->get_result();
        $item = $res->fetch_assoc();
        if ($item):
      ?>
      <div class="bg-white p-6 rounded-lg shadow mt-6">
        <form method="POST" enctype="multipart/form-data" class="space-y-3">
          <input type="hidden" name="id" value="<?=$item['id']?>">
          <input type="hidden" name="existing_gambar" value="<?=htmlspecialchars($item['gambar'])?>">
          <input name="judul" value="<?=htmlspecialchars($item['judul'])?>" class="w-full border rounded px-3 py-2" required />
          <textarea name="isi" rows="6" class="w-full border rounded px-3 py-2" required><?=htmlspecialchars($item['isi'])?></textarea>
          <input type="file" name="gambar" accept=".jpg,.jpeg,.png,.webp" class="border p-2 rounded" />
          <button name="update" class="bg-blue-900 text-yellow-400 px-4 py-2 rounded">Update</button>
          <a href="berita.php" class="ml-3 text-gray-600">Batal</a>
        </form>
      </div>
      <?php endif; endif; ?>

    </main>
  </div>
</body>
</html>
