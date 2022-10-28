-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2022 at 02:34 PM
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

--
-- Dumping data for table `earnings`
--

INSERT INTO `earnings` (`id`, `wallet_address`, `amount`, `token`, `created`) VALUES
(1, 'ac360cad1a0e23a1533ddd0e9aab1214cd9a34f2b88128be3904e11ba6b28c77', 0.5, '20f504618a47d8bb720e22348ea07d6e85f7a7a8', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `investments`
--

CREATE TABLE `investments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `investment_plan` text NOT NULL,
  `amount` float NOT NULL,
  `created` date NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `investments`
--

INSERT INTO `investments` (`id`, `user_id`, `investment_plan`, `amount`, `created`, `modified`) VALUES
(9, 1, '', 0, '2022-10-28', '2022-10-28 12:10:02'),
(10, 1, '', 0, '2022-10-28', '2022-10-28 12:12:41'),
(11, 1, '', 0, '2022-10-28', '2022-10-28 12:13:34');

-- --------------------------------------------------------

--
-- Table structure for table `referrals`
--

CREATE TABLE `referrals` (
  `id` int(11) NOT NULL,
  `referral_id` int(11) NOT NULL,
  `referred_id` int(11) NOT NULL,
  `bonus` float NOT NULL,
  `token` varchar(64) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `referrals`
--

INSERT INTO `referrals` (`id`, `referral_id`, `referred_id`, `bonus`, `token`, `created`) VALUES
(1, 1, 3, 0, '60ab3237001939bc10e6dea7db7c841aa3af78a5', '2017-10-22 10:01:00');

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

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `from_wallet_address`, `to_wallet_address`, `previous_hash`, `current_hash`, `amount`, `description`, `token`, `transaction_type`, `status`, `created`) VALUES
(1, 'ac360cad1a0e23a1533ddd0e9aab1214cd9a34f2b88128be3904e11ba6b28c77', 'ac360cad1a0e23a1533ddd0e9aab1214cd9a34f2b88128be3904e11ba6b28c77', 'ac360cad1a0e23a1533ddd0e9aab1214cd9a34f2b88128be3904e11ba6b28c77', 'ac360cad1a0e23a1533ddd0e9aab1214cd9a34f2b88128be3904e11ba6b28c77', 2000, 'Genesys Block', '123456', 'genesys_block', 1, '2022-10-20 09:29:49'),
(14, '0xcf98E2777dC3B0BBd50acFEAeCaca79E166DD888', '41b2ef23294ebfbca5dcb15dfa2abc3f827da91c336ccf1614159fa276ebaed7', 'd685b618784249af438b03473259a70dda661a7eabf163e9ddcf25c3ab6e2314', 'c0f99074b3b3362952d41e48c21ad7084d641404c2d781c95ee9befbdfe785d6', 200, 'Deposit to wallet', 'd73e5eea716795c6eb348badeddf5ca3', 'deposit', 1, '2022-10-27 07:14:19'),
(15, 'bc1qzmedlhj7p3ljfw59ul8z0d4xae7xssauazucr6', '41b2ef23294ebfbca5dcb15dfa2abc3f827da91c336ccf1614159fa276ebaed7', 'c0f99074b3b3362952d41e48c21ad7084d641404c2d781c95ee9befbdfe785d6', '3cb648192876b8618636ae4f2e3a58122888dcbb239feae1e0ae466a6486a603', 3000, 'Deposit to wallet', '93d97e640d784d83bc8dbdf13993771b', 'deposit', 1, '2022-10-27 07:32:17'),
(16, '41b2ef23294ebfbca5dcb15dfa2abc3f827da91c336ccf1614159fa276ebaed7', '41b2ef23294ebfbca5dcb15dfa2abc3f827da91c336ccf1614159fa276ebaed7', '3cb648192876b8618636ae4f2e3a58122888dcbb239feae1e0ae466a6486a603', '55927832a875d3707912e96c452b7de7941e425da758512645ba5345870b81df', 700, 'Withdrawal from wallet', '81d71544e2ffe39914d6e425fbc91828', 'withdrawal', 1, '2022-10-27 11:41:16'),
(17, '41b2ef23294ebfbca5dcb15dfa2abc3f827da91c336ccf1614159fa276ebaed7', '41b2ef23294ebfbca5dcb15dfa2abc3f827da91c336ccf1614159fa276ebaed7', '55927832a875d3707912e96c452b7de7941e425da758512645ba5345870b81df', '90f522efa99ef7437c4d6eb72309db4145122d870ef0223b38d28c737045a3e9', 1400, 'Withdrawal from wallet', '02342d6d91317cd8fb1b2a2d32899194', 'withdrawal', 1, '2022-10-27 11:55:49'),
(18, '41b2ef23294ebfbca5dcb15dfa2abc3f827da91c336ccf1614159fa276ebaed7', '41b2ef23294ebfbca5dcb15dfa2abc3f827da91c336ccf1614159fa276ebaed7', '90f522efa99ef7437c4d6eb72309db4145122d870ef0223b38d28c737045a3e9', '43f04b393df0aeaa0c760e56ac74272804c70bc696dbd7abb2952209412059f3', 400, 'Withdrawal from wallet', 'b7e592c970311d7aac5a269c66b59281', 'withdrawal', 0, '2022-10-28 13:14:19');

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
(1, 'Bankole Emmanuel', 'emmafikayomi2004@gmail.com', '$2y$10$yk2SBU8R9EeG9TW6LiuxYeOBktoCUxb5qr7uGGzm.fuN52j9ozlNi', 1, 'user', 'cf2f3c727170d32e4f929d27d8ee5f1f', '2022-10-17 08:53:05', '2022-10-20 08:27:26'),
(2, 'Adeleke Mayowa', 'adelekemayowa@gmail.com', '$2y$10$BOeOMythLvBPvzMLNw/Nu.pOVjul84izGFTpScSYKxNYBd3CUfxOe', 1, 'admin', '05c1b6144257accbacfea6085cbfeaac', '2022-10-17 08:53:05', '2022-10-17 07:56:24'),
(3, 'Omoloja Ayodeji', 'rileythehuman@gmail.com', '$2y$10$7vjrj2KUYHgBPsgVXCuVu.GfTcfwGFc95UmYNQZJmwriQgVfgWpSy', 1, 'user', '', '2017-10-22 10:52:00', '2022-10-17 08:54:04'),
(4, 'ISreal Godspower', 'elonbtcinvestment@gmail.com', '$2y$10$7vjrj2KUYHgBPsgVXCuVu.GfTcfwGFc95UmYNQZJmwriQgVfgWpSy', 0, 'admin', '', '2017-10-22 10:52:00', '2022-10-19 20:44:32');

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
(1, 1, '41b2ef23294ebfbca5dcb15dfa2abc3f827da91c336ccf1614159fa276ebaed7', '17dbe6be55b1a2e232300b58bacdaa8508202e37ad77f9bc4b9acc1189688ecc', 3000, '1', '', '88cb20a064b86dbd8eaac08317dd9d90', 1, '2022-10-17 10:52:55', '2022-10-28 12:12:42'),
(2, 3, 'ac360cad1a0e23a1533ddd0e9aab1214cd9a34f2b88128be3904e11ba6b28c77', 'f09a95e48aebb2ca481659bf504cacdeab175a2fb4552e066a864b7afea361a2', 0, '1', '1528', '5d8c55427654ee031914edece6509d28', 1, '2022-10-17 10:52:55', '2022-10-26 15:24:06');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `investments`
--
ALTER TABLE `investments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `referrals`
--
ALTER TABLE `referrals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `wallet`
--
ALTER TABLE `wallet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
