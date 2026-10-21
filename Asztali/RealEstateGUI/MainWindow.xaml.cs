using System;
using System.Data;
using System.Windows;
using MySql.Data.MySqlClient;

namespace RealEstateGUI
{
    public partial class MainWindow : Window
    {
        string connStr = "server=localhost;database=ingatlan;user=root;password=";

        public MainWindow()
        {
            InitializeComponent();

            // SQL átnevezések (AS Id, AS Name, AS Phone) a XAML-ben megadott nevekhez igazítva
            MySqlDataAdapter da = new MySqlDataAdapter("SELECT id AS Id, name AS Name, phone AS Phone FROM sellers ORDER BY name", connStr);
            DataTable dt = new DataTable();
            da.Fill(dt);

            lbSellers.ItemsSource = dt.DefaultView;
        }

        private void btnLoadAds_Click(object sender, RoutedEventArgs e)
        {
            if (lbSellers.SelectedItem == null) return;

            DataRowView sor = (DataRowView)lbSellers.SelectedItem;
            int sellerId = Convert.ToInt32(sor["Id"]);

            MySqlDataAdapter da = new MySqlDataAdapter($"SELECT COUNT(*) FROM realestates WHERE sellerId = {sellerId}", connStr);
            DataTable dt = new DataTable();
            da.Fill(dt);

            tbAdCount.Text = dt.Rows[0][0].ToString();
        }
    }
}