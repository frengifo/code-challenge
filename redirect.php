<?php

ini_set('display_errors', 0);

if(!preg_match('|^[0-9a-zA-Z]{1,6}$|', $_GET['url']))
{
	die('Esta no es una URL válida');
}

require('config/config.php');
require('libraries/MysqliDb.php');

$db = new MysqliDb (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$shortened_id = getIDFromShortenedURL($_GET['url']);

//OBTENER URL POR ID
$db->where ("id",  $shortened_id );
$long_url = $db->getOne ( DB_TABLE );

//INCREMENTAR NUMERO DE VISITAS
$data = Array (  'referrals' => $db->inc(1) 	);
$db->where ('id',  $shortened_id );
$db->update (DB_TABLE, $data);

//REDIRECIONAR A LA URL LARGA
header('HTTP/1.1 301 Moved Permanently');
header('Location: ' .  $long_url['long_url']);
exit;

function getIDFromShortenedURL ($string, $base = ALLOWED_CHARS)
{
	$length = strlen($base);
	$size = strlen($string) - 1;
	$string = str_split($string);
	$out = strpos($base, array_pop($string));
	foreach($string as $i => $char)
	{
		$out += strpos($base, $char) * pow($length, $size - $i);
	}
	return $out;
}