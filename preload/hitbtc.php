<?php
	if(isset($_GET['a']) && isset($_GET['b'])){
		$pair = strtolower($_GET['a'].$_GET['b']);
		echo file_get_contents("https://api.hitbtc.com/api/2/public/ticker/$pair");
	}else{
		echo file_get_contents("https://api.hitbtc.com/api/2/public/ticker/btcusd");
	}
	// https://api.hitbtc.com/
	
?>