<!DOCTYPE html>
<html lang="en">

<style>
	.dropdown:hover>.dropdown-menu 
	{
		display: block;
	}
	
	.alert
	{
		width:400px
	}
	
	.btn-dark--scrollTo
	{
		display: none; /* Hidden by default */
		position: fixed; /* Sticky position */
		bottom: 50px; /* Place the button at the bottom of the page */
		right: 30px; /* Place the button 30px from the right */
		z-index: 99; /* Make sure it is always on top */
		color: #fff;
		background-color: #343a40;
		border-color: #343a40;
	}

.vertical-scrolling
	{
		height: 300px;
		overflow-y: auto;
		overflow-x: hidden;
	}
	
.dropdown-menu.columns-2 {
	min-width: 500px;
}
.multi-column-dropdown {
	list-style: none;
}
 
@media (max-width: 767px) {
	.dropdown-menu.multi-column {
		min-width: 240px !important;
		overflow-x: hidden;
	}
}
</style>

  <head>  
  <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-131380572-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-131380572-1');
</script>

	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
	<link rel="icon" type="image/png" href="images/favicon.png">

    <title><?php echo htmlspecialchars( $results['pageTitle'] )?></title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/blog-home.css" rel="stylesheet">
	
	<!-- Font Awesome Icons -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/solid.css" integrity="sha384-wnAC7ln+XN0UKdcPvJvtqIH3jOjs9pnKnq9qX68ImXvOGz2JuFoEiCjT8jyZQX2z" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/fontawesome.css" integrity="sha384-HbmWTHay9psM8qyzEKPc8odH4DsOuzdejtnr+OFtDmOcIVnhgReQ4GZBH7uwcjf6" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/brands.css" integrity="sha384-rf1bqOAj3+pw6NqYrtaE1/4Se2NBwkIfeYbsFdtiR6TQz0acWiwJbv1IM/Nt/ite" crossorigin="anonymous">
	
        <!-- Back To Top (Smooth) -->
	<link rel="stylesheet" href="css/style.css"> <!-- Resource style -->

	<!-- WYSIWYG Editor -->
	<script type="text/javascript" src="templates/include/ckeditor/ckeditor.js"></script>
  </head>

  <body>
	
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="index.php"><img src="images/logotipo_letras.png" width="160" height="40" class="thumbnail" alt="Cinque Terre" align="right"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Início
                <span class="sr-only">(current)</span>
              </a>
            </li>
			<li class="nav-item">
              <a class="nav-link" href="quemsomos_intro.php"><i class="fas fa-comments"></i> Quem Somos
                <span class="sr-only">(current)</span>
              </a>
            </li>
			<!--<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fas fa-comments"></i> Quem Somos
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
					<a class="dropdown-item" href="quemsomos_intro.php">A Tenda - TUPBG</a>
					<a class="dropdown-item" href="quemsomos_galeriafotos.php">Galeria de Fotos</a>
				</div>
			</li>-->
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fas fa-church"></i> A Umbanda
				</a>
				<div class="dropdown-menu multi-column columns-2 vertical-scrolling" aria-labelledby="navbarDropdownMenuLink">
						<div class="row">
							<div class="col-sm-6">
								<a class="dropdown-item" href="AUmbanda_Historia.php">A História da Umbanda</a>
								<a class="dropdown-item" href="AUmbanda_OqueE.php">A Umbanda</a>
								<a class="dropdown-item" href="AUmbanda_ACarta.php">A Carta Magna da Umbanda</a>
								<a class="dropdown-item" href="AUmbanda_OANJO.php">Os Anjos da Guarda</a>
                                                                <a class="dropdown-item" href="AUmbanda_OSORIXAS.php">Os Orixás</a>                                                           
                                                                <a class="dropdown-item" href="AUmbanda_ASPRINCIPAIS.php">As Linhas Principais</a>
                                                                <a class="dropdown-item" href="AUmbanda_ATRANSITORIA.php">As Linhas Transitórias</a>
                                                                <a class="dropdown-item" href="AUmbanda_OSGUARDIOES.php">Os Guardiões</a>
                                                                <a class="dropdown-item" href="AUmbanda_SEUZE.php">Seu Zé Pelintra</a>
                                                                <a class="dropdown-item" href="AUmbanda_OSCIGANOS.php">Os Ciganos</a>
								
							</div>
							<div class="col-sm-6">
                                                                <a class="dropdown-item" href="#">O Corpo Mediúnico</a>                                                                
                                                                <a class="dropdown-item" href="AUmbanda_TERREIRO.php">O Terreiro</a>
								<a class="dropdown-item" href="AUmbanda_ALiturgia.php">A Liturgia da Umbanda</a>								
                                                                <a class="dropdown-item" href="AUmbanda_OMUNDO.php">O Mundo Que Não Vemos</a>
								<a class="dropdown-item" href="AUmbanda_AMEDIUNIDADE.php">A Mediunidade</a>
                                                                <a class="dropdown-item" href="AUmbanda_ODESENVOLVIMENTO.php">O Desenvolvimento <br>Mediúnico</a>
								<a class="dropdown-item" href="AUmbanda_ASGUIAS.php">As Guias de Contas</a>
								<a class="dropdown-item" href="AUmbanda_preparacao.php">A Preparação para os <br>Trabalhos</a>
								</div>
						</div>
				</div>
			</li>
			<li class="nav-item">
              <a class="nav-link" href="index.php?action=coursesFetch"><i class="fas fa-book-reader"></i> Cursos</a>
            </li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fas fa-book-open"></i> Leitura
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
					<a class="dropdown-item" href="index.php?action=booksFetch">Livros Indicados</a>
					<a class="dropdown-item" href="leitura_contos.php">Contos do Pai Benedito</a>
					<a class="dropdown-item" href="#">Jornal Estrela Guia</a>
				</div>
			</li>
            <li class="nav-item">
              <a class="nav-link" href="contatos.php"><i class="fas fa-phone"></i> Contato</a>
            </li>
			<li class="nav-item">
              <a class="nav-link" href="admin.php"><i class="fas fa-lock"></i> Admin</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <div class="container">

      <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-sm-8">

          <!--<h1 class="my-4" align="center">
			 <img src="images/logotipo_pai_benedito.jpg" width="250" height="120" class="thumbnail" alt="Cinque Terre" align="left"> 
            Tenda de Umbanda
			<small><br>Pai Benedito da Guiné</small>
          </h1>-->

				