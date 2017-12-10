<?php
$options  = array('http' => array('user_agent' => 'HaxorTrade v0.1'));
$context  = stream_context_create($options);

if(isset($_GET['a']) && isset($_GET['b'])){
	$pair = strtoupper($_GET['a'].'-'.$_GET['b']);
	$response = file_get_contents('https://api.gdax.com/products/'.$pair.'/stats', false, $context);
}else{
	$response = file_get_contents('https://api.gdax.com/products/BTC-USD/stats', false, $context);
}


// $response = file_get_contents('https://api.gdax.com/products/BTC-USD/stats', false, $context);
	echo $response;
?>