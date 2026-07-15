-- Select the target database in phpMyAdmin before importing this file.
-- InfinityFree creates and names the database through its hosting panel.

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
('Mark Benedict Castro', 'buyer@bbb.test', 'buyer123', 'FEU Institute of Technology, Manila', '09170000002', 'buyer', 1, 'buyer-confirmed'),
('BBB Test Buyer', 'buyer123@bbb.test', 'buyer123', 'Manila, Philippines', '09170000003', 'buyer', 1, 'buyer123-confirmed');

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
('Wine Layered Mini Dress', 'Dresses', 'Wine and white mini dress with layered structured panels.', 2299.00, 9, 'BBB/JPG Files/BBB - 27.jpg', 'Active'),
('Silver Extended-Cuff Trousers', 'Bottoms', 'Light silver wide-leg trousers with a long tailored line and turned cuffs.', 1599.00, 14, 'BBB/Bottoms/Bottom - Men(3).png', 'Active'),
('Onyx Grid High-Waist Trousers', 'Bottoms', 'High-waist black trousers with a subtle woven grid and sweeping wide leg.', 1799.00, 10, 'BBB/Bottoms/Bottom - Men(4).png', 'Active'),
('Slate Double-Pleat Trousers', 'Bottoms', 'Slate tailored trousers finished with deep double pleats and a relaxed leg.', 1699.00, 12, 'BBB/Bottoms/Bottom - Men(5).png', 'Active'),
('Noir Pinstripe Wide-Leg Trousers', 'Bottoms', 'Fluid black wide-leg trousers traced with fine vertical pinstripes.', 1799.00, 11, 'BBB/Bottoms/Bottom - Women(6).png', 'Active'),
('Onyx Harness-Barrel Trousers', 'Bottoms', 'Sculpted black barrel trousers accented by an asymmetric gold-clasp strap.', 1899.00, 9, 'BBB/Bottoms/Bottom - Women(7).png', 'Active'),
('Navy Pleated-Hem Vest Dress', 'Dresses', 'Tailored navy vest dress with covered buttons and an ivory pleated hem.', 2299.00, 10, 'BBB/Dresses/Dress - Women(2).png', 'Active'),
('Olive Sculpted Blazer Dress', 'Dresses', 'Sleeveless olive blazer dress shaped with curved seams and metal buttons.', 2399.00, 8, 'BBB/Dresses/Dress - Women(3).png', 'Active'),
('Pearl Corset Mini Dress', 'Dresses', 'Blush satin corset mini dress embellished with pearls and gathered draping.', 2699.00, 7, 'BBB/Dresses/Dress - Women(4).png', 'Active'),
('Crimson Rosette Column Dress', 'Dresses', 'Crimson column mini dress covered in dimensional rosettes and trailing petals.', 2599.00, 8, 'BBB/Dresses/Dress - Women(5).png', 'Active'),
('Cocoa Scarf-Neck Midi Dress', 'Dresses', 'Cocoa chiffon midi dress with a scarf neckline and softly pleated skirt.', 2299.00, 11, 'BBB/Dresses/Dress - Women(6).png', 'Active'),
('Taupe Tie-Neck Utility Dress', 'Dresses', 'Sleeveless taupe dress with a long tie neck and polished utility pockets.', 2399.00, 9, 'BBB/Dresses/Dress - Women(11).png', 'Active'),
('Ivory Polka-Dot Drop-Waist Dress', 'Dresses', 'Ivory drop-waist mini dress patterned with black polka dots and a gathered hem.', 1999.00, 12, 'BBB/Dresses/Dress - Women(12).png', 'Active'),
('Onyx Clasp Work Jacket', 'Men Tops', 'Black work jacket detailed with polished metal clasps and a clean point collar.', 2199.00, 10, 'BBB/Men Tops/Men(3).png', 'Active'),
('Cocoa Asymmetric Utility Vest', 'Men Tops', 'Washed cocoa utility vest with asymmetric panels and raw-edge finishing.', 1599.00, 13, 'BBB/Men Tops/Men(4).png', 'Active'),
('Espresso Pinstripe Tie Shirt', 'Men Tops', 'Cropped espresso pinstripe shirt finished with a matching draped tie.', 1699.00, 12, 'BBB/Men Tops/Men(5).png', 'Active'),
('Noir Short-Sleeve Blazer Shirt', 'Men Tops', 'Minimal black short-sleeve shirt cut with sharp blazer-style lapels.', 1499.00, 15, 'BBB/Men Tops/Men(6).png', 'Active'),
('Ivory Embroidered Line Overshirt', 'Men Tops', 'Ivory overshirt with tonal abstract line embroidery and a relaxed silhouette.', 1899.00, 11, 'BBB/Men Tops/Men(7).png', 'Active'),
('Noir Lace-Up Detail Shirt', 'Men Tops', 'Black long-sleeve shirt animated by contrasting white lace-up details.', 1999.00, 9, 'BBB/Men Tops/Men(8).png', 'Active'),
('Washed Charcoal Muscle Tee', 'Men Tops', 'Sleeveless charcoal tee with a washed finish and sculpted shoulder seams.', 999.00, 18, 'BBB/Men Tops/Men(9).png', 'Active'),
('Navy Pinstripe Bardot Top', 'Women Tops', 'Off-shoulder navy pinstripe top with sculpted folds and a button front.', 1399.00, 14, 'BBB/Women Tops/Women(3).png', 'Active'),
('Taupe Sculpted Knit Top', 'Women Tops', 'Fitted taupe knit top shaped with a soft funnel neck and corset-inspired waist.', 1299.00, 15, 'BBB/Women Tops/Women(4).png', 'Active'),
('Olive Asymmetric Draped Top', 'Women Tops', 'Sleeveless olive top with folded lapels and an asymmetric draped hem.', 1499.00, 12, 'BBB/Women Tops/Women(5).png', 'Active'),
('Noir Pleated Halter Top', 'Women Tops', 'Black pleated halter top with a ruffled neckline and defined waist.', 1399.00, 13, 'BBB/Women Tops/Women(6).png', 'Active'),
('Espresso Layered Turtleneck', 'Women Tops', 'Espresso ribbed turtleneck with a cropped overlay and buttoned inner layer.', 1699.00, 10, 'BBB/Women Tops/Women(7).png', 'Active'),
('Distressed Cocoa Mock-Neck Top', 'Women Tops', 'Sleeveless cocoa mock-neck top with an asymmetric gathered waist and aged finish.', 1499.00, 11, 'BBB/Women Tops/Women(8).png', 'Active');

INSERT INTO `audit_logs` (`user_id`, `user_name`, `activity`) VALUES
(1, 'System Admin', 'Initial database seed for BBB');
