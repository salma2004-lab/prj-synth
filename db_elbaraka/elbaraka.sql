-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 20, 2025 at 05:54 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elbaraka`
--

-- --------------------------------------------------------

--
-- Table structure for table `about`
--

CREATE TABLE `about` (
  `id` int(11) NOT NULL,
  `heading` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about`
--

INSERT INTO `about` (`id`, `heading`, `description`, `image_url`) VALUES
(1, 'Nous sommes ELBARAKA', 'Bienvenue chez Elbaraka, votre restaurant-café idéal pour savourer des plats délicieux dans une ambiance chaleureuse et conviviale. Créé en 2025, Elbaraka vous propose un menu varié, en passant par des desserts raffinés et des boissons rafraîchissantes. Chaque détail est pensé pour vous offrir une expérience culinaire unique, alliant qualité, saveur et élégance. Profitez d’un espace accueillant, parfait pour partager un moment agréable entre amis, en famille ou en solo. Découvrez notre univers et laissez-vous séduire par notre passion pour la gastronomie.', 'images/about-img.png');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`) VALUES
(1, 'Burger', '2025-04-19 23:49:24'),
(2, 'Pizza', '2025-04-19 23:49:24'),
(3, 'Pasta', '2025-04-19 23:49:24'),
(4, 'Frites', '2025-04-19 23:49:24'),
(5, 'Salade', '2025-04-19 23:49:24');

-- --------------------------------------------------------

--
-- Table structure for table `footer`
--

CREATE TABLE `footer` (
  `id` int(11) NOT NULL,
  `key_name` varchar(50) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `footer`
--

INSERT INTO `footer` (`id`, `key_name`, `value`) VALUES
(1, 'address', 'Lot amal nr 1'),
(2, 'phone', '+212 522 23 45 67'),
(3, 'email', 'Elbaraka@gmail.com'),
(4, 'hours_days', 'Tous les jours'),
(5, 'hours_time', '10:00 - 22:30'),
(6, 'facebook', 'https://www.facebook.com/yourpage'),
(7, 'instagram', 'https://www.instagram.com/yourpage'),
(8, 'twitter', 'https://twitter.com/yourpage');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `sales_count` int(11) DEFAULT 0,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `name`, `description`, `price`, `image_url`, `sales_count`, `category_id`) VALUES
(1, 'Pizza aux Fruits de Mer', 'La Pizza aux Fruits de Mer est une pizza savoureuse garnie d’une sauce tomate parfumée, d’un mélange de crevettes, calamars et moules sautés à l’ail, et recouverte de fromage fondant.', 200.00, 'images/f1.png', 0, 2),
(2, 'Burger maison', 'Le Burger Maison est un savoureux burger avec un steak de bœuf haché juteux dans un pain moelleux, garni de fromage cheddar, de rondelles de tomate.', 150.00, 'images/f2.png', 0, 1),
(3, 'Homemade Vegan Burgers', 'Homemade Vegan Burgers sont des burgers savoureux à base de haricots noirs ou de pois chiches écrasés, mélangés avec des flocons d’avoine, des oignons, de l’ail et des carottes.', 120.00, 'images/f7.png', 0, 1),
(4, 'Pizza aux Fruits de Mer', 'La Pizza aux Fruits de Mer est une pizza savoureuse garnie d’une sauce tomate parfumée, d’un mélange de crevettes, calamars et moules sautés à l’ail, et recouverte de fromage fondant.', 200.00, 'images/f1.png', 0, 2),
(5, 'Burger maison', 'Le Burger Maison est un savoureux burger avec un steak de bœuf haché juteux dans un pain moelleux, garni de fromage cheddar, de rondelles de tomate.', 150.00, 'images/f2.png', 0, 1),
(6, 'Homemade Vegan Burgers', 'Homemade Vegan Burgers sont des burgers savoureux à base de haricots noirs ou de pois chiches écrasés, mélangés avec des flocons d’avoine, des oignons, de l’ail et des carottes.', 120.00, 'images/f7.png', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `discount` decimal(5,2) NOT NULL,
  `image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `name`, `description`, `discount`, `image_url`) VALUES
(1, 'Burgers classiques', 'Découvrez nos burgers classiques avec une réduction de 20% !', 20.00, 'images/o1.jpg'),
(2, 'Pizza aux Fruits de Mer', 'Profitez d\'une délicieuse pizza aux fruits de mer avec 10% de réduction.', 10.00, 'images/f1.png'),
(4, 'Pizza Margarita', 'La traditionnelle Pizza Margarita est disponible avec 15% de remise spéciale.', 15.00, 'images/o2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` int(11) NOT NULL,
  `day_name` varchar(50) NOT NULL,
  `day_of_week` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`id`, `day_name`, `day_of_week`, `title`, `description`) VALUES
(1, 'Lundi', 1, '🎉 Offre Famille', 'Réservez une table pour votre famille : <span class=\"highlight\">2 personnes ne paient pas !</span>'),
(2, 'Mardi', 2, '🥗 Menu Gratuit Enfant', 'Pour chaque plat adulte, un menu enfant est <span class=\"highlight\">offert</span>.'),
(3, 'Mercredi', 3, '🍕 2 pour 1 Pizza', 'Achetez une pizza, la 2e est <span class=\"highlight\">gratuite</span>.'),
(4, 'Jeudi', 4, '🍝 Pasta Gourmande', 'Pour tout plat de pâtes commandé, une petite salade est <span class=\"highlight\">offerte!</span>.'),
(5, 'Vendredi', 5, '🍰 -10% sur pâtisseries', '<span class=\"highlight\">10% de réduction</span> sur toutes les pâtisseries.'),
(6, 'Samedi', 6, '🍽 Menu Spécial Week-end', 'Menu complet à prix réduit pour toute la famille.'),
(7, 'Dimanche', 0, '🍽 Livraison Gratuite', 'Livraison offerte sur toutes les commandes à partir de 100 DH.');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `guests` int(11) NOT NULL,
  `reservation_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `name`, `phone`, `email`, `guests`, `reservation_date`, `created_at`) VALUES
(1, 'souhaib', '1111111', 'souhaib@c.com', 3, '2025-04-10', '2025-04-20 01:21:42');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `testimonial` text NOT NULL,
  `image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `testimonial`, `image_url`) VALUES
(1, 'Moana', 'Chez Elbaraka, on ne se contente pas de manger, on passe un vrai bon moment. Le cadre est agréable, le personnel est au petit soin, et les plats sont un régal. Que demander de plus ?', 'images/F1.jpeg'),
(2, 'Hafid', 'J’ai eu une petite demande spéciale lors de ma commande, et elle a été parfaitement respectée. C’est agréable de se sentir écouté et respecté en tant que client.', 'images/1H.jpeg'),
(3, 'Nabil', 'Même lors des heures de pointe, la livraison reste rapide et les plats arrivent impeccables. C’est rare de trouver un service aussi constant.', 'images/2H.jpeg'),
(4, 'Karim', 'L’équipe prend le temps d’écouter et de répondre aux besoins des clients. Que ce soit sur place ou pour une commande, on se sent toujours bien pris en charge.', 'images/3H.jpeg'),
(5, 'Sabah', 'Chaque commande est un plaisir : les portions sont généreuses, les ingrédients sont frais, et la présentation donne vraiment envie. On sent que tout est fait avec soin.', 'images/client1.jpg'),
(6, 'Lina', 'J’ai commandé en ligne et j’ai été agréablement surpris : mon plat est arrivé en moins de 30 minutes, bien chaud et parfaitement emballé. Bravo pour cette organisation !', 'images/2F.jpeg'),
(7, 'Safae', 'Le personnel d’Elbaraka est toujours souriant et professionnel. On sent qu’ils aiment leur travail, et ça se reflète dans l’accueil chaleureux et l’efficacité du service.', 'images/3F.jpeg'),
(8, 'Soufiane', 'En tant que client de Elbaraka, je trouve que le service est excellent. Le personnel est amical et attentif, ce qui rend l\'expérience encore plus agréable. Concernant la livraison, elle s\'est déroulée sans accroc : le plat est arrivé chaud et bien emballé, ce qui est toujours un plus. Le temps de livraison était raisonnable, environ 30 minutes, ce qui est parfait pour un repas rapide.', 'images/4H.jpeg'),
(9, 'Ali', 'Je dois dire que le service est remarquable. Le personnel est accueillant et fait tout pour que les clients se sentent à l\'aise. La livraison a été rapide et efficace, avec un délai d\'environ 30 minutes. Les plats sont arrivés en parfait état, bien chauds et soigneusement emballés, ce qui témoigne d\'une attention aux détails.', 'images/client2.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `footer`
--
ALTER TABLE `footer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category` (`category_id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about`
--
ALTER TABLE `about`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `footer`
--
ALTER TABLE `footer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
