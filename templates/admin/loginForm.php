<?php include "templates/include/header.php" ?>

<ul class="col-sm-12">
<form action="admin.php?action=login" method="post">
    <input type="hidden" name="login" value="true" />
	<br>
	<br>
	<?php if ( isset( $results['errorMessage'] ) ) { ?>
		<div class="alert alert-danger" role="alert">
			<?php echo $results['errorMessage'] ?>
			
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	<?php } ?>
		
	<div class="card mb-4">
        <h5 class="card-header"><i class="fas fa-lock"></i> Login do Administrador</h5>
        <div class="card-body">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon1" style="width: 5rem;">Usuário</span>
				</div>
				<input type="text" name="username" id="username" class="form-control" placeholder="Seu nome de usuário" aria-label="User" aria-describedby="basic-addon1" required autofocus maxlength="20">
            </div>
			  
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon1" style="width: 5rem;">Senha</span>
				</div>
				<input type="password" name="password" id="password" class="form-control" placeholder="Sua senha" aria-label="Password" aria-describedby="basic-addon1" required maxlength="20">
            </div>
			<br>
			<button type="submit" name="login" class="btn btn-dark">Login</button>
			  
        </div>
    </div>    
</form>
</ul>
<?php include "templates/include/footer.php" ?>