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

    }
}