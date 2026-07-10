CREATE DATABASE IF NOT EXISTS `final_project_db`;
USE `final_project_db`;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `complete_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `address` varchar(200) NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `role` varchar(20) NOT NULL,
  `email_confirmed` tinyint(1) NOT NULL DEFAULT 0,
  `confirmation_code` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(6) NOT NULL,
  `image` varchar(120) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(6) UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(50) NOT NULL,
  `shipping_address` varchar(200) NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` int(6) UNSIGNED NOT NULL,
  `product_id` int(6) UNSIGNED NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(6) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `audit_logs` (
  `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(6) UNSIGNED NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `activity` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`complete_name`, `email`, `password`, `address`, `contact_number`, `role`, `email_confirmed`, `confirmation_code`) VALUES
('System Admin', 'admin@threadline.test', 'admin123', 'Manila, Philippines', '09170000001', 'admin', 1, 'admin-confirmed'),
('Mark Benedict Castro', 'buyer@threadline.test', 'buyer123', 'FEU Institute of Technology, Manila', '09170000002', 'buyer', 1, 'buyer-confirmed');

INSERT INTO `products` (`name`, `category`, `description`, `price`, `quantity`, `image`, `status`) VALUES
('Classic Cotton Shirt', 'Tops', 'Soft daily shirt with a clean ThreadLine print.', 499.00, 35, 'img/product-shirt.svg', 'Active'),
('Oversized Graphic Tee', 'Tops', 'Relaxed streetwear tee for casual outfits.', 699.00, 24, 'img/product-tee.svg', 'Active'),
('Denim Straight Pants', 'Bottoms', 'Comfortable straight-cut denim pants.', 1199.00, 18, 'img/product-pants.svg', 'Active'),
('Pleated Midi Skirt', 'Bottoms', 'Light pleated skirt for smart casual wear.', 899.00, 20, 'img/product-skirt.svg', 'Active'),
('Everyday Hoodie', 'Outerwear', 'Warm pullover hoodie with front pocket.', 1299.00, 16, 'img/product-hoodie.svg', 'Active'),
('Summer Linen Dress', 'Dresses', 'Breathable linen dress for warm weather.', 1499.00, 12, 'img/product-dress.svg', 'Active'),
('Canvas Tote Bag', 'Accessories', 'Reusable tote bag with printed group logo.', 349.00, 40, 'img/product-tote.svg', 'Active'),
('ThreadLine Cap', 'Accessories', 'Adjustable cap with embroidered logo.', 399.00, 28, 'img/product-cap.svg', 'Active');

INSERT INTO `audit_logs` (`user_id`, `user_name`, `activity`) VALUES
(1, 'System Admin', 'Initial database seed for ThreadLine Clothing');
