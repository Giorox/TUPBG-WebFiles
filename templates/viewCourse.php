<?php include "templates/include/header.php" ?>

<br>
<br>
<div class="col-sm-12" class="card mb-4">
    <div class="card-body">
        <h2 class="card-title"><?php echo $results2['courses']->courseName?></h2>
        <p class="card-text"><b>Instrutor:</b> <?php echo $results2['courses']->courseInstructor ?></p>
		<p class="card-text"><?php echo $results2['courses']->courseDescription?></p>
		<p class="card-text"><b>Data de Início:</b> <?php echo strftime('%d/%m/%G', $results2['courses']->courseStartDate)?><br><b>Data de Fim:</b> <?php echo strftime('%d/%m/%G', $results2['courses']->courseEndDate)?></p>
		<p class="card-text"><b>Preço:</b> <?php echo $results2['courses']->coursePrice ?></p>
		<a href="index.php?action=coursesFetch" class="btn btn-primary">&larr; Retornar à pagina anterior</a>
    </div>
</div>

<?php include "templates/include/footer.php" ?>