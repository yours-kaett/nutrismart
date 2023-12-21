-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 21, 2023 at 09:18 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nutrismart`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blood_pressures`
--

DROP TABLE IF EXISTS `tbl_blood_pressures`;
CREATE TABLE IF NOT EXISTS `tbl_blood_pressures` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bp_value` varchar(50) NOT NULL,
  `patient_id` int NOT NULL,
  `created_at` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_blood_pressures`
--

INSERT INTO `tbl_blood_pressures` (`id`, `bp_value`, `patient_id`, `created_at`) VALUES
(1, '120/10', 3, '2023-12-21');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dietary_logging`
--

DROP TABLE IF EXISTS `tbl_dietary_logging`;
CREATE TABLE IF NOT EXISTS `tbl_dietary_logging` (
  `id` int NOT NULL AUTO_INCREMENT,
  `meal_id` int NOT NULL,
  `time` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `rice` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `viand` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ingredients` text NOT NULL,
  `carbohydrates` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `protein` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fat` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fiber` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `total_grams` varchar(50) NOT NULL,
  `date` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `patient_id` int NOT NULL,
  `blood_sugar_level` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_dietary_logging`
--

INSERT INTO `tbl_dietary_logging` (`id`, `meal_id`, `time`, `rice`, `viand`, `ingredients`, `carbohydrates`, `protein`, `fat`, `fiber`, `total_grams`, `date`, `patient_id`, `blood_sugar_level`) VALUES
(10, 1, '7:00 am', '-', 'Oatmeal Champorado with Fresh Fruits', '1/2 cup rolled oats, 1 tablespoon cocoa powder, 1-2 tablespoons coconut sugar or sweetener of choice, Fresh fruits (banana slices, cherry).', '40', '7', '4', '6', '57', '2023-12-22', 3, '100'),
(11, 3, '8:00 pm', 'Plain Rice', 'Tinolang Manok', '150g chicken breast, Ginger, garlic, and onions, Green papaya slices and malunggay leaves, 1 cup cooked white rice.', '30', '20', '5', '3', '58', '2023-12-21', 3, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dietary_meal`
--

DROP TABLE IF EXISTS `tbl_dietary_meal`;
CREATE TABLE IF NOT EXISTS `tbl_dietary_meal` (
  `id` int NOT NULL AUTO_INCREMENT,
  `meal_id` int NOT NULL,
  `time` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rice` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `viand` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ingredients` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `carbohydrates` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `protein` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `fat` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `fiber` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `hp_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `meal_id` (`meal_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_dietary_meal`
--

INSERT INTO `tbl_dietary_meal` (`id`, `meal_id`, `time`, `rice`, `viand`, `ingredients`, `carbohydrates`, `protein`, `fat`, `fiber`, `hp_id`) VALUES
(18, 1, '7:00 am', '-', 'Oatmeal Champorado with Fresh Fruits', '1/2 cup rolled oats, 1 tablespoon cocoa powder, 1-2 tablespoons coconut sugar or sweetener of choice, Fresh fruits (banana slices, cherry).', '40', '7', '4', '6', 3),
(20, 1, '07:00 am', '-', 'Tofu and Vegetable Scramble', '150g tofu, crumbled, Mixed vegetables (bell peppers, onions, tomatoes), 1 teaspoon turmeric for color and flavor, 1 tablespoon cooking oil.', '10', '15', '10', '3', 3),
(21, 1, '07:00 am', '-', 'Arroz Caldo with Chicken and Vegetables', '1/2 cup brown rice, 150g boneless, skinless chicken breast, Ginger, garlic, and onions, Mixed vegetables (carrots, zucchini)', '30', '10', '5', '3', 3),
(22, 2, '12:00 pm', 'Brown Rice', 'Sinigang na Baboy', '50g pork belly, lean cuts, Tamarind-based soup with vegetables (kangkong, radish, eggplant), 1 cup cooked brown rice.', '40', '15', '10', '5', 3),
(23, 2, '12:00 pm', 'Plain Rice', 'Grilled Bangus Salad', 'Grilled bangus (milkfish), Mixed salad greens, Cucumber, red onion, and tomatoes, Calamansi vinaigrette dressing', '15', '20', '10', '5', 3),
(24, 3, '8:00 pm', 'Plain Rice', 'Tinolang Manok', '150g chicken breast, Ginger, garlic, and onions, Green papaya slices and malunggay leaves, 1 cup cooked white rice.', '30', '20', '5', '3', 3),
(25, 3, 'Grilled Tilapia with Mango Salsa', 'Plain Rice', 'Grilled Tilapia with Mango Salsa', 'Grilled tilapia fillet, Fresh mango salsa (mango, red onion, cilantro, lime juice), Steamed okra or kangkong on the side.', '25', '25', '10', '5', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_glucose_levels`
--

DROP TABLE IF EXISTS `tbl_glucose_levels`;
CREATE TABLE IF NOT EXISTS `tbl_glucose_levels` (
  `id` int NOT NULL AUTO_INCREMENT,
  `glucose_value` varchar(50) NOT NULL,
  `patient_id` int NOT NULL,
  `created_at` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_glucose_levels`
--

INSERT INTO `tbl_glucose_levels` (`id`, `glucose_value`, `patient_id`, `created_at`) VALUES
(1, '80', 3, '2023-12-22'),
(2, '95', 3, '2023-12-23'),
(3, '85', 3, '2023-12-24'),
(4, '115', 3, '2023-12-25'),
(5, '80', 3, '2023-12-26'),
(6, '95', 3, '2023-12-27'),
(7, '85', 3, '2023-12-28'),
(8, '115', 3, '2023-12-29'),
(9, '115', 3, '2024-01-03'),
(10, '95', 3, '2024-01-05'),
(11, '80', 3, '2024-01-06'),
(12, '95', 3, '2024-01-07'),
(13, '85', 3, '2024-01-08'),
(14, '115', 3, '2024-01-010'),
(15, '80', 3, '2024-01-13'),
(16, '95', 3, '2024-01-14'),
(17, '85', 3, '2024-01-16'),
(18, '115', 3, '2024-01-17'),
(19, '115', 3, '2024-01-18'),
(20, '80', 3, '2024-01-20'),
(21, '90', 3, '2024-01-28');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_goals`
--

DROP TABLE IF EXISTS `tbl_goals`;
CREATE TABLE IF NOT EXISTS `tbl_goals` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` varchar(50) NOT NULL,
  `time` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `patient_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `seeker_id` (`patient_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_goals`
--

INSERT INTO `tbl_goals` (`id`, `date`, `time`, `title`, `description`, `patient_id`) VALUES
(9, '2023-12-21', '05:12:46', 'test', 'testtttt', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_health_provider`
--

DROP TABLE IF EXISTS `tbl_health_provider`;
CREATE TABLE IF NOT EXISTS `tbl_health_provider` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_health_provider`
--

INSERT INTO `tbl_health_provider` (`id`, `email`, `username`, `password`) VALUES
(3, 'health_provider@gmail.com', 'health_provider', '0bc2074c27f74220261bcb7e2312dd6d');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_meal`
--

DROP TABLE IF EXISTS `tbl_meal`;
CREATE TABLE IF NOT EXISTS `tbl_meal` (
  `id` int NOT NULL AUTO_INCREMENT,
  `meal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_meal`
--

INSERT INTO `tbl_meal` (`id`, `meal`) VALUES
(1, 'Breakfast'),
(2, 'Lunch'),
(3, 'Dinner');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_patient`
--

DROP TABLE IF EXISTS `tbl_patient`;
CREATE TABLE IF NOT EXISTS `tbl_patient` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_patient`
--

INSERT INTO `tbl_patient` (`id`, `username`, `email`, `password`) VALUES
(3, 'patient1', 'test@test.com', '8103cfda42d725cd38e8bdf9610ef9a6');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_dietary_meal`
--
ALTER TABLE `tbl_dietary_meal`
  ADD CONSTRAINT `tbl_dietary_meal_ibfk_2` FOREIGN KEY (`meal_id`) REFERENCES `tbl_meal` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
