-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2022 at 11:17 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `buckvest`
--

-- --------------------------------------------------------

--
-- Table structure for table `earnings`
--

CREATE TABLE `earnings` (
  `id` int(11) NOT NULL,
  `wallet_address` text NOT NULL,
  `amount` float NOT NULL,
  `token` varchar(225) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `investments`
--

CREATE TABLE `investments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `investment_plan` text NOT NULL,
  `created` date NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `referrals`
--

CREATE TABLE `referrals` (
  `id` int(11) NOT NULL,
  `referral_id` int(11) NOT NULL,
  `referred_id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `referrals`
--

INSERT INTO `referrals` (`id`, `referral_id`, `referred_id`, `token`, `created`) VALUES
(1, 1, 3, '60ab3237001939bc10e6dea7db7c841aa3af78a5', '2017-10-22 10:01:00');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `from_wallet_address` text NOT NULL,
  `to_wallet_address` text NOT NULL,
  `previous_hash` text NOT NULL,
  `current_hash` text NOT NULL,
  `amount` float NOT NULL,
  `description` text NOT NULL,
  `token` varchar(128) NOT NULL,
  `transaction_type` text NOT NULL,
  `status` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(500) NOT NULL,
  `status` int(11) NOT NULL,
  `access_level` varchar(64) NOT NULL,
  `access_code` varchar(32) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `status`, `access_level`, `access_code`, `created`, `modified`) VALUES
(1, 'Bankole Emmanuel', 'emmafikayomi2004@gmail.com', '$2y$10$yk2SBU8R9EeG9TW6LiuxYeOBktoCUxb5qr7uGGzm.fuN52j9ozlNi', 1, 'user', 'cf2f3c727170d32e4f929d27d8ee5f1f', '2022-10-17 08:53:05', '2022-10-17 07:53:05'),
(2, 'Adeleke Mayowa', 'adelekemayowa@gmail.com', '$2y$10$BOeOMythLvBPvzMLNw/Nu.pOVjul84izGFTpScSYKxNYBd3CUfxOe', 1, 'admin', '05c1b6144257accbacfea6085cbfeaac', '2022-10-17 08:53:05', '2022-10-17 07:56:24'),
(3, 'Omoloja Ayodeji', 'rileythehuman@gmail.com', '$2y$10$7vjrj2KUYHgBPsgVXCuVu.GfTcfwGFc95UmYNQZJmwriQgVfgWpSy', 1, 'user', '', '2017-10-22 10:52:00', '2022-10-17 08:54:04');

-- --------------------------------------------------------

--
-- Table structure for table `wallet`
--

CREATE TABLE `wallet` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `public_wallet_address` text NOT NULL,
  `private_wallet_address` text NOT NULL,
  `balance` float NOT NULL,
  `wallet_type` varchar(32) NOT NULL,
  `wallet_key` varchar(32) NOT NULL,
  `access_code` varchar(225) NOT NULL,
  `status` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wallet`
--

INSERT INTO `wallet` (`id`, `user_id`, `public_wallet_address`, `private_wallet_address`, `balance`, `wallet_type`, `wallet_key`, `access_code`, `status`, `created`, `modified`) VALUES
(1, 3, '41b2ef23294ebfbca5dcb15dfa2abc3f827da91c336ccf1614159fa276ebaed7', '17dbe6be55b1a2e232300b58bacdaa8508202e37ad77f9bc4b9acc1189688ecc', 0, '1', '', '88cb20a064b86dbd8eaac08317dd9d90', 1, '2022-10-17 10:52:55', '2022-10-17 08:52:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `earnings`
--
ALTER TABLE `earnings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `investments`
--
ALTER TABLE `investments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `referrals`
--
ALTER TABLE `referrals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wallet`
--
ALTER TABLE `wallet`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `earnings`
--
ALTER TABLE `earnings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `investments`
--
ALTER TABLE `investments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `referrals`
--
ALTER TABLE `referrals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `wallet`
--
ALTER TABLE `wallet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
