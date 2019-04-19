<?php include "templates/include/header.php" ?>
<br>
<br>
<div class="col-sm-12" class="card mb-4">
    <?php if ( $imagePath = $results['article']->getImagePath( IMG_TYPE_FULLSIZE ) ) { ?>
		<img class="card-img-top" src="<?php echo $imagePath?>" alt="Card image cap">
	<?php }else { ?>
		<img class="card-img-top" src="http://placehold.it/750x300" alt="Card image cap">
	<?php } ?>
    <div class="card-body">
        <h2 class="card-title"><?php echo $results['article']->title?></h2>
        <p class="card-text"><?php echo $results['article']->summary ?></p>
		<p class="card-text"><?php echo $results['article']->content?></p>
		<a href="./" class="btn btn-primary">&larr; Retornar à pagina inicial</a>
    </div>
    <div class="card-footer text-muted">
        Publicado <?php echo strftime('%d/%m/%G', $results['article']->publicationDate)?> por
        <a href="#">Admin</a>
		<br>
		Tags: <?php echo $results['article']->tagString?>
    </div>
</div>

<?php include "templates/include/footer.php" ?>