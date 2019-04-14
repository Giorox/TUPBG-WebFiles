<?php include "templates/include/header.php";
$index = 0;
 ?>

<ul class="col-sm-12" id="headlines">
	<br>
	<br>
	<div class="card mb-4">
		<!--<img class="card-img-top" src="images/logotipo_pai_benedito.jpg" alt="Card image cap">-->
		<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="5000" data-pause="hover">
					<ol class="carousel-indicators">
						<?php foreach ( $results3['news'] as $news ) { ?>
							<?php if ( $index === 0 ) { ?>
								<li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $news->newsID?>" class="active"></li>
							<?php }else { ?>
								<li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $news->newsID?>"></li>
							<?php } $index = $index + 1; ?>
						<?php } $index = 0; ?>
					</ol>
					<div class="carousel-inner">
						<?php foreach ( $results3['news'] as $news ) { ?>
							<?php if ( $index === 0 ) { ?>
								<div class="carousel-item active">
							<?php }else { ?>
								<div class="carousel-item">
							<?php } $index = $index + 1; ?>
								<img class="d-block w-100" src="<?php echo ($news->getImagePath( IMG_TYPE_FULLSIZE )) ?>"/>
								<div class="carousel-caption d-none d-md-block">
									<h5><?php echo $news->title ?></h5>
									<p><?php echo $news->content ?></p>
								</div>
							</div>
						<?php } $index = 0; ?>
					</div>
				</div>
				<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
		<div class="card-body">
			<h2 class="card-title">Bem-Vindo à Tenda</h2>
			<p class="card-text">O passado e o presente endossam o futuro.</p>
			<a href="quemsomos_intro.php" class="btn btn-primary">Continuar lendo &rarr;</a>
		</div>
	</div>

	<?php foreach ( $results['articles'] as $article ) { ?>
		<!-- Blog Post -->
        <div class="card mb-4">
			<?php if ( $imagePath = $article->getImagePath( IMG_TYPE_FULLSIZE ) ) { ?>
				<img class="card-img-top" src="<?php echo $imagePath?>" alt="Card image cap">
			<?php }else { ?>
				<img class="card-img-top" src="http://placehold.it/750x300" alt="Card image cap">
			<?php } ?>
            <div class="card-body">
				<h2 class="card-title"><?php echo $article->title?></h2>
				<p class="card-text"><?php echo $article->summary?></p>
				<a href=".?action=viewArticle&amp;articleId=<?php echo $article->id?>" class="btn btn-primary">Continuar lendo &rarr;</a>
            </div>
            <div class="card-footer text-muted">
				Publicado <?php echo strftime('%d/%m/%G', $article->publicationDate)?> por
				<a href="#">Admin</a>
            </div>
        </div>  
	<?php } ?>

</ul>
<p><a href="./?action=archive&pageNumber=1">Todos os Artigos</a></p>

<?php include "templates/include/footer.php" ?>