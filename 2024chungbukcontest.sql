-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 26-06-08 13:51
-- 서버 버전: 10.4.32-MariaDB
-- PHP 버전: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `2024chungbukcontest`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `cars`
--

CREATE TABLE `cars` (
  `idx` int(11) NOT NULL,
  `driver_idx` int(11) NOT NULL,
  `type` varchar(400) NOT NULL,
  `price` varchar(400) NOT NULL,
  `days` varchar(400) NOT NULL,
  `location` varchar(400) NOT NULL,
  `status` enum('pending','accepted','rejected','') NOT NULL,
  `reject_reason` text NOT NULL,
  `request_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `cars`
--

INSERT INTO `cars` (`idx`, `driver_idx`, `type`, `price`, `days`, `location`, `status`, `reject_reason`, `request_at`) VALUES
(1, 4, '시후의 차', '300', '월,화,수,목,금', '무열왕릉', 'accepted', '', '2026-06-08 10:09:49'),
(2, 4, '세단', '200', '월,화,수,목,금', '대릉원', 'accepted', '', '2026-06-08 10:09:40'),
(3, 5, 'SUV', '300', '월,수,금,토', '무열왕릉', 'accepted', '', '2026-06-08 10:09:40'),
(4, 6, '밴', '400', '화,목,토,일', '불국사', 'accepted', '', '2026-06-08 10:09:40'),
(5, 4, '경차', '100', '월,화,수,목,금,토,일', '국립경주박물관', 'accepted', '', '2026-06-08 10:09:40'),
(6, 5, '세단', '500', '토,일', '석굴암', 'accepted', '', '2026-06-08 10:09:40');

-- --------------------------------------------------------

--
-- 테이블 구조 `locations`
--

CREATE TABLE `locations` (
  `idx` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `locations`
--

INSERT INTO `locations` (`idx`, `name`) VALUES
(1, '대릉원'),
(2, '무열왕릉'),
(3, '경주엑스포대공원'),
(4, '국립경주박물관'),
(5, '화랑의언덕'),
(6, '불국사'),
(7, '석굴암'),
(8, '문무대왕릉');

-- --------------------------------------------------------

--
-- 테이블 구조 `reserves`
--

CREATE TABLE `reserves` (
  `idx` int(11) NOT NULL,
  `user_idx` int(11) NOT NULL,
  `car_idx` int(11) NOT NULL,
  `driver_idx` int(11) NOT NULL,
  `status` enum('pending','riding','done','rejected') NOT NULL DEFAULT 'pending',
  `start_location` varchar(300) NOT NULL,
  `end_location` varchar(100) NOT NULL,
  `request_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `reserves`
--

INSERT INTO `reserves` (`idx`, `user_idx`, `car_idx`, `driver_idx`, `status`, `start_location`, `end_location`, `request_at`) VALUES
(2, 1, 2, 4, 'done', '대릉원', '화랑의언덕', '2026-06-08 10:41:08'),
(3, 1, 2, 4, 'rejected', '대릉원', '무열왕릉', '2026-06-08 11:28:11'),
(4, 1, 5, 4, 'riding', '국립경주박물관', '대릉원', '2026-06-08 11:33:39');

-- --------------------------------------------------------

--
-- 테이블 구조 `routes`
--

CREATE TABLE `routes` (
  `idx` int(11) NOT NULL,
  `from_idx` int(11) NOT NULL,
  `to_idx` int(11) NOT NULL,
  `distance` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `routes`
--

INSERT INTO `routes` (`idx`, `from_idx`, `to_idx`, `distance`) VALUES
(1, 1, 2, 3.9),
(2, 1, 3, 4.8),
(3, 2, 1, 3.9),
(4, 2, 4, 4.5),
(5, 2, 5, 5.2),
(6, 3, 1, 4.8),
(7, 3, 4, 5.6),
(8, 3, 6, 7.9),
(9, 4, 2, 4.5),
(10, 4, 3, 5.6),
(11, 4, 5, 7.3),
(12, 5, 2, 5.2),
(13, 5, 4, 7.3),
(14, 6, 3, 7.9),
(15, 6, 7, 7.7),
(16, 6, 8, 10.2),
(17, 7, 6, 7.7),
(18, 7, 8, 9.1),
(19, 8, 6, 10.2),
(20, 8, 7, 9.1);

-- --------------------------------------------------------

--
-- 테이블 구조 `users`
--

CREATE TABLE `users` (
  `idx` int(11) NOT NULL,
  `id` varchar(400) NOT NULL,
  `pw` varchar(400) NOT NULL,
  `type` enum('admin','basic','driver','') NOT NULL,
  `is_login` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `users`
--

INSERT INTO `users` (`idx`, `id`, `pw`, `type`, `is_login`) VALUES
(1, 'u01', '1234', 'basic', 0),
(2, 'u02', '1234', 'basic', 0),
(3, 'u03', '1234', 'basic', 0),
(4, 'd01', '1234', 'driver', 0),
(5, 'd02', '1234', 'driver', 0),
(6, 'd03', '1234', 'driver', 0),
(7, 'admin', '1234', 'admin', 0);

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `reserves`
--
ALTER TABLE `reserves`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idx`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `cars`
--
ALTER TABLE `cars`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 테이블의 AUTO_INCREMENT `reserves`
--
ALTER TABLE `reserves`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 테이블의 AUTO_INCREMENT `routes`
--
ALTER TABLE `routes`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- 테이블의 AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
