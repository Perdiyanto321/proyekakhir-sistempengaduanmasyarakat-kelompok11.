CREATE DATABASE db_pengaduan;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    PASSWORD VARCHAR(255) NOT NULL,
    ROLE ENUM('user','admin') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE laporan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    judul VARCHAR(255) NOT NULL,
    isi TEXT NOT NULL,
    lokasi VARCHAR(255) NOT NULL,
    foto VARCHAR(255),
    STATUS ENUM('menunggu','proses','selesai','ditolak') DEFAULT 'menunggu',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE
)

CREATE TABLE tanggapan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    laporan_id INT NOT NULL,
    respon TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (laporan_id) REFERENCES laporan(id)
    ON DELETE CASCADE
);

INSERT INTO users (nama, email, PASSWORD, ROLE)
VALUES ('admin', 'admin@gmail.com', 'admin123', 'admin');