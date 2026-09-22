using System;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Input;

namespace WWE_Control_Room
{
    public partial class MainWindow : Window
    {
        public MainWindow()
        {
            InitializeComponent();
        }

        private void Window_Loaded(object sender, RoutedEventArgs e)
        {
            Box1.Focus();
            Mouse.OverrideCursor = Cursors.None;
        }

        // Amikor a videó a végére ér, visszatekeri az elejére és újra elindítja
        private void BgVideo_MediaEnded(object sender, RoutedEventArgs e)
        {
            BgVideo.Position = TimeSpan.Zero;
            BgVideo.Play();
        }

        private void Window_PreviewKeyDown(object sender, KeyEventArgs e)
        {
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