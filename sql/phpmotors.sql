-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 13, 2023 at 02:26 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpmotors`
--

-- --------------------------------------------------------

--
-- Table structure for table `carclassification`
--

CREATE TABLE `carclassification` (
  `classificationId` int(11) NOT NULL,
  `classificationName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `carclassification`
--

INSERT INTO `carclassification` (`classificationId`, `classificationName`) VALUES
(1, 'SUV'),
(2, 'Classic'),
(3, 'Sports'),
(4, 'Trucks'),
(5, 'Used'),
(16, 'Boats');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `clientId` int(10) UNSIGNED NOT NULL,
  `clientFirstname` varchar(15) NOT NULL,
  `clientLastname` varchar(25) NOT NULL,
  `clientEmail` varchar(40) NOT NULL,
  `clientPassword` varchar(255) NOT NULL,
  `clientLevel` enum('1','2','3') NOT NULL DEFAULT '1',
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`clientId`, `clientFirstname`, `clientLastname`, `clientEmail`, `clientPassword`, `clientLevel`, `comment`) VALUES
(2, 'Admin', 'User', 'admin@cse340.net', '$2y$10$FWO8sW6Xd402TgDr0YygxOPftKirnByQLyCva3hHEXe5bJgBpCMOy', '3', NULL),
(3, 'Jack', 'Bequick', 'notanadmin@cse340.net', '$2y$10$Aaih.rdmFqpOTqDbkPWh5OUWjETkbUgx2eUytCzmz9npRTvLJxeZG', '1', NULL),
(8, 'Moses', 'Johnston', '123@gmail.com', '$2y$10$LSLUpaf9t.dpR5ed9LxQe.XHX9jxgeUtci0PbC7qPmod925VaRe..', '1', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `imgId` int(10) UNSIGNED NOT NULL,
  `invId` int(10) UNSIGNED NOT NULL,
  `imgName` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `imgPath` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `imgDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `imgPrimary` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`imgId`, `invId`, `imgName`, `imgPath`, `imgDate`, `imgPrimary`) VALUES
(9, 1, 'wrangler.jpg', '/phpmotors/images/vehicles/wrangler.jpg', '2023-07-02 03:58:03', 1),
(10, 1, 'wrangler-tn.jpg', '/phpmotors/images/vehicles/wrangler-tn.jpg', '2023-07-02 03:58:03', 1),
(11, 2, 'ford-modelt.jpg', '/phpmotors/images/vehicles/ford-modelt.jpg', '2023-07-02 03:58:17', 1),
(12, 2, 'ford-modelt-tn.jpg', '/phpmotors/images/vehicles/ford-modelt-tn.jpg', '2023-07-02 03:58:17', 1),
(13, 3, 'lambo-Adve.jpg', '/phpmotors/images/vehicles/lambo-Adve.jpg', '2023-07-02 03:58:33', 1),
(14, 3, 'lambo-Adve-tn.jpg', '/phpmotors/images/vehicles/lambo-Adve-tn.jpg', '2023-07-02 03:58:33', 1),
(15, 4, 'monster.jpg', '/phpmotors/images/vehicles/monster.jpg', '2023-07-02 03:59:33', 1),
(16, 4, 'monster-tn.jpg', '/phpmotors/images/vehicles/monster-tn.jpg', '2023-07-02 03:59:33', 1),
(17, 5, 'ms.jpg', '/phpmotors/images/vehicles/ms.jpg', '2023-07-02 03:59:49', 1),
(18, 5, 'ms-tn.jpg', '/phpmotors/images/vehicles/ms-tn.jpg', '2023-07-02 03:59:49', 1),
(19, 6, 'bat.jpg', '/phpmotors/images/vehicles/bat.jpg', '2023-07-02 04:00:00', 1),
(20, 6, 'bat-tn.jpg', '/phpmotors/images/vehicles/bat-tn.jpg', '2023-07-02 04:00:00', 1),
(21, 7, 'mm.jpg', '/phpmotors/images/vehicles/mm.jpg', '2023-07-02 04:00:10', 1),
(22, 7, 'mm-tn.jpg', '/phpmotors/images/vehicles/mm-tn.jpg', '2023-07-02 04:00:10', 1),
(23, 8, 'fire-truck.jpg', '/phpmotors/images/vehicles/fire-truck.jpg', '2023-07-02 04:01:16', 1),
(24, 8, 'fire-truck-tn.jpg', '/phpmotors/images/vehicles/fire-truck-tn.jpg', '2023-07-02 04:01:16', 1),
(25, 9, 'crown-vic.jpg', '/phpmotors/images/vehicles/crown-vic.jpg', '2023-07-02 04:01:27', 1),
(26, 9, 'crown-vic-tn.jpg', '/phpmotors/images/vehicles/crown-vic-tn.jpg', '2023-07-02 04:01:27', 1),
(27, 10, 'camaro.jpg', '/phpmotors/images/vehicles/camaro.jpg', '2023-07-02 04:01:35', 1),
(28, 10, 'camaro-tn.jpg', '/phpmotors/images/vehicles/camaro-tn.jpg', '2023-07-02 04:01:35', 1),
(29, 11, 'escalade.jpg', '/phpmotors/images/vehicles/escalade.jpg', '2023-07-02 04:01:44', 1),
(30, 11, 'escalade-tn.jpg', '/phpmotors/images/vehicles/escalade-tn.jpg', '2023-07-02 04:01:44', 1),
(31, 12, 'hummer.jpg', '/phpmotors/images/vehicles/hummer.jpg', '2023-07-02 04:01:58', 1),
(32, 12, 'hummer-tn.jpg', '/phpmotors/images/vehicles/hummer-tn.jpg', '2023-07-02 04:01:58', 1),
(33, 13, 'aerocar.jpg', '/phpmotors/images/vehicles/aerocar.jpg', '2023-07-02 04:02:06', 1),
(34, 13, 'aerocar-tn.jpg', '/phpmotors/images/vehicles/aerocar-tn.jpg', '2023-07-02 04:02:06', 1),
(35, 14, 'fbi.jpg', '/phpmotors/images/vehicles/fbi.jpg', '2023-07-02 04:02:16', 1),
(36, 14, 'fbi-tn.jpg', '/phpmotors/images/vehicles/fbi-tn.jpg', '2023-07-02 04:02:16', 1),
(39, 18, 'bees bees bees.png', '/phpmotors/images/vehicles/bees bees bees.png', '2023-07-02 04:03:16', 1),
(40, 18, 'bees bees bees-tn.png', '/phpmotors/images/vehicles/bees bees bees-tn.png', '2023-07-02 04:03:16', 1),
(41, 21, 'delorean.jpg', '/phpmotors/images/vehicles/delorean.jpg', '2023-07-02 04:09:34', 1),
(42, 21, 'delorean-tn.jpg', '/phpmotors/images/vehicles/delorean-tn.jpg', '2023-07-02 04:09:34', 1),
(45, 3, 'Aventador.jpg', '/phpmotors/images/vehicles/Aventador.jpg', '2023-07-02 04:36:46', 0),
(46, 3, 'Aventador-tn.jpg', '/phpmotors/images/vehicles/Aventador-tn.jpg', '2023-07-02 04:36:46', 0),
(47, 7, 'mm2.jpg', '/phpmotors/images/vehicles/mm2.jpg', '2023-07-02 04:36:57', 0),
(48, 7, 'mm2-tn.jpg', '/phpmotors/images/vehicles/mm2-tn.jpg', '2023-07-02 04:36:57', 0),
(49, 18, 'Screenshot 2023-06-17 002441.png', '/phpmotors/images/vehicles/Screenshot 2023-06-17 002441.png', '2023-07-02 05:19:40', 0),
(50, 18, 'Screenshot 2023-06-17 002441-tn.png', '/phpmotors/images/vehicles/Screenshot 2023-06-17 002441-tn.png', '2023-07-02 05:19:40', 0),
(51, 3, 'Lambo_Ave_Orange.jpg', '/phpmotors/images/vehicles/Lambo_Ave_Orange.jpg', '2023-07-12 18:37:14', 0),
(52, 3, 'Lambo_Ave_Orange-tn.jpg', '/phpmotors/images/vehicles/Lambo_Ave_Orange-tn.jpg', '2023-07-12 18:37:14', 0),
(55, 15, 'Dog car.jpg', '/phpmotors/images/vehicles/Dog car.jpg', '2023-07-12 18:53:23', 1),
(56, 15, 'Dog car-tn.jpg', '/phpmotors/images/vehicles/Dog car-tn.jpg', '2023-07-12 18:53:23', 1);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `invId` int(10) UNSIGNED NOT NULL,
  `invMake` varchar(30) NOT NULL,
  `invModel` varchar(30) NOT NULL,
  `invDescription` text NOT NULL,
  `invImage` varchar(50) NOT NULL,
  `invThumbnail` varchar(50) NOT NULL,
  `invPrice` decimal(10,2) NOT NULL,
  `invStock` smallint(6) NOT NULL,
  `invColor` varchar(20) NOT NULL,
  `classificationId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`invId`, `invMake`, `invModel`, `invDescription`, `invImage`, `invThumbnail`, `invPrice`, `invStock`, `invColor`, `classificationId`) VALUES
(1, 'Jeep ', 'Wrangler', 'The Jeep Wrangler is small and compact with enough power to get you where you want to go. It is great for everyday driving as well as off-roading whether that be on the rocks or in the mud!', '/images/vehicles/wrangler.jpg', '/images/vehicles/wrangler-tn.jpg', 28045.00, 4, 'Orange', 1),
(2, 'Ford', 'Model T', 'The Ford Model T can be a bit tricky to drive. It was the first car to be put into production. You can get it in any color you want as long as it&#039;s black.', '/images/vehicles/ford-modelt.jpg', '/images/vehicles/ford-modelt-tn.jpg', 30000.00, 2, 'Black', 2),
(3, 'Lamborghini', 'Adventador', 'This V-12 engine packs a punch in this sporty car. Make sure you wear your seatbelt and obey all traffic laws.', '/images/vehicles/lambo-Adve.jpg', '/images/vehicles/lambo-Adve-tn.jpg', 417650.00, 1, 'Blue', 3),
(4, 'Monster', 'Truck', 'Most trucks are for working, this one is for fun. This beast comes with 60 inch tires giving you the traction needed to jump and roll in the mud.', '/images/vehicles/monster.jpg', '/images/vehicles/monster-tn.jpg', 150000.00, 3, 'purple', 4),
(5, 'Mechanic', 'Special', 'Not sure where this car came from. However, with a little tender loving care it will run as good a new.', '/images/vehicles/ms.jpg', '/images/vehicles/ms-tn.jpg', 100.00, 1, 'Rust', 5),
(6, 'Batmobile', 'Custom', 'Ever want to be a superhero? Now you can with the bat mobile. This car allows you to switch to bike mode allowing for easy maneuvering through traffic during rush hour.', '/images/vehicles/bat.jpg', '/images/vehicles/bat-tn.jpg', 65000.00, 1, 'Black', 3),
(7, 'Mystery', 'Machine', 'Scooby and the gang always found luck in solving their mysteries because of their 4 wheel drive Mystery Machine. This Van will help you do whatever job you are required to with a success rate of 100%.', '/images/vehicles/mm.jpg', '/images/vehicles/mm-tn.jpg', 10000.00, 12, 'Green', 1),
(8, 'Spartan', 'Fire Truck', 'Emergencies happen often. Be prepared with this Spartan fire truck. Comes complete with 1000 ft. of hose and a 1000-gallon tank.', '/images/vehicles/fire-truck.jpg', '/images/vehicles/fire-truck-tn.jpg', 50000.00, 1, 'Red', 4),
(9, 'Ford', 'Crown Victoria', 'After the police force updated their fleet these cars are now available to the public! These cars come equipped with the siren which is convenient for college students running late to class.', '/images/vehicles/crown-vic.jpg', '/images/vehicles/crown-vic-tn.jpg', 10000.00, 5, 'White', 5),
(10, 'Chevy', 'Camaro', 'If you want to look cool this is the car you need! This car has great performance at an affordable price. Own it today!', '/images/vehicles/camaro.jpg', '/images/vehicles/camaro-tn.jpg', 25000.00, 10, 'Silver', 3),
(11, 'Cadillac', 'Escalade', 'This styling car is great for any occasion from going to the beach to meeting the president. The luxurious inside makes this car a home away from home.', '/images/vehicles/escalade.jpg', '/images/vehicles/escalade-tn.jpg', 75195.00, 4, 'Black', 1),
(12, 'GM', 'Hummer', 'Do you have 6 kids and like to go off-roading? The Hummer gives you the small interiors with an engine to get you out of any muddy or rocky situation.', '/images/vehicles/hummer.jpg', '/images/vehicles/hummer-tn.jpg', 58800.00, 5, 'Yellow', 5),
(13, 'Aerocar International', 'Aerocar', 'Are you sick of rush hour traffic? This car converts into an airplane to get you where you are going fast. Only 6 of these were made, get this one while it lasts!', '/images/vehicles/aerocar.jpg', '/images/vehicles/aerocar-tn.jpg', 1000000.00, 1, 'Red', 2),
(14, 'FBI', 'Surveillance Van', 'Do you like police shows? You will feel right at home driving this van. Comes complete with surveillance equipment for an extra fee of $2,000 a month. ', '/images/vehicles/fbi.jpg', '/images/vehicles/fbi-tn.jpg', 20000.00, 1, 'Green', 1),
(15, 'Dog ', 'Car', 'Do you like dogs? Well, this car is for you straight from the 90s from Aspen, Colorado we have the original Dog Car complete with fluffy ears.', '/images/vehicles/no-image.png', '/images/vehicles/no-image-tn.png', 35000.00, 1, 'Brown', 2),
(18, 'Boat', 'Frigate', 'Boats boats boats boats boats boats!!', '/images/vehicles/bees bees bees.png', '/images/vehicles/bees bees bees-tn.png', 100.00, 100, 'Brown', 16),
(21, 'DMC', 'Dolorean', '1.21 jigawatts!\r\n\r\nDoes not include old science friend :(', '/images/vehicles/delorean.jpg', '/images/vehicles/delorean-tn.jpg', 30.00, 1, 'Gray', 5);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `reviewId` int(10) UNSIGNED NOT NULL,
  `reviewText` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `reviewDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `invId` int(10) UNSIGNED NOT NULL,
  `clientId` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`reviewId`, `reviewText`, `reviewDate`, `invId`, `clientId`) VALUES
(1, 'This is a sweet car! It go! So! Fast!', '2023-07-09 04:48:56', 3, 3),
(3, 'This is not a boat! This is just a swarm of bees!', '2023-07-11 02:13:58', 18, 3),
(5, 'The Bee in Boat stands for bees!', '2023-07-11 02:20:14', 18, 2),
(7, 'Did not include a talking dog. no stars.', '2023-07-12 17:55:14', 7, 2),
(9, 'I&#039;m batman', '2023-07-12 18:40:56', 6, 8),
(10, 'Please remove this picture -FBI', '2023-07-12 18:41:25', 14, 8),
(11, 'I am not a fire fighter', '2023-07-12 18:41:42', 8, 8),
(12, 'This is a scam. They just sent me a picture of the dolorean. Still worked for time travel tho', '2023-07-12 18:42:18', 21, 8),
(14, 'It looks just like the picture', '2023-07-12 18:46:16', 15, 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carclassification`
--
ALTER TABLE `carclassification`
  ADD PRIMARY KEY (`classificationId`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`clientId`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`imgId`),
  ADD KEY `inv_id_fk` (`invId`) USING BTREE;

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`invId`),
  ADD KEY `classificationId` (`classificationId`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`reviewId`),
  ADD KEY `inv_fk` (`invId`),
  ADD KEY `client_fk` (`clientId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carclassification`
--
ALTER TABLE `carclassification`
  MODIFY `classificationId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `clientId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `imgId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `invId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `reviewId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `FK_inventory_images` FOREIGN KEY (`invId`) REFERENCES `inventory` (`invId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`classificationId`) REFERENCES `carclassification` (`classificationId`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `FK_reviews_clients` FOREIGN KEY (`clientId`) REFERENCES `clients` (`clientId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_reviews_inventory` FOREIGN KEY (`invId`) REFERENCES `inventory` (`invId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
