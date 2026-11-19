--14. feladat
SELECT COUNT(*) as 'nagyrendezvények száma' FROM rendezveny WHERE letszam >= 100;

--15. feladat
SELECT idopont, napokszama, letszam FROM rendezveny JOIN helyszin ON helyszinId = helyszin.id WHERE helyszin.nev = "Szeged";

--16. feladat
UPDATE kapcsolat SET kapcsolat.cegnev = 'BugFix IT' WHERE kapcsolat.nev = 'Nagy Béla';

--17. feladat
SELECT tipus.nev as 'típus', AVG(rendezveny.letszam) as 'átlaglétszám'
	FROM rendezveny
		INNER JOIN tipus ON rendezveny.tipusId = tipus.id
	GROUP BY rendezveny.tipusId
	ORDER BY 2 DESC
	LIMIT 2;

--18. feladat
SELECT helyszin.nev
	FROM helyszin
		LEFT JOIN rendezveny ON rendezveny.helyszinId = helyszin.id
	WHERE rendezveny.id IS NULL;
--vagy
SELECT helyszin.nev
	FROM rendezveny
		RIGHT JOIN helyszin ON rendezveny.helyszinId = helyszin.id
	WHERE rendezveny.id IS NULL;

--vagy
SELECT helyszin.nev
	FROM helyszin
	WHERE helyszin.id NOT IN
		(SELECT rendezveny.helyszinId FROM rendezveny);

--19. feladat