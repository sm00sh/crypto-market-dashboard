<?php
	if(isset($_GET['a']) && isset($_GET['b'])){
		
		$pair = strtolower($_GET['a'].'_'.$_GET['b']);
		$data = file_get_contents("https://wex.nz/api/3/ticker/$pair");
		
		$data=json_encode(json_decode($data)->$pair);

		echo $data;
		
	}else{
		echo file_get_contents("https://wex.nz/api/3/ticker/btc_usd");
	}

	
// 	echo file_get_contents("https://wex.nz/api/3/ticker/btc_usd");
	
	// https://wex.nz/api/3/docs#main
	// https://wex.nz/pushAPI/docs
	
	
?>
