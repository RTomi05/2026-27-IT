using System;
using System.Collections.Generic;
using System.Windows;
using System.Windows.Input;
using System.Windows.Media.Animation;

namespace WWE_Control_Room
{
    // Adatmodell az emberekhez / wrestlingerekhez
    public class Player
    {
        public string Rank { get; set; }
        public string Name { get; set; }
        public string Score { get; set; }
    }

    public partial class MainWindow : Window
    {
        private bool isAnimating = false;

        // Lista a táblázat adatainak
        public List<Player> PlayersList { get; set; } = new List<Player>
        {
            new Player { Rank = "#1", Name = "Roman Reigns", Score = "98 PTS" },
            new Player { Rank = "#2", Name = "Cody Rhodes", Score = "96 PTS" },
            new Player { Rank = "#3", Name = "Seth Rollins", Score = "93 PTS" },
            new Player { Rank = "#4", Name = "CM Punk", Score = "93 PTS" },
            new Player { Rank = "#5", Name = "Rhea Ripley", Score = "93 PTS" }
        };

        public MainWindow()
        {
            InitializeComponent();
        }

        private void Window_Loaded(object sender, RoutedEventArgs e)
        {
            Box1.Focus();
            Mouse.OverrideCursor = Cursors.None;
            BgVideo.Play();

            // DataGrid feltöltése az adatokkal
            PlayerGrid.ItemsSource = PlayersList;
        }

        private void BgVideo_MediaOpened(object sender, RoutedEventArgs e)
        {
            BgVideo.Position = TimeSpan.FromSeconds(3);
            BgVideo.Play();
        }

        private void BgVideo_MediaEnded(object sender, RoutedEventArgs e)
        {
            BgVideo.Position = TimeSpan.FromSeconds(3);
            BgVideo.Play();
        }

        private void Window_PreviewKeyDown(object sender, KeyEventArgs e)
        {
            if (isAnimating) return;

            // 1. KILÉPŐ ABLAK NYITVA
            if (ExitDialog.Visibility == Visibility.Visible)
            {
                if (e.Key == Key.Enter)
                {
                    Application.Current.Shutdown();
                    e.Handled = true;
                }
                else if (e.Key == Key.Escape)
                {
                    ExitDialog.Visibility = Visibility.Collapsed;
                    e.Handled = true;
                }
                return;
            }

            // 2. HA A DATAGRID TÁBLÁZAT LÁTSZIK
            if (TableViewGrid.Visibility == Visibility.Visible)
            {
                // ESC -> Vissza a főmenübe
                if (e.Key == Key.Escape)
                {
                    isAnimating = true;
                    TableViewGrid.Visibility = Visibility.Collapsed;
                    FieldsGrid.Visibility = Visibility.Visible;

                    var showFieldsAnim = (Storyboard)FindResource("ShowFieldsStoryboard");
                    showFieldsAnim.Completed += (s, ev) =>
                    {
                        Box1.Focus();
                        isAnimating = false;
                    };
                    showFieldsAnim.Begin();

                    e.Handled = true;
                    return;
                }

                // ENTER -> Kiválasztott ember feldolgozása
                if (e.Key == Key.Enter)
                {
                    if (PlayerGrid.SelectedItem is Player selectedPlayer)
                    {
                        MessageBox.Show($"Kiválasztva: {selectedPlayer.Name} (Rang: {selectedPlayer.Rank}, Értékelés: {selectedPlayer.Score})");
                    }
                    e.Handled = true;
                    return;
                }

                // W és S gombok kezelése a DataGrid léptetéséhez (a nyilak alapból működnek)
                if (e.Key == Key.W)
                {
                    if (PlayerGrid.SelectedIndex > 0)
                        PlayerGrid.SelectedIndex--;
                    e.Handled = true;
                    return;
                }
                else if (e.Key == Key.S)
                {
                    if (PlayerGrid.SelectedIndex < PlayerGrid.Items.Count - 1)
                        PlayerGrid.SelectedIndex++;
                    e.Handled = true;
                    return;
                }

                return;
            }

            // 3. MAIN MENU ESC (Kilépő ablak)
            if (e.Key == Key.Escape)
            {
                ExitDialog.Visibility = Visibility.Visible;
                e.Handled = true;
                return;
            }

            // 4. MAIN MENU ENTER A MEZŐ 1-EN
            if (e.Key == Key.Enter && FieldsGrid.Visibility == Visibility.Visible)
            {
                if (Keyboard.FocusedElement == Box2)
                {
                    isAnimating = true;

                    var hideAnimation = (Storyboard)FindResource("HideFieldsStoryboard");
                    hideAnimation.Completed += (s, ev) =>
                    {
                        FieldsGrid.Visibility = Visibility.Collapsed;
                        TableViewGrid.Visibility = Visibility.Visible;

                        var showTableAnim = (Storyboard)FindResource("ShowTableStoryboard");
                        showTableAnim.Completed += (s2, ev2) =>
                        {
                            isAnimating = false;

                            // Fókusz a DataGrid-re, és kijelöljük az első elemet
                            PlayerGrid.Focus();
                            PlayerGrid.SelectedIndex = 0;
                        };
                        showTableAnim.Begin();
                    };

                    hideAnimation.Begin();
                    e.Handled = true;
                    return;
                }
            }

            // 5. WASD NAVIGÁCIÓ A FŐMENÜ MEZŐI KÖZÖTT
            FocusNavigationDirection? direction = e.Key switch
            {
                Key.W => FocusNavigationDirection.Up,
                Key.S => FocusNavigationDirection.Down,
                Key.A => FocusNavigationDirection.Left,
                Key.D => FocusNavigationDirection.Right,
                _ => null
            };

            if (direction.HasValue)
            {
                if (Keyboard.FocusedElement is UIElement currentElement)
                {
                    currentElement.MoveFocus(new TraversalRequest(direction.Value));
                    e.Handled = true;
                }
            }
        }
    }
}