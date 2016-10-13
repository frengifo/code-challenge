<!DOCTYPE html>
<html>
	<title>Code Challenge</title>
	<meta name="robots" content="noindex, nofollow">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css" media="all" />
	<link rel="stylesheet" href="assets/css/main.css" type="text/css" media="all" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
	<link rel="shortcut icon" href="https://test-hl.koding.com/a/images/favicon.ico">
<body>


	
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<form method="post" action="shorten.php" id="shortener">
					<label for="longurl">[INGRESE URL]</label>
					<input type="search" name="longurl" id="longurl" placeholder="http://getbootstrap.com/" required>
					<a href="#" target="_blank" class="short"></a>
					<div class="clear"></div>
					<a href="javascript:;" class="back"><i class="fa fa-undo" aria-hidden="true"></i></a>
					<input type="submit" value="Shorten" id="btn">
				</form>
			</div>
			<div class="col-md-12">
				<h2>Estadisticas</h2>
				<table border="1">
					<thead>
						<tr>
							<td>URL</td>
							<td>URL ACORTADA</td>
							<td>FECHA</td>
							<td>TOTAL REFERENCIAS</td>
						</tr>
					</thead>
					<tbody id="list">
					
							<tr>
								<td>http</td>
								<td>http</td>
								<td>2016</td>
								<td class="text-center">20</td>
							</tr>
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
	
	<script>
	
	$(function () {
		$('#shortener').submit(function () {
			$.ajax({data: {longurl: $('#longurl').val()}, url: 'shorten.php', complete: function (XMLHttpRequest, textStatus) {
				$('#longurl').val("")
				$('#longurl, #btn').hide();
				$('.short').html(XMLHttpRequest.responseText); 
				$('.short').attr("href",XMLHttpRequest.responseText); 
				$('.short, .back').fadeIn();
				$('#shortener').css({"background-color":"rgb(0, 212, 43)"})
			}});
			return false;
		});
		
		$(".back").click(function(){
			$('.short, .back').hide();
			$('#longurl, #btn').fadeIn();
			$('#shortener').css({"background-color":"rgb(247, 215, 9)"})
		})
		
		$.post( "shorten.php",{ get_urls: 1 }, function( data ) {
		  $( "#list" ).html( data );
		});
		
	});
	
	</script>
</body>
</html>

