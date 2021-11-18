-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Nov 18, 2021 at 12:55 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `food_booking_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `for_restaurant` tinyint(1) NOT NULL DEFAULT 0,
  `street` varchar(300) NOT NULL,
  `town` varchar(300) NOT NULL,
  `county` varchar(300) DEFAULT NULL,
  `post_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `entity_id`, `for_restaurant`, `street`, `town`, `county`, `post_code`) VALUES
(1, 1, 1, '44 Long Street', 'Mile End', NULL, 'CO4 6YT'),
(2, 2, 1, '45 Neville Street', 'Ilmer', NULL, 'HP27 8UJ'),
(3, 3, 1, '78 Front St', 'Henley', NULL, 'TA10 5YF'),
(4, 5, 0, '78 Golf Road', 'Swimbridge', NULL, 'EX32 0YD'),
(5, 6, 0, '38 Felix Lane', 'Shurrery', NULL, 'KW14 0LJ'),
(6, 8, 0, '123 Street', 'Colchburgh', '', 'CO2 4LM'),
(7, 20, 0, '23 Holgate Rd', 'Ratcliffe on Sea', '', 'CO3 4ML'),
(9, 4, 1, '34 Restaurant Street', 'Rest upon Tyne', 'Essex', 'TA10 5YF'),
(11, 23, 1, '173 Rotary Close', 'Colchester', 'Essex', 'CO4 3JH');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_order`
--

CREATE TABLE `delivery_order` (
  `id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` varchar(300) NOT NULL,
  `total` float NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `delivery_order`
--

INSERT INTO `delivery_order` (`id`, `restaurant_id`, `user_id`, `address`, `total`, `date`) VALUES
(4, 23, 20, '23 Holgate Rd, Ratcliffe on Sea, CO3 4ML', 62.94, '2021-11-18');

-- --------------------------------------------------------

--
-- Table structure for table `menu_item`
--

CREATE TABLE `menu_item` (
  `id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `name` varchar(300) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu_item`
--

INSERT INTO `menu_item` (`id`, `restaurant_id`, `name`, `price`) VALUES
(9, 23, 'Chicken Burger Meal', 10.99),
(10, 23, 'Beef Burger', 9.99),
(11, 23, 'Beef Burger Meal', 13.99),
(12, 23, 'Pepsi Can', 2.99),
(13, 23, 'Fanta Can', 2.99);

-- --------------------------------------------------------

--
-- Table structure for table `restaurant`
--

CREATE TABLE `restaurant` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(300) NOT NULL,
  `email` varchar(300) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `open` tinyint(1) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `dine_in` tinyint(1) DEFAULT NULL,
  `delivery` int(11) DEFAULT NULL,
  `rating` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `restaurant`
--

INSERT INTO `restaurant` (`id`, `user_id`, `name`, `email`, `phone`, `open`, `description`, `dine_in`, `delivery`, `rating`) VALUES
(1, 2, 'Restaurant One', 'restaurant_one@email.com', '01223 456 456', 0, NULL, 0, 0, NULL),
(2, 9, 'Second Restaurant', 'second_rest@email.com', '03214 789 954', 0, NULL, 0, 0, NULL),
(3, 7, 'Third Restaurant', 'rest_thrd@anoteremail.com', '03214 951 456', 0, NULL, 0, 0, NULL),
(4, 123, 'Restaurant Andrei', 'restaurant@gmail.com', '01234 951 147', 0, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 0, 0, 4.5),
(23, 22, 'Queueing House', 'queue@test-email.com', '32154 975 654', 0, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_table`
--

CREATE TABLE `restaurant_table` (
  `id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `name` varchar(300) NOT NULL,
  `max_seats` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `restaurant_table`
--

INSERT INTO `restaurant_table` (`id`, `restaurant_id`, `name`, `max_seats`) VALUES
(3, 23, 'Table Inside', 4),
(4, 23, 'Table Inside', 4),
(9, 23, 'Table Inside', 4),
(10, 23, 'Table Inside', 4);

-- --------------------------------------------------------

--
-- Table structure for table `table_booking`
--

CREATE TABLE `table_booking` (
  `id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `table_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `seats` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_booking`
--

INSERT INTO `table_booking` (`id`, `restaurant_id`, `table_id`, `user_id`, `date`, `seats`) VALUES
(3, 23, 4, 22, '2021-11-28', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(300) NOT NULL,
  `email` varchar(300) NOT NULL,
  `username` varchar(300) NOT NULL,
  `password` varchar(300) NOT NULL,
  `salt` varchar(300) NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `username`, `password`, `salt`, `type`) VALUES
(1, 'Client User', 'client@dummy_email.com', 'client', 'fab472b91a173627645530b85b4584d7', 'salt', 1),
(2, 'Restaurant User', 'restaurant@dummy_email.com', 'restaurant', 'fab472b91a173627645530b85b4584d7', 'salt', 2),
(3, 'Admin user', 'admin@dummy_email.com', 'admin', 'parola', 'salt', 3),
(4, 'Another Client', 'aclient@dummy_email.com', 'aclient', 'parola', 'salt', 1),
(5, 'Client One', 'clientone@email.com', 'clientone', 'parola', 'salt', 1),
(6, 'Client Two', 'clienttwo@email.com', 'clienttwo', 'parola', 'salt', 1),
(7, 'User Postman', 'postmanuser@dummy_email.com', 'postmanuser', 'fc76a2fc0d279d666458fb52edeccc74', 'postmanuser_salt', 2),
(8, 'Client Three', 'clientthree@gmail.com', 'clientthree', '1acbf4f33a748038c8a459a23b0e8d6b', 'clientthree_salt', 1),
(9, 'Restaurant Two', 'restauranttwo@useremail.com', 'restauranttwo', '8a181ccb03218dc981b0d82233daf0a5', 'restauranttwo_salt', 2),
(10, 'Andrei Kovaci', 'andrei.kovaci@gmail.com', 'akovac', 'b321ee8d5eab14dfb9e102e05b648753', 'akovac_salt', 1),
(11, 'Mirel Dorel', 'mirel@gmail.com', 'mireldorel', '2a09d130905cb2396668055c10937247', 'mireldorel_salt', 1),
(14, 'Mirel Dorel', 'mirel@gmail.com', 'mireldorel2', 'e0b81a49f0778fd9e385db39b3828f09', 'mireldorel2_salt', 1),
(15, 'Andrei Kovaci', 'andrei.kovaci@gmail.com', 'andreikovaci', '6b3a84e1defbad52c24afb6bfdcf97ef', 'andreikovaci_salt', 2),
(16, 'Andrei Kovaci', 'andrei.kovaci@gmail.com', 'akovac10', '23ec0b6e3ac903c2eb7092d4f63c8336', 'akovac10_salt', 1),
(17, 'Ionel Marcu', 'marcudorel@gmail.com', 'ionelmarcu', '8cbc3fa313291f9881d239185e9e6363', 'ionelmarcu_salt', 1),
(18, 'Account Restaurant', 'rest_acc@gmail.com', 'restaccount2', '8cde78f14b6fad9f5b3919cc14c9603b', 'restaccount2_salt', 2),
(19, 'Test Account', 'testAccount@gmail.com', 'testtest', '84d015fd428171d2cdcc1caf47fa687a', 'testtest_salt', 1),
(20, 'Another Test', 'test@testemail.com', 'testuser', '37594c4f0133f1a722a08767c52bc1bd', 'testuser_salt', 1),
(21, 'New Restaurant', 'newrest@email.com', 'newrest', '61c5f30376661bcd55fcfce02f91aaba', 'newrest_salt', 2),
(22, 'Andrei Restaurant', 'restaurant.andrei@gmail.com', 'andreirest', 'cef651293845a5a89fca3b803d891098', 'andreirest_salt', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`id`, `type`) VALUES
(1, 'Client'),
(2, 'Restaurant'),
(3, 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_order`
--
ALTER TABLE `delivery_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_item`
--
ALTER TABLE `menu_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant`
--
ALTER TABLE `restaurant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant_table`
--
ALTER TABLE `restaurant_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_booking`
--
ALTER TABLE `table_booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `delivery_order`
--
ALTER TABLE `delivery_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `menu_item`
--
ALTER TABLE `menu_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `restaurant`
--
ALTER TABLE `restaurant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `restaurant_table`
--
ALTER TABLE `restaurant_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `table_booking`
--
ALTER TABLE `table_booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
