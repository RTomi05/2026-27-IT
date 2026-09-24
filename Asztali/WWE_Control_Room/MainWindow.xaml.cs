using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Reflection;
using System.Runtime.InteropServices; // Win32 DLL Import a memória felszabadításához
using System.Windows;
using System.Windows.Controls;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Animation;
using System.Windows.Media.Imaging;

namespace WWE_Control_Room
{
    public class Player
    {
        public string Rank { get; set; }
        public string Name { get; set; }
        public string Score { get; set; }
    }

    public enum MainMenuPosition
    {
        Box1_Calendar, // Bal felső
        Box2_Roster,   // Jobb felső
        Box3_BookShow, // Bal alsó
        Box4_Options   // Jobb alsó
    }

    public enum BookShowControl
    {
        EventType,
        Player1,
        Player2,
        BookButton
    }

    public partial class MainWindow : Window
    {
        #region Memory Optimization Helpers

        [DllImport("kernel32.dll")]
        private static extern bool SetProcessWorkingSetSize(IntPtr proc, IntPtr min, IntPtr max);

        /// <summary>
        /// Kényszerített Garbage Collection és az elpazarolt OS Working Set memória felszabadítása.
        /// </summary>
        public static void FlushMemory()
        {
            GC.Collect();
            GC.WaitForPendingFinalizers();
            GC.Collect();

            if (Environment.OSVersion.Platform == PlatformID.Win32NT)
            {
                SetProcessWorkingSetSize(System.Diagnostics.Process.GetCurrentProcess().Handle, -1, -1);
            }
        }

        /// <summary>
        /// Képek optimalizált betöltése: Dekódolás csak a kívánt szélességre (DecodePixelWidth) + Freeze() a RAM spóroláshoz.
        /// </summary>
        private ImageBrush LoadOptimizedBrush(string relativePath, int decodeWidth = 350)
        {
            try
            {
                var bitmap = new BitmapImage();
                bitmap.BeginInit();
                bitmap.UriSource = new Uri(relativePath, UriKind.RelativeOrAbsolute);
                bitmap.DecodePixelWidth = decodeWidth;
                bitmap.CacheOption = BitmapCacheOption.OnLoad;
                bitmap.EndInit();
                bitmap.Freeze();

                return new ImageBrush(bitmap) { Stretch = Stretch.UniformToFill };
            }
            catch
            {
                return null;
            }
        }

        #endregion

        private bool isAnimating = false;

        private MainMenuPosition currentMenuPos = MainMenuPosition.Box1_Calendar;
        private BookShowControl currentBookControl = BookShowControl.EventType;

        // 0 = Menüből nyitott Roster, 1 = Red Corner kiválasztás, 2 = Blue Corner kiválasztás
        private int targetPlayerSlot = 0;

        public List<Player> PlayersList { get; set; } = new List<Player>();

        public MainWindow()
        {
            InitializeComponent();
        }

        private void Window_Loaded(object sender, RoutedEventArgs e)
        {
            SetMenuFocus(MainMenuPosition.Box1_Calendar);
            //Mouse.OverrideCursor = Cursors.None;
            BgVideo.Play();

            // Egér dupla kattintás esemény hozzáadása a Roster rácshoz
            PlayerGrid.MouseDoubleClick += PlayerGrid_MouseDoubleClick;

            PlayersList = LoadPlayersFromFile("roster.txt");

            // Pontszám szerinti csökkenő rendezés + rangok frissítése a betöltéskor
            SortPlayersByScore();

            PlayerGrid.ItemsSource = PlayersList;
            Player1Combo.ItemsSource = PlayersList;
            Player2Combo.ItemsSource = PlayersList;

            if (PlayersList.Count >= 2)
            {
                Player1Combo.SelectedIndex = 0;
                Player2Combo.SelectedIndex = 1;
            }

            // Betöltés utáni memóriatakarítás
            FlushMemory();
        }

        #region Focus Helpers

        private void SetMenuFocus(MainMenuPosition pos)
        {
            currentMenuPos = pos;
            switch (pos)
            {
                case MainMenuPosition.Box1_Calendar: Box1.Focus(); break;
                case MainMenuPosition.Box2_Roster: Box2.Focus(); break;
                case MainMenuPosition.Box3_BookShow: Box3.Focus(); break;
                case MainMenuPosition.Box4_Options: Box4.Focus(); break;
            }
        }

        private void SetBookShowFocus(BookShowControl control)
        {
            currentBookControl = control;
            switch (control)
            {
                case BookShowControl.EventType: EventTypeCombo.Focus(); break;
                case BookShowControl.Player1: Player1Combo.Focus(); break;
                case BookShowControl.Player2: Player2Combo.Focus(); break;
                case BookShowControl.BookButton: BookButton.Focus(); break;
            }
        }

        #endregion

        #region File, Video & Roster Edit Logic

        private List<Player> LoadPlayersFromFile(string filePath)
        {
            var list = new List<Player>();
            if (!File.Exists(filePath)) return list;

            try
            {
                foreach (var line in File.ReadAllLines(filePath))
                {
                    if (string.IsNullOrWhiteSpace(line) || line.StartsWith("//")) continue;
                    var parts = line.Split(';');
                    if (parts.Length >= 3)
                    {
                        list.Add(new Player
                        {
                            Rank = parts[0].Trim(),
                            Name = parts[1].Trim(),
                            Score = parts[2].Trim()
                        });
                    }
                }
            }
            catch { }
            return list;
        }

        private void SortPlayersByScore()
        {
            if (PlayersList == null || PlayersList.Count == 0) return;

            PlayersList.Sort((p1, p2) =>
            {
                double score1 = double.TryParse(p1?.Score, out double s1) ? s1 : 0;
                double score2 = double.TryParse(p2?.Score, out double s2) ? s2 : 0;

                int scoreComparison = score2.CompareTo(score1);
                if (scoreComparison != 0) return scoreComparison;

                int rank1 = int.TryParse(p1?.Rank, out int r1) ? r1 : int.MaxValue;
                int rank2 = int.TryParse(p2?.Rank, out int r2) ? r2 : int.MaxValue;

                return rank1.CompareTo(rank2);
            });

            for (int i = 0; i < PlayersList.Count; i++)
            {
                PlayersList[i].Rank = (i + 1).ToString();
            }
        }

        private void SavePlayersToFile(string filePath, List<Player> players)
        {
            try
            {
                var lines = new List<string>();
                foreach (var player in players)
                {
                    lines.Add($"{player.Rank};{player.Name};{player.Score}");
                }
                File.WriteAllLines(filePath, lines);
            }
            catch (Exception ex)
            {
                MessageBox.Show($"Hiba a fájl mentése során: {ex.Message}", "Mentési hiba", MessageBoxButton.OK, MessageBoxImage.Error);
            }
        }

        private void EditPlayerScore(Player player)
        {
            if (player == null) return;

            string newScore = ShowInputDialog($"Pontszám módosítása: {player.Name}", "Új pontszám (Score):", player.Score);

            if (!string.IsNullOrWhiteSpace(newScore) && newScore != player.Score)
            {
                player.Score = newScore.Trim();
                SortPlayersByScore();

                PlayerGrid.Items.Refresh();
                Player1Combo.Items.Refresh();
                Player2Combo.Items.Refresh();

                PlayerGrid.SelectedItem = player;
                PlayerGrid.ScrollIntoView(player);

                SavePlayersToFile("roster.txt", PlayersList);
            }
        }

        private string ShowInputDialog(string title, string promptText, string defaultValue = "")
        {
            Window inputWindow = new Window
            {
                Width = 380,
                Height = 180,
                Title = title,
                WindowStartupLocation = WindowStartupLocation.CenterOwner,
                Owner = this,
                ResizeMode = ResizeMode.NoResize,
                Background = new SolidColorBrush(Color.FromRgb(30, 30, 30)),
                Foreground = Brushes.White
            };

            StackPanel stack = new StackPanel { Margin = new Thickness(15) };
            TextBlock text = new TextBlock { Text = promptText, Margin = new Thickness(0, 0, 0, 10), Foreground = Brushes.White, FontSize = 14 };
            TextBox input = new TextBox { Text = defaultValue, Margin = new Thickness(0, 0, 0, 15), Padding = new Thickness(5), FontSize = 14 };
            Button okBtn = new Button { Content = "Mentés", IsDefault = true, Width = 90, Height = 30, HorizontalAlignment = HorizontalAlignment.Right };

            okBtn.Click += (s, e) => { inputWindow.DialogResult = true; inputWindow.Close(); };

            stack.Children.Add(text);
            stack.Children.Add(input);
            stack.Children.Add(okBtn);
            inputWindow.Content = stack;

            input.Focus();
            input.SelectAll();

            return inputWindow.ShowDialog() == true ? input.Text : null;
        }

        /// <summary>
        /// Universalitást biztosító szövegkiolvasó tetszőleges UI elemből.
        /// </summary>
        private string GetItemText(object item)
        {
            if (item == null) return string.Empty;

            if (item is ComboBoxItem cbi)
            {
                if (cbi.Content is TextBlock tb) return tb.Text;
                if (cbi.Content != null) return cbi.Content.ToString();
            }
            if (item is TextBlock textBlock) return textBlock.Text;
            if (item is ContentControl cc && cc.Content != null) return cc.Content.ToString();

            return item.ToString();
        }

        /// <summary>
        /// Kiolvassa az EventTypeCombo-ból a jelenlegi szöveges értéket.
        /// </summary>
        private string GetCurrentEventType()
        {
            if (EventTypeCombo == null) return "Match";

            if (EventTypeCombo is ComboBox combo)
            {
                if (combo.SelectedItem != null)
                {
                    string txt = GetItemText(combo.SelectedItem);
                    if (!string.IsNullOrWhiteSpace(txt)) return txt;
                }
                if (!string.IsNullOrWhiteSpace(combo.Text)) return combo.Text;
            }

            return GetItemText(EventTypeCombo);
        }

        /// <summary>
        /// Garantált és átfogó értékfrissítés a felületen megjelenő Esemény Típus mezőre.
        /// </summary>
        private void SetEventType(string typeName)
        {
            if (EventTypeCombo == null) return;

            string targetUpper = typeName.ToUpper().Trim();

            // 1. Ha az EventTypeCombo egy ComboBox
            if (EventTypeCombo is ComboBox combo)
            {
                if (combo.Items.Count == 0 && combo.ItemsSource == null)
                {
                    combo.Items.Add(new ComboBoxItem { Content = "MATCH" });
                    combo.Items.Add(new ComboBoxItem { Content = "PROMO" });
                }

                int matchIndex = -1;

                for (int i = 0; i < combo.Items.Count; i++)
                {
                    string itemText = GetItemText(combo.Items[i]);
                    if (string.Equals(itemText, targetUpper, StringComparison.OrdinalIgnoreCase))
                    {
                        matchIndex = i;
                        break;
                    }
                }

                if (matchIndex == -1)
                {
                    if (targetUpper == "PROMO" && combo.Items.Count > 1) matchIndex = 1;
                    else if (combo.Items.Count > 0) matchIndex = 0;
                }

                if (matchIndex != -1)
                {
                    combo.SelectedIndex = matchIndex;
                    combo.SelectedItem = combo.Items[matchIndex];

                    if (combo.Items[matchIndex] is ComboBoxItem cbi)
                    {
                        cbi.IsSelected = true;
                        if (cbi.Content is TextBlock tb) tb.Text = targetUpper;
                        else if (cbi.Content is string) cbi.Content = targetUpper;
                    }
                }

                try { combo.Text = targetUpper; } catch { }
            }

            // 2. Reflexióval frissítjük a Text vagy Content tulajdonságot is (ha a mező egy TextBlock, Label vagy Button)
            try
            {
                var textProp = EventTypeCombo.GetType().GetProperty("Text");
                if (textProp != null && textProp.CanWrite) textProp.SetValue(EventTypeCombo, targetUpper);

                var contentProp = EventTypeCombo.GetType().GetProperty("Content");
                if (contentProp != null && contentProp.CanWrite) contentProp.SetValue(EventTypeCombo, targetUpper);
            }
            catch { }

            // 3. Vizuális elrendezés és újrarajzolás kikényszerítése
            EventTypeCombo.InvalidateVisual();
            EventTypeCombo.UpdateLayout();
        }

        /// <summary>
        /// Dinamikus dizájnolt párbeszédablak az Esemény Típus kiválasztásához.
        /// </summary>
        private void ShowEventTypeSelectionDialog()
        {
            string currentType = GetCurrentEventType();

            Window selectWindow = new Window
            {
                Width = 460,
                Height = 220,
                Title = "Esemény Típus Kiválasztása",
                WindowStartupLocation = WindowStartupLocation.CenterOwner,
                Owner = this,
                ResizeMode = ResizeMode.NoResize,
                Background = new SolidColorBrush(Color.FromRgb(20, 20, 20)),
                Foreground = Brushes.White,
                WindowStyle = WindowStyle.ToolWindow
            };

            StackPanel mainPanel = new StackPanel
            {
                Margin = new Thickness(20),
                VerticalAlignment = VerticalAlignment.Center
            };

            TextBlock headerText = new TextBlock
            {
                Text = "VÁLASSZ ESEMÉNY TÍPUST",
                FontSize = 16,
                FontWeight = FontWeights.Bold,
                Foreground = new SolidColorBrush(Color.FromRgb(220, 220, 220)),
                HorizontalAlignment = HorizontalAlignment.Center,
                Margin = new Thickness(0, 0, 0, 20)
            };

            Grid grid = new Grid();
            grid.ColumnDefinitions.Add(new ColumnDefinition { Width = new GridLength(1, GridUnitType.Star) });
            grid.ColumnDefinitions.Add(new ColumnDefinition { Width = new GridLength(1, GridUnitType.Star) });

            Button matchBtn = new Button
            {
                Content = "MATCH",
                Height = 70,
                Margin = new Thickness(8),
                FontSize = 18,
                FontWeight = FontWeights.Bold,
                Foreground = Brushes.White,
                Cursor = Cursors.Hand
            };

            Button promoBtn = new Button
            {
                Content = "PROMO",
                Height = 70,
                Margin = new Thickness(8),
                FontSize = 18,
                FontWeight = FontWeights.Bold,
                Foreground = Brushes.White,
                Cursor = Cursors.Hand
            };

            Grid.SetColumn(matchBtn, 0);
            Grid.SetColumn(promoBtn, 1);

            grid.Children.Add(matchBtn);
            grid.Children.Add(promoBtn);

            mainPanel.Children.Add(headerText);
            mainPanel.Children.Add(grid);
            selectWindow.Content = mainPanel;

            void UpdateButtonVisuals()
            {
                if (matchBtn.IsFocused)
                {
                    matchBtn.BorderBrush = Brushes.Gold;
                    matchBtn.BorderThickness = new Thickness(4);
                    matchBtn.Background = new SolidColorBrush(Color.FromRgb(200, 40, 40));
                }
                else
                {
                    bool isSelected = currentType.Equals("Match", StringComparison.OrdinalIgnoreCase);
                    matchBtn.BorderBrush = isSelected ? Brushes.Red : Brushes.DarkGray;
                    matchBtn.BorderThickness = isSelected ? new Thickness(2) : new Thickness(1);
                    matchBtn.Background = new SolidColorBrush(Color.FromRgb(120, 30, 30));
                }

                if (promoBtn.IsFocused)
                {
                    promoBtn.BorderBrush = Brushes.Gold;
                    promoBtn.BorderThickness = new Thickness(4);
                    promoBtn.Background = new SolidColorBrush(Color.FromRgb(40, 120, 220));
                }
                else
                {
                    bool isSelected = currentType.Equals("Promo", StringComparison.OrdinalIgnoreCase);
                    promoBtn.BorderBrush = isSelected ? Brushes.DodgerBlue : Brushes.DarkGray;
                    promoBtn.BorderThickness = isSelected ? new Thickness(2) : new Thickness(1);
                    promoBtn.Background = new SolidColorBrush(Color.FromRgb(20, 70, 130));
                }
            }

            matchBtn.GotFocus += (s, e) => UpdateButtonVisuals();
            matchBtn.LostFocus += (s, e) => UpdateButtonVisuals();
            promoBtn.GotFocus += (s, e) => UpdateButtonVisuals();
            promoBtn.LostFocus += (s, e) => UpdateButtonVisuals();

            void ApplyChoiceAndClose(string type)
            {
                SetEventType(type);
                selectWindow.DialogResult = true;
                selectWindow.Close();
            }

            matchBtn.Click += (s, e) => ApplyChoiceAndClose("Match");
            promoBtn.Click += (s, e) => ApplyChoiceAndClose("Promo");

            selectWindow.PreviewKeyDown += (s, e) =>
            {
                if (e.Key == Key.Escape)
                {
                    e.Handled = true;
                    selectWindow.Close();
                }
                else if (e.Key == Key.Left || e.Key == Key.A)
                {
                    e.Handled = true;
                    matchBtn.Focus();
                }
                else if (e.Key == Key.Right || e.Key == Key.D)
                {
                    e.Handled = true;
                    promoBtn.Focus();
                }
                else if (e.Key == Key.Enter)
                {
                    e.Handled = true;
                    if (matchBtn.IsFocused)
                    {
                        ApplyChoiceAndClose("Match");
                    }
                    else if (promoBtn.IsFocused)
                    {
                        ApplyChoiceAndClose("Promo");
                    }
                }
            };

            selectWindow.Loaded += (s, e) =>
            {
                if (currentType.Equals("Promo", StringComparison.OrdinalIgnoreCase))
                {
                    promoBtn.Focus();
                }
                else
                {
                    matchBtn.Focus();
                }
                UpdateButtonVisuals();
            };

            selectWindow.ShowDialog();
        }

        private void PlayerGrid_MouseDoubleClick(object sender, MouseButtonEventArgs e)
        {
            if (PlayerGrid.SelectedItem is Player selectedPlayer)
            {
                if (targetPlayerSlot == 0)
                {
                    EditPlayerScore(selectedPlayer);
                }
                else
                {
                    ConfirmRosterSelection();
                }
            }
        }

        private void BgVideo_MediaOpened(object sender, RoutedEventArgs e) => ResetVideo();
        private void BgVideo_MediaEnded(object sender, RoutedEventArgs e) => ResetVideo();

        private void ResetVideo()
        {
            BgVideo.Position = TimeSpan.FromSeconds(3);
            BgVideo.Play();
        }

        #endregion

        #region Safe Animation Helper

        private void PlayStoryboard(string resourceName, Action onCompleted)
        {
            isAnimating = true;
            var anim = (Storyboard)FindResource(resourceName);

            EventHandler handler = null;
            handler = (s, e) =>
            {
                anim.Completed -= handler;
                isAnimating = false;
                onCompleted?.Invoke();
            };

            anim.Completed += handler;
            anim.Begin();
        }

        #endregion

        #region Central Key Router

        private void Window_PreviewKeyDown(object sender, KeyEventArgs e)
        {
            if (isAnimating) return;

            if (ExitDialog.Visibility == Visibility.Visible)
            {
                HandleExitDialogKeys(e);
                return;
            }

            if (BookShowGrid.Visibility == Visibility.Visible)
            {
                HandleBookShowKeys(e);
                return;
            }

            if (TableViewGrid.Visibility == Visibility.Visible)
            {
                HandleRosterKeys(e);
                return;
            }

            if (FieldsGrid.Visibility == Visibility.Visible)
            {
                HandleMainMenuKeys(e);
                return;
            }
        }

        #endregion

        #region Screen Key Handlers

        private void HandleExitDialogKeys(KeyEventArgs e)
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
        }

        private void HandleMainMenuKeys(KeyEventArgs e)
        {
            if (e.Key == Key.Escape)
            {
                ExitDialog.Visibility = Visibility.Visible;
                e.Handled = true;
                return;
            }

            switch (e.Key)
            {
                case Key.W:
                case Key.Up:
                    if (currentMenuPos == MainMenuPosition.Box3_BookShow) SetMenuFocus(MainMenuPosition.Box1_Calendar);
                    else if (currentMenuPos == MainMenuPosition.Box4_Options) SetMenuFocus(MainMenuPosition.Box2_Roster);
                    e.Handled = true;
                    return;

                case Key.S:
                case Key.Down:
                    if (currentMenuPos == MainMenuPosition.Box1_Calendar) SetMenuFocus(MainMenuPosition.Box3_BookShow);
                    else if (currentMenuPos == MainMenuPosition.Box2_Roster) SetMenuFocus(MainMenuPosition.Box4_Options);
                    e.Handled = true;
                    return;

                case Key.A:
                case Key.Left:
                    if (currentMenuPos == MainMenuPosition.Box2_Roster) SetMenuFocus(MainMenuPosition.Box1_Calendar);
                    else if (currentMenuPos == MainMenuPosition.Box4_Options) SetMenuFocus(MainMenuPosition.Box3_BookShow);
                    e.Handled = true;
                    return;

                case Key.D:
                case Key.Right:
                    if (currentMenuPos == MainMenuPosition.Box1_Calendar) SetMenuFocus(MainMenuPosition.Box2_Roster);
                    else if (currentMenuPos == MainMenuPosition.Box3_BookShow) SetMenuFocus(MainMenuPosition.Box4_Options);
                    e.Handled = true;
                    return;

                case Key.Enter:
                    if (currentMenuPos == MainMenuPosition.Box2_Roster) OpenRosterScreen();
                    else if (currentMenuPos == MainMenuPosition.Box3_BookShow) OpenBookShowScreen();
                    e.Handled = true;
                    return;
            }
        }

        private void HandleRosterKeys(KeyEventArgs e)
        {
            if (e.Key == Key.Escape)
            {
                CloseRosterScreen();
                e.Handled = true;
                return;
            }

            if (e.Key == Key.Enter)
            {
                if (targetPlayerSlot != 0)
                {
                    ConfirmRosterSelection();
                }
                else
                {
                    if (PlayerGrid.SelectedItem is Player selectedPlayer)
                    {
                        EditPlayerScore(selectedPlayer);
                    }
                }
                e.Handled = true;
                return;
            }

            if (e.Key == Key.W || e.Key == Key.Up)
            {
                if (PlayerGrid.SelectedIndex > 0)
                {
                    PlayerGrid.SelectedIndex--;
                    PlayerGrid.ScrollIntoView(PlayerGrid.SelectedItem);
                }
                e.Handled = true;
            }
            else if (e.Key == Key.S || e.Key == Key.Down)
            {
                if (PlayerGrid.SelectedIndex < PlayerGrid.Items.Count - 1)
                {
                    PlayerGrid.SelectedIndex++;
                    PlayerGrid.ScrollIntoView(PlayerGrid.SelectedItem);
                }
                e.Handled = true;
            }
        }

        private void HandleBookShowKeys(KeyEventArgs e)
        {
            if (MatchDialog.Visibility == Visibility.Visible)
            {
                if (e.Key == Key.Enter || e.Key == Key.Escape)
                {
                    MatchDialog.Visibility = Visibility.Collapsed;
                    e.Handled = true;
                }
                return;
            }

            if (e.Key == Key.Escape)
            {
                CloseBookShowScreen();
                e.Handled = true;
                return;
            }

            // ENTER KEZELÉSE A BOOK A SHOW KÉPERNYŐN
            if (e.Key == Key.Enter)
            {
                if (currentBookControl == BookShowControl.EventType)
                {
                    ShowEventTypeSelectionDialog();
                    e.Handled = true;
                    return;
                }
                else if (currentBookControl == BookShowControl.Player1)
                {
                    OpenRosterForPlayer(1);
                    e.Handled = true;
                    return;
                }
                else if (currentBookControl == BookShowControl.Player2)
                {
                    OpenRosterForPlayer(2);
                    e.Handled = true;
                    return;
                }
                else if (currentBookControl == BookShowControl.BookButton)
                {
                    ExecuteBookMatch();
                    e.Handled = true;
                    return;
                }
            }

            switch (e.Key)
            {
                case Key.W:
                case Key.Up:
                    if (currentBookControl == BookShowControl.Player1 || currentBookControl == BookShowControl.Player2)
                        SetBookShowFocus(BookShowControl.EventType);
                    else if (currentBookControl == BookShowControl.BookButton)
                        SetBookShowFocus(BookShowControl.Player1);
                    e.Handled = true;
                    break;

                case Key.S:
                case Key.Down:
                    if (currentBookControl == BookShowControl.EventType)
                        SetBookShowFocus(BookShowControl.Player1);
                    else if (currentBookControl == BookShowControl.Player1 || currentBookControl == BookShowControl.Player2)
                        SetBookShowFocus(BookShowControl.BookButton);
                    e.Handled = true;
                    break;

                case Key.A:
                case Key.Left:
                    if (currentBookControl == BookShowControl.EventType)
                    {
                        SetEventType("Match");
                    }
                    else if (currentBookControl == BookShowControl.Player2)
                    {
                        SetBookShowFocus(BookShowControl.Player1);
                    }
                    else if (currentBookControl == BookShowControl.Player1)
                    {
                        if (Player1Combo.SelectedIndex > 0) Player1Combo.SelectedIndex--;
                    }
                    e.Handled = true;
                    break;

                case Key.D:
                case Key.Right:
                    if (currentBookControl == BookShowControl.EventType)
                    {
                        SetEventType("Promo");
                    }
                    else if (currentBookControl == BookShowControl.Player1)
                    {
                        SetBookShowFocus(BookShowControl.Player2);
                    }
                    else if (currentBookControl == BookShowControl.Player2)
                    {
                        if (Player2Combo.SelectedIndex < Player2Combo.Items.Count - 1) Player2Combo.SelectedIndex++;
                    }
                    e.Handled = true;
                    break;
            }
        }

        #endregion

        #region Match Logic

        private void ExecuteBookMatch()
        {
            var eventType = GetCurrentEventType();

            var p1 = Player1Combo.SelectedItem as Player;
            var p2 = Player2Combo.SelectedItem as Player;

            string p1Name = p1 != null ? p1.Name : "Player 1";
            string p2Name = p2 != null ? p2.Name : "Player 2";

            if (p1 != null && p2 != null && p1.Name == p2.Name)
            {
                MatchText.Text = "HIBA!\nEgy birkózó nem küzdhet saját maga ellen!";
                MatchDialog.Visibility = Visibility.Visible;
                return;
            }
            else
            {
                MatchText.Text = $"{eventType.ToUpper()}\n\n{p1Name}   VS   {p2Name}";
                MatchDialog.Visibility = Visibility.Visible;
            }
        }

        #endregion

        #region Screen Transitions & Roster Selection

        private void OpenRosterScreen()
        {
            targetPlayerSlot = 0;
            PlayStoryboard("HideFieldsStoryboard", () =>
            {
                FieldsGrid.Visibility = Visibility.Collapsed;
                TableViewGrid.Visibility = Visibility.Visible;

                PlayStoryboard("ShowTableStoryboard", () =>
                {
                    PlayerGrid.Focus();
                    if (PlayerGrid.Items.Count > 0)
                    {
                        PlayerGrid.SelectedIndex = 0;
                        PlayerGrid.ScrollIntoView(PlayerGrid.SelectedItem);
                    }

                    FlushMemory();
                });
            });
        }

        private void OpenRosterForPlayer(int playerSlot)
        {
            targetPlayerSlot = playerSlot;
            BookShowGrid.Visibility = Visibility.Collapsed;
            TableViewGrid.Visibility = Visibility.Visible;

            PlayStoryboard("ShowTableStoryboard", () =>
            {
                PlayerGrid.Focus();
                if (PlayerGrid.Items.Count > 0)
                {
                    var currentP = playerSlot == 1 ? Player1Combo.SelectedItem : Player2Combo.SelectedItem;
                    if (currentP != null) PlayerGrid.SelectedItem = currentP;
                    else PlayerGrid.SelectedIndex = 0;

                    PlayerGrid.ScrollIntoView(PlayerGrid.SelectedItem);
                }

                FlushMemory();
            });
        }

        private void ConfirmRosterSelection()
        {
            if (PlayerGrid.SelectedItem is Player selectedPlayer)
            {
                if (targetPlayerSlot == 1)
                {
                    var p2 = Player2Combo.SelectedItem as Player;
                    if (p2 != null && p2.Name == selectedPlayer.Name)
                    {
                        System.Media.SystemSounds.Beep.Play();
                        return;
                    }
                    Player1Combo.SelectedItem = selectedPlayer;
                }
                else if (targetPlayerSlot == 2)
                {
                    var p1 = Player1Combo.SelectedItem as Player;
                    if (p1 != null && p1.Name == selectedPlayer.Name)
                    {
                        System.Media.SystemSounds.Beep.Play();
                        return;
                    }
                    Player2Combo.SelectedItem = selectedPlayer;
                }
            }

            CloseRosterScreen();
        }

        private void CloseRosterScreen()
        {
            if (targetPlayerSlot > 0)
            {
                int returningSlot = targetPlayerSlot;
                targetPlayerSlot = 0;

                TableViewGrid.Visibility = Visibility.Collapsed;
                BookShowGrid.Visibility = Visibility.Visible;

                if (returningSlot == 1) SetBookShowFocus(BookShowControl.Player1);
                else if (returningSlot == 2) SetBookShowFocus(BookShowControl.Player2);
            }
            else
            {
                TableViewGrid.Visibility = Visibility.Collapsed;
                FieldsGrid.Visibility = Visibility.Visible;

                PlayStoryboard("ShowFieldsStoryboard", () =>
                {
                    SetMenuFocus(MainMenuPosition.Box2_Roster);
                });
            }

            FlushMemory();
        }

        private void OpenBookShowScreen()
        {
            PlayStoryboard("HideFieldsStoryboard", () =>
            {
                FieldsGrid.Visibility = Visibility.Collapsed;
                BookShowGrid.Visibility = Visibility.Visible;
                SetBookShowFocus(BookShowControl.EventType);

                FlushMemory();
            });
        }

        private void CloseBookShowScreen()
        {
            BookShowGrid.Visibility = Visibility.Collapsed;
            FieldsGrid.Visibility = Visibility.Visible;

            PlayStoryboard("ShowFieldsStoryboard", () =>
            {
                SetMenuFocus(MainMenuPosition.Box3_BookShow);
            });

            FlushMemory();
        }

        #endregion
    }
}