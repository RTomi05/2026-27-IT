using System.Collections.Generic;
using System.Linq;
using System.Windows;
using RealEstate;

namespace RealEstateGUI
{
    public partial class MainWindow : Window
    {
        List<Ad> hirdetesek = new List<Ad>();

        public MainWindow()
        {
            InitializeComponent();

            hirdetesek = Ad.LoadFromCsv("realestates.csv");

            // A helyi változó neve eladoLista lett, így a C# tudja, 
            // hogy az 'eladok' a XAML-ben lévő ListBox-ra vonatkozik:
            List<Seller> eladoLista = hirdetesek
                .Select(a => a.Seller)
                .GroupBy(s => s.Id)
                .Select(g => g.First())
                .OrderBy(s => s.Name)
                .ToList();

            eladok.ItemsSource = eladoLista;
        }

        private void betoltes_Click(object sender, RoutedEventArgs e)
        {
            if (eladok.SelectedItem == null) return;

            Seller kivalasztott = (Seller)eladok.SelectedItem;

            int db = hirdetesek.Count(a => a.Seller.Id == kivalasztott.Id);

            tbAdCount.Text = db.ToString();
        }
    }
}