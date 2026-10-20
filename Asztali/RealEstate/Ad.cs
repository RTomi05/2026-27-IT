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

        public static List<Ad> LoadFromCsv(string fileName)
        {
            List<Ad> lista = new List<Ad>();
            string[] lines = File.ReadAllLines(fileName, Encoding.UTF8);

            for (int i = 1; i < lines.Length; i++)
            {
                if (string.IsNullOrWhiteSpace(lines[i])) continue;

                string[] parts = lines[i].Split(';');

                int id = int.Parse(parts[0]);
                int rooms = int.Parse(parts[1]);
                string latLong = parts[2];
                int floors = int.Parse(parts[3]);
                int area = int.Parse(parts[4]);
                string description = parts[5];
                bool freeOfCharge = parts[6] == "1";
                string imageUrl = parts[7];
                DateTime createAt = DateTime.Parse(parts[8]);

                int sellerId = int.Parse(parts[9]);
                string sellerName = parts[10];
                string sellerPhone = parts[11];
                Seller seller = new Seller(sellerId, sellerName, sellerPhone);

                int categoryId = int.Parse(parts[12]);
                string categoryName = parts[13];
                Category category = new Category(categoryId, categoryName);

                Ad ad = new Ad(id, rooms, latLong, floors, area, description, freeOfCharge, imageUrl, createAt, seller, category);
                lista.Add(ad);
            }

            return lista;
        }

        public double DistanceTo(double targetLat, double targetLong)
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