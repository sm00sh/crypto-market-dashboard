<?php
	include('includes/exchanges.inc');
	include('includes/coinsB.inc');	

	$balance='display:none;';	
	if(isset($_GET['balance']) && $_GET['balance'] == 1){
		$balance='';
	}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Market Data</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" crossorigin="anonymous">

    <!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<link rel="stylesheet" href="/css/main2.css">
	<style>
		.coinTable{
			margin-bottom: 15px;
		}
		.coinPrice{
			font-size: x-large;
		}
	</style>
  </head>

<body>

    <main role="main" class="container-fluid">
		<!-- BTC -->
	    <div class="row">
			<div class="col-12">
		<?php 
		foreach($coinsB as $a => $b){ ?>
			<div style="display: block; float: left; width: 24%;">
				<table width="100%" class="coinTable">
					<thead>
						<tr><th class="text-center"><img src="<?=$b['image'];?>" height="32px"> <?=$b['full'];?></th></tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<table width="100%" style="float: left;" class="coinPrice">
									<tr>
										<td class="text-center">
											<span id="<?=$b['short'];?>CurrentUSD">USD</span>
										</td>
										<td class="text-center">
											<span id="<?=$b['short'];?>CurrentEUR">EUR</span>
										</td>
									</tr>
								</table>
								<table width="100%">
									<tr>
										<td id="<?=$b['short'];?>Change1hRow"><span id="<?=$b['short'];?>Change1h"></span> <small>(1h)</small></td>
										<td id="<?=$b['short'];?>Change24hRow"><span id="<?=$b['short'];?>Change24h"></span> <small>(1d)</small></td>
										<td id="<?=$b['short'];?>Change7dRow"><span id="<?=$b['short'];?>Change7d"></span> <small>(7d)</small></td>
									</tr>
									<tr style="<?=$balance;?>">
										<td><span id="<?=$b['short'];?>BalanceCoin"><?=$b['balance'];?></span></td>
										<td><span id="<?=$b['short'];?>BalanceUSD"></span></td>
										<td><span id="<?=$b['short'];?>BalanceEUR"></span></td>
									</tr>
								</table>
								<table width="100%" style="display: none;">
									<tr>
										<td class="text-center"> <img class="sparkline" alt="sparkline" src="https://files.coinmarketcap.com/generated/sparklines/<?=$b['graph'];?>.png"> </td>
									</tr>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div style="display: block; float: left; width: 1%;" class="coinSplit">&nbsp;</div>
		<?php } ?>
			</div>
	    </div>

    </main><!-- /.container -->
	<div class="fixed-bottom">
		<table width="100%" style="<?=$balance;?>">
			<tr>
				<td width="50%" class="text-center"><a href="#">$</a> <span id="totalBalanceUSD">0</span></td>
				<td width="50%" class="text-center"><a href="#">€</a> <span id="totalBalanceEUR">0</span></td>
			</tr>
		</table>

		<!--<div class="float-right"><span id="errorFooter" class="counter"></span></div> -->
		 <div class="float-right"><span class="counter">Reloading in</span> <span class="counter" id="counter"></span></div>
	</div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"  crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
	<script src="https://d3dy5gmtp8yhk7.cloudfront.net/2.1/pusher.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="/js/MD5.js"></script>
	<script type="text/javascript" src="/js/autobahn.min.js"></script>
	<script type="text/javascript" src="/js/numberFormat.js"></script>
	<script type="text/javascript" src="/js/jquery.li-scroller.1.0.js"></script>

	<script>

	$(function(){
	    $("ul#ticker01").liScroll();
	});


	function updateCellDataNew(exchange, coinName, dataNew){


		var dataOld  = parseFloat($( "#"+exchange+"Last"+coinName ).text().replace('.','').replace(',','.'));
		var newValue = parseFloat(dataNew);

		var updateCellA = exchange+"Update"+coinName;
		var updateCellB = exchange+"Last"+coinName;
		var updateCellC = exchange+"Currency"+coinName;

		
		if(dataOld < dataNew){
			$( "#"+updateCellA ).html('<i class="fa fa-arrow-up text-success" aria-hidden="true"></i>') 
			$( "#"+updateCellB ).addClass( "higherValue" ).removeClass( "lowerValue" );
			$( "#"+updateCellB ).text(newValue.format(2, 3, '.', ','));
			$( "#"+updateCellC).text('$');
			$( "#"+updateCellC ).addClass( "higherValue" ).removeClass( "lowerValue" );
//			console.log("up")
			return 1;
		}else if(dataOld > dataNew){
			$( "#"+updateCellA ).html('<i class="fa fa-arrow-down text-danger" aria-hidden="true"></i>') 
			$( "#"+updateCellB ).addClass( "lowerValue" ).removeClass( "higherValue" );
			$( "#"+updateCellB ).text(newValue.format(2, 3, '.', ','));
			$( "#"+updateCellC).text('$');
			$( "#"+updateCellC ).addClass( "lowerValue" ).removeClass( "higherValue" );
//			console.log("down")
			return -1;
		}
	}		

		
	function getData(){

		$.getJSON( "/preload/coinmarketcap.php", function( data ) {

			data.forEach(function(a){
				if(/^[a-zA-Z0-9- ]*$/.test(a.symbol) == false) {
				    console.warn('Symbol string contains illegal characters. ('+a.symbol+')');
				}else{
					if(a.symbol === 'BTG' && a.name === 'Bitgem'){
						// rename the a.symbol as this conflicts with bitcoin gold...
						a.symbol = 'BITGEM';
					}
					if(parseFloat(a.price_usd) < 1){
						$( "#"+a.symbol+"CurrentUSD" ).text('$ '+parseFloat(a.price_usd).format(4, 3, '.', ','));
						$( "#"+a.symbol+"CurrentEUR" ).text('€ '+parseFloat(a.price_eur).format(4, 3, '.', ','));					
					}else{
						$( "#"+a.symbol+"CurrentUSD" ).text('$ '+parseFloat(a.price_usd).format(2, 3, '.', ','));
						$( "#"+a.symbol+"CurrentEUR" ).text('€ '+parseFloat(a.price_eur).format(2, 3, '.', ','));					
					}
					if(parseFloat(a.percent_change_1h) < 0){
						$( "#"+a.symbol+"Change1hRow" ).addClass( "lowerValue" ).removeClass( "higherValue" );
					}else{
						$( "#"+a.symbol+"Change1hRow" ).addClass( "higherValue" ).removeClass( "lowerValue" );
					}
					$( "#"+a.symbol+"Change1h" ).text(a.percent_change_1h+' %');
	
					if(parseFloat(a.percent_change_24h) < 0){
						$( "#"+a.symbol+"Change24hRow" ).addClass( "lowerValue" ).removeClass( "higherValue" );
					}else{
						$( "#"+a.symbol+"Change24hRow" ).addClass( "higherValue" ).removeClass( "lowerValue" );
					}
					$( "#"+a.symbol+"Change24h" ).text(a.percent_change_24h+' %');
	
					if(parseFloat(a.percent_change_7d) < 0){
						$( "#"+a.symbol+"Change7dRow" ).addClass( "lowerValue" ).removeClass( "higherValue" );
					}else{
						$( "#"+a.symbol+"Change7dRow" ).addClass( "higherValue" ).removeClass( "lowerValue" );
					}
					$( "#"+a.symbol+"Change7d" ).text(a.percent_change_7d+' %');
					var currentBalance = parseFloat($( "#"+a.symbol+"BalanceCoin" ).text());
					$( "#"+a.symbol+"BalanceCoin" ).text(currentBalance+" "+a.symbol)
					$( "#"+a.symbol+"BalanceUSD" ).text( "$ "+parseFloat(currentBalance * parseFloat(a.price_usd)).format(2, 3, '.', ',') );
					$( "#"+a.symbol+"BalanceEUR" ).text( "€ "+parseFloat(currentBalance * parseFloat(a.price_eur)).format(2, 3, '.', ',') );
					
					$( "#"+a.symbol+"BalanceUSD" ).text( "$ "+parseFloat(currentBalance * parseFloat(a.price_usd)).format(2, 3, '.', ',') );
					
					if(currentBalance > 0){
						var currentTotalUSD = parseFloat($( "#totalBalanceUSD" ).text());
						totalBalanceUSD = parseFloat(currentBalance * parseFloat(a.price_usd)) + currentTotalUSD
						$( "#totalBalanceUSD" ).text(totalBalanceUSD)
	
						var currentTotalEUR = parseFloat($( "#totalBalanceEUR" ).text());
						totalBalanceEUR = parseFloat(currentBalance * parseFloat(a.price_eur)) + currentTotalEUR
						$( "#totalBalanceEUR" ).text(totalBalanceEUR)
					}
				}
			});
		});		
	}
	
	function countDownFunction(){
		preload()
		countDownTimer();
	}

	function countDownTimer(){
		var count = 600, timer = setInterval(function() {
		    $("#counter").html(count--);
		    if(count == 0){
			    clearInterval(timer);
			    countDownFunction();
			}
		}, 1000);
	}
	
	countDownTimer();
	
	
	function preload(){
		getData();
	}
	
	preload();
	</script>
	
	
  </body>
</html>
