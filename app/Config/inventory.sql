-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 19, 2024 at 07:56 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `bowner`
--

CREATE TABLE `bowner` (
  `boid` int(11) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bowner`
--

INSERT INTO `bowner` (`boid`, `userid`) VALUES
(2, 131),
(3, 137),
(4, 138),
(5, 139);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `invid` int(11) NOT NULL,
  `boid` int(11) DEFAULT NULL,
  `productid` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`invid`, `boid`, `productid`, `level`) VALUES
(1, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` int(100) NOT NULL,
  `qty` int(100) NOT NULL,
  `supplierid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `qty`, `supplierid`) VALUES
(20, 'taqi111222', 10, 10, 4),
(22, 'Please22', 22, 22, 4);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supplierid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `boid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplierid`, `userid`, `boid`) VALUES
(4, 112, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` int(11) DEFAULT 3
) ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `type`) VALUES
(69, 'lba', 'majed@gmail.com', '$2y$10$F.JTIufruK62Q/wGHf88iuJ1TorPtNN1WIAoRa32TVrUYBnNUKBG6', 1),
(73, 'sameh', 'abu_lba@yahoo.com', '$2y$10$8ZqMb413QCU6bU4l33jDg.3tjHNnVFkkwrW1SlcNgfw4uhoNtLtOq', 0),
(76, 'abdo', 'sapodasnpd@gmail.com', '$2y$10$Oqgi8aj45fGRwzJVg9SofuLVWnlv7zKoJmdaRWIrgo.esRFeJsL/G', 1),
(95, 'Khaled', 'Majed@gmail.com', '$2y$10$FKomXlV7myfLKxuF5VqCPOu.1PI4lqro0JF6kto/8vHqP4j6rn5lG', 0),
(100, 'abdo233322222222222222222', 'Majed@22222gmail.com', '123123123', 2),
(101, 'NIGGERSSSSSSSSS', 'MSSSSSSSajed@gmail.com', '123123123', 2),
(102, 'msadjasjdsaWDSSSSSSSSS', 'sdasda22222222222sD@sadaspdas.cpm', '333', 2),
(103, 'Moh', 'moh@gmail.com', '123123123@', 1),
(104, 'Moh', 'moh@gmail.com', '123123123@', 1),
(105, 'Moh', 'Faha2dKal@proton.me', '123123123@', 1),
(112, 'taqi', 'taqi@gmail.com', '$2y$10$oEipKkHnlmHZSs4H/WUOwu7QUXsnAFB3bCIktK4Mm6qly/k8/Na4m', 1),
(113, 'bo', 'bo@gmail.com', '$2y$10$Py59DdDCqY.LEiH5c.u4..73EhIOqcn3Wfk4ZHil5swST0V7SoFrC', 3),
(114, 'bo1', 'bo1@gmail.com', '$2y$10$NfWt4i7Ez2PPpHwIJ0qOC.9GDXZ8LOVZn8ihqbWTor.2ui.gwDdqa', 3),
(115, 'User', 'user@gmail.com', '$2y$10$d01wlb6dW9/G9rAtpMUhaee0MEm8Zt7JE.kOhpC8YvLSWF.DPsNGy', 2),
(116, 'bo2', 'bo2@gmail.com', '$2y$10$kHE0jQpgEC9IlxqfMILBNO3azynjvLoyCDNPKHCbrFYUh3JIBDeru', 3),
(117, 'bo3', 'bo3@gmail.com', '$2y$10$ETzsU8BvfnGqPg8LCgpOZ.fvsEhSHd8GW4QQ3BqfbP111dSrxY8MK', 3),
(118, 'bo4', 'bo4@gmail.com', '$2y$10$QLIZrRdK3.XMs864HGU7kuIeLQc9M6.XQj0W5zZSkEPOZjOXuOUuy', 3),
(119, 'bo5', 'bo5@gmail.com', '$2y$10$E.0ePLQhu77/y.1d0dV7pumTSu2wyzNBCWFFox.Uz5tfuCMlD.rSW', 3),
(120, 'bo6', 'bo22@gmail.com', '$2y$10$eKlo3XEnNtAHUMb3v8KHfOG4RN0A16tcnM.PVvXL.NHtvjexc263O', 3),
(121, 'bo53', 'bo53@gmail.com', '$2y$10$1YOKfJF0cb8/yCDXW8D87.jEAA0IV5i/355ZejsjlX3S7JYEe3ZQ6', 3),
(122, 'bo535', 'bo535@gmail.com', '$2y$10$fsh47/ZBMePS6tPK5ZSg8egJeU3cYtnMXRqONTJD3DOSPN9MbSZO.', 3),
(123, 'bo5352', 'bo5325@gmail.com', '$2y$10$9mBjb5dkG3IcrEQCohqrMOuYEzDlDsc.3zVXqn/tbBKOnrW6t1AGq', 3),
(124, 'bo51', 'b12o@gmail.com', '$2y$10$JHvbOlJIBQJTAbnDxndJEOrlhlBVHcGqb5REyZIE9ZFb8u6SW7KVm', 3),
(125, 'bo51333', 'b2o@gmail.com', '$2y$10$9JkfZgll3GjdjXRe7t4daukx.99g.nfO8QvkJqLJzG3/aHhKQ3EzK', 3),
(126, 'bo322', 'Fah22adKal@proton.me', '$2y$10$fMUQtz6g/0Wec39YI1EdoutpcUW4pNT5bUfyIuzGJ.CjnM.kLaxby', 3),
(127, 'bo51222', 'gasdas2n@gnmail.com', '$2y$10$5lStPTcxuSydC9vqbmhB6uqik5458iDzKkFQx.JFd9CHC7FzwTVdW', 3),
(128, 'bo22223', 'gasda2sn@gnmail.com', '$2y$10$rwCp84hvYyUFTRT.2mXmXOPy5xKYt2wNutw7nu2RQLA6hVfXLumS.', 3),
(131, 'taqi22', 'bo3232@gmail.com', '$2y$10$54uCHsYV1LUR2qU/Tgv5JecfcNlDJbU46hhXnU2H8K6TUJHB6djPC', 3),
(137, 'taqi232', 'gasd232asn@gnmail.com', '$2y$10$nUMC0P/UDWWgCv8LGTdM4Oha5CwATfVJ.mWtX.XUhEURkTCqgnBAi', 3),
(138, 'taqi2322', 'gasdas2n@gnmail.com', '$2y$10$A3z.5/dn1ZyvyjRx.3ITxOnwYxHEJ7anVcar3dIi.6DNegGac2nmO', 3),
(139, 'Mohamed', 'Majed@2222222gmail.com', '$2y$10$D4Z6GMc07TARSMmOTOyfdeZ6Oxuo0EMheMSxa4ICPCcrabHBeNP4K', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bowner`
--
ALTER TABLE `bowner`
  ADD PRIMARY KEY (`boid`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`invid`),
  ADD KEY `boid` (`boid`),
  ADD KEY `productid` (`productid`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_ibfk_1` (`supplierid`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplierid`),
  ADD KEY `supplier_ibfk_1` (`userid`),
  ADD KEY `fk_supplier_bowner` (`boid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bowner`
--
ALTER TABLE `bowner`
  MODIFY `boid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `invid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplierid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bowner`
--
ALTER TABLE `bowner`
  ADD CONSTRAINT `bowner_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`boid`) REFERENCES `bowner` (`boid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inventory_ibfk_2` FOREIGN KEY (`productid`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`supplierid`) REFERENCES `supplier` (`supplierid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `supplier`
--
ALTER TABLE `supplier`
  ADD CONSTRAINT `fk_supplier_bowner` FOREIGN KEY (`boid`) REFERENCES `bowner` (`boid`),
  ADD CONSTRAINT `supplier_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
