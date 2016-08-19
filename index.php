<?php 
require_once('init/init.php');
require_once('kelas/class.soundcloud.php');

$otak = new Soundcloud;

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
			<form action="/" method="get">
				<div class="input-group input-group-lg">
			      <input type="text" name="q" class="form-control" placeholder="Search for...">
			      <span class="input-group-btn">
			        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
			      </span>
			    </div>
			</form>
		</div>
		<?php 

		if(!empty($_GET['page'])){
			$noPage=$_GET['page'];
			$page=($noPage-1)*12;
		}else{
			$noPage='1';
			$page='0';
		}

		if (empty($_GET['q'])) {
			echo "
				<div class='result'>
					Keyword harus diisi.
				</div>
			";
		} else {
			$url = 'http://api.soundcloud.com/tracks.json?q='.$otak->removeSpace($_GET['q']).'&limit=12&offset='.$page.'&client_id='.$otak->client_ID;
			$json = json_decode($otak->grab($url));
			
			echo "<div class='result'>";
			if(!empty($json[0]->title)) {
			foreach ($json as $list):

			$id = $list->id;
			$permalink = $list->permalink_url;
			$title = $list->title;
			$suka = $list->likes_count;
			$size = $list->original_content_size;
			
			if ($genre = $list->genre) {
				$genre = $genre;
			} else {
				$genre = 'Tidak ada Genre';
			}

			if($song=$list->artwork_url) {
				$thumb = $song ;
			}
			else {
				$thumb='theme/KnightMusic.png';
			}
		 ?>
			<div class="lists">
				<div class="lists-left">
					<a href="javascript:void(0)">
						<img src="<?php echo $thumb ?>" alt="">
					</a>
				</div>
				<div class="lists-body">
					<h3 class="title-lists"><a href="view.php?id=<?= $id ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $title ?>"><?php echo $otak->limit_string($title) ?></a></h3>
					<div class="lists-info">
						<span class="icon"><i class="glyphicon glyphicon-tag"></i></span>
						<span><?php echo $genre ?></span>
						<span class="icon"><i class="glyphicon glyphicon-thumbs-up"></i></span>
						<span><?php echo $suka ?></span>
						<span class="icon"><i class="glyphicon glyphicon-hdd"></i></span>
						<span><?php echo $otak->getSize($size) ?></span>
					</div>
					<audio controls preload="none">
						<source src="http://api.soundcloud.com/tracks/<?php echo $id; ?>/stream?client_id=<?php echo $otak->client_ID ?>" type="audio/mpeg">
					</audio>
					<div class="action">
						<a href="download.php?id=<?= $id ?>&title=<?= $otak->removeSpace($title) ?>" class="btn"><i class="glyphicon glyphicon-cloud-download"></i> Download</a> <a target="_blank" href="https://web.facebook.com/sharer.php?u=http://sc-grab.dev" class="btn"><i class="glyphicon glyphicon-share"></i> Share</a>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		<?php endforeach; } }
		?>
		<?php if(!empty($_GET['q'])) { ?>
		<div class="pagger">
			<nav aria-label="...">
			  <ul class="pager">
			  	<?php 
			  		if($noPage > 1) {
			  			echo '<li><a href="?q='.$_GET['q'].'&page='.($noPage-1).'"><span aria-hidden="true">&larr;</span> Previous</a></li>';
			  		} else {
			  			echo '<li class="disabled"><a href="#"><span aria-hidden="true">&larr;</span> Previous</a></li>';
			  		}

			  		if(!empty($json[9])) {
			  			echo '<li><a href="?q='.$_GET['q'].'&page='.($noPage+1).'">Next<span aria-hidden="true">&rarr;</span></a></a></li>';
			  		} else {
			  			echo '<li class="disabled"><a href="#">Next <span aria-hidden="true">&rarr;</span></a></li>';
			  		}
			  	 ?>
			    
			  </ul>
			</nav>
		</div>
		<?php } ?>
		</div>
	</div>
<?php include('partials/footer.php') ?>