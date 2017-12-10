<?php
	if(isset($_GET['a']) && isset($_GET['b'])){
		$pair = $_GET['a'].$_GET['b'];
		echo file_get_contents("https://api.bitfinex.com/v2/ticker/t$pair");
	}else{
		echo file_get_contents("https://api.bitfinex.com/v2/ticker/tBTCUSD");
	}

	
?>