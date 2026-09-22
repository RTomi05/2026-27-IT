namespace magassagosUristen
{
    internal class Program
    {
        static void Main(string[] args)
        {

            //1. feladat
            int[] magassagok = { 159, 162, 163, 165, 166, 168, 169, 170, 172, 174, 175, 178, 182, 185, 186 };

            bool rendezett = true;
            for (int i = 1; i < magassagok.Length; i++)
            {
                if (magassagok[i] < magassagok[i - 1])
                {
                    rendezett = false;
                    break;
                }
            }
            Console.WriteLine("Magasság szerint vannak rendezve? " + (rendezett ? "IGEN" : "NEM"));

            //2. feladat
            Array.Sort(magassagok, (a, b) => b.CompareTo(a));

            //3. feladat
            //Visszarendezem
            Array.Sort(magassagok);
            int kulonbseg = magassagok[magassagok.Length - 1] - magassagok[0];
            Console.WriteLine("A különség a legmagasabb és a legalacsonyabb diák között: " + kulonbseg + " cm");

            //4. feladat
            bool vanEgyforma = false;
            for (int i = 1; i < magassagok.Length; i++)
            {
                if (magassagok[i] == magassagok[i - 1])
                {
                    vanEgyforma = true;
                    break;
                }
            }
            Console.WriteLine("Van két egyforma magasságú diák az osztályban? " + (vanEgyforma ? "IGEN" : "NEM"));

            //5. feladat
            for (int j = 150; j <= 200; j++)
            {
                int db = 0;
                for (int i = 0; i < magassagok.Length; i++)
                {
                    if (magassagok[i] == j)
                    {
                        db++;
                    }
                }
                Console.WriteLine(j + " cm: " + db);
            }
        }
    }
}
