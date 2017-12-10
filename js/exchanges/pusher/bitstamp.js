        var bitstampPusher = new Pusher('de504dc5763aeef9ff52'),
            bitstampTradesChannelBTC = bitstampPusher.subscribe('live_trades'),
            bitstampTradesChannelLTC = bitstampPusher.subscribe('live_trades_ltcusd'),
            bitstampTradesChannelETH = bitstampPusher.subscribe('live_trades_ethusd'),

            child = null,
            i = 0;

        bitstampTradesChannelBTC.bind('trade', function (data) {
	        if(data.type === 0){
		        var a='BTC'
				updateCellDataNew('bitstamp', 'BTC', data.price)
	        }
        });
        bitstampTradesChannelLTC.bind('trade', function (data) {
	        if(data.type === 0){
		        var a='LTC'
				updateCellDataNew('bitstamp', 'LTC', data.price)
	        }
        });
        bitstampTradesChannelETH.bind('trade', function (data) {
	        if(data.type === 0){
		        var a='ETH'
				updateCellDataNew('bitstamp', 'ETH', data.price)
	        }
        });


		bitstampPusher.connection.bind('state_change', function(states) {
		  var prevState = states.previous;
		  var currState = states.current;
		  console.log("BITSTAMP : "+ currState)
		  if(currState === 'connected'){
		  	$( "#bitstampConnectionStatus" ).text("connected");

		  	$("#bitstampStatus").addClass( "dot-success" ).removeClass( "dot-danger" ).removeClass( "dot-warning" );
		  }else{
		  	$( "#bitstampConnectionStatus" ).text("error");

			$("#bitstampStatus").addClass( "dot-danger" ).removeClass( "dot-success" ).removeClass( "dot-warning" );  
		  }
		  
		  
		});
