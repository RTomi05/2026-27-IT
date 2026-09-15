using System.ComponentModel.Design.Serialization;

internal class Program
{
    private static void Main(string[] args)
    {
        int[] meresek = new int[20];
        meresek = [650, 628, 628, 658, 683, 683, 644, 611, 645, 619, 619, 580, 580, 626, 626, 626, 598, 636, 612, 584];

        //legnagyobb
        int hanyadik = 0;
        for (int i = 0; i < meresek.Length; i++)
        {
            if (meresek[i] > meresek[hanyadik])
            {
                hanyadik = i;
            }
        }
        Console.WriteLine("Legmagasabb: " + (hanyadik + 1));

        int legmagasabb = meresek[hanyadik];
        //legalacsonyabb

        for (int i = 0; i < meresek.Length; i++)
        {
            if (meresek[i] < meresek[hanyadik])
            {
                hanyadik = i;
            }
        }
        Console.WriteLine("Legalacsonyabb: " + (hanyadik + 1));
        int legalacsonyabb = meresek[hanyadik];

        //második legmagasabb

        for (int i = 0; i < meresek.Length; i++)
        {
            if (meresek[i] > meresek[hanyadik] && meresek[i] < legmagasabb)
            {
                hanyadik = i;
            }
        }
        Console.WriteLine("Második legmagasabb: " + (hanyadik + 1));

        int osszeg = 0;
        double atlag = 0;
        for (int i = 0; i < meresek.Length; i++)
        {
            osszeg += meresek[i];
        }
        atlag = osszeg / (double)meresek.Length;
        Console.WriteLine("Az átlag: " + atlag + " m");

        bool jart = false;
        int felszinErtek = 1000;
        for (int i = 0; i < meresek.Length; i++)
        {
            if (meresek[i] > felszinErtek)
            {
                jart = true;
                
            }
        }
        if (jart)
        {
            Console.WriteLine("Járt " + felszinErtek + " méter felett");
        }
        else
        {
            Console.WriteLine("Nem járt " + felszinErtek + " méter felett");
        }

        int db = 0;
        for (int i = 0; i < meresek.Length; i++)
        {
            if (meresek[i] > 600 & meresek[i] < 650)
            {
                db++;
            }
        }
        Console.WriteLine(db + " alkalommal járt 600 és 650 méter között.");

        osszeg = 0;
        db = 0;
        for(int i = 0; i < meresek.Length; i++)
        {
            if (meresek[i] > legalacsonyabb && meresek[i] < legmagasabb)
            {
                osszeg += meresek[i];
                db++;
            }
        }
        atlag = (double)osszeg / db;

        Console.WriteLine("Az átlagos magasság a legalacsonyabb és a legmagasabb pont között: " + atlag + " m");


        //8. feladat

        int lejto = 0;
        int eleje = 0;
        for(int i = 0; i < meresek.Length-1;i++)
        {
            if (meresek[i+1] - meresek[i] < lejto)
            {
                eleje = i;
                lejto = meresek[i+1] - meresek[i];
            }
        }
        //Console.WriteLine(lejto);
        Console.WriteLine(eleje + ". és " + (eleje+1) + ". mérés között volt a legmeredekebb lejtő");

        //9. feladat

        int emelkedo = 0;
        eleje = 0;
        for (int i = 0; i < meresek.Length - 1; i++)
        {
            if (meresek[i + 1] - meresek[i] > emelkedo)
            {
                eleje = i;
                emelkedo = meresek[i + 1] - meresek[i];
            }
        }
        Console.WriteLine(emelkedo);
        Console.WriteLine(eleje + ". és " + (eleje + 1) + ". mérés között volt a legmeredekebb emelkedő");

        //10. és 11. feladat

        int jartFennsik = 0;
        for(int i = 0;i < meresek.Length -1;i++)
        {
            if (Math.Abs(meresek[i+1] - meresek[i]) < 5 && meresek[i] > 600)
            {
                jartFennsik++;
            }
        }
        if(jartFennsik > 0)
        {
            Console.WriteLine("Járt fennsíkon.");
        }
        else
        {
            Console.WriteLine("Nem járt fennsíkon.");
        }

        Console.WriteLine(jartFennsik + " alkalommal járt fennsíkon.");

        //12. feladat

        int szintkulonbseg = 0;
        for (int i = 0; i < meresek.Length - 1; i++)
        {
            szintkulonbseg += Math.Abs(meresek[i + 1] - meresek[i]);

        }
        Console.WriteLine("A teljes megtett szintkülönbség: " + szintkulonbseg);
    }
}