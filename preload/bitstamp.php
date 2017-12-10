<?php
	if(isset($_GET['a']) && isset($_GET['b'])){
		$pair = strtolower($_GET['a'].$_GET['b']);
		echo file_get_contents("https://www.bitstamp.net/api/v2/ticker/$pair/");
	}else{
		echo file_get_contents("https://www.bitstamp.net/api/v2/ticker/btcusd/");
	}
	
	
	// https://nl.bitstamp.net/websocket/
	// https://nl.bitstamp.net/s/examples/live_trades.html
	// use type 0 (buy) for current price tag
?>