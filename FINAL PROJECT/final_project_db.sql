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
('System Admin', 'admin@bbb.test', 'admin123', 'Manila, Philippines', '09170000001', 'admin', 1, 'admin-confirmed'),
('Mark Benedict Castro', 'buyer@bbb.test', 'buyer123', 'FEU Institute of Technology, Manila', '09170000002', 'buyer', 1, 'buyer-confirmed');

INSERT INTO `products` (`name`, `category`, `description`, `price`, `quantity`, `image`, `status`) VALUES
('Silk Monogram Scarf', 'Accessories', 'Brown and ivory square scarf with a clean monogram border.', 549.00, 24, 'BBB/JPG Files/BBB - 5.jpg', 'Active'),
('Heritage Paisley Scarf', 'Accessories', 'Lightweight paisley scarf in warm neutral colors.', 599.00, 20, 'BBB/JPG Files/BBB - 7.jpg', 'Active'),
('Ivory Draped Trousers', 'Bottoms', 'High-waist ivory trousers with a soft draped front.', 1299.00, 16, 'BBB/JPG Files/BBB - 9.jpg', 'Active'),
('Rose Wide-Leg Trousers', 'Bottoms', 'Tailored rose trousers with a relaxed wide-leg shape.', 1399.00, 14, 'BBB/JPG Files/BBB - 10.jpg', 'Active'),
('Pearl Wrap Skort', 'Bottoms', 'Structured pearl skort with an asymmetric wrap front.', 999.00, 18, 'BBB/JPG Files/BBB - 11.jpg', 'Active'),
('Navy Tailored Trousers', 'Bottoms', 'Straight navy trousers finished with a side buckle.', 1499.00, 15, 'BBB/JPG Files/BBB - 12.jpg', 'Active'),
('Sand Utility Trousers', 'Bottoms', 'Wide-leg sand trousers with layered utility details.', 1599.00, 12, 'BBB/JPG Files/BBB - 13.jpg', 'Active'),
('Two-Tone Tailored Pants', 'Bottoms', 'Statement tailored pants with contrasting black panels.', 1699.00, 10, 'BBB/JPG Files/BBB - 14.jpg', 'Active'),
('Ivory Asymmetric Top', 'Women Tops', 'Fitted ivory top with an asymmetric folded neckline.', 1099.00, 16, 'BBB/JPG Files/BBB - 15.jpg', 'Active'),
('Cocoa Belted Top', 'Women Tops', 'Cocoa high-neck top with a matching waist tie.', 1199.00, 14, 'BBB/JPG Files/BBB - 16.jpg', 'Active'),
('Lilac Ruched Top', 'Women Tops', 'Soft lilac top with gathered detailing across the front.', 999.00, 18, 'BBB/JPG Files/BBB - 17.jpg', 'Active'),
('Striped Relaxed Shirt', 'Men Tops', 'Long-sleeve striped shirt with a relaxed tailored fit.', 1299.00, 15, 'BBB/JPG Files/BBB - 18.jpg', 'Active'),
('Cream Embroidered Overshirt', 'Men Tops', 'Textured cream overshirt with a clean button front.', 1599.00, 12, 'BBB/JPG Files/BBB - 19.jpg', 'Active'),
('Midnight Mandarin Shirt', 'Men Tops', 'Short-sleeve midnight shirt with a minimal mandarin collar.', 1399.00, 14, 'BBB/JPG Files/BBB - 20.jpg', 'Active'),
('Printed Asymmetric Cape', 'Outerwear', 'Light printed cape with an asymmetric draped silhouette.', 1699.00, 10, 'BBB/JPG Files/BBB - 21.jpg', 'Active'),
('Ivory Waterfall Jacket', 'Outerwear', 'Cropped ivory jacket with a wide waterfall collar.', 1899.00, 9, 'BBB/JPG Files/BBB - 22.jpg', 'Active'),
('Burgundy Cape Coat', 'Outerwear', 'Structured burgundy cape coat with metal neck detail.', 2199.00, 8, 'BBB/JPG Files/BBB - 23.jpg', 'Active'),
('Taupe Cropped Jacket', 'Outerwear', 'Tailored taupe cropped jacket with a wide lapel.', 1999.00, 11, 'BBB/JPG Files/BBB - 24.jpg', 'Active'),
('Mocha Drape Evening Dress', 'Dresses', 'One-shoulder mocha dress with a flowing draped panel.', 2499.00, 8, 'BBB/JPG Files/BBB - 25.jpg', 'Active'),
('Stone Wrap Midi Dress', 'Dresses', 'Long-sleeve stone dress with a flattering wrap waist.', 2199.00, 10, 'BBB/JPG Files/BBB - 26.jpg', 'Active'),
('Wine Layered Mini Dress', 'Dresses', 'Wine and white mini dress with layered structured panels.', 2299.00, 9, 'BBB/JPG Files/BBB - 27.jpg', 'Active');

INSERT INTO `audit_logs` (`user_id`, `user_name`, `activity`) VALUES
(1, 'System Admin', 'Initial database seed for BBB');
