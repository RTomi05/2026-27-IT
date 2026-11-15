--2. feladat
SELECT bemutato, utolso
FROM darab
WHERE cim LIKE '%Traviata'
ORDER BY bemutato ASC;

--3. feladat
SELECT cim
FROM darab
WHERE bemutato BETWEEN '2000-01-01' AND '2005-12-31'; --ORDER BY bemutato ASC;

--4. feladat
SELECT cim, nev
FROM darab
JOIN mufaj ON darab.mufajid = mufaj.id
ORDER BY DATEDIFF(darab.utolso, darab.bemutato) DESC
LIMIT 1;

--5. feladat
SELECT DISTINCT cim, mufaj.nev
FROM darab
JOIN mufaj ON darab.mufajid = mufaj.id
WHERE (mufaj.nev = 'opera' OR mufaj.nev = 'operett')
AND cim LIKE '%asszony%';