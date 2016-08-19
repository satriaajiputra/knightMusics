<?php 

include_once('kelas/class.soundcloud.php');
$init = new Soundcloud;

if(isset($_GET['id']) && isset($_GET['title'])) {
	$url = $init->download($_GET['id']);
	header("Content-Type: audio/mpeg");
	header("Content-Length:".$init->getfilesize($init->download($_GET['id'])));
	header('Content-Disposition:attachment; filename="'.$_GET['title'].'-[KM - KnightMusic].mp3"');
	
	readfile($url);
	header("Content-Transfer-Encoding:binary");
} else {
	header('Location:search.php');
}


 ?>