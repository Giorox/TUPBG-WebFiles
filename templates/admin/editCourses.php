<?php include "templates/include/header.php" ?>

<br>
<br>
<?php if($_SESSION['accesslevel'] == 1)
		include "templates/include/adminHeader.php"; 
	  elseif ($_SESSION['accesslevel'] == 2)
		include "templates/include/adminHeader_2.php"?>

<h1><?php echo $results['pageTitle']?></h1>
<form action="admin.php?action=<?php echo $results2['formAction']?>" method="post" enctype="multipart/form-data">
	<input type="hidden" id="courseID" name="courseID" value="<?php echo $results2['course']->courseID ?>"/>
	
	<?php if ( isset( $results2['errorMessage'] ) ) { ?>		
		<div class="alert alert-danger" role="alert">
			<?php echo $results2['errorMessage'] ?>
			
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	<?php } ?>

	<form>
		<div class="form-group">
			<label for="courseName">Nome do Curso</label>
			<input type="text" class="form-control" name="courseName" id="courseName" placeholder="Nome do Curso" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results2['course']->courseName )?>"/>
		</div>
		<div class="form-group">
			<label for="courseInstructor">Instrutor do Curso</label>
			<textarea class="form-control" name="courseInstructor" id="courseInstructor" placeholder="Instrutor do Curso" required maxlength="1000" rows="3"><?php echo htmlspecialchars( $results2['course']->courseInstructor )?></textarea>
		</div>	
		<div>
            <label for="courseStartDate">Data do Início:
				<b><?php if(htmlspecialchars( $results2['course']->courseStartDate ) != "")
							echo $results2['course']->courseStartDate ? date( "d-m-Y", $results2['course']->courseStartDate ) : "";
						else
							echo "Não possui";
				?></b>
			</label>
            <input type="date" name="courseStartDate" id="courseStartDate" placeholder="AAAA-MM-DD" required maxlength="10" value="<?php echo $results2['course']->courseStartDate ? date( "d-m-Y", $results2['course']->courseStartDate ) : "" ?>" />
        </div>
		<div>
            <label for="courseEndDate">Data do Fim:
				<b><?php if(htmlspecialchars( $results2['course']->courseEndDate ) != "")
							echo $results2['course']->courseEndDate ? date( "d-m-Y", $results2['course']->courseEndDate ) : "";
						else
							echo "Não possui";
				?></b>
			</label>
            <input type="date" name="courseEndDate" id="courseEndDate" placeholder="AAAA-MM-DD" required maxlength="10" value="<?php echo $results2['course']->courseEndDate ? date( "d-m-Y", $results2['course']->courseEndDate ) : "" ?>" />
        </div>
		<div class="form-group">
			<label for="courseDescription">Descrição do Curso</label>
			<textarea class="form-control" name="courseDescription" id="courseDescription" placeholder="Descriçao do Curso" required maxlength="1000" rows="3"><?php echo htmlspecialchars( $results2['course']->courseDescription )?></textarea>
			<script type="text/javascript">
				CKEDITOR.replace( 'courseDescription' );
			</script>
		</div>	
		<div class="form-group">
			<label for="coursePrice">Preço</label>
			<textarea class="form-control" name="coursePrice" id="coursePrice" placeholder="Preço do Curso" required maxlength="1000" rows="3"><?php echo htmlspecialchars( $results2['course']->coursePrice )?></textarea>
		</div>
		
		<div class="form-group">
			<label for="courseStatus">Situação Atual do Curso:
				<b><?php if(htmlspecialchars( $results2['course']->courseStatus ) == 1)
						echo "Inscrições Abertas";
					elseif (htmlspecialchars( $results2['course']->courseStatus ) == 2)
						echo "Em Andamento";
					elseif (htmlspecialchars( $results2['course']->courseStatus ) == 3)
						echo "Encerrado";
					else
						echo "Não possui";
				?></b>
			</label>
			<select class="form-control" name="courseStatus" id="courseStatus">
				<option>1 - Inscrições Abertas</option>
				<option>2 - Em Andamento</option>
				<option>3 - Encerrrado</option>
			</select>
		</div>
		
		<div class="buttons">
			<input class="btn btn-dark" type="submit" name="saveChanges" value="Salvar alterações" />
			<input class="btn btn-dark" type="submit" formnovalidate name="cancel" value="Cancelar" />
        </div>
		<br/>
	</form>

	<?php if ( $results2['course']->courseID ) { ?>
		<a href="admin.php?action=deleteCourses&amp;courseID=<?php echo $results2['course']->courseID ?>" onclick="return confirm('Tem certeza que deseja excluir este curso?')"><button class="btn btn-danger" type="button">Excluir este Curso</button></a>
	<?php } ?>
	<br/>
</form>

<?php include "templates/include/footer.php" ?>