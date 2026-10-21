using System;
using System.Collections.Generic;
using System.Globalization;
using System.IO;
using System.Text;

namespace RealEstate
{
    public class Ad
    {
        public int Id { get; set; }
        public int Rooms { get; set; }
        public string LatLong { get; set; }
        public int Floors { get; set; }
        public int Area { get; set; }
        public string Description { get; set; }
        public bool FreeOfCharge { get; set; }
        public string ImageUrl { get; set; }
        public DateTime CreateAt { get; set; }
        public Seller Seller { get; set; }
        public Category Category { get; set; }

        public Ad() { }

        public Ad(int id, int rooms, string latLong, int floors, int area, string description,
                  bool freeOfCharge, string imageUrl, DateTime createAt, Seller seller, Category category)
        {
            Id = id;
            Rooms = rooms;
            LatLong = latLong;
            Floors = floors;
            Area = area;
            Description = description;
            FreeOfCharge = freeOfCharge;
            ImageUrl = imageUrl;
            CreateAt = createAt;
            Seller = seller;
            Category = category;
        }

        public static List<Ad> LoadFromCsv(string fajlnev)
        {
            List<Ad> lista = new List<Ad>();
            string[] sorok = File.ReadAllLines(fajlnev, Encoding.UTF8);

            for (int i = 1; i < sorok.Length; i++)
            {
                if (string.IsNullOrWhiteSpace(sorok[i])) continue;

                string[] darabol = sorok[i].Split(';');

                int id = int.Parse(darabol[0]);
                int rooms = int.Parse(darabol[1]);
                string latLong = darabol[2];
                int floors = int.Parse(darabol[3]);
                int area = int.Parse(darabol[4]);
                string description = darabol[5];
                bool freeOfCharge = darabol[6] == "1";
                string imageUrl = darabol[7];
                DateTime createAt = DateTime.Parse(darabol[8]);

                int sellerId = int.Parse(darabol[9]);
                string sellerName = darabol[10];
                string sellerPhone = darabol[11];
                Seller seller = new Seller(sellerId, sellerName, sellerPhone);

                int categoryId = int.Parse(darabol[12]);
                string categoryNev = darabol[13];
                Category category = new Category(categoryId, categoryNev);

                Ad ad = new Ad(id, rooms, latLong, floors, area, description, freeOfCharge, imageUrl, createAt, seller, category);
                lista.Add(ad);
            }

            return lista;
        }

        public double Tavolsag(double targetLat, double targetLong)
        {
            string[] coords = LatLong.Split(',');
            double lat = double.Parse(coords[0], CultureInfo.InvariantCulture);
            double lon = double.Parse(coords[1], CultureInfo.InvariantCulture);

            double dLat = lat - targetLat;
            double dLon = lon - targetLong;

            return Math.Sqrt(dLat * dLat + dLon * dLon);
        }
    }
}