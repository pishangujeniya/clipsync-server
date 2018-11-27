using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using Microsoft.Owin.Hosting;

namespace SignalRHubConsole {
	class Program {
		static void Main(string[] args) {

			Console.WriteLine("SignalRHub Starting Process...");
			Console.WriteLine("Enter port number :");
			string port_number = Console.ReadLine();
			Console.WriteLine("Enter Domain:");
			string domain = Console.ReadLine();
			string url = @"http://"+ domain + ":" +port_number+"/";
			Console.WriteLine("SignalRHub Startin at : "+url);
			using (WebApp.Start<Startup>(url)) {
				Console.WriteLine(string.Format("Server running at {0}", url));
				Console.WriteLine("Press any key to exit...");
				Console.ReadLine();
			}


		}
	}
}
