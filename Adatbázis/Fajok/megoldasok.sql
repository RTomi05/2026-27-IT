-- A feladatok megoldására elkészített SQL parancsokat illessze be a feladat sorszáma után!

-- 9. feladat:
CREATE DATABASE vedettmadarak DEFAULT CHARACTER SET utf8 COLLATE utf8_hungarian_c

-- 11. feladat:
UPDATE faj SET ertek = 25 WHERE id = 352;

-- 12. feladat:
SELECT faj.nev, faj.latin FROM faj WHERE faj.evszam IS NULL ORDER BY nev;

-- 13. feladat:
SELECT faj.evszam, COUNT(faj.id) AS "fajok szama"
FROM faj
WHERE faj.evszam > 2000
GROUP BY faj.evszam
ORDER BY 1 ASC; 

-- 14. feladat:
SELECT faj.nev AS faj, csalad.nev AS csalad, rend.nev AS rend, faj.ertek * 1000 AS "eszmei ertek"
FROM faj
INNER JOIN csalad ON faj.csaladId=csalad.id
INNER JOIN rend ON csalad.rendId=rend.id
WHERE faj.ertek > 500; 
 
-- 15. feladat:
SELECT csalad.nev, AVG(faj.ertek) AS atlag
FROM faj
INNER JOIN csalad ON faj.csaladId=csalad.id
GROUP BY csalad.nev; 
