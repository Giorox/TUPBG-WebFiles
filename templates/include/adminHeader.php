<!-- This is the admin header for access level 1 -->

<div id="adminHeader" class="card mb-4">
    <h5 class="card-header"><i class="fas fa-toolbox"></i> Dashboard do Administrador</h5>
    <div class="card-body">
		<p>Você esta logado como <b><?php echo htmlspecialchars( $_SESSION['username']); ?></b>.</p>
		<?php if(basename($_SERVER['PHP_SELF']) == "admin.php" && !isset( $_GET['action'] )){ ?> 
			<p><?php echo $results['totalRows']?> artigo<?php echo ( $results['totalRows'] > 1 ) ? 's' : '' ?> no total.<br>
			<?php echo $results2['totalRows']?> curso<?php echo ($results2['totalRows'] > 1) ? 's' : '' ?> no total.<br>
			<?php echo $results3['totalRows']?> notícia<?php echo ($results3['totalRows'] > 1) ? 's' : '' ?> no total.<br>
			<?php echo $results4['totalRows']?> livro<?php echo ($results4['totalRows'] > 1) ? 's' : '' ?> no total.</p> 
		<?php } ?>
		<a href="admin.php?action=newArticle"><button class="btn btn-dark" type="button">Publicar Artigo</button></a>
		<a href="admin.php?action=newCourses"><button class="btn btn-dark" type="button">Novo Curso</button></a>
		<a href="admin.php?action=editPhotoGallery"><button class="btn btn-dark" type="button">Subir Foto</button></a>
		<a href="admin.php?action=newNews"><button class="btn btn-dark" type="button">Nova Notícia</button></a>
		<a href="admin.php?action=newBooks"><button class="btn btn-dark" type="button">Novo Livro</button></a>
		<a href="admin.php?action=logout"><button class="btn btn-dark" type="button">Sair</button></a>
	</div>
</div>