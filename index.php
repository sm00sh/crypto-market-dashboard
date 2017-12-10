<?php
	include('includes/exchanges.inc');
	include('includes/coins.inc');
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
	<link rel="stylesheet" href="/css/main.css">

  </head>

<body>

    <main role="main" class="container-fluid">
		<!-- BTC -->
	    <div class="row">
		    <div class="col">
<!-- 			    <h1 class="text-center">Market data</h1> -->
				<table width="100%">
					<thead>
						<tr>
							<th width="12.5%"></th>
							<?php foreach($exchanges as $c => $d){
								echo '<th width="12.5%"><span id="'.$d['short'].'Status" class="dot dot-warning"></span> '.$d['name'].'</th>';
							}?>
	
						</tr>
					</thead>
					<tbody>
						<?php 
						foreach($coins as $a => $b){
							echo '<tr>';
							echo '<th><img src="'.$b['image'].'" height="32px"> &nbsp; '.$b['full'].'</th>';
							foreach($exchanges as $c => $d){
								echo '<td><span id="'.$d['short'].'Update'.$b['short'].'"></span> <span id="'.$d['short'].'Currency'.$b['short'].'"></span> <span id="'.$d['short'].'Last'.$b['short'].'"></span></td>';
							}
							echo '</tr>';
						}?>

					</tbody>
				</table>
		    </div>
	    </div>

    </main><!-- /.container -->
	<div class="fixed-bottom">
		<ul id="ticker01">
			<?php foreach($exchanges as $c => $d){
				echo '<li><a href="#">'.$d['name'].'</a> <span id="'.$d['short'].'ConnectionStatus">connecting</span> - <span id="'.$d['short'].'Disconnects">0</span><span class="split"></span> </li>';
			}?>
		</ul>
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


	<!-- BITSTAMP PUSHER -->
	<script type="text/javascript" src="/js/exchanges/pusher/bitstamp.js"></script>
	    
	<!-- WEX.NZ PUSHER -->
	<script type="text/javascript" src="/js/exchanges/pusher/wex.js"></script>
    
    <!-- OKCOIN SOCKET -->
	<script type="text/javascript" src="/js/exchanges/socket/okcoin.js"></script>

    <!-- POLONIEX SOCKET -->
	<script type="text/javascript" src="/js/exchanges/socket/poloniex.js"></script>

    <!-- BITFINEX SOCKET -->
	<script type="text/javascript" src="/js/exchanges/socket/bitfinex.js"></script>
    
    
    <!-- HITBTC SOCKET -->
	<script type="text/javascript" src="/js/exchanges/socket/hitbtc.js"></script>

    <!-- GDAX SOCKET -->
	<script type="text/javascript" src="/js/exchanges/socket/gdax.js"></script>
	
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
			return 1;
		}else if(dataOld > dataNew){
			$( "#"+updateCellA ).html('<i class="fa fa-arrow-down text-danger" aria-hidden="true"></i>') 
			$( "#"+updateCellB ).addClass( "lowerValue" ).removeClass( "higherValue" );
			$( "#"+updateCellB ).text(newValue.format(2, 3, '.', ','));
			$( "#"+updateCellC).text('$');
			$( "#"+updateCellC ).addClass( "lowerValue" ).removeClass( "higherValue" );
			return -1;
		}
	}		
		
	function getData(a, b){

		$.getJSON( "/preload/wex.php?a="+a+"&b="+b, function( data ) {
			if (typeof data.last !== 'undefined' && data.last !== null && data.last){
			  $( "#wexLast"+a ).text(parseFloat(data.last).format(2, 3, '.', ','));
			}
		});
		
		$.getJSON( "/preload/hitbtc.php?a="+a+"&b="+b, function( data ) {
			if (typeof data.last !== 'undefined' && data.last !== null && data.last){
			  $( "#hitbtcLast"+a ).text(parseFloat(data.last).format(2, 3, '.', ','));
			}
		});
		
		$.getJSON( "/preload/gdax.php?a="+a+"&b="+b, function( data ) {
			if (typeof data.last !== 'undefined' && data.last !== null && data.last){
			  $( "#gdaxLast"+a ).text(parseFloat(data.last).format(2, 3, '.', ','));
			}
		});
		
		$.getJSON( "/preload/bitfinex.php?a="+a+"&b="+b, function( data ) {
			if (typeof data.last !== 'undefined' && data.last !== null && data.last){
			  $( "#bitfinexLast"+a ).text(parseFloat(data[6]).format(2, 3, '.', ','));
			}
		});

		if(a === "DSH"){
			var c = "DASH"
			$.getJSON( "/preload/poloniex.php?a="+b+"&b="+c, function( data ) {
				if (typeof data.last !== 'undefined' && data.last !== null && data.last){
				  $( "#poloniexLast"+a ).text(parseFloat(data.last).format(2, 3, '.', ','));
				}
			});
		
		}else{
			$.getJSON( "/preload/poloniex.php?a="+b+"&b="+a, function( data ) {
				if (typeof data.last !== 'undefined' && data.last !== null && data.last){
					$( "#poloniexLast"+a ).text(parseFloat(data.last).format(2, 3, '.', ','));
				}
			});
		}

		$.getJSON( "/preload/okcoin.php?a="+a+"&b="+b, function( data ) {
			if (typeof data.last !== 'undefined' && data.last !== null && data.last){
				$( "#okcoinLast"+a ).text(parseFloat(data.ticker.last).format(2, 3, '.', ','));
			}

		});
		
		$.getJSON( "/preload/bitstamp.php?a="+a+"&b="+b, function( data ) {
			if (typeof data.last !== 'undefined' && data.last !== null && data.last){
				$( "#bitstampLast"+a ).text(parseFloat(data.last).format(2, 3, '.', ','));
			}
		});		
		
	}	
	
	function preload(){
		getData('BTC', 'USD');
		getData('BCH', 'USD');
		getData('LTC', 'USD');
		getData('NMC', 'USD');
		getData('NVC', 'USD');
		getData('PPC', 'USD');
		getData('DSH', 'USD');
		getData('ETH', 'USD');
		getData('ZEC', 'USD');
	}
	
	preload();
	</script>
	
	
  </body>
</html>
