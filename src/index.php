<?php
	define("DOC_ROOT", getenv("DOCUMENT_ROOT"));		// Identificar pastas (apenas as do projetos)
	define("PROJ_DIR", $_SERVER['REQUEST_URI']);
	define("TITLE", strlen(PROJ_DIR) === 1 ? substr(DOC_ROOT, 3) : substr(substr(PROJ_DIR,1,strlen(PROJ_DIR)-2),strrpos(substr(PROJ_DIR,0,strlen(PROJ_DIR)-2), '/')));
	
	for ($i=0; $i < substr_count(PROJ_DIR,'/',1); $i++) { 
		$path = $path.'../'; 
	}

	require_once($path.'cfg.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= TITLE ?></title>

    <link rel="stylesheet" href="<?= CSS_DIR ?>bootstrap-reboot.min.css">
    <link rel="stylesheet" href="<?= CSS_DIR ?>bootstrap.css">
    <link rel="stylesheet" href="<?= CSS_DIR ?>custom.min.css">

</head>
<body>
	
	<?php if(PROJ_DIR !== '/'){ ?>
	<div class="container">
		<nav aria-label="...">
			<ul class="pagination pagination-lg justify-content-center">
				<li class="page-item"><a class="page-link" href="/">HOME</a></li>
				<?php
					foreach(glob(DOC_ROOT.'/*', GLOB_ONLYDIR) as $dir) {
						$link = substr($dir, strpos($dir,'/')+1);
						if(strpos($link,'_') === FALSE){
							$class = (strtoupper($link) == strtoupper(str_replace('/', '', PROJ_DIR))) ? ' disabled' : '';
							echo '<li class="page-item'.$class.'"><a class="page-link" href="/'.strtoupper($link).'/">'.strtoupper($link).'</a></li>';
						}
					}
				?>
			</ul>
		</nav>
	</div>
	<?php } ?>
	<div class="container">

		<div class="row">

			<?php
			foreach(glob(DOC_ROOT.PROJ_DIR.'*', GLOB_ONLYDIR) as $dir) {
				$projeto = str_replace(DOC_ROOT.PROJ_DIR, '', $dir);
				if(strpos($projeto,'_') === FALSE){
					$link = checkSpecifics($projeto);
					$cardTitle = str_replace('_', '', $projeto);
					$logo = localizaLogo($projeto);
					$blog = strpos(strtoupper($projeto),'BLOG') ? 'blog': '';
					$bgText = (empty($logo)) ? '' : "style='background-image: url(".$logo.");'";
					$linkText = (empty($logo)) ? $projeto : '&nbsp;';
			?>
	
			<div class="card-group col-sm-3">
				<div class="card bg-light">
					<div class="card-header">
						<h5 class="card-title"><?= strtoupper($cardTitle) ?></h5>
					</div>
					<div class="card-body">
						<a href="<?= is_null($link) ? $projeto : $link ?>">
						<img class="card-img-top" src="<?=  $logo ?>" alt="<?= $projeto ?> logo">
						</a>
					</div>
				</div>
			</div>
	
			<?php } } ?>
	
		</div>
	</div>

	<?php
	function localizaLogo($projeto){
		$local = "";
		$filePNG = (!file_exists(IMG_DIR.$filePNG)) ? "noimage.png" : strtolower($projeto).".png";
		$fileJPG = (!file_exists(IMG_DIR.$fileJPG)) ? "noimage.jpg" : strtolower($projeto).".jpg";

		if(file_exists(IMG_DIR.$filePNG)){
			$local = IMG_DIR.$filePNG;
		}elseif(file_exists(IMG_DIR.$fileJPG)){
			$local = IMG_DIR.$fileJPG;
		}else{
			$local = IMG_DIR."noimage.png";
		}
		return $local;
	}
	function checkSpecifics ($projeto){
		$link = null;
		if(strtolower(TITLE) === 'laravel' ){
			$link = 'http://'.$projeto.'.test';
		}
		return $link;
	}
	?>
    <script source="<?= JS_DIR ?>bootstrap.bundle.min.js"></script>
    <script source="<?= JS_DIR ?>bootstrap.min.js"></script>
</body>
</html>