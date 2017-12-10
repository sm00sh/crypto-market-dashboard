function bitfinexDoSend(message) {
//	console.log("SENT: " + message);
	bitfinexWebSocket.websocket.send(message);
}
function bitfinexOnOpen(evt) {
// 	console.log("CONNECTED");
	bitfinexDoSend('{"event":"conf","flags":6144}')
	bitfinexDoSend('{"event":"subscribe","pair":"BTCUSD","channel":"ticker"}');
	bitfinexDoSend('{"event":"subscribe","pair":"BCHUSD","channel":"ticker"}');
	bitfinexDoSend('{"event":"subscribe","pair":"LTCUSD","channel":"ticker"}');
	bitfinexDoSend('{"event":"subscribe","pair":"ETHUSD","channel":"ticker"}');
	bitfinexDoSend('{"event":"subscribe","pair":"DSHUSD","channel":"ticker"}');
	bitfinexDoSend('{"event":"subscribe","pair":"ZECUSD","channel":"ticker"}');
}


var bitfinexWebSocket = {};
bitfinexWebSocket.init = function(uri) {
	this.wsUri = uri;
	this.lastHeartBeat = new Date().getTime();
	this.overtime = 8000;
	
	bitfinexWebSocket.websocket = new WebSocket(bitfinexWebSocket.wsUri);
	
	bitfinexWebSocket.websocket.onopen = function(evt) {
		$( "#bitfinexConnectionStatus" ).text("connected");
		$("#bitfinexStatus").addClass( "dot-success" ).removeClass( "dot-danger" ).removeClass( "dot-warning" );
		console.log("BITFINEX : connected")
		bitfinexOnOpen()
	};
	bitfinexWebSocket.websocket.onmessage = function(evt) {
		bitfinexOnMessage(evt)
	};
	
	bitfinexWebSocket.websocket.onerror = function(evt){
		$( "#bitfinexConnectionStatus" ).text("error");
		$("#bitfinexStatus").addClass( "dot-danger" ).removeClass( "dot-success" ).removeClass( "dot-warning" );
	}

	bitfinexWebSocket.websocket.onclose = function(evt){
		$("#bitfinexStatus").addClass( "dot-danger" ).removeClass( "dot-success" ).removeClass( "dot-warning" );
		$( "#bitfinexConnectionStatus" ).text("closed");

		bitfinexWebSocket.init("wss://api.bitfinex.com/ws/1")
		var reconnectCounter = parseInt($( "#bitfinexDisconnects" ).text())+1;
		$( "#bitfinexDisconnects" ).text(reconnectCounter);

	}
	
}

var bitfinexArray = [];

function bitfinexOnMessage(e) {
	var array = JSON.parse(e.data);

	if(array.event === "subscribed"){
		bitfinexArray[array.chanId] = array.pair[0]+array.pair[1]+array.pair[2];
	}
	
		if(array[1] === "hb"){
//			console.log("heart beat")
		}else{
//			console.log(array);
			coinName = bitfinexArray[[array[0]]]
			coinID = array[0];
			lastPrice = array[7];
			updateCellDataNew('bitfinex', coinName, lastPrice)

			
 			$( "#bitfinexLast"+coinName ).text(parseFloat(lastPrice).format(2, 3, '.', ','));	// some bug prevents the updateCellDataNew function to update the cell data... hence this second call
		}

	}

window.onload = bitfinexWebSocket.init("wss://api.bitfinex.com/ws/1");
