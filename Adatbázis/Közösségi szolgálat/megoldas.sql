--2. feladat
SELECT tevekenyseg.nev
FROM tevekenyseg
WHERE iskolai <> 0;

--3. feladat
SELECT SUM(hossz*maxletszam)
FROM munka;

--4. feladat
SELECT osztaly, diak.nev, datum, kezdes as idopont, oraszam, tevekenyseg.nev as tevekenyseg
FROM diak
JOIN jelentkezes ON diak.id = jelentkezes.diakid
JOIN munka ON jelentkezes.munkaid = munka.id
JOIN tevekenyseg ON munka.tevekenysegid = tevekenyseg.id
WHERE osztaly LIKE '10.%'
ORDER BY osztaly ASC, datum ASC;

--5. feladat
SELECT nev, COUNT(*)
FROM diak
JOIN jelentkezes ON diak.id = jelentkezes.diakid
WHERE elfogadva AND NOT teljesitve
GROUP BY diak.id
HAVING COUNT(2) >= 2;

--6. feladat
SELECT datum, kezdes, hossz, tevekenyseg.nev
FROM munka
JOIN tevekenyseg ON munka.tevekenysegid = tevekenyseg.id
JOIN jelentkezes ON munka.id = jelentkezes.munkaid