--2. feladat
SELECT cim, gyartas FROM film WHERE hossz IS NULL OR bemutato IS NULL ORDER BY gyartas ASC;

--3. feladat
SELECT cim FROM film WHERE gyartas = year(bemutato);

--4. feladat
SELECT SUM(hossz)/600 as napok FROM film WHERE youtube;

--5. feladat
SELECT bemutato FROM film WHERE bemutato < '1944-12-24' ORDER BY bemutato DESC LIMIT 1;

--6. feladat
SELECT szemely.nev, COUNT(gyartas) as evben FROM film INNER JOIN feladat ON film.id = feladat.filmid INNER JOIN szemely ON feladat.szemelyid = szemely.id WHERE nev = 'Kabos Gyula' GROUP BY gyartas;

--7. feladat
SELECT cim FROM film INNER JOIN feladat ON film.id = feladat.filmid INNER JOIN szemely ON feladat.szemelyid = szemely.id WHERE szemely.nev = 'Turay Ida' AND youtube AND hossz <= (SELECT hossz FROM film WHERE cim = 'Pesti mese');

--8. feladat
SELECT nev FROM szemely WHERE id NOT IN ();