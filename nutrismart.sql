-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 21, 2023 at 06:14 AM
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
  `month` int NOT NULL,
  `day` int NOT NULL,
  `year` int NOT NULL,
  `food_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `carbohydrates` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `blood_sugar_level` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `time` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `seeker_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `seeker_id` (`seeker_id`),
  KEY `meal_id` (`meal_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `seeker_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `seeker_id` (`seeker_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
-- Table structure for table `tbl_meal_recom`
--

DROP TABLE IF EXISTS `tbl_meal_recom`;
CREATE TABLE IF NOT EXISTS `tbl_meal_recom` (
  `id` int NOT NULL AUTO_INCREMENT,
  `item_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` text NOT NULL,
  `meal_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `meal` (`meal_id`),
  KEY `meal_id` (`meal_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_meal_recom`
--

INSERT INTO `tbl_meal_recom` (`id`, `item_name`, `description`, `meal_id`) VALUES
(1, 'Oatmeal', 'Cooked steel-cut oats or rolled oats topped with fresh berries, a sprinkle of chopped nuts, and a drizzle of sugar-free syrup.', 1),
(2, 'Greek Yogurt Parfait', 'Greek yogurt layered with sliced almonds, unsweetened granola, and a few berries.', 1),
(3, 'Scrambled Eggs', 'Scramble eggs with spinach, tomatoes, and a dash of low-fat cheese. Serve with whole-grain toast.', 1),
(4, 'Smoothie', 'Blend spinach, frozen berries, unsweetened almond milk, and a scoop of protein powder or Greek yogurt.', 1),
(5, 'Avocado Toast', 'Whole-grain toast topped with sliced avocado, a poached egg, and a pinch of salt and pepper.', 1),
(6, 'Grilled Chicken Salad', 'Grilled chicken breast over a bed of mixed greens with cherry tomatoes, cucumber, and a vinaigrette dressing.', 2),
(7, 'Quinoa Bowl', 'Cooked quinoa mixed with roasted vegetables, chickpeas, and a tahini dressing.', 2),
(8, 'Tuna Salad', 'A can of water-packed tuna mixed with diced celery, onion, and a dollop of Greek yogurt, served in lettuce wraps or on whole-grain bread.', 2),
(9, 'Turkey and Veggie Wrap', 'Whole-grain wrap filled with lean turkey slices, hummus, and plenty of veggies.', 2),
(10, 'Vegetable Soup', 'A hearty vegetable soup with lentils or beans and a side salad.', 2),
(11, 'Baked Salmon', 'Baked salmon with a lemon-dill sauce, served with steamed broccoli and quinoa.', 3),
(12, 'Stir-Fried Tofu', 'Tofu stir-fried with colorful bell peppers, broccoli, and a low-sodium teriyaki sauce, served over brown rice.', 3),
(13, 'Grilled Chicken with Asparagus', 'Grilled chicken breast with roasted asparagus and a side of mashed cauliflower.', 3),
(14, 'Spaghetti Squash', 'Spaghetti squash noodles with marinara sauce and lean ground turkey.', 3),
(15, 'Vegetable Curry', 'A vegetable curry with chickpeas and a side of brown rice.', 3),
(16, 'Celery and Peanut Butter', 'Celery sticks with a smear of natural peanut butter.', 4),
(17, 'Cottage Cheese', 'Low-fat cottage cheese with a sprinkle of cinnamon and sliced peaches.', 4),
(18, 'Carrot Sticks and Hummus', 'Sliced carrots served with hummus for dipping.', 4),
(19, 'Hard-Boiled Eggs', ' A hard-boiled egg with a pinch of salt and pepper.', 4),
(20, 'Mixed Nuts', 'A small handful of unsalted mixed nuts for a satisfying crunch.', 4);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_seeker`
--

DROP TABLE IF EXISTS `tbl_seeker`;
CREATE TABLE IF NOT EXISTS `tbl_seeker` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_dietary_logging`
--
ALTER TABLE `tbl_dietary_logging`
  ADD CONSTRAINT `tbl_dietary_logging_ibfk_1` FOREIGN KEY (`seeker_id`) REFERENCES `tbl_seeker` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_dietary_logging_ibfk_2` FOREIGN KEY (`meal_id`) REFERENCES `tbl_meal` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
