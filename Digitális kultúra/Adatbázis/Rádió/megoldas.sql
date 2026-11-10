--2. feladat
SELECT ido, cim, eloado FROM lista WHERE nap = 3 AND time(ido) >= time("9:00") ORDER BY ido;
--VAGY
SELECT ido, cim, eloado FROM lista WHERE nap = 3 AND ido >= '09:00:00' ORDER BY ido;

--3. feladat
SELECT nap, COUNT(*) as muvek_Szama FROM lista GROUP BY nap ORDER BY muvek_szama DESC;

--4. feladat
SELECT cim, eloado FROM lista WHERE nap = 1 AND eloado LIKE '%LISZT FERENC KAMARAZENEKAR';

--5. feladat
SELECT veznev, utonev, szul, hal FROM szerzo WHERE szul > 0 AND szul IS NOT NULL ORDER BY szul ASC LIMIT 1;

--6. feladat
SELECT DISTINCT lista.cim FROM lista JOIN szerzo ON lista.szerzoazon = szerzo.azon WHERE szerzo.szul = ( SELECT MIN(szul) FROM szerzo WHERE szul > 0 AND szul IS NOT NULL);