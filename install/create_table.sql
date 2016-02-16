-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas generowania: 16 Lut 2016, 17:55
-- Wersja serwera: 5.5.47-0+deb8u1
-- Wersja PHP: 5.6.17-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Baza danych: `monitoring`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `hosts`
--

CREATE TABLE IF NOT EXISTS `hosts` (
  `id` int(11) NOT NULL,
  `hostname` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `ip` varchar(15) COLLATE utf8_polish_ci DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `type` varchar(20) COLLATE utf8_polish_ci DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `value` decimal(10,3) DEFAULT NULL,
  `value_last` decimal(10,3) DEFAULT NULL,
  `value2` decimal(10,3) DEFAULT NULL,
  `value2_last` decimal(10,3) DEFAULT NULL,
  `last_check` timestamp NULL DEFAULT NULL,
  `last_change` timestamp NULL DEFAULT NULL,
  `probe_cmd` varchar(1000) COLLATE utf8_polish_ci DEFAULT NULL,
  `rrd_file` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `disabled` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `hosts`
--
ALTER TABLE `hosts`
ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `hosts`
--
ALTER TABLE `hosts`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;