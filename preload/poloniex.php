<?php
	$data = file_get_contents("https://poloniex.com/public?command=returnTicker");
	if(isset($_GET['a']) && isset($_GET['b'])){
		if(strtoupper($_GET['a']) == 'USD'){
			$pair = strtoupper($_GET['a'].'T_'.$_GET['b']);
		}else{
			$pair = strtoupper($_GET['a'].'_'.$_GET['b']);
		}
		$data=json_encode(json_decode($data)->$pair);
	}
	echo $data;
	
	
	// https://m.poloniex.com/support/api/
	// https://pastebin.com/dMX7mZE0
	//
?>