CREATE DATABASE IF NOT EXISTS sekolah_db DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE sekolah_db;

-- Tabel users
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','user') DEFAULT 'user',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabel berita
CREATE TABLE IF NOT EXISTS berita (
  id INT AUTO_INCREMENT PRIMARY KEY,
  judul VARCHAR(255) NOT NULL,
  isi TEXT NOT NULL,
  gambar VARCHAR(255) DEFAULT 'img/noimage.jpg',
  penulis VARCHAR(100) DEFAULT 'admin',
  tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tambah admin
INSERT INTO users (username, password, role) VALUES 
('admin', '$2y$10$wuQ3jHIDq47OTcjhGlmN6OVYxZg44hNxwpmG5vV7L7fDk3aTCOD4y', 'admin');

-- Contoh berita
INSERT INTO berita (judul, isi, penulis) VALUES
('Selamat Datang di Portal', 'Ini berita pertama di dashboard.', 'admin'),
('Pengumuman Libur', 'Besok libur, tetap semangat belajar!', 'admin');
