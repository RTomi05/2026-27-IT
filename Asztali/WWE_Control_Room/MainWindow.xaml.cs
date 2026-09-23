using System;
using System.Collections.Generic;
using System.IO;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Input;
using System.Windows.Media.Animation;

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

            PlayersList = LoadPlayersFromFile("roster.txt");
            PlayerGrid.ItemsSource = PlayersList;
            Player1Combo.ItemsSource = PlayersList;
            Player2Combo.ItemsSource = PlayersList;

            if (PlayersList.Count >= 2)
            {
                Player1Combo.SelectedIndex = 0;
                Player2Combo.SelectedIndex = 1;
            }
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

        #region File & Video Logic

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

            // 1. Kilépő dialógus
            if (ExitDialog.Visibility == Visibility.Visible)
            {
                HandleExitDialogKeys(e);
                return;
            }

            // 2. Book A Show képernyő
            if (BookShowGrid.Visibility == Visibility.Visible)
            {
                HandleBookShowKeys(e);
                return;
            }

            // 3. Roster képernyő (DataGrid)
            if (TableViewGrid.Visibility == Visibility.Visible)
            {
                HandleRosterKeys(e);
                return;
            }

            // 4. Főmenü képernyő (2x2 Rács)
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
            // Kizárólag ESC-re lép vissza a főmenübe (vagy a Book A Show-ba)
            if (e.Key == Key.Escape)
            {
                CloseRosterScreen();
                e.Handled = true;
                return;
            }

            // ENTER -> Csak akkor hagyja jóvá a kiválasztást és lép vissza, ha a Book A Show-ból nyitottuk meg (targetPlayerSlot != 0)
            if (e.Key == Key.Enter)
            {
                if (targetPlayerSlot != 0)
                {
                    ConfirmRosterSelection();
                }
                e.Handled = true;
                return;
            }

            // NAVIGÁCIÓ (W / S / Nyilak)
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
            // Ha a meccs kiíró ablak van nyitva
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

            // ENTER megnyomása a kiválasztott vezérlőn
            if (e.Key == Key.Enter)
            {
                if (currentBookControl == BookShowControl.Player1)
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

            // NAVIGÁCIÓ (WASD / NYILAK)
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
                        if (EventTypeCombo.SelectedIndex > 0) EventTypeCombo.SelectedIndex--;
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
                        if (EventTypeCombo.SelectedIndex < EventTypeCombo.Items.Count - 1) EventTypeCombo.SelectedIndex++;
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
            var eventType = (EventTypeCombo.SelectedItem as ComboBoxItem)?.Content?.ToString() ?? "Match";
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
            MatchText.Text = $"{eventType}\n\n{p1Name}   VS   {p2Name}";
            MatchDialog.Visibility = Visibility.Visible;
            }

        }

        #endregion

        #region Screen Transitions & Roster Selection

        private void OpenRosterScreen()
        {
            targetPlayerSlot = 0; // Főmenüből nyitva
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
                });
            });
        }

        private void OpenRosterForPlayer(int playerSlot)
        {
            targetPlayerSlot = playerSlot; // 1 = Red Corner, 2 = Blue Corner
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
            });
        }

        private void ConfirmRosterSelection()
        {
            if (PlayerGrid.SelectedItem is Player selectedPlayer)
            {
                // 1. Ha a Piros saroknak (Player 1) választunk embert:
                if (targetPlayerSlot == 1)
                {
                    var p2 = Player2Combo.SelectedItem as Player;
                    // Ha a Kék sarokban ugyanez az ember van, nem engedjük a választást
                    if (p2 != null && p2.Name == selectedPlayer.Name)
                    {
                        // Nem csinál semmit, vagy akár ki is csipoghat a rendszer
                        System.Media.SystemSounds.Beep.Play();
                        return; // Nem engedi bezárni a Rostert ezzel a választással
                    }
                    Player1Combo.SelectedItem = selectedPlayer;
                }
                // 2. Ha a Kék saroknak (Player 2) választunk embert:
                else if (targetPlayerSlot == 2)
                {
                    var p1 = Player1Combo.SelectedItem as Player;
                    // Ha a Piros sarokban ugyanez az ember van, nem engedjük
                    if (p1 != null && p1.Name == selectedPlayer.Name)
                    {
                        System.Media.SystemSounds.Beep.Play();
                        return;
                    }
                    Player2Combo.SelectedItem = selectedPlayer;
                }
            }

            // Ha érvényes volt a választás, bezárjuk a Rostert
            CloseRosterScreen();
        }

        private void CloseRosterScreen()
        {
            if (targetPlayerSlot > 0)
            {
                // Visszatérés a Book A Show képernyőre
                int returningSlot = targetPlayerSlot;
                targetPlayerSlot = 0;

                TableViewGrid.Visibility = Visibility.Collapsed;
                BookShowGrid.Visibility = Visibility.Visible;

                if (returningSlot == 1) SetBookShowFocus(BookShowControl.Player1);
                else if (returningSlot == 2) SetBookShowFocus(BookShowControl.Player2);
            }
            else
            {
                // Visszatérés a Főmenübe
                TableViewGrid.Visibility = Visibility.Collapsed;
                FieldsGrid.Visibility = Visibility.Visible;

                PlayStoryboard("ShowFieldsStoryboard", () =>
                {
                    SetMenuFocus(MainMenuPosition.Box2_Roster);
                });
            }
        }

        private void OpenBookShowScreen()
        {
            PlayStoryboard("HideFieldsStoryboard", () =>
            {
                FieldsGrid.Visibility = Visibility.Collapsed;
                BookShowGrid.Visibility = Visibility.Visible;
                SetBookShowFocus(BookShowControl.EventType);
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
        }

        #endregion
    }
}