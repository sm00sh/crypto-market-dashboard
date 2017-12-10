        var wexPusher = new Pusher('ee987526a24ba107824c', { cluster: 'eu' }),
            wexTradesChannelBTC = wexPusher.subscribe('btc_usd.trades'),
            wexTradesChannelBCH = wexPusher.subscribe('bch_usd.trades'),
            wexTradesChannelLTC = wexPusher.subscribe('ltc_usd.trades'),
            wexTradesChannelETH = wexPusher.subscribe('eth_usd.trades'),
            wexTradesChannelNMC = wexPusher.subscribe('nmc_usd.trades'),
            wexTradesChannelNVC = wexPusher.subscribe('nvc_usd.trades'),
            wexTradesChannelPPC = wexPusher.subscribe('ppv_usd.trades'),
            wexTradesChannelDSH = wexPusher.subscribe('dsh_usd.trades'),
            wexTradesChannelZEC = wexPusher.subscribe('zec_usd.trades');

        wexTradesChannelBTC.bind('trades', function (data) {
			if(data[0][0] === 'buy'){
		        var a='BTC'
				updateCellDataNew('wex', a, data[0][1])
			}
        });

        wexTradesChannelBCH.bind('trades', function (data) {
			if(data[0][0] === 'buy'){
		        var a='BCH'
				updateCellDataNew('wex', a, data[0][1])
			}
        });
        wexTradesChannelLTC.bind('trades', function (data) {
			if(data[0][0] === 'buy'){
		        var a='LTC'
				updateCellDataNew('wex', a, data[0][1])
			}
        });

        wexTradesChannelETH.bind('trades', function (data) {
			if(data[0][0] === 'buy'){
		        var a='ETH'
				updateCellDataNew('wex', a, data[0][1])
			}
        });

        wexTradesChannelNMC.bind('trades', function (data) {
			if(data[0][0] === 'buy'){
		        var a='NMC'
				updateCellDataNew('wex', a, data[0][1])
			}
        });
        wexTradesChannelNVC.bind('trades', function (data) {
			if(data[0][0] === 'buy'){
		        var a='NVC'
				updateCellDataNew('wex', a, data[0][1])
			}
        });
        wexTradesChannelPPC.bind('trades', function (data) {
			if(data[0][0] === 'buy'){
		        var a='PPC'
				updateCellDataNew('wex', a, data[0][1])
			}
        });
        wexTradesChannelDSH.bind('trades', function (data) {
			if(data[0][0] === 'buy'){
		        var a='DSH'
				updateCellDataNew('wex', a, data[0][1])
			}
        });
        wexTradesChannelZEC.bind('trades', function (data) {
			if(data[0][0] === 'buy'){
		        var a='ZEC'
				updateCellDataNew('wex', a, data[0][1])
			}
        });



		wexPusher.connection.bind('state_change', function(states) {
		  var prevState = states.previous;
		  var currState = states.current;
		  console.log("WEX : "+ currState)
		  if(currState === 'connected'){
		  	$( "#wexConnectionStatus" ).text("connected");
		  	$("#wexStatus").addClass( "dot-success" ).removeClass( "dot-danger" ).removeClass( "dot-warning" );
		  }else{
		  	$( "#wexConnectionStatus" ).text("connected");
			$("#wexStatus").addClass( "dot-danger" ).removeClass( "dot-success" ).removeClass( "dot-warning" );  
		  }
		  
		  
		});
