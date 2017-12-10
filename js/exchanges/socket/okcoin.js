	var okCoinWebSocket = {};
	okCoinWebSocket.init = function(uri, apiKey, secretKey) {
		this.wsUri = uri;
		this.apiKey = apiKey;
		this.secretKey = secretKey;
		this.lastHeartBeat = new Date().getTime();
		this.overtime = 8000;
		
		okCoinWebSocket.websocket = new WebSocket(okCoinWebSocket.wsUri);
		
		okCoinWebSocket.websocket.onopen = function(evt) {
			$( "#okcoinConnectionStatus" ).text("connected");
			onOpen(evt)
		};
		okCoinWebSocket.websocket.onclose = function(evt) {
			$( "#okcoinConnectionStatus" ).text("closed");
			onClose(evt)
		};
		okCoinWebSocket.websocket.onmessage = function(evt) {
			onMessage(evt)
		};
		okCoinWebSocket.websocket.onerror = function(evt) {
			$( "#okcoinConnectionStatus" ).text("error");
			onError(evt)
		};
		
		//setInterval(checkConnect,5000);
	}
	function checkConnect() {
		websocket.send("{'event':'ping'}");
		if ((new Date().getTime() - okCoinWebSocket.lastHeartBeat) > okCoinWebSocket.overtime) {

		}
	}
	function onOpen(evt) {
		console.log("OKCOIN : connected")

		$("#okcoinStatus").addClass( "dot-success" ).removeClass( "dot-danger" ).removeClass( "dot-warning" );
//		print("CONNECTED");
		doSend("{'event':'addChannel','channel':'ok_sub_spot_btc_usd_ticker'}");
		doSend("{'event':'addChannel','channel':'ok_sub_spot_bch_usd_ticker'}");
		doSend("{'event':'addChannel','channel':'ok_sub_spot_ltc_usd_ticker'}");
		doSend("{'event':'addChannel','channel':'ok_sub_spot_eth_usd_ticker'}");
	}
	
	function onClose(evt) {
		$("#okcoinStatus").addClass( "dot-danger" ).removeClass( "dot-success" ).removeClass( "dot-warning" );
		var reconnectCounter = parseInt($( "#okcoinDisconnects" ).text())+1;
		$( "#okcoinDisconnects" ).text(reconnectCounter);

		okCoinWebSocket.init("wss://real.okcoin.com:10440/websocket/okcoinapi", "#YOUR_API_KEY#", "#YOUR_SECRET_KEY#")
//		print("DISCONNECTED");
	}
	function onMessage(e) {
//		console.log(new Date().getTime() + ": " + e.data)
		var array = JSON.parse(e.data);
		for (var i = 0; i < array.length; i++) {
			for (var j = 0;j < array[i].length; j++) {
				var isTrade = false;
				var isCancelOrder = false;
				
				if (array[i][j] == 'ok_spotusd_trade' || array[i][j] == 'ok_spotcny_trade') {
					isTrade = true;
				} else if (array[i][j] == 'ok_spotusd_cancel_order'
						|| array[i][j] == 'ok_spotcny_cancel_order') {
					isCancelOrder = true;
				}
				
				var order_id = array[i][j].order_id;
				if (typeof (order_id) != 'undefined') {
					if (isTrade) {
						//下单成功 业务代码
						console.log("orderId is  " + order_id);
					} else if (isCancelOrder) {
						//取消订单成功 业务代码
						console.log("order  " + order_id + " is now cancled");
					}
				}
			}
		}
		if (array.event == 'pong') {
			okCoinWebSocket.lastHeartBeat = new Date().getTime();
		} else {
			if (typeof array[0].channel !== 'undefined' ){
				var a = array[0].channel.split("_")[3].toUpperCase();

				updateCellDataNew('okcoin', a, array[0].data.last)
				$( "#okcoinLast"+a ).text(parseFloat(array[0].data.last).format(2, 3, '.', ','));	// some bug prevents the updateCellDataNew function to update the cell data... hence this second call
				
			}
		}
	}
	function onError(evt) {
		$("#okcoinStatus").addClass( "dot-danger" ).removeClass( "dot-success" ).removeClass( "dot-warning" );
//		print('<span style="color: red;">ERROR:</span> ' + evt.data);

	}
	function doSend(message) {
//		print("SENT: " + message);
		okCoinWebSocket.websocket.send(message);
	}
	function print(message) {
		var status = document.getElementById("status");
		status.style.wordWrap = "break-word";
		status.innerHTML += message + "<br/>";
	}
	
	window.onload = okCoinWebSocket.init("wss://real.okcoin.com:10440/websocket/okcoinapi", "#YOUR_API_KEY#", "#YOUR_SECRET_KEY#");
