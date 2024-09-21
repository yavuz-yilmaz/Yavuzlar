-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: db
-- Üretim Zamanı: 21 Eyl 2024, 10:39:58
-- Sunucu sürümü: 8.0.39
-- PHP Sürümü: 8.2.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `yavuzlaryemek`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `basket`
--

CREATE TABLE `basket` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `food_id` int NOT NULL,
  `note` text COLLATE utf8mb4_general_ci,
  `quantity` int NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `basket`
--

INSERT INTO `basket` (`id`, `user_id`, `food_id`, `note`, `quantity`, `created_at`) VALUES
(8, 6, 1, NULL, 4, '2024-09-16 22:08:58');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `restaurant_id` int NOT NULL,
  `surname` text COLLATE utf8mb4_general_ci NOT NULL,
  `title` text COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `score` int NOT NULL,
  `created_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `company`
--

CREATE TABLE `company` (
  `id` int NOT NULL,
  `name` text COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `logo_path` text COLLATE utf8mb4_general_ci NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `company`
--

INSERT INTO `company` (`id`, `name`, `description`, `logo_path`, `deleted_at`) VALUES
(1, 'Yavuzlar Inc.', 'Yavuzlar Inc bir yemek şirketidir.', 'yavuzlarinc.jpg', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cupon`
--

CREATE TABLE `cupon` (
  `id` int NOT NULL,
  `restaurant_id` int DEFAULT NULL,
  `name` text COLLATE utf8mb4_general_ci NOT NULL,
  `discount` float NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `cupon`
--

INSERT INTO `cupon` (`id`, `restaurant_id`, `name`, `discount`, `created_at`) VALUES
(1, 1, 'Kampanya', 20, '2024-09-16 14:49:56');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `food`
--

CREATE TABLE `food` (
  `id` int NOT NULL,
  `restaurant_id` int NOT NULL,
  `name` text COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `image_path` text COLLATE utf8mb4_general_ci NOT NULL,
  `price` float NOT NULL,
  `discount` float NOT NULL,
  `created_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `food`
--

INSERT INTO `food` (`id`, `restaurant_id`, `name`, `description`, `image_path`, `price`, `discount`, `created_at`, `deleted_at`) VALUES
(1, 1, 'Köfte', 'Bildiğimiz köfte', 'kofte.jpg', 100, 20, '2024-09-16 13:43:23', NULL),
(5, 3, 'Döner', 'Bildiğimiz döner', 'doner.png', 50, 10, '2024-09-16 19:51:24', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `order`
--

CREATE TABLE `order` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `order_status` text COLLATE utf8mb4_general_ci NOT NULL,
  `total_price` float NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `order`
--

INSERT INTO `order` (`id`, `user_id`, `order_status`, `total_price`, `created_at`) VALUES
(12, 1, 'Hazırlanıyor', 80, '2024-09-17 12:57:37'),
(13, 1, 'Teslim Edildi', 80, '2024-09-17 12:57:54'),
(14, 1, 'Hazırlanıyor', 60, '2024-09-17 13:05:10'),
(15, 1, 'Hazırlanıyor', 140, '2024-09-17 13:06:52'),
(16, 9, 'Hazırlanıyor', 180, '2024-09-17 15:15:13'),
(17, 10, 'Hazırlanıyor', 80, '2024-09-18 19:52:11'),
(18, 1, 'Hazırlanıyor', 60, '2024-09-19 10:47:07');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `order_items`
--

CREATE TABLE `order_items` (
  `id` int NOT NULL,
  `food_id` int NOT NULL,
  `order_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `order_items`
--

INSERT INTO `order_items` (`id`, `food_id`, `order_id`, `quantity`, `price`) VALUES
(8, 1, 12, 1, 80),
(9, 1, 13, 1, 80),
(10, 1, 14, 1, 80),
(11, 1, 15, 2, 160),
(12, 1, 16, 2, 160),
(13, 5, 16, 1, 40),
(14, 1, 17, 1, 80),
(15, 1, 18, 1, 80);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `restaurant`
--

CREATE TABLE `restaurant` (
  `id` int NOT NULL,
  `company_id` int NOT NULL,
  `name` text COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `image_path` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `restaurant`
--

INSERT INTO `restaurant` (`id`, `company_id`, `name`, `description`, `image_path`, `created_at`) VALUES
(1, 1, 'Köfteci Yusuf', 'Köfte yapar', 'kofteciyusuf.jpg', '2024-09-16 13:40:10'),
(3, 1, 'Öncü Döner', 'Döner yapar', 'oncu.png', '2024-09-16 19:51:14');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `company_id` int DEFAULT NULL,
  `role` text COLLATE utf8mb4_general_ci NOT NULL,
  `name` text COLLATE utf8mb4_general_ci NOT NULL,
  `surname` text COLLATE utf8mb4_general_ci NOT NULL,
  `username` text COLLATE utf8mb4_general_ci NOT NULL,
  `password` text COLLATE utf8mb4_general_ci NOT NULL,
  `balance` float NOT NULL DEFAULT '5000',
  `created_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `company_id`, `role`, `name`, `surname`, `username`, `password`, `balance`, `created_at`, `deleted_at`) VALUES
(1, 1, 'admin', 'name', 'surname', 'admin', '$argon2id$v=19$m=65536,t=4,p=1$aGs3Y2ViUzRQN1dVYzdrWQ$bKrfJmGTGPZ6fxN5i8SqWJepTUxG9o2r46mzUPw1Wa8', 3970, '2024-09-16 00:00:00', NULL),
(4, 1, 'customer', 'Nurettin', 'Oğuz', 'noguz', '$argon2id$v=19$m=65536,t=4,p=1$aGs3Y2ViUzRQN1dVYzdrWQ$bKrfJmGTGPZ6fxN5i8SqWJepTUxG9o2r46mzUPw1Wa8', 5000, '2024-09-16 00:00:00', NULL),
(9, NULL, 'customer', 'Bekir', 'Oğuz', 'boguz', '$argon2id$v=19$m=65536,t=4,p=1$TGZxOUhscDNqZVNKSDJjOA$5YwkPCPUtqXBLwAkQSRLUHsfk/FoVQp9llRZgjIAuTo', 4811, '2024-09-17 15:14:52', NULL),
(10, 1, 'company', 'company', 'company', 'company', '$argon2id$v=19$m=65536,t=4,p=1$aGs3Y2ViUzRQN1dVYzdrWQ$bKrfJmGTGPZ6fxN5i8SqWJepTUxG9o2r46mzUPw1Wa8', 4920, '2024-09-17 15:25:01', NULL);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `basket`
--
ALTER TABLE `basket`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `cupon`
--
ALTER TABLE `cupon`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `restaurant`
--
ALTER TABLE `restaurant`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `basket`
--
ALTER TABLE `basket`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Tablo için AUTO_INCREMENT değeri `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `company`
--
ALTER TABLE `company`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `cupon`
--
ALTER TABLE `cupon`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `food`
--
ALTER TABLE `food`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `order`
--
ALTER TABLE `order`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Tablo için AUTO_INCREMENT değeri `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Tablo için AUTO_INCREMENT değeri `restaurant`
--
ALTER TABLE `restaurant`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
