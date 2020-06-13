using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using Xamarin.Forms;

namespace AppCS
{
    public partial class MainPage : ContentPage
    {
        public MainPage()
        {
            InitializeComponent();
            wbvApp.Source = "http://192.168.125.223/CS/Frontend";
            //wbvApp.Source = "https://alistapart.com/article/responsive-web-design/";
        }
    }
}
