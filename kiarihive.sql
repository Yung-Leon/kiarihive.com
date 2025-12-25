-- Create database
CREATE DATABASE IF NOT EXISTS kiarihive;
USE kiarihive;

-- Users table (for admin/customer care)
CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin','customer') NOT NULL DEFAULT 'customer'
);

-- Insert default admin (password: admin123)
INSERT INTO users (username,password,role) VALUES
('admin',SHA2('admil123',256),'admin');

-- Products table
CREATE TABLE `products` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `description` TEXT NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `image` VARCHAR(255) NOT NULL
);

-- Sample products
INSERT INTO products (name, description, price, image) VALUES
('Wildflower Honey', 'Pure Kenyan wildflower honey.', 1200, 'images/wildflower.jpg'),
('Forest Honey', 'Natural forest honey.', 1500, 'images/forest.jpg'),
('Acacia Honey', 'Raw acacia honey.', 1800, 'images/acacia.jpg');

-- Orders table
CREATE TABLE `orders` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `customer_name` VARCHAR(100) NOT NULL,
  `customer_email` VARCHAR(100) NOT NULL,
  `customer_address` TEXT NOT NULL,
  `total` DECIMAL(10,2) NOT NULL,
  `status` ENUM('pending','approved','cancelled') DEFAULT 'pending',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Order Items
CREATE TABLE `order_items` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `order_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `quantity` INT NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (`order_id`) REFERENCES orders(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES products(`id`) ON DELETE CASCADE
);
