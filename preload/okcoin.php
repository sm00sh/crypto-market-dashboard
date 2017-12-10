<?php
	if(isset($_GET['a']) && isset($_GET['b'])){
		$pair = strtolower($_GET['a'].'_'.$_GET['b']);
		
		echo file_get_contents("https://www.okcoin.com/api/v1/ticker.do?symbol=$pair");
	}else{
		echo file_get_contents("https://www.okcoin.com/api/v1/ticker.do?symbol=btc_usd");
	}

	
?>