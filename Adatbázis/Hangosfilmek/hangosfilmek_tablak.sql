
CREATE TABLE `feladat` (
  `id` int(11) NOT NULL,
  `filmid` int(11) NOT NULL,
  `szemelyid` int(11) NOT NULL,
  `megnevezes` varchar(50) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;


CREATE TABLE `film` (
  `id` int(11) NOT NULL,
  `cim` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  `gyartas` int(11) NOT NULL,
  `hossz` int(11) NOT NULL,
  `bemutato` date NOT NULL,
  `youtube` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;


CREATE TABLE `szemely` (
  `id` int(11) NOT NULL,
  `nev` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  `nem` varchar(10) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;


ALTER TABLE `feladat`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `film`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `szemely` ADD PRIMARY KEY(`id`);