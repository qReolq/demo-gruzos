CREATE DATABASE IF NOT EXISTS gruzovozoft CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE gruzovozoft;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fio VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL,
    login VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    is_admin TINYINT(1) NOT NULL DEFAULT 0
);

CREATE TABLE requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    request_date DATE NOT NULL,
    request_time TIME NOT NULL,
    weight FLOAT NOT NULL,
    dimensions VARCHAR(255),
    cargo_type ENUM('fragile', 'perishable', 'refrigerated', 'animals', 'liquid', 'furniture', 'trash') DEFAULT 'fragile',
    from_address VARCHAR(255),
    to_address VARCHAR(255),
    status ENUM('new', 'in_progress', 'cancelled') DEFAULT 'new',
    feedback TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE service_reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    rating TINYINT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO users (fio, phone, email, login, password, is_admin)
VALUES ('Администратор', '+7(999)-999-99-99', 'admin@gruzovozoff.ru', 'admin',
'gruzok2024', 1);
