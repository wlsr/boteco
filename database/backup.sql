-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table inventario_farmacia.cart
CREATE TABLE IF NOT EXISTS `cart` (
  `cart_id` int NOT NULL AUTO_INCREMENT,
  `item_id` int NOT NULL,
  `cart_qty` int NOT NULL,
  `cart_stock_id` int NOT NULL,
  `user_id` int NOT NULL,
  `cart_uniqid` varchar(35) NOT NULL,
  PRIMARY KEY (`cart_id`),
  KEY `item_id` (`item_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`),
  CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22966 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table inventario_farmacia.expired
CREATE TABLE IF NOT EXISTS `expired` (
  `exp_id` int NOT NULL AUTO_INCREMENT,
  `exp_itemName` varchar(50) NOT NULL,
  `exp_itemPrice` float NOT NULL,
  `exp_itemQty` int NOT NULL,
  `exp_expiredDate` date DEFAULT NULL,
  PRIMARY KEY (`exp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=329 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table inventario_farmacia.item
CREATE TABLE IF NOT EXISTS `item` (
  `item_id` int NOT NULL AUTO_INCREMENT,
  `item_name` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `item_price` double NOT NULL,
  `item_type_id` int NOT NULL,
  `item_code` varchar(35) NOT NULL,
  `lab_id` int NOT NULL,
  `item_grams` varchar(20) NOT NULL,
  PRIMARY KEY (`item_id`),
  KEY `item_type_id` (`item_type_id`),
  KEY `lab_id` (`lab_id`),
  CONSTRAINT `item_ibfk_1` FOREIGN KEY (`item_type_id`) REFERENCES `item_type` (`item_type_id`),
  CONSTRAINT `item_ibfk_2` FOREIGN KEY (`lab_id`) REFERENCES `laboratorio` (`lab_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2142 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table inventario_farmacia.item_type
CREATE TABLE IF NOT EXISTS `item_type` (
  `item_type_id` int NOT NULL AUTO_INCREMENT,
  `item_type_desc` varchar(50) NOT NULL,
  PRIMARY KEY (`item_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=205 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table inventario_farmacia.laboratorio
CREATE TABLE IF NOT EXISTS `laboratorio` (
  `lab_id` int NOT NULL AUTO_INCREMENT,
  `nombre_lab` varchar(50) NOT NULL,
  PRIMARY KEY (`lab_id`)
) ENGINE=InnoDB AUTO_INCREMENT=162 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table inventario_farmacia.sales
CREATE TABLE IF NOT EXISTS `sales` (
  `sales_id` int NOT NULL AUTO_INCREMENT,
  `item_code` varchar(35) NOT NULL,
  `generic_name` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `brand` varchar(35) NOT NULL,
  `gram` varchar(35) NOT NULL,
  `type` varchar(35) NOT NULL,
  `qty` int NOT NULL,
  `price` float NOT NULL,
  `date_sold` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int NOT NULL,
  `descuento` float NOT NULL,
  PRIMARY KEY (`sales_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21486 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table inventario_farmacia.stock
CREATE TABLE IF NOT EXISTS `stock` (
  `stock_id` int NOT NULL AUTO_INCREMENT,
  `item_id` int NOT NULL,
  `stock_qty` int NOT NULL,
  `stock_expiry` date DEFAULT NULL,
  `stock_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `stock_manufactured` date DEFAULT NULL,
  `stock_purchased` date DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `cant_add` int DEFAULT '0',
  PRIMARY KEY (`stock_id`),
  KEY `item_id` (`item_id`),
  KEY `fk_user_id` (`user_id`),
  CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11106 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table inventario_farmacia.stock_history
CREATE TABLE IF NOT EXISTS `stock_history` (
  `history_id` int NOT NULL AUTO_INCREMENT,
  `stock_id` int DEFAULT NULL,
  `item_id` int DEFAULT NULL,
  `stock_qty` int DEFAULT NULL,
  `cant_add` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `action_type` enum('INSERT','UPDATE','DELETE') DEFAULT NULL,
  `action_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`history_id`)
) ENGINE=InnoDB AUTO_INCREMENT=128 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table inventario_farmacia.user
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `user_account` varchar(50) NOT NULL,
  `user_pass` varchar(35) NOT NULL,
  `user_type` int NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for trigger inventario_farmacia.after_stock_delete
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO';
DELIMITER //
CREATE TRIGGER `after_stock_delete` AFTER DELETE ON `stock` FOR EACH ROW BEGIN
    INSERT INTO stock_history (stock_id, item_id, stock_qty, cant_add, user_id, action_type)
    VALUES (OLD.stock_id, OLD.item_id, OLD.stock_qty, OLD.cant_add, OLD.user_id, 'DELETE');
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger inventario_farmacia.after_stock_insert
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO';
DELIMITER //
CREATE TRIGGER `after_stock_insert` AFTER INSERT ON `stock` FOR EACH ROW BEGIN
    INSERT INTO stock_history (stock_id, item_id, stock_qty, cant_add, user_id, action_type)
    VALUES (NEW.stock_id, NEW.item_id, NEW.stock_qty, NEW.cant_add, NEW.user_id, 'INSERT');
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger inventario_farmacia.after_stock_update
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO';
DELIMITER //
CREATE TRIGGER `after_stock_update` AFTER UPDATE ON `stock` FOR EACH ROW BEGIN
    INSERT INTO stock_history (stock_id, item_id, stock_qty, cant_add, user_id, action_type)
    VALUES (NEW.stock_id, NEW.item_id, NEW.stock_qty, NEW.cant_add, NEW.user_id, 'UPDATE');
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
