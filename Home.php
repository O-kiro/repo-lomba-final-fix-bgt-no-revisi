<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Prestasi</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f0f4f9;
    }

    /* Header */
    .header {
      background: #002b7a;
      color: white;
      padding: 15px;
      text-align: center;
      font-size: 20px;
      font-weight: bold;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .header img {
      width: 24px;
      height: 24px;
    }

    /* Kontainer kartu */
    .cards {
      display: flex;
      justify-content: center;
      gap: 20px;
      padding: 30px 20px;
    }

    .card {
      width: 180px;
      height: 240px;
      background: #e6edf8;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      transition: transform 0.2s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      cursor: pointer;
    }

    .card:hover {
      transform: translateY(-6px);
    }

    /* Tombol */
    .more-btn {
      display: block;
      margin: 0 auto 30px;
      padding: 10px 20px;
      background: #ffd23f;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-weight: bold;
      transition: background 0.2s;
    }

    .more-btn:hover {
      background: #e6be2d;
    }
  </style>
</head>
<body>

  <!-- Header -->
  <div class="header">
    <img src="img/piala.png" alt="Trophy">
    Prestasi
  </div>

  <!-- Kartu -->
  <div class="cards">
      <!-- Card Prestasi 1 -->
  <div class="card">
    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition">
      <img src="images/prestasi1.jpg" alt="prestasi 1" class="w-full h-40 object-cover">
      <div class="p-4">
        <h4 class="font-bold text-lg text-blue-800">Juara 1 Olim INFORMATIKAAA!!!</h4>
        <p class="text-gray-600 text-sm mt-2">
          Siswa MAN Kota Batu berhasil meraih Juara 1 tingkat gtw.
        </p>
        <a href="Prestasi1.php"></a>
      </div>
    </div>
  </div>


     <a href="Prestasi1.php"></a>
       <!-- Card Prestasi 2 -->
  <div class="card">
    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition">
      <img src="images/prestasi2.jpg" alt="prestasi 2" class="w-full h-40 object-cover">
      <div class="p-4">
        <h4 class="font-bold text-lg text-blue-800">ngantuk poll</h4>
        <p class="text-gray-600 text-sm mt-2">
          Isi sendiri yh.
        </p>
      </div>
    </div>
  </div>
  
       <!-- Card Prestasi 3 -->
  <div class="card">
    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition">
      <img src="images/prestasi3.jpg" alt="prestasi 3" class="w-full h-40 object-cover">
      <div class="p-4">
        <h4 class="font-bold text-lg text-blue-800">gtw</h4>
        <p class="text-gray-600 text-sm mt-2">
          ppppp.
        </p>
      </div>
    </div>
  </div>
    
   <!-- Card Prestasi 4 -->
  <div class="card">
    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition">
      <img src="images/prestasi4.jpg" alt="prestasi 4" class="w-full h-40 object-cover">
      <div class="p-4">
        <h4 class="font-bold text-lg text-blue-800">juara debat bahasa c++</h4>
        <p class="text-gray-600 text-sm mt-2">
          tingkat luar angkasa.
        </p>
      </div>
    </div>
  </div>

   <!-- Card Prestasi 5 -->
  <div class="card">
    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition">
      <img src="images/prestasi5.jpg" alt="prestasi 5" class="w-full h-40 object-cover">
      <div class="p-4">
        <h4 class="font-bold text-lg text-blue-800">MAKOBA</h4>
        <p class="text-gray-600 text-sm mt-2">
          sklh ijo.
        </p>
      </div>
    </div>
  </div>
  </div>

  <!-- Tombol -->
  <button class="more-btn">Lihat Lebih Banyak</button>

  </script>

</body>
</html>
</html>