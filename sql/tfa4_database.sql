-- Fresh TFA4 database export based on the TFA3 POS sample data.
-- Import this file into phpMyAdmin, then run `php spark migrate` from the project root.
-- The migration fills each existing user's password with a PHP password_hash() value.
CREATE DATABASE IF NOT EXISTS pos_database CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE pos_database;

CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    created_at DATETIME NOT NULL
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    full_name VARCHAR(100) NOT NULL,
    created_at DATETIME NOT NULL,
    avatar VARCHAR(255) NULL DEFAULT NULL,
    password VARCHAR(255) NULL DEFAULT NULL
);

INSERT INTO customers (full_name, email, phone, created_at) VALUES
('Jon Snow', 'jon.snow@example.com', '09171234567', '2026-09-01 09:00:00'),
('Robb Stark', 'robb.stark@example.com', '09181234567', '2026-09-02 10:15:00'),
('Ned Stark', 'ned.stark@example.com', '09191234567', '2026-09-03 11:30:00'),
('Sansa Stark', 'sansa.stark@example.com', '09201234567', '2026-09-04 13:45:00'),
('Joffrey Lannister', 'joffrey.lannister@example.com', '09211234567', '2026-09-05 15:00:00');

INSERT INTO users (username, full_name, created_at) VALUES
('jon.snow', 'Jon Snow', '2026-09-01 08:00:00'),
('robb.stark', 'Robb Stark', '2026-09-01 08:30:00'),
('ned.stark', 'Ned Stark', '2026-09-02 09:00:00'),
('sansa.stark', 'Sansa Stark', '2026-09-03 09:30:00'),
('joffrey.lannister', 'Joffrey Lannister', '2026-09-04 10:00:00');
