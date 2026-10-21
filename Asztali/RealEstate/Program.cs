using System;
using System.Collections.Generic;
using System.Linq;

namespace RealEstate
{
    class Program
    {
        static void Main(string[] args)
        {
            List<Ad> ads = Ad.LoadFromCsv("realestates.csv");

            double atlagTerulet = ads.Where(a => a.Floors == 0).Average(a => a.Area);
            Console.WriteLine($"1. Földszinti ingatlanok átlagos alapterülete: {atlagTerulet:0.00} m2");
            
            //8. feladat
            double ovodaLat = 47.4164220114023;
            double ovodaLong = 19.066342425796986;

            Ad tehermentes = ads
                .Where(a => a.FreeOfCharge)
                .OrderBy(a => a.Tavolsag(ovodaLat, ovodaLong))
                .FirstOrDefault();

            if (tehermentes != null)
            {
                Console.WriteLine("2. Mesevár óvodához légvonalban legközelebbi tehermentes ingatlan adatai:");
                Console.WriteLine($"        Eladó neve     : {tehermentes.Seller.Name}");
                Console.WriteLine($"        Eladó telefonja: {tehermentes.Seller.Phone}");
                Console.WriteLine($"        Alapterület    : {tehermentes.Area}");
                Console.WriteLine($"        Szobák száma   : {tehermentes.Rooms}");
            }
        }
    }
}