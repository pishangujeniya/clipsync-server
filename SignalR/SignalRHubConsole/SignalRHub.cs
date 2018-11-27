using Microsoft.AspNet.SignalR;
using Microsoft.AspNet.SignalR.Hubs;
using System;
using System.Collections;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;


namespace SignalRHubConsole {
	[HubName("SignalRHub")]
	public class SignalRHub : Hub {

		public override bool Equals(object obj) {
			return base.Equals(obj);
		}

		public override int GetHashCode() {
			return base.GetHashCode();
		}

		public override Task OnConnected() {
			IRequest request = Context.Request;
			string connectionID = Context.ConnectionId;
			string uid = request.QueryString.Get("uid");
			string platform = request.QueryString.Get("platform");
			string device_id = request.QueryString.Get("device_id");
			Console.WriteLine("uid  : {0} | platform : {1} | device_id : {2} | connectionID : {3}",uid,platform,device_id,connectionID);
			Users.AddUserConnection(uid, new UserConnection(platform, device_id, connectionID));
			return base.OnConnected();
		}

		public override Task OnDisconnected(bool stopCalled) {
			Console.WriteLine("OnDisconnected : "+Context.ConnectionId);
			string searched_uid = Users.GetUIDFromConnectionID(Context.ConnectionId);
			if (!searched_uid.Equals("") || searched_uid.Length > 0) {
				Users.DeleteUserConnection(searched_uid, Context.ConnectionId);
			} else {
				Console.WriteLine("UID not found for user connection string : "+Context.ConnectionId);
			}
			return base.OnDisconnected(stopCalled);
		}

		public override Task OnReconnected() {
			return base.OnReconnected();
		}

		public override string ToString() {
			return base.ToString();
		}

		protected override void Dispose(bool disposing) {
			base.Dispose(disposing);
		}

		public void DetermineLength(string message) {

			Console.WriteLine(message);
			string newMessage = string.Format(@"{0} has a length of: {1}", message, message.Length);
			Clients.All.ReceiveLength(newMessage);
		}

		public void SendCopiedText(string text) {
			
			string connection_id = Context.ConnectionId;
			string uid = Users.GetUIDFromConnectionID(connection_id);
			Console.WriteLine("Received from : " + connection_id + " uid : "+uid + " this : " + text);
			ArrayList connectionList = Users.GetUserConnections(uid);
			for (int i = 0; i < connectionList.Count; i++) {
				UserConnection userConnection = (UserConnection)connectionList[i];
				if (!userConnection.Getconnection_id().Equals(connection_id)) {
					//the above if condition is to send to only those connection except the current incoming
					Clients.Client(userConnection.Getconnection_id()).ReceiveCopiedText(text);
				}
			}
		}
	}
}
