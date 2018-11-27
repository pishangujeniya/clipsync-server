using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace SignalRHubConsole {
	class UserConnection {

		private string platform = "";
		private string device_id = "";
		private string connection_id = "";

		public UserConnection(string platform, string device_id, string connection_id) {
			this.Setplatform(platform);
			this.Setdevice_id(device_id);
			this.Setconnection_id(connection_id);
		}

		public string Getplatform() {
			return platform;
		}

		public void Setplatform(string value) {
			platform = value;
		}

		public string Getconnection_id() {
			return connection_id;
		}

		public void Setconnection_id(string value) {
			connection_id = value;
		}

		public string Getdevice_id() {
			return device_id;
		}

		public void Setdevice_id(string value) {
			device_id = value;
		}
	}
}
