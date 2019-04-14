<?php include "templates/include/header.php" ?>

<br>
<br>
<?php if($_SESSION['accesslevel'] == 1)
		include "templates/include/adminHeader.php"; 
	  elseif ($_SESSION['accesslevel'] == 2)
		include "templates/include/adminHeader_2.php"?>

<h1><?php echo $results['pageTitle']?></h1>
<form action="admin.php?action=<?php echo $results3['formAction']?>" method="post" enctype="multipart/form-data">
	<input type="hidden" id="newsID" name="newsID" value="<?php echo $results3['news']->newsID ?>"/>

	<?php if ( isset( $results3['errorMessage'] ) ) { ?>		
		<div class="alert alert-danger" role="alert">
			<?php echo $results3['errorMessage'] ?>
			
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	<?php } ?>

	<form>
		<div class="form-group">
			<label for="titulo">Título</label>
			<input type="text" class="form-control" name="title" id="title" placeholder="Título da notícia" autofocus maxlength="255" value="<?php echo htmlspecialchars( $results3['news']->title )?>"/>
		</div>
		<div class="form-group">
			<label for="conteudo">Conteúdo</label>
			<textarea class="form-control" name="content" id="content" placeholder="Conteúdo da notícia" maxlength="100000" rows="6"><?php echo htmlspecialchars( $results3['news']->content )?></textarea>
		</div>
<script type="text/javascript">
				CKEDITOR.replace( 'content' );
			</script>
		
		<?php if ( $results3['news'] && $imagePath = $results3['news']->getImagePath() ) { ?>
			<div>
				<label>Imagem Atual</label>
				<img id="newsImage" src="<?php echo $imagePath ?>" alt="News Image" />
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
		
		<div class="buttons">
			<input class="btn btn-dark" type="submit" name="saveChanges" value="Salvar alterações" />
			<input class="btn btn-dark" type="submit" formnovalidate name="cancel" value="Cancelar" />
        </div>
		<br/>
	</form>

	<?php if ( $results3['news']->newsID ) { ?>
		<a href="admin.php?action=deleteNews&amp;newsID=<?php echo $results3['news']->newsID ?>" onclick="return confirm('Tem certeza que deseja excluir esta notícia?')"><button class="btn btn-danger" type="button">Excluir esta notícia</button></a>
	<?php } ?>
	
</form>

<?php include "templates/include/footer.php" ?>