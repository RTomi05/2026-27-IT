-- Táblák létrehozása

-- Rendezvénytípusok
CREATE TABLE tipus
(
    id  	int         	NOT NULL AUTO_INCREMENT,
    nev 	varchar(50) 	NOT NULL UNIQUE,
    primary key (id)
);

CREATE TABLE helyszin
(
    id  	int         	NOT NULL AUTO_INCREMENT,
    nev 	varchar(50) 	NOT NULL UNIQUE,
    primary key (id)
);

CREATE TABLE kapcsolat
(
    id  	int         	NOT NULL AUTO_INCREMENT,
    nev 	varchar(50) 	NOT NULL UNIQUE,
	telefon varchar(30) 	NOT NULL,
	email 	varchar(50) 	NOT NULL,
	cegnev 	varchar(50),
    primary key (id)
);

CREATE TABLE rendezveny
(
    id  		int         NOT NULL AUTO_INCREMENT,
    kapcsolatId int			NOT NULL,
	idopont 	date 		NOT NULL,
	napokszama 	int 		NOT NULL,
	helyszinId 	int 		NOT NULL,
	letszam 	int			NOT NULL,
	tipusId 	int 		NOT NULL,
    primary key (id),
	key kapcsolatId (kapcsolatId),
    CONSTRAINT FK_kapcsolat_kapcsolatId FOREIGN KEY (kapcsolatId) REFERENCES kapcsolat (id),
	key helyszinId (helyszinId),
    CONSTRAINT FK_helyszin_helyszinId FOREIGN KEY (helyszinId) REFERENCES helyszin (id),
	key tipusId (tipusId),
    CONSTRAINT FK_tipus_tipusId FOREIGN KEY (tipusId) REFERENCES tipus (id)
);

-- Adatok beszúrása
INSERT INTO tipus (id, nev)
VALUES 	(1, 'szabadtéri'),
		(2, 'beltéri'),
		(3, 'online'),
		(4, 'tréning'),
		(5, 'céges rendezvény');
	   
INSERT INTO helyszin (id, nev)
VALUES 	(1, 'Megrendelő telephelye'),
		(2, 'Budapest'),
		(3, 'Szeged'),
		(4, 'Debrecen'),
		(5, 'Pécs'),
		(6, 'Balaton'),
		(7, 'Velencei tó'),
		(8, 'Egyéb');

INSERT INTO kapcsolat (id, nev, telefon, email, cegnev)
VALUES 	(1, 'Kiss Piroska', '+3620123456', 'kiss.piroska@paprika.hu', 'Paprika Paradicsom'),
		(2, 'Nagy Béla', '+3670523456', 'nagy.bela@bugfix.hu', NULL),
		(3, 'Vass Alajos', '+36309998877', 'vass.alajos@vaskalapos.hu', 'Vaskalapos Hulladékhasznosító'),
		(4, 'Nagy Lilla', '+36308768768', 'nagy.lilla@szoke-ciklon.hu', 'Szőke Ciklon Illatszergyár'),
		(5, 'Major Anna', '+36201347761', 'major.anna@organic.hu', 'Organic Gyógyszergyár'),
		(6, 'Balogh Béla', '+36304673753', 'balogh.bela@nadpalca.hu', 'Nádpálca Oktatástechnikai Kereskelem'),
		(7, 'Szabó Krisztina', '+36205049928', 'szabo.krisztina@kaqkk.hu', 'Kaqkk Kft.'),
		(8, 'Hanta Balázs', '+36705463728', 'hanta.balazs@hanta.hu', 'Hanta Pályázatíró Kft.'),
		(9, 'Mekk Elek', '+36305161721', 'mekk.elek@talan-holnap.hu', 'Talán Holnap Karbantartás');

INSERT INTO rendezveny (id, kapcsolatId, idopont, napokszama, helyszinId, letszam, tipusID)
VALUES 	(1, 5, '2023-12-01', 3, 3, 100, 4),
		(2, 3, '2023-12-01', 1, 1, 120, 5),
		(3, 1, '2023-12-06', 1, 1, 40, 5),
		(4, 7, '2023-12-07', 3, 3, 20, 4),
		(5, 4, '2023-12-08', 1, 2, 70, 2),
		(6, 6, '2023-12-09', 1, 1, 30, 3),
		(7, 8, '2023-12-11', 3, 4, 10, 4),
		(8, 9, '2023-12-12', 1, 1, 30, 2),
		(9, 2, '2023-12-13', 5, 5, 30, 4),		
		(10, 5, '2023-12-14', 1, 2, 230, 5),
		(11, 7, '2023-12-15', 1, 1, 65, 5),
		(12, 8, '2023-12-15', 1, 2, 40, 5);