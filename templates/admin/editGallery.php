<?php include "templates/include/header.php";
$dir = "images/photogallery";
$images = glob("$dir/*.{jpg,png,bmp}", GLOB_BRACE);
 ?>
 
<br>
<br>
<?php if($_SESSION['accesslevel'] == 1)
		include "templates/include/adminHeader.php"; 
	  elseif ($_SESSION['accesslevel'] == 2)
		include "templates/include/adminHeader_2.php"?>

<h1><?php echo $results['pageTitle']?></h1>

<form action="admin.php?action=<?php echo $results['formAction']?>" method="post" enctype="multipart/form-data">

	<?php if ( isset( $results['errorMessage'] ) ) { ?>		
		<div class="alert alert-danger" role="alert">
			<?php echo $results['errorMessage'] ?>
			
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	<?php } ?>

	<form>		
		<?php foreach($images as $image) { ?>
			<div>
				<img id="articleImage" src="<?php echo $image ?>" alt="Article Image" width="250px" height="150px"/>
				<input type="hidden" name="URLimagem" value="<?php echo $image; ?>" />
			</div>
			</br>
        <?php } ?>
			
        <div>
			<label for="image">Nova Imagem</label>
			<input type="file" name="fileToUpload" id="fileToUpload" placeholder="Escolha uma imagem" maxlength="255" />
        </div>		
		
		<div class="buttons">
			<input class="btn btn-dark" type="submit" name="saveChanges" value="Carregar Imagem Nova" />
			<input class="btn btn-dark" type="submit" name="deleteImg" value="Deletar Imagem Mais Antiga" />
			<input class="btn btn-dark" type="submit" formnovalidate name="cancel" value="Cancelar" />
        </div>
		
		<br/>
	</form>
	<br/>
</form>

<?php include "templates/include/footer.php"; ?>

