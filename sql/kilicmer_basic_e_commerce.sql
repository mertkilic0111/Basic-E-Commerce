-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3306
-- Üretim Zamanı: 21 Tem 2024, 13:34:50
-- Sunucu sürümü: 10.2.44-MariaDB-cll-lve
-- PHP Sürümü: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `kilicmer_basic_e_commerce`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `about_us`
--

CREATE TABLE `about_us` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `about_us`
--

INSERT INTO `about_us` (`id`, `description`) VALUES
(1, '&lt;h3&gt;Biz Kimiz?&lt;/h3&gt;&lt;p&gt;Şirketimiz, kaliteli ürünler sunmak amacıyla kurulmuş olup, müşteri memnuniyetini her zaman ön planda tutmaktadır. Misyonumuz, en iyi alışveriş deneyimini sağlamaktır. Ekibimiz, her biri kendi alanında uzman kişilerden oluşmaktadır.&lt;/p&gt;&lt;h3&gt;Vizyonumuz&lt;/h3&gt;&lt;p&gt;Vizyonumuz, sektörde öncü ve güvenilir bir marka olmaktır. Yenilikçi çözümlerle müşterilerimize değer katmayı hedefliyoruz.&lt;/p&gt;&lt;h3&gt;Değerlerimiz&lt;/h3&gt;&lt;ul&gt;&lt;li&gt;Müşteri odaklılık&lt;/li&gt;&lt;li&gt;Kalite&lt;/li&gt;&lt;li&gt;Yenilikçilik&lt;/li&gt;&lt;li&gt;Güvenilirlik&lt;/li&gt;&lt;li&gt;Takım çalışması&lt;/li&gt;&lt;/ul&gt;&lt;h3&gt;İletişim&lt;/h3&gt;&lt;p&gt;Bizimle iletişime geçmek için &lt;a href=&quot;iletisim.html&quot; target=&quot;_blank&quot;&gt;iletişim sayfamızı&lt;/a&gt; ziyaret edebilirsiniz.&lt;/p&gt;');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `adsoyad` varchar(128) NOT NULL,
  `e_posta` varchar(128) NOT NULL,
  `sifre` varchar(128) NOT NULL,
  `user_path` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `admins`
--

INSERT INTO `admins` (`id`, `adsoyad`, `e_posta`, `sifre`, `user_path`) VALUES
(1, 'admin', 'admin', 'cytORUpVN08yYjlHeG5wTTJpcjF6Zz09', 'inc');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_token` varchar(512) NOT NULL,
  `visible_order_token` varchar(255) NOT NULL,
  `name_surname` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total_payment` decimal(10,2) NOT NULL,
  `ctime` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `orders`
--

INSERT INTO `orders` (`id`, `order_token`, `visible_order_token`, `name_surname`, `product_id`, `quantity`, `price`, `total_payment`, `ctime`) VALUES
(7, '53nu-hepd-qz9g-7ic5-UDRpYU9BNTNFNDRUcTltV2RscGlMVUhYTUJycUVRK1pQVFE4RFdBYkNCdz0=', '53nu-hepd-qz9g-7ic5', 'MERT KILIÇ', 5, 6, '187.49', '1124.94', '1721556662'),
(6, '53nu-hepd-qz9g-7ic5-UDRpYU9BNTNFNDRUcTltV2RscGlMVUhYTUJycUVRK1pQVFE4RFdBYkNCdz0=', '53nu-hepd-qz9g-7ic5', 'MERT KILIÇ', 4, 5, '154.99', '774.95', '1721556662');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `p_order` int(11) NOT NULL,
  `cover_image` varchar(255) NOT NULL,
  `slug_url` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `p_order`, `cover_image`, `slug_url`, `description`, `status`) VALUES
(4, 'Ürün Adı 1', '154.99', 1, 'upload/products/52ab373d542993ca74b0aaa710ce3fd2.webp', 'urun-adi-1', '&lt;p&gt;&lt;strong&gt;Lorem Ipsum&lt;/strong&gt; is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.&lt;/p&gt;', 1),
(5, 'Ürün Adı 2', '187.49', 1, 'upload/products/b7c0d68968ac3ff92a59a6d2374606e8.webp', 'urun-adi-2', '&lt;p&gt;Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &quot;de Finibus Bonorum et Malorum&quot; (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, &quot;Lorem ipsum dolor sit amet..&quot;, comes from a line in section 1.10.32.&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from &quot;de Finibus Bonorum et Malorum&quot; by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.&lt;/p&gt;', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`) VALUES
(8, 4, 'upload/gallery/5023ed7ae66f171683c672c237ba7a84.webp'),
(7, 4, 'upload/gallery/3fa2b8c043928e3481372cf3a55d37ce.webp'),
(6, 4, 'upload/gallery/0808e14f49adabd2b8b9dd58a28091cf.webp'),
(5, 4, 'upload/gallery/1c5e108aff0c894060ffbbf1d69ae30b.webp'),
(9, 5, 'upload/gallery/3715a25ecb1bf74d25cd91e7f834bd18.webp'),
(10, 5, 'upload/gallery/f8fd03c99bf0cd300f49b5b2aab63354.webp'),
(11, 5, 'upload/gallery/eb66288e40834aa49fa4cb8d46727d04.webp');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `web_site` varchar(255) NOT NULL,
  `site_title` varchar(255) NOT NULL,
  `site_desc` text NOT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `e_mail` varchar(255) DEFAULT NULL,
  `maps_link` varchar(1024) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `settings`
--

INSERT INTO `settings` (`id`, `web_site`, `site_title`, `site_desc`, `favicon`, `logo`, `address`, `phone_number`, `e_mail`, `maps_link`) VALUES
(1, 'https://example.com/', 'Basic E-commerce', 'Basic E-commerce 4 free', 'upload/imgs/086f1624e10169d60f9cd3325717a3f4.png', 'upload/imgs/8b586384258a029ad7d00284df09a229.png', 'İstanbul, Türkiye', '+90 555 555 5555', 'info@site.com', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d192697.8885055538!2d28.84737317241579!3d41.00546324292252!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14caa7040068086b%3A0xe1ccfe98bc01b0d0!2zxLBzdGFuYnVs!5e0!3m2!1str!2str!4v1721470864232!5m2!1str!2str');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `about_us`
--
ALTER TABLE `about_us`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug_url` (`slug_url`);

--
-- Tablo için indeksler `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `about_us`
--
ALTER TABLE `about_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
