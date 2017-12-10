function gdaxDoSend(message) {
//	console.log("SENT: " + message);
	gdaxWebSocket.websocket.send(message);
}

function gdaxOnOpen(evt) {
 	console.log("GDAX : connected")
	gdaxDoSend('{"type": "subscribe","channels": [{ "name": "ticker", "product_ids": ["BTC-USD"] }]}');
	gdaxDoSend('{"type": "subscribe","channels": [{ "name": "ticker", "product_ids": ["LTC-USD"] }]}');
	gdaxDoSend('{"type": "subscribe","channels": [{ "name": "ticker", "product_ids": ["ETH-USD"] }]}');
}

var gdaxWebSocket = {};
gdaxWebSocket.init = function(uri) {
	this.wsUri = uri;
	this.lastHeartBeat = new Date().getTime();
	this.overtime = 8000;
	gdaxWebSocket.websocket = new WebSocket(gdaxWebSocket.wsUri);
	gdaxWebSocket.websocket.onopen = function(evt) {
		$( "#gdaxConnectionStatus" ).text("connected");
		$("#gdaxStatus").addClass( "dot-success" ).removeClass( "dot-danger" ).removeClass( "dot-warning" );
		gdaxOnOpen()
	};
	gdaxWebSocket.websocket.onmessage = function(evt) {
		gdaxOnMessage(evt)
	};
	
	gdaxWebSocket.websocket.onerror = function(evt){
		$( "#gdaxConnectionStatus" ).text("error");

		$("#gdaxStatus").addClass( "dot-danger" ).removeClass( "dot-success" ).removeClass( "dot-warning" );
	}

	gdaxWebSocket.websocket.onclose = function(evt){
		$("#gdaxStatus").addClass( "dot-danger" ).removeClass( "dot-success" ).removeClass( "dot-warning" );

		$( "#gdaxConnectionStatus" ).text("closed");

		gdaxWebSocket.init("wss://ws-feed.gdax.com");
		var reconnectCounter = parseInt($( "#gdaxDisconnects" ).text())+1;
		$( "#gdaxDisconnects" ).text(reconnectCounter);

	}
	
}

function gdaxOnMessage(e) {
	var array = JSON.parse(e.data);
	if(array.type === 'ticker'){
		var coinName = array.product_id[0]+array.product_id[1]+array.product_id[2];
		updateCellDataNew('gdax', coinName, array.price)
	}
}

window.onload = gdaxWebSocket.init("wss://ws-feed.gdax.com");
