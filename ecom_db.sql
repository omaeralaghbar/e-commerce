-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: 06 يوليو 2023 الساعة 15:08
-- إصدار الخادم: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecom_db`
--

-- --------------------------------------------------------

--
-- بنية الجدول `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(11) NOT NULL,
  `cat_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- إرجاع أو استيراد بيانات الجدول `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_title`) VALUES
(6, 'Science'),
(7, 'Art'),
(8, 'Novels'),
(9, 'History ');

-- --------------------------------------------------------

--
-- بنية الجدول `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` text NOT NULL DEFAULT 'draft'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- إرجاع أو استيراد بيانات الجدول `comments`
--

INSERT INTO `comments` (`id`, `product_id`, `author`, `email`, `title`, `comment`, `date`, `status`) VALUES
(1, 13, 'Omar', 'omaeralagbar@gmail.com', 'nice', 'nice photo', '2022-11-01', 'published'),
(2, 14, 'Ahmed', 'ahmed@gmail.com', 'ugly', 'so bad', '2022-11-01', 'published'),
(4, 11, 'abas', 'alshamelah.school8@gmail.com', 'thank u', 'thank you , I love this product', '2022-11-04', 'published'),
(5, 16, 'Raed', 'omaer.alaghbar@hotmail.com', 'Science book', 'I love this book and I will buy this one in the future', '2022-11-04', 'published'),
(6, 12, 'Samer', 'alshamelah.school12@gmail.com', 'Teat again', 'test again', '2022-11-05', 'draft'),
(7, 13, 'Hassan', 'hassan@gmail.com', 'Photo', 'for test only', '2022-11-07', 'published'),
(8, 14, 'Adnan', 'adnan@gmail.com', 'Super', 'very good I\'ll buy more items', '2022-11-09', 'published'),
(9, 14, 'Raed', 'alshamelah.school7@gmail.com', 'test', 'test only *******************************', '2023-04-23', 'published');

-- --------------------------------------------------------

--
-- بنية الجدول `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_amount` float NOT NULL,
  `order_transaction` varchar(255) NOT NULL,
  `order_status` varchar(255) NOT NULL,
  `order_currency` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- إرجاع أو استيراد بيانات الجدول `orders`
--

INSERT INTO `orders` (`order_id`, `order_amount`, `order_transaction`, `order_status`, `order_currency`) VALUES
(8, 345, '3536985', 'Completed', 'USA'),
(9, 345, '3536985', 'Completed', 'USA'),
(10, 345, '3536985', 'Completed', 'USA'),
(11, 345, '020000000', 'Completed', 'KSA'),
(12, 345, '3536985', 'Completed', 'USA'),
(13, 345, '3536985', 'Completed', 'USA'),
(14, 345, '353000000', 'Completed', 'USA'),
(15, 345, '35302222222', 'Completed', 'USA'),
(16, 345, '3536985', 'Completed', 'KSA'),
(17, 345, '3536985', 'Completed', 'KSA'),
(18, 345, '3536985', 'Completed', 'KSA'),
(19, 345, '3536985', 'Completed', 'KSA'),
(20, 345, '3536985', 'Completed', 'KSA'),
(21, 345, '3536985', 'Completed', 'KSA'),
(22, 345, '3536985', 'Completed', 'KSA'),
(23, 345, '3536985', 'Completed', 'KSA'),
(24, 345, '3536985', 'Completed', 'KSA'),
(25, 345, '3536985', 'Completed', 'KSA');

-- --------------------------------------------------------

--
-- بنية الجدول `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_title` varchar(255) NOT NULL,
  `product_category_id` int(11) NOT NULL,
  `product_price` float NOT NULL,
  `product_quantity` int(11) NOT NULL DEFAULT 0,
  `product_description` text NOT NULL,
  `short_desc` text NOT NULL,
  `product_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- إرجاع أو استيراد بيانات الجدول `products`
--

INSERT INTO `products` (`product_id`, `product_title`, `product_category_id`, `product_price`, `product_quantity`, `product_description`, `short_desc`, `product_image`) VALUES
(13, 'Science Book', 6, 89, 24, 'Science book written by Omar for students', 'Books about science and more', 'science3.jpg'),
(14, 'Science Book', 6, 32, 50, 'Science book written by Omar for students', 'Deep studying about the organs of human body', 'science4.jpg'),
(15, 'Science Book', 6, 36, 53, 'Science book written by Omar for students', 'The science of science', 'science5.jpg'),
(16, 'Science Book', 6, 62, 67, 'Science book written by Omar for students', 'The science of science', 'science6.jpg'),
(17, 'Science Book', 6, 256, 133, 'Science book written by Omar for students', 'The science of insects', 'science7.jpg'),
(18, 'Science Book', 6, 142, 158, 'Science book written by Omar for students', 'Planets in the university', 'science7.jpg'),
(19, 'Science Book', 6, 12, 113, 'Science book written by Omar for students', 'DNA and genetic information', 'science8.jpg'),
(20, 'Science Book', 6, 115, 77, 'Science book written by Omar for students', 'The functions of organs', 'science9.jpg'),
(21, 'Science Book', 6, 65, 68, 'Science book written by Omar for students', 'Science for everyone', 'science10.jpg'),
(22, 'Science Book', 6, 73, 110, 'Science book written by Omar for students', 'Science for everyone', 'science11.jpg'),
(23, 'Novels Books', 8, 125, 49, 'classic novels include: Jane Eyre by Charlotte Bronte. Wuthering Heights by Emily Brontë Moby Dick by Herman Melville', 'classic novels include: Jane Eyre by Charlotte Bronte. Wuthering Heights by Emily Brontë Moby Dick by Herman Melville', 'novel1.jpg'),
(24, 'Novels Books', 8, 25, 91, 'classic novels include: Jane Eyre by Charlotte Bronte. Wuthering Heights by Emily Brontë Moby Dick by Herman Melville', 'classic novels include: Jane Eyre by Charlotte Bronte. Wuthering Heights by Emily Brontë Moby Dick by Herman Melville', 'novel2.jpg'),
(25, 'Novels Books', 8, 36, 48, 'classic novels include: Jane Eyre by Charlotte Bronte. Wuthering Heights by Emily Brontë Moby Dick by Herman Melville', 'classic novels include: Jane Eyre by Charlotte Bronte. Wuthering Heights by Emily Brontë Moby Dick by Herman Melville', 'novel3.jpg'),
(26, 'Novels Books', 8, 90, 59, 'classic novels include: Jane Eyre by Charlotte Bronte. Wuthering Heights by Emily Brontë Moby Dick by Herman Melville', 'classic novels include: Jane Eyre by Charlotte Bronte. Wuthering Heights by Emily Brontë Moby Dick by Herman Melville', 'novel4.jpg'),
(27, 'Science Book', 6, 12, 49, 'tset', 'test', 'science4.jpg'),
(28, 'Science Book', 6, 898, 58, 'test', 'test', 'science10.jpg'),
(29, 'Science Book', 6, 12, 46, 'test', 'science for kids', 'science11.jpg'),
(30, 'Science Book', 6, 123, 129, 'test', 'test', 'science10.jpg'),
(31, 'Science Book', 6, 564, 46, 'test', 'test', 'science9.jpg'),
(32, 'Science Book', 6, 6, 45, 'test', 'test', 'science1.jpg');

-- --------------------------------------------------------

--
-- بنية الجدول `reports`
--

CREATE TABLE `reports` (
  `report_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_price` float NOT NULL,
  `product_title` varchar(255) NOT NULL,
  `product_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- إرجاع أو استيراد بيانات الجدول `reports`
--

INSERT INTO `reports` (`report_id`, `product_id`, `order_id`, `product_price`, `product_title`, `product_quantity`) VALUES
(5, 13, 12, 89, 'Science Book', 1),
(6, 15, 13, 36, 'Science Book', 2),
(7, 13, 14, 89, 'Science Book', 1),
(8, 19, 15, 12, 'Science Book', 1),
(9, 13, 16, 89, 'Science Book', 5),
(10, 13, 17, 89, 'Science Book', 3),
(11, 13, 18, 89, 'Science Book', 3),
(12, 13, 19, 89, 'Science Book', 4),
(13, 13, 20, 89, 'Science Book', 2),
(14, 13, 21, 89, 'Science Book', 2),
(15, 13, 22, 89, 'Science Book', 6),
(16, 13, 23, 89, 'Science Book', 10),
(17, 14, 24, 32, 'Science Book', 67),
(18, 14, 25, 32, 'Science Book', 4);

-- --------------------------------------------------------

--
-- بنية الجدول `slides`
--

CREATE TABLE `slides` (
  `slide_id` int(11) NOT NULL,
  `slide_title` varchar(255) NOT NULL,
  `slide_image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- إرجاع أو استيراد بيانات الجدول `slides`
--

INSERT INTO `slides` (`slide_id`, `slide_title`, `slide_image`) VALUES
(14, 'Art4', 'art4.jpg'),
(15, 'img9', 'img9.jpg'),
(16, 'art5', 'art5.webp'),
(17, 'art3', 'art3.jpg'),
(18, 'img1', 'img1.jpg'),
(19, 'novel2', 'novel2.jpg'),
(20, 'art7', 'art7.jpg');

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`) VALUES
(1, 'Omaer1988', 'omaeralagbar@gmail.com', 'omaer1988abcd'),
(2, 'Ahmed', 'ahmed@gmail.com', 'omaer1988abcd');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `photo_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `slides`
--
ALTER TABLE `slides`
  ADD PRIMARY KEY (`slide_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `slides`
--
ALTER TABLE `slides`
  MODIFY `slide_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
