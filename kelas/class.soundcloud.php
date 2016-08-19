<?php

/*

	Created By Satria Aji Putra
	https://web.facebook.com/aji.s.aj1555

*/


class Soundcloud {

	// ganti kode pakai client id kamu
	public $client_ID = '99a45fcd6a56ea4d7aea237edea8500c';

	public function grab($url) {
		ini_set("user_agent","Opera/9.80 (J2ME/MIDP; Opera Mini/4.2 19.42.55/19.892; U; en) Presto/2.5.25");
		$grab = @fopen($url, 'r');
		$contents = "";
		if ($grab) {
			while (!feof($grab)) {
				$contents.= fread($grab, 8192);
			}
			fclose($grab);
		}
		return $contents;
	}

	public function removeSpace($string) {
		$qw = str_replace('+','_',$string);
		$qw = str_replace('-','_',$qw);
		$qw = str_replace(' ','_',$qw);
		return $qw;
	}

	public function getSize($size) {
		$sizeOri = $size;
		$sizeName = array(" Bytes"," KB"," MB"," GB"," TB"," PB"," EB"," ZB"," YB");
		return $sizeOri ?	 round($sizeOri/pow(1024,($i=floor(log($sizeOri,1024)))),2).$sizeName[$i] : '0 Bytes';
	}

	public function limit_string($string) {
		if (strlen($string) >= 20) {
			return substr($string, 0, 40)."...";
		}
		return $string;
	}

	public function download($id) {
		$url = json_decode($this->grab('http://api.soundcloud.com/i1/tracks/'.$id.'/streams?client_id=99a45fcd6a56ea4d7aea237edea8500c'));

		return $url->http_mp3_128_url;
	}

	public function getfilesize($url) {
		$data=get_headers($url, true);
		if (isset($data['Content-Length'])){
			return (int)$data['Content-Length'];
		}
	}

	public function durasi($milsec) {
	    $seconds = floor($milsec / 1000);
	    $minutes = floor($seconds / 60);
	    $seconds = $seconds % 60;
	    $minutes = $minutes % 60;

	    $format = '%u:%02u';
	    $time = sprintf($format, $minutes, $seconds);
	    return rtrim($time, '0');
	}

}