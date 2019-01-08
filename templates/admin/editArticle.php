<?php include "templates/include/header.php" ?>

<br>
<br>
<?php if($_SESSION['accesslevel'] == 1)
		include "templates/include/adminHeader.php"; 
	  elseif ($_SESSION['accesslevel'] == 2)
		include "templates/include/adminHeader_2.php"?>

<h1><?php echo $results['pageTitle']?></h1>
<form action="admin.php?action=<?php echo $results['formAction']?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="articleId" value="<?php echo $results['article']->id ?>"/>

	<?php if ( isset( $results['errorMessage'] ) ) { ?>		
		<div class="alert alert-danger" role="alert">
			<?php echo $results['errorMessage'] ?>
			
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	<?php } ?>

	<form>
		<div class="form-group">
			<label for="titulo">Título</label>
			<input type="text" class="form-control" name="title" id="title" placeholder="Título do Artigo" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['article']->title )?>"/>
		</div>
		<div class="form-group">
			<label for="sumario">Sumário</label>
			<textarea class="form-control" name="summary" id="summary" placeholder="Breve sumário do artigo" required maxlength="1000" rows="3"><?php echo htmlspecialchars( $results['article']->summary )?></textarea>
			<script type="text/javascript">
				CKEDITOR.replace( 'summary', { toolbar : 'Basic' , extraPlugins: 'imageuploader'} );
			</script>
		</div>
		<div class="form-group">
			<label for="conteudo">Conteúdo</label>
			<textarea class="form-control" name="content" id="content" placeholder="Conteúdo do artigo" required maxlength="100000" rows="6"><?php echo htmlspecialchars( $results['article']->content )?></textarea>
			<script type="text/javascript">
				CKEDITOR.replace( 'content', {extraPlugins: 'imageuploader'});
			</script>
		</div>
		<div class="form-group">
			<label for="conteudo">Tags</label>
			<textarea class="form-control" name="tagString" id="tagString" placeholder="Tags do artigo" required maxlength="255" rows="1"><?php echo htmlspecialchars( $results['article']->tagString )?></textarea>
		</div>
		
		<?php if ( $results['article'] && $imagePath = $results['article']->getImagePath() ) { ?>
			<div>
				<label>Imagem Atual</label>
				<img id="articleImage" src="<?php echo $imagePath ?>" alt="Article Image" />
			</div>
 
			<div>
				<label></label>
				<input type="checkbox" name="deleteImage" id="deleteImage" value="yes"/ > <label for="deleteImage">Excluir imagem</label>
			</div>
        <?php } ?>
 
        <div>
			<label for="image">Nova Imagem</label>
			<input type="file" name="image" id="image" placeholder="Escolha uma imagem" maxlength="255" />
        </div>
		
		<div>
            <label for="publicationDate">Data de Publicação:
			<b><?php if(htmlspecialchars( $results['article']->publicationDate ) != "")
							echo $results['article']->publicationDate ? date( "d-m-Y", $results['article']->publicationDate ) : "";
						else
							echo "Não possui";
				?></b>
			</label>
            <input type="date" name="publicationDate" id="publicationDate" placeholder="AAAA-MM-DD" required maxlength="10" value="<?php echo $results['article']->publicationDate ? date( "d-m-Y", $results['article']->publicationDate ) : "" ?>" />
        </div>
		
		<div class="buttons">
			<input class="btn btn-dark" type="submit" name="saveChanges" value="Salvar alterações" />
			<input class="btn btn-dark" type="submit" formnovalidate name="cancel" value="Cancelar" />
        </div>
		<br/>
	</form>

	<?php if ( $results['article']->id ) { ?>
		<a href="admin.php?action=deleteArticle&amp;articleId=<?php echo $results['article']->id ?>" onclick="return confirm('Tem certeza que deseja excluir este artigo?')"><button class="btn btn-danger" type="button">Excluir este Artigo</button></a>
	<?php } ?>
	
</form>

<?php include "templates/include/footer.php" ?>