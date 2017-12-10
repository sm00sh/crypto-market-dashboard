function hitbtcDoSend(message) {
//	console.log("SENT: " + message);
	hitbtcWebSocket.websocket.send(message);
}

function hitbtcOnOpen(evt) {
 	console.log("HITBTC : connected")
	hitbtcDoSend('{"method": "subscribeTicker","params": {"symbol": "BTCUSD"},"id": 1}');
	hitbtcDoSend('{"method": "subscribeTicker","params": {"symbol": "BCHUSD"},"id": 2}');
	hitbtcDoSend('{"method": "subscribeTicker","params": {"symbol": "LTCUSD"},"id": 3}');
	hitbtcDoSend('{"method": "subscribeTicker","params": {"symbol": "ETHUSD"},"id": 4}');
	hitbtcDoSend('{"method": "subscribeTicker","params": {"symbol": "PPCUSD"},"id": 5}');
	hitbtcDoSend('{"method": "subscribeTicker","params": {"symbol": "ZECUSD"},"id": 6}');

}

var hitbtcWebSocket = {};
hitbtcWebSocket.init = function(uri) {
	this.wsUri = uri;
	this.lastHeartBeat = new Date().getTime();
	this.overtime = 8000;
	hitbtcWebSocket.websocket = new WebSocket(hitbtcWebSocket.wsUri);
	hitbtcWebSocket.websocket.onopen = function(evt) {
		$("#hitbtcStatus").addClass( "dot-success" ).removeClass( "dot-danger" ).removeClass( "dot-warning" );
		$( "#hitbtcConnectionStatus" ).text("connected");

		hitbtcOnOpen()
	};
	hitbtcWebSocket.websocket.onmessage = function(evt) {
		hitbtcOnMessage(evt)
	};
	
	hitbtcWebSocket.websocket.onerror = function(evt){
		$( "#hitbtcConnectionStatus" ).text("error");

		$("#hitbtcStatus").addClass( "dot-danger" ).removeClass( "dot-success" ).removeClass( "dot-warning" );
	}

	hitbtcWebSocket.websocket.onclose = function(evt){
		$( "#hitbtcConnectionStatus" ).text("closed");
		$("#hitbtcStatus").addClass( "dot-danger" ).removeClass( "dot-success" ).removeClass( "dot-warning" );
		hitbtcWebSocket.init("wss://api.hitbtc.com/api/2/ws");
		
		var reconnectCounter = parseInt($( "#hitbtcDisconnects" ).text())+1;
		$( "#hitbtcDisconnects" ).text(reconnectCounter);

	}
	
}

function hitbtcOnMessage(e) {
	var array = JSON.parse(e.data);
	if(array.channel === "ticker"){
		var coinName = array.data.symbol[0]+array.data.symbol[1]+array.data.symbol[2];
		
		updateCellDataNew('hitbtc', coinName, array.data.last)
	}
}

window.onload = hitbtcWebSocket.init("wss://api.hitbtc.com/api/2/ws");
