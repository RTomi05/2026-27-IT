--2. feladat
SELECT sorszam,ertek FROM valasz JOIN jatekos ON jatekos.id = jatekos.id WHERE veznev="Szolnoki" AND utonev="Lajos";

--3. feladat
SELECT kategoria, COUNT(*) as szamlalt FROM jatekos WHERE csapat=3 GROUP BY kategoria;