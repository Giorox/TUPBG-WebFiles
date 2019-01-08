<!-- This is the admin header for access level 2 -->

<div id="adminHeader" class="card mb-4">
    <h5 class="card-header"><i class="fas fa-toolbox"></i> Dashboard do Administrador</h5>
    <div class="card-body">
		<p>Você esta logado como <b><?php echo htmlspecialchars( $_SESSION['username']); ?></b>.</p>
		<?php if(basename($_SERVER['PHP_SELF']) == "admin.php" && !isset( $_GET['action'] )){ ?>
			<p><?php echo $results['totalRows']?> artigo<?php echo ( $results['totalRows'] > 1 ) ? 's' : '' ?> no total.<br>
		<?php } ?>
		<a href="admin.php?action=newArticle"><button class="btn btn-dark" type="button">Publicar Artigo</button></a>
		<a href="admin.php?action=logout"><button class="btn btn-dark" type="button">Sair</button></a>
	</div>
</div>