CREATE TABLE `crawlEmails` (
  `id` int(6) UNSIGNED NOT NULL,
  `url` varchar(100) NOT NULL,
  `email` varchar(30) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
