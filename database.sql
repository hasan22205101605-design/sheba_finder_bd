CREATE DATABASE IF NOT EXISTS sheba_finder_bd;
USE sheba_finder_bd;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    user_type ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (name, email, phone, password, user_type) VALUES 
('Admin', 'admin@shebafinder.com', '01700000000', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Insert sample regular user (password: user123)
INSERT INTO users (name, email, phone, password, user_type) VALUES 
('Rahim Uddin', 'rahim@gmail.com', '01712345678', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user');

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    icon VARCHAR(50) DEFAULT 'fas fa-tools',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE technicians (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100),
    address TEXT,
    experience INT DEFAULT 0,
    rating DECIMAL(2,1) DEFAULT 4.0,
    price_per_hour DECIMAL(10,2) NOT NULL,
    image VARCHAR(255) DEFAULT 'default.jpg',
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    technician_id INT NOT NULL,
    user_id INT NULL,
    customer_name VARCHAR(100) NOT NULL,
    customer_phone VARCHAR(20) NOT NULL,
    customer_email VARCHAR(100),
    address TEXT NOT NULL,
    booking_date DATE NOT NULL,
    booking_time TIME NOT NULL,
    status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending',
    total_amount DECIMAL(10,2) NOT NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (technician_id) REFERENCES technicians(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

INSERT INTO categories (name, icon) VALUES
('Plumbing', 'fas fa-wrench'),
('Electrical', 'fas fa-bolt'),
('Carpentry', 'fas fa-hammer'),
('AC Repair', 'fas fa-snowflake'),
('Cleaning', 'fas fa-broom'),
('Painting', 'fas fa-paint-brush');

INSERT INTO technicians (category_id, name, phone, email, address, experience, rating, price_per_hour, image) VALUES
(1, 'Md. Rahim Uddin', '01712345678', 'rahim@gmail.com', 'Dhaka', 8, 4.8, 500, 'technician1.jpg'),
(1, 'Karim Mia', '01812345678', 'karim@gmail.com', 'Gazipur', 5, 4.5, 450, 'technician2.jpg'),
(2, 'Shahidul Islam', '01912345678', 'shahidul@gmail.com', 'Narayanganj', 10, 4.9, 600, 'technician3.jpg'),
(2, 'Rafiq Uddin', '01723456789', 'rafiq@gmail.com', 'Dhaka', 6, 4.6, 550, 'technician4.jpg'),
(3, 'Mizanur Rahman', '01823456789', 'mizan@gmail.com', 'Dhaka', 7, 4.7, 500, 'technician5.jpg'),
(4, 'Kamal Hossain', '01923456789', 'kamal@gmail.com', 'Dhaka', 5, 4.4, 700, 'technician6.jpg'),
(5, 'Sumon Mia', '01734567890', 'sumon@gmail.com', 'Gazipur', 4, 4.3, 400, 'technician7.jpg'),
(6, 'Rana Ahmed', '01834567890', 'rana@gmail.com', 'Dhaka', 6, 4.6, 550, 'technician8.jpg');
