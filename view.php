<?php 
require_once('init/init.php');
require_once('kelas/class.soundcloud.php');
$otak = new soundcloud;

if (isset($_GET['id'])) {
	$data = json_decode($otak->grab('http://api.soundcloud.com/tracks/'.$_GET['id'].'?client_id='.$otak->client_ID));

	$durasi = $otak->durasi($data->duration);
	$title = $data->title;
	$size = $otak->getSize($data->original_content_size);
	$genre = '';
	if ($data->genre == '') {
		$genre = 'Tidak ada Genre';
	} else {
		$genre = $data->genre;
	}
	$created = date('d M Y', strtotime($data->created_at));
	$deskripsi = $data->description;

include('partials/header.php');
 ?>
	<!-- <img src="assets/img/KnightMusic.png" alt=""> -->
	<div class="wrapper">
		<div class="top-info">
			<div class="thumb-logo">
				<img src="theme/KnightMusic.png" alt="">
			</div>
			<h1>Music Search Engine that User Friendly</h1>
		</div>
		<div class="search-form">
			<form action="">
				<div class="input-group input-group-lg">
			      <input type="text" class="form-control" placeholder="Search for...">
			      <span class="input-group-btn">
			        <button class="btn btn-default" type="button"><i class="glyphicon glyphicon-search"></i></button>
			      </span>
			    </div>
			</form>
		</div>
		<div class="result">
			<div class="lists">
				<div class="lists-body" style="float: none;">
					<h3 class="title-lists"><a href="javascript:void(0)"><?= $title; ?></a></h3>
					<div class="lists-info">
						<span class="icon"><i class="glyphicon glyphicon-tag"></i></span>
						<span><?= $genre; ?></span>
						<span class="icon"><i class="glyphicon glyphicon-hdd"></i></span>
						<span><?= $size; ?></span>
					</div>
					<div class="description">
						<ul>
							<li><span>Title :</span><?= $title; ?></li>
							<li><span>Size :</span><?= $size; ?></li>
							<li><span>Duration :</span><?= $durasi; ?></li>
							<li><span>Genre :</span><?= $genre; ?></li>
							<li><span>Created At :</span></li>
						</ul>
						<div class="subdesc">
							<p><?= $deskripsi ?></p>
						</div>
					</div>
					<div class="action prevAction">
						<a href="download.php?id=<?= $_GET['id'] ?>&title=<?= $otak->removeSpace($title) ?>" class="btn"><i class="glyphicon glyphicon-cloud-download"></i> Download</a> <a href="https://web.facebook.com/sharer.php?u=http://sc-grab.dev" class="btn" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="glyphicon glyphicon-share"></i> Share</a>
					</div>
					<div class="other">
						<h2>Other Musics</h2>
						<ul>
						<?php
						$url = 'http://api.soundcloud.com/tracks.json?genres='.str_replace(' ', '%20', $data->genre).'&limit=5&client_id='.$otak->client_ID;
						$json = json_decode($otak->grab($url));
						
							foreach ($json as $list):
								$title = $list->title;
								$url = 'view.php?id='.$list->id;
						?>
						
							<li>
								<h4><a href="<?= $url ?>"><?= $title ?></a></h4>
							</li>
						<?php endforeach;  ?>
						</ul>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</div>
	
<?php 
} else {
	header("Location: index.php");
}

include('partials/footer.php');
 ?>