CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    PASSWORD VARCHAR(255),
    ROLE ENUM('user', 'admin'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE laporan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    judul VARCHAR(255),
    isi TEXT,
    lokasi VARCHAR(255),
    foto VARCHAR(255),
    STATUS ENUM('menunggu','proses','selesai', 'ditolak') DEFAULT 'menunggu',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE
);

CREATE TABLE tanggapan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    laporan_id INT,
    respon TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (laporan_id) REFERENCES laporan(id)
    ON DELETE CASCADE
);

INSERT INTO users (nama, email, PASSWORD, ROLE) VALUES
('admin1', 'admin1@gmail.com', 'admin123', 'admin')
