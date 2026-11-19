--2. feladat
SELECT diakok.nev
FROM diakok
WHERE diakok.telepules = "Barnamalom";

--3. feladat
SELECT datum, terem, orasorszam
FROM orak
WHERE targy = "angol"
ORDER BY datum ASC, orasorszam ASC;

--4. feladat
SELECT csoport, targy, datum
FROM orak
WHERE csoport 
LIKE '9%' AND (targy = 'matematika' OR targy = 'fizika')
ORDER BY targy;

--5. feladat
SELECT telepules, COUNT(nev) AS 'diákok száma'
FROM diakok
GROUP BY telepules
ORDER BY COUNT(nev) DESC;

--6. feladat
SELECT DISTINCT targy
FROM orak
ORDER BY targy;

--7. feladat
SELECT diakok.nev, diakok.email, diakok.telefon
FROM orak
JOIN kapcsolo ON orak.id = oraid
JOIN diakok ON kapcsolo.diakid = diakok.id
WHERE orak.tanar = "Angol Anna" AND orak.datum = "2028-11-10";

--8. feladat
SELECT nev
FROM diakok
WHERE telepules = 
	(SELECT telepules
	FROM diakok
	WHERE nev = "Majer Melinda")
	AND nev != "Majer Melinda";