<?php $results['pageTitle'] = "Cursos | Tenda Pai Benedito";
include "templates/include/header.php" ?>

      <ul class="col-sm-12" id="headlines">

		<!-- Blog Post -->
		  <br>
		  <br>
          <div class="card mb-4">
            <div class="card-body">
              <h2 class="card-title">Cursos com Inscrição Aberta</h2>
                                <div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th scope="col">Título</th>
							<th scope="col">Data de Início</th>
							<th scope="col">Preço</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $results2['courses'] as $courses ) { ?>
							<?php if($courses->courseStatus === 1) { ?>
								<tr>
									<th scope="row"><a href=".?action=viewCourse&amp;courseID=<?php echo $courses->courseID?>" target="_blank" class="btn"><?php echo $courses->courseName?></a></th>
									<td><?php echo strftime('%d/%m/%G', $courses->courseStartDate)?></td>
									<td><?php echo $courses->coursePrice?></td>
								</tr>
							<?php } ?>
						<?php } ?>
					</tbody>
				</table>
				</div>
				<br><br>
				
				<h2 class="card-title">Cursos em Andamento</h2>
				<table class="table">
					<thead>
						<tr>
							<th scope="col">Título</th>
							<th scope="col">Data de Início</th>
							<th scope="col">Preço</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $results2['courses'] as $courses ) { ?>
							<?php if($courses->courseStatus === 2) { ?>
								<tr>
									<th scope="row"><a href=".?action=viewCourse&amp;courseID=<?php echo $courses->courseID?>" target="_blank" class="btn"><?php echo $courses->courseName?></a></th>
									<td><?php echo strftime('%d/%m/%G', $courses->courseStartDate)?></td>
									<td><?php echo $courses->coursePrice?></td>
								</tr>
							<?php } ?>
						<?php } ?>
					</tbody>
				</table>
            </div>
          </div>

      </ul>


<?php include "templates/include/footer.php" ?>

