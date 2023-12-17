-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 17, 2023 at 05:54 AM
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
-- Table structure for table `tbl_dietary_logging`
--

DROP TABLE IF EXISTS `tbl_dietary_logging`;
CREATE TABLE IF NOT EXISTS `tbl_dietary_logging` (
  `id` int NOT NULL AUTO_INCREMENT,
  `meal_id` int NOT NULL,
  `time` varchar(50) NOT NULL,
  `rice` varchar(50) NOT NULL,
  `viand` varchar(50) NOT NULL,
  `carbohydrates` varchar(50) NOT NULL,
  `protein` varchar(50) NOT NULL,
  `fat` varchar(50) NOT NULL,
  `fiber` varchar(50) NOT NULL,
  `total_grams` varchar(50) NOT NULL,
  `date` varchar(50) NOT NULL,
  `patient_id` int NOT NULL,
  `blood_sugar_level` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_dietary_logging`
--

INSERT INTO `tbl_dietary_logging` (`id`, `meal_id`, `time`, `rice`, `viand`, `carbohydrates`, `protein`, `fat`, `fiber`, `total_grams`, `date`, `patient_id`, `blood_sugar_level`) VALUES
(3, 1, '7:00 am', '-', 'Oatmeal Champorado with Fresh Fruits', '40', '7', '4', '6', '57', '2023-12-14', 3, '100'),
(4, 2, '12:00 pm', 'Plain Rice', 'Grilled Bangus Salad', '15', '20', '10', '5', '50', '2023-12-14', 3, '100'),
(5, 3, '8:00 pm', 'Plain Rice', 'Tinolang Manok', '30', '20', '5', '3', '58', '2023-12-14', 3, '100');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dietary_meal`
--

DROP TABLE IF EXISTS `tbl_dietary_meal`;
CREATE TABLE IF NOT EXISTS `tbl_dietary_meal` (
  `id` int NOT NULL AUTO_INCREMENT,
  `meal_id` int NOT NULL,
  `time` varchar(50) NOT NULL,
  `rice` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `viand` varchar(50) NOT NULL,
  `ingredients` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `carbohydrates` varchar(50) NOT NULL,
  `protein` varchar(50) NOT NULL,
  `fat` varchar(50) NOT NULL,
  `fiber` varchar(50) NOT NULL,
  `hp_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
-- Table structure for table `tbl_goals`
--

DROP TABLE IF EXISTS `tbl_goals`;
CREATE TABLE IF NOT EXISTS `tbl_goals` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `patient_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_goals`
--

INSERT INTO `tbl_goals` (`id`, `date`, `title`, `description`, `patient_id`) VALUES
(1, '2023-12-17', 'test', 'qwertyuiop[', 3),
(2, '2023-12-18', 'asdfg', 'test', 3);

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
  `meal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_patient`
--

INSERT INTO `tbl_patient` (`id`, `username`, `email`, `password`) VALUES
(3, 'patient1', 'test@test.com', '8103cfda42d725cd38e8bdf9610ef9a6');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
