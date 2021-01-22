-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2016 at 09:23 AM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ekd`
--
CREATE DATABASE IF NOT EXISTS `ekd` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ekd`;

-- --------------------------------------------------------

--
-- Table structure for table `credit_cards`
--

CREATE TABLE `credit_cards` (
  `credit_card_id` int(10) NOT NULL,
  `card_number` bigint(20) NOT NULL,
  `card_type` varchar(100) NOT NULL,
  `card_ccv` int(3) NOT NULL,
  `card_expiry_date` date NOT NULL,
  `customer_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(10) NOT NULL,
  `email` varchar(254) NOT NULL,
  `password` varchar(60) NOT NULL,
  `first_name` varchar(35) NOT NULL,
  `last_name` varchar(35) NOT NULL,
  `mobile_number` int(8) NOT NULL,
  `dob` date NOT NULL,
  `address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int(10) NOT NULL,
  `email` varchar(254) NOT NULL,
  `password` varchar(60) NOT NULL,
  `first_name` varchar(35) NOT NULL,
  `last_name` varchar(35) NOT NULL,
  `mobile_number` int(8) NOT NULL,
  `dob` date NOT NULL,
  `address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `email`, `password`, `first_name`, `last_name`, `mobile_number`, `dob`, `address`) VALUES
(1, 'deyi@ekd.com', '$2y$10$NUbDK85pyYSK4FmhwoneROa3.QnXIo5cQxiEnSIMuIDXIxpo0qlhG', 'Admin', 'De Yi', 90921292, '1996-03-12', 'Tampines'),
(2, 'kenneth@ekd.com', '$2y$10$JwCZX9T5nTcn8L2..neYROfn8jZdJhwFuh5IStq0J3weuVIU4eAta', 'Admin', 'Kenneth', 98765432, '1997-02-02', 'Tampines'),
(3, 'eeshi@ekd.com', '$2y$10$q.cG2WJNskT89DKfmE4ZsuRA7IV1uWm1QTcCi/0tC3Oig/sUoReyi', 'Admin', 'Ee Shi', 98765432, '1996-12-28', 'Eunos');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(10) NOT NULL,
  `item_name` varchar(35) NOT NULL,
  `description` mediumtext NOT NULL,
  `size` varchar(100) NOT NULL,
  `color` varchar(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `price` double(10,2) NOT NULL,
  `stock_quantity` int(10) NOT NULL,
  `image_url` mediumtext NOT NULL,
  `employee_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `item_name`, `description`, `size`, `color`, `gender`, `price`, `stock_quantity`, `image_url`, `employee_id`) VALUES
(1, 'Power Men''s Canvas Running Shoes', 'Material: Canvas\r\nLifestyle: Casual\r\nClosure Type: Lace-Up\r\nWarranty Type: Manufacturer\r\nProduct warranty against manufacturing defects: 60 days\r\nCare Instructions: Allow you pair of shoes to air and de-odorize at a regular basis. This also helps them retain their natural shape; use shoe bags to prevent any stains or mildew; dust any dry dirt from the surface using a clean cloth, do not use polish or shiner', '6 UK,7 UK', 'Red', 'Male', 1399.00, 50, 'images/iteminfo/id_1/image1.jpg,images/iteminfo/id_1/image2.jpg,images/iteminfo/id_1/image3.jpg,images/iteminfo/id_1/image4.jpg,images/iteminfo/id_1/image5.jpg,images/iteminfo/id_1/image6.jpg,images/iteminfo/id_1/image7.jpg', 1),
(2, 'BUSCA', 'Material: Leather\r\nSole: Rubber\r\nGet ready for winter with these awesome lace-up boots featuring a rugged lug sole and warm shearling lining.\r\n- Winter boot.\r\n- Round toe.\r\n- Lug sole.\r\n- Block heel.', '7,8,9,10,11,12,13', 'Brown', 'Male', 165.50, 45, 'images/iteminfo/id_3/image1.jpg,images/iteminfo/id_3/image2.jpg,images/iteminfo/id_3/image3.jpg,images/iteminfo/id_3/image4.jpg', 1),
(3, 'FLAGSTONE', 'Material: Leather\r\nSole: Leather\r\nBe a trendy business man in these both classic and fashionable lace-up derbies. \r\n- Derby shoe.\r\n- Almond toe.\r\n- Block heel.', '9,10', 'Black', 'Male', 150.00, 254, 'images/iteminfo/id_4/image1.jpg,images/iteminfo/id_4/image2.jpg,images/iteminfo/id_4/image3.jpg', 1),
(4, 'Sling Back Heel Pumps', 'Threaded texture finish on the pointed toe construction, ZALORA gets your shoe game strong with these pumps for the anytime ensemble. Featuring elasticised slingback heel straps for convenient wearing while exuding elegance through the kitten heels.\r\n\r\n- Polyurethane \r\n- Pointed toe\r\n- Elasticised slingback heel strap fastening\r\n- Kitten heels\r\n- Polyurethane insole\r\n- Synthetic rubber outsole\r\n- Heel height: 8.5cm/3.3"', 'UK 2,UK 3,UK 4,UK 5,UK 6,UK 7,UK 8', 'Pale Yellow,Black', 'Female', 39.90, 96, 'images/iteminfo/id_5/image1.jpg,images/iteminfo/id_5/image2.jpg,images/iteminfo/id_5/image3.jpg,images/iteminfo/id_5/image4.jpg,images/iteminfo/id_5/image5.jpg,images/iteminfo/id_5/image6.jpg,images/iteminfo/id_5/image7.jpg,images/iteminfo/id_5/image8.jpg,images/iteminfo/id_5/image9.jpg,images/iteminfo/id_5/image10.jpg', 1),
(5, 'Sling Back Sandals With Tassel', 'ZALORA gives the classic strappy sandals a delightful touch of chic with lovely tassel details and gold tone accents. These lovelies are perfect for those relaxing fun-filled weekends.\r\n\r\n- Fits true to size\r\n- Synthetic leather upper\r\n- Open toe\r\n- Adjustable pin buckle and hook fastening\r\n- Synthetic insole\r\n- Synthetic outsole', 'UK 2,UK 3,UK 4,UK 5,UK 6,UK 7,UK 8', 'Black,White', 'Female', 29.90, 50, 'images/iteminfo/id_6/image1.jpg,images/iteminfo/id_6/image2.jpg,images/iteminfo/id_6/image3.jpg,images/iteminfo/id_6/image4.jpg,images/iteminfo/id_6/image5.jpg,images/iteminfo/id_6/image6.jpg,images/iteminfo/id_6/image7.jpg,images/iteminfo/id_6/image8.jpg,images/iteminfo/id_6/image9.jpg,images/iteminfo/id_6/image10.jpg,images/iteminfo/id_6/image11.jpg,images/iteminfo/id_6/image12.jpg', 1),
(6, 'Knee Boots Heels', 'The knee-high boots are shifting their gears from seasonal to statement making. Enveloped with classic suedette finish, ZALORA keeps these boots comfortable by adding chunky low heels and side zippers. \r\n\r\n- Textile upper\r\n- Almond toe\r\n- Side zip fastening\r\n- Synthetic insole\r\n- Synthetic outsole\r\n- Calf circumference: 18cm/7"\r\n- Shaft height: 34.1cm/13.4"\r\n- Heel height: 3.2cm/1.15"', 'UK 2,UK 3,UK 4,UK 5,UK 6,UK 7,UK 8', 'Brown,Blue,Black', 'Female', 69.90, 213, 'images/iteminfo/id_7/image1.jpg,images/iteminfo/id_7/image2.jpg,images/iteminfo/id_7/image3.jpg,images/iteminfo/id_7/image4.jpg,images/iteminfo/id_7/image5.jpg,images/iteminfo/id_7/image6.jpg,images/iteminfo/id_7/image7.jpg,images/iteminfo/id_7/image8.jpg,images/iteminfo/id_7/image9.jpg,images/iteminfo/id_7/image10.jpg,images/iteminfo/id_7/image11.jpg,images/iteminfo/id_7/image12.jpg,images/iteminfo/id_7/image13.jpg,images/iteminfo/id_7/image14.jpg,images/iteminfo/id_7/image15.jpg', 1),
(7, 'Authentic Original 2-Eye Boat Shoes', 'Amaretto Authentic Original 2-Eye Boat Shoes by Sperry Top-Spider features a Full Active Comfort System and genuine hand sewn moccasin construction allow for a comfortable, personal fit. These classic shoes are ideal for casual wear. \r\n\r\n- Leather upper\r\n- Genuine hand sewn Tru-Moc construction for durable comfort\r\n- 360Â° lacing system with two rust proof eyelets for secure fit\r\n- Pig skin insole \r\n- Shock absorbing EVA heel cup for added comfort\r\n- Non-marking rubber outsole with razor cut wave-sipingâ„¢ for ultimate wet or dry traction', 'UK 6,UK 7,UK 8,UK 9,UK 10,UK 11', 'Tan,Classic Brown,Amaretto', 'Male', 139.00, 31, 'images/iteminfo/id_8/image1.jpg,images/iteminfo/id_8/image2.jpg,images/iteminfo/id_8/image3.jpg,images/iteminfo/id_8/image4.jpg,images/iteminfo/id_8/image5.jpg,images/iteminfo/id_8/image6.jpg,images/iteminfo/id_8/image7.jpg,images/iteminfo/id_8/image8.jpg,images/iteminfo/id_8/image9.jpg,images/iteminfo/id_8/image10.jpg,images/iteminfo/id_8/image11.jpg,images/iteminfo/id_8/image12.jpg,images/iteminfo/id_8/image13.jpg,images/iteminfo/id_8/image14.jpg,images/iteminfo/id_8/image15.jpg', 1),
(8, 'Strap Boot Heels', 'A cross between seasonal and statement-making, we love the stellar look of these ZALORA boots. Designed with a fair measure of simplicity and height-boosting heels, the brand amplifies the smooth, clean silhouette with textured panels. \r\n\r\n- Synthetic upper\r\n- Almond toe\r\n- Side zip fastening\r\n- Synthetic and textile insole\r\n- Synthetic outsole\r\n- Shaft height: 10cm/3.7"\r\n- Heel height: 3.1cm/1.15"', 'UK 2,UK 3,UK 4,UK 5,UK 6,UK 7,UK 8', 'Navy,Black,Camel', 'Female', 49.90, 66, 'images/iteminfo/id_9/image1.jpg,images/iteminfo/id_9/image2.jpg,images/iteminfo/id_9/image3.jpg,images/iteminfo/id_9/image4.jpg,images/iteminfo/id_9/image5.jpg,images/iteminfo/id_9/image6.jpg,images/iteminfo/id_9/image7.jpg,images/iteminfo/id_9/image8.jpg,images/iteminfo/id_9/image9.jpg,images/iteminfo/id_9/image10.jpg,images/iteminfo/id_9/image11.jpg,images/iteminfo/id_9/image12.jpg,images/iteminfo/id_9/image13.jpg,images/iteminfo/id_9/image14.jpg,images/iteminfo/id_9/image15.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `item_feedbacks`
--

CREATE TABLE `item_feedbacks` (
  `item_feedback_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `message` mediumtext NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `total_cost` int(10) NOT NULL,
  `status` int(1) NOT NULL,
  `delivery_date` date DEFAULT NULL,
  `remarks` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(10) NOT NULL,
  `order_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `size` int(10) NOT NULL,
  `color` int(10) NOT NULL,
  `gender` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sales_banner`
--

CREATE TABLE `sales_banner` (
  `sales_banner_id` int(2) NOT NULL,
  `item_id` int(10) DEFAULT NULL,
  `image_url` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_banner`
--

INSERT INTO `sales_banner` (`sales_banner_id`, `item_id`, `image_url`) VALUES
(1, 7, 'images/sales_banner/banner1.jpg'),
(2, NULL, 'images/sales_banner/banner2.jpg'),
(3, NULL, 'images/sales_banner/banner3.jpg'),
(4, NULL, 'images/sales_banner/banner4.jpg'),
(5, NULL, 'images/sales_banner/banner5.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `credit_cards`
--
ALTER TABLE `credit_cards`
  ADD PRIMARY KEY (`credit_card_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `item_feedbacks`
--
ALTER TABLE `item_feedbacks`
  ADD PRIMARY KEY (`item_feedback_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `sales_banner`
--
ALTER TABLE `sales_banner`
  ADD PRIMARY KEY (`sales_banner_id`),
  ADD KEY `item_id` (`item_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `credit_cards`
--
ALTER TABLE `credit_cards`
  MODIFY `credit_card_id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `item_feedbacks`
--
ALTER TABLE `item_feedbacks`
  MODIFY `item_feedback_id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sales_banner`
--
ALTER TABLE `sales_banner`
  MODIFY `sales_banner_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `credit_cards`
--
ALTER TABLE `credit_cards`
  ADD CONSTRAINT `credit_cards_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`);

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`);

--
-- Constraints for table `item_feedbacks`
--
ALTER TABLE `item_feedbacks`
  ADD CONSTRAINT `item_feedbacks_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  ADD CONSTRAINT `item_feedbacks_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`);

--
-- Constraints for table `sales_banner`
--
ALTER TABLE `sales_banner`
  ADD CONSTRAINT `sales_banner_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
