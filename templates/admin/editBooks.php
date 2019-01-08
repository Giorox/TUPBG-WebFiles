<?php include "templates/include/header.php" ?>

<br>
<br>
<?php if($_SESSION['accesslevel'] == 1)
		include "templates/include/adminHeader.php"; 
	  elseif ($_SESSION['accesslevel'] == 2)
		include "templates/include/adminHeader_2.php"?>

<h1><?php echo $results['pageTitle']?></h1>
<form action="admin.php?action=<?php echo $results4['formAction']?>" method="post" enctype="multipart/form-data">
	<input type="hidden" id="bookID" name="bookID" value="<?php echo $results4['book']->bookID ?>"/>
	
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
			<label for="bookTitle">Título do Livro</label>
			<input type="text" class="form-control" name="bookTitle" id="bookTitle" placeholder="Título do Livro" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results4['book']->bookTitle )?>"/>
		</div>
		<div class="form-group">
			<label for="bookMedium">Médium</label>
			<textarea class="form-control" name="bookMedium" id="bookMedium" placeholder="Médium" required maxlength="1000" rows="2"><?php echo htmlspecialchars( $results4['book']->bookMedium )?></textarea>
		</div>	
		<div class="form-group">
			<label for="bookAuthor">Autor Espiritual</label>
			<textarea class="form-control" name="bookAuthor" id="bookAuthor" placeholder="Autor Espiritual" required maxlength="1000" rows="2"><?php echo htmlspecialchars( $results4['book']->bookAuthor )?></textarea>
		</div>	
		<div class="form-group">
			<label for="ISBN">ISBN</label>
			<textarea class="form-control" name="ISBN" id="ISBN" placeholder="ISBN do livro" required maxlength="1000" rows="1"><?php echo htmlspecialchars( $results4['book']->ISBN )?></textarea>
		</div>
		<div class="form-group">
			<label for="bookLink">Link</label>
			<textarea class="form-control" name="bookLink" id="bookLink" placeholder="Link do livro" required maxlength="1000" rows="3"><?php echo htmlspecialchars( $results4['book']->bookLink )?></textarea>
		</div>
		
		<div class="buttons">
			<input class="btn btn-dark" type="submit" name="saveChanges" value="Salvar alterações" />
			<input class="btn btn-dark" type="submit" formnovalidate name="cancel" value="Cancelar" />
        </div>
		<br/>
	</form>

	<?php if ( $results4['book']->bookID ) { ?>
		<a href="admin.php?action=deleteBooks&amp;bookID=<?php echo $results4['book']->bookID ?>" onclick="return confirm('Tem certeza que deseja excluir este livro?')"><button class="btn btn-danger" type="button">Excluir este Livro</button></a>
	<?php } ?>
	<br/>
</form>

<?php include "templates/include/footer.php" ?>