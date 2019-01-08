<?php include "templates/include/header.php" ?>

<br>
<br>
<h1>Resultados da Busca.</h1>
<p><?php echo $results['totalRows']?> artigo<?php echo ( $results['totalRows'] != 1 ) ? 's' : '' ?> encontrados.</p>

<div class="list-group">

<?php foreach ( $results['articles'] as $article ) {
	if($article->title != 'NaN'){ //If the title is different than NaN, show it on screen, else, skip it.
?>	
	<a href=".?action=viewArticle&amp;articleId=<?php echo $article->id?>" class="list-group-item list-group-item-action flex-column align-items-start">
		<div class="d-flex w-100 justify-content-between">
			<h5 class="mb-1"><?php echo htmlspecialchars( $article->title )?></h5>
			<small><?php echo strftime('%d/%m/%G', $article->publicationDate)?></small>
		</div>
		<p class="summary"><?php echo strip_tags(htmlspecialchars_decode( $article->summary ))?></p>
	</a>
<?php } }?>

</div>
<p><a href="./">Retornar à página inicial</a></p>

<?php include "templates/include/footer.php" ?>