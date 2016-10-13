<?php

 
ini_set('display_errors', 0);
//OBTIENE LA URL 
$url_to_shorten = get_magic_quotes_gpc() ? stripslashes(trim($_REQUEST['longurl'])) : trim($_REQUEST['longurl']);
require('config/config.php');
require('libraries/MysqliDb.php');

$db = new MysqliDb (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if(!empty($url_to_shorten) && preg_match('|^https?://|', $url_to_shorten))
{
	

	// VALIDAR URL
	if(CHECK_URL)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url_to_shorten);
		curl_setopt($ch,  CURLOPT_RETURNTRANSFER, TRUE);
		$response = curl_exec($ch);
		$response_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		if($response_status == '404')
		{
			die('Url no encontrada error: 404');
		}
		
	}
	
	// SI LA URL YA FUE REGISTRADA
	$db->where ("long_url", $url_to_shorten );
	$already_shortened = $db->getOne ( DB_TABLE );
	
	if(!empty($already_shortened))
	{
		// OBTENER URL
		$shortened_url = getShortenedURLFromID($already_shortened['id']);
		
	}
	else
	{
		
		//SI NO REGISTRAR URL
		$data = Array ("long_url" => $url_to_shorten,
		               "created" => time(),
		               "creator" => $_SERVER['REMOTE_ADDR'],
		               "mobile" => isMobile() ? 1:0,
		);
		$id = $db->insert (DB_TABLE, $data);

		$shortened_url = getShortenedURLFromID($id);
		

	}
	echo BASE_HREF . $shortened_url;
}

function getShortenedURLFromID ($integer, $base = ALLOWED_CHARS)
{
	$length = strlen($base);
	while($integer > $length - 1)
	{
		$out = $base[fmod($integer, $length)] . $out;
		$integer = floor( $integer / $length );
	}
	return $base[$integer] . $out;
}
function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}


if( isset( $_POST['get_urls'] ) ){ 
	
	$urls = $db->get('short_urls');
	
	foreach($urls as $key => $value){
		$shorUrl =  BASE_HREF.getShortenedURLFromID($value['id']);
?>
	
	<tr>
		<td><?php echo $value['long_url'] ?></td>
		<td>
			<a href="<?php echo $shorUrl; ?>" target="_blank">
				<?php echo $shorUrl; ?>
			</a>
		</td>
		<td><?php echo date('Y-m-d h:m:i', $value['created'] ) ?></td>
		<td class="text-center"><?php echo $value['referrals'] ?></td>
	</tr>	
	
<?php
	}
}
