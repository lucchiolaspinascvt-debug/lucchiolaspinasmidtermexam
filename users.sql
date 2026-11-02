SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

SET NAMES utf8mb4;

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `address` varchar(150) NOT NULL,
  `age` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_created` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `first_name`, `last_name`, `address`, `age`, `username`, `password`, `date_created`) VALUES
(1, 'Lucchio', 'Las Pinas', 'etivac imus', 19, 'lusho_2111', '$2y$10$WRD1l2P1vyVECCK5o25Ztu3cAmQNH9uggaq4gjehr6S3r22jfE/aC', '2026-11-02 16:12:21'),
(2, 'raine', 'mae', 'greengate', 19, 'dedwoman', '$2y$10$/ad1RkTeqbsb6JhP07p15uVAENR0Rlkn3qfJcZ8ZrS9U2UVywWc7W', '2026-11-02 16:14:27');

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

COMMIT;